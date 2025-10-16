<?php

namespace TCore\WorkingTime\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use TCore\Base\Enums\Department;
use TCore\Base\Enums\WorkingTimeStatus;
use TCore\Superadmin\Repositories\Admin\AdminRepositoryInterface;
use TCore\WorkingTime\DataTables\WorkingTimeDataTable;
use TCore\WorkingTime\Exports\StatisticWorkingTime;
use TCore\WorkingTime\Http\Requests\WorkingTimeRequest;
use TCore\WorkingTime\Repositories\WorkingTime\WorkingTimeRepositoryInterface;
use TCore\WorkingTime\Services\WorkingTimeStatistic;
use Theme\Cms\Http\Controllers\Controller;

class WorkingTimeController extends Controller
{
    public function __construct(
        public WorkingTimeRepositoryInterface $repo,
        public AdminRepositoryInterface $repoAdmin
    ) {}

    public function dashboard(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        if(get_auth_admin()->isSuperadmin())
        {
            $department = $request->enum('department', Department::class);
        }elseif(get_auth_admin()->isRoleManager())
        {
            $department = get_auth_admin()->enumDepartment();
        }

        $listYears = $this->repo->getQueryBuilder()
            ->selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $filter = [
            'is_superadmin' => false
        ];

        $employees = $this->repoAdmin->getByQueryBuilder(
            filter: $filter,
            relations: [
                'managerDepartments', 'team',
                'workingTimes' => fn($q) => $q->whereMonth('date', $month)->whereYear('date', $year)->whereNotNull('check_out'), 
                'leaveRequests' => fn($q) => $q->approved()->where(
                    fn($q) => $q->where(
                        fn($q) => $q->whereMonth('start_date', $month)->whereYear('start_date', $year)
                    )->orWhere(fn($q) => $q->whereMonth('end_date', $month)->whereYear('end_date', $year))
                )
            ]            
        );

        if(is_array($department))
        {
            $employees = $employees->where(fn($q) => $q->WhereHas('team', fn($q) => $q->whereIn('department', $department)));
        }else if($department) {
            $employees = $employees->where(fn($q) => $q->whereRelation('managerDepartments', 'department', $department)->orWhereRelation('team', 'department', $department));
        }

        $employees = $employees->get();

        $statistic = [];

        foreach($employees as $employee)
        {
            array_push($statistic, new WorkingTimeStatistic($employee, $month, $year));
        }

        if($request->input('submitter') == 'exportExcel')
        {
            return Excel::download(new StatisticWorkingTime($statistic), 'bang-cham-cong-'. now()->format('m-Y') .'.xlsx');
        }

        return view('packages_workingtime::dashboard.index')

        ->with('statistic', $statistic)

        ->with('list_years', $listYears)

        ->with('departments', Department::asSelectArray())
        
        ->with('breadcrumbs', $this->breadcrumbs()->add(trans('Chấm công'))->add(trans('Dashboard')));
    }

    public function index(WorkingTimeDataTable $dataTable)
    {
        $listYears = $this->repo->getQueryBuilder()
            ->selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        return $dataTable->render('packages_workingtime::working_times.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Chấm công'))->add(trans('Điểm danh')),
            'list_years' => $listYears
        ]);
    }

    public function create()
    {
        return view('packages_workingtime::working_times.create')
            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Thời gian làm việc'), 'working_time.index')->add(trans('Thêm')));
    }

    public function store(WorkingTimeRequest $request)
    {
        try {

            $data = $request->validated();

            $workingTime = $this->repo->create($data);

            return $request->input('submitter') == 'save'
                ? utilities()->toRoute('working_time.edit', $workingTime->id)
                : utilities()->toRoute('working_time.index');
        } catch (\Throwable $th) {

            // throw $th;
            return utilities()->responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function edit($id)
    {
        $workingTime = $this->repo->findOrFail($id, ['admin']);

        if (request()->ajax()) {
            return view('packages_workingtime::working_times.modal.edit')->with('working_time', $workingTime);
        }

        return view('packages_workingtime::working_times.edit')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Thời gian làm việc'), 'working_time.index')->add(trans('Sửa')))

            ->with('working_time', $workingTime);
    }

    public function update(WorkingTimeRequest $request)
    {
        try {

            $data = $request->validated();

            $this->repo->update($request->id, $data);
            if (request()->ajax()) {
                return utilities()->responseAjax();
            }

            return $request->input('submitter') == 'save'
                ? utilities()->responseBack()
                : utilities()->toRoute('working_time.index');
        } catch (\Throwable $th) {
            // throw $th;
            return utilities()->responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function delete($id)
    {
        try {

            $this->repo->delete($id);

            if (request()->ajax()) {
                return utilities()->responseAjax();
            }

            return utilities()->toRoute('superadmin.admin.index');
        } catch (\Throwable $th) {

            //throw $th;

            if (request()->ajax()) {
                return utilities()->responseAjax(error: true, msg: $th->getMessage());
            }

            return utilities()->responseBack(error: true, msg: $th->getMessage());
        }
    }

    public function checkin(Request $request)
    {
        try {
            $auth = get_auth_admin();

            if ($auth->checkLocationAllowCheckInOut() == false) {
                return response()->json(['msg' => trans('Bạn không có ở công ty !')], 400);
            }

            $response = $this->repo->checkin($auth);

            if ($response) {
                return response()->json(['msg' => trans('Checkin thành công.')]);
            }

            return response()->json(['msg' => trans('Checkin thất bại')], 400);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function checkout()
    {
        try {
            $auth = get_auth_admin();

            if ($auth->checkLocationAllowCheckInOut() == false) {
                return response()->json(['msg' => trans('Bạn không có ở công ty !')], 400);
            }

            $response = $this->repo->checkout($auth);

            if ($response) {
                return response()->json(['msg' => trans('Checkout thành công.')]);
            }

            return response()->json(['msg' => trans('Checkout thất bại')], 400);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }
}
