<?php

namespace TCore\Superadmin\Http\Controllers;

use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\Department;
use TCore\Superadmin\DataTables\AdminDataTable;
use TCore\Superadmin\Http\Requests\AdminRequest;
use TCore\Superadmin\Repositories\Admin\AdminRepositoryInterface;
use TCore\Base\Enums\Gender;
use TCore\Base\Enums\SuperDepartment;
use TCore\Superadmin\DataTables\AdminWorkingTimeDataTable;
use TCore\Superadmin\Services\SalaryCalculationService;
use TCore\WorkingTime\Repositories\WorkingTime\WorkingTimeRepositoryInterface;
use Theme\Cms\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct(
        public AdminRepositoryInterface $repo,
        public WorkingTimeRepositoryInterface $repoWorkingtime,
        public Bank $modelBank
    ) {}
    
    public function index(AdminDataTable $dataTable)
    {
        return $dataTable->render('packages_superadmin::admin.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Quản lý nhân viên'))
        ]);
    }

    public function create()
    {
        return view('packages_superadmin::admin.create')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Quản lý nhân viên'), 'superadmin.admin.index')->add(trans('Thêm')))

            ->with('super_department', SuperDepartment::asSelectArrayAvailable())

            ->with('departments', Department::asSelectArray())

            ->with('banks', $this->modelBank->all())

            ->with('gender', Gender::asSelectArray());
    }

    public function store(AdminRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $data['admin']['salary'] = $data['admin']['salary'] === null ? 0 : $data['admin']['salary'];

            if (isset($data['admin']['is_superadmin']) && $data['admin']['is_superadmin'] == true) {
                $data['admin']['super_department'] = SuperDepartment::None;
            }

            $admin = $this->repo->create($data['admin']);

            if ($admin->canAssignManager() && isset($data['department']) && count($data['department']) > 0) {
                $departments = array_map(fn($item) => ['department' => $item], $data['department']);

                $admin->managerDepartments()->createMany($departments);
            }

            $admin->bankAccount()->create($data['bank_account']);

            DB::commit();

            return $request->input('submitter') == 'save'
                ? utilities()->toRoute('superadmin.admin.edit', $admin->id)
                : utilities()->toRoute('superadmin.admin.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return utilities()->responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function edit($id)
    {
        $admin = $this->repo->findOrFail($id, ['team', 'managerDepartments', 'bankAccount']);

        $managerDepartments = $admin->managerDepartments->pluck('department')->map(fn($i) => $i->value);

        return view('packages_superadmin::admin.edit')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Quản lý nhân viên'), 'superadmin.admin.index')->add(trans('Sửa')))

            ->with('super_department', SuperDepartment::asSelectArrayAvailable())

            ->with('departments', Department::asSelectArray())

            ->with('manager_departments', $managerDepartments)

            ->with('banks', $this->modelBank->all())

            ->with('admin', $admin);
    }

    public function update(AdminRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['admin']['salary'] = $data['admin']['salary'] === null ? 0 : $data['admin']['salary'];

            if ($data['admin']['password'] == '') {
                unset($data['admin']['password']);
            }

            $admin = $this->repo->findOrFail($data['id']);

            if ($admin->canAssignManager()) {
                $this->repo->syncManagerDepartment($admin, $request->input('department', []));
            } else {
                $admin->managerDepartments()->delete();
            }

            $this->repo->update($request->id, $data['admin']);
            $admin->bankAccount()->update($data['bank_account']);

            DB::commit();
            return $request->input('submitter') == 'save'
                ? utilities()->responseBack()
                : utilities()->toRoute('superadmin.admin.index');
        } catch (\Throwable $th) {

            DB::rollBack();
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

    public function calculateSalary($id, Request $request, AdminWorkingTimeDataTable $dataTable)
    {
        $month = $request->input('filter_month', now()->month);
        $year = $request->input('filter_year', now()->year);

        $admin = $this->repo->findOrFail($id)->load([
            'workingTimes' => fn($q) => $q->whereMonth('date', $month)->whereYear('date', $year)->whereNotNull('check_out'), 
            'leaveRequests' => fn($q) => $q->approved()->where(
                fn($q) => $q->where(
                    fn($q) => $q->whereMonth('start_date', $month)->whereYear('start_date', $year)
                )->orWhere(fn($q) => $q->whereMonth('end_date', $month)->whereYear('end_date', $year))
            )
        ]);

        $salaryData = SalaryCalculationService::make(
            $admin,
            $month,
            $year
        )->calculateSalary();


        $currentMonth = now()->month;
        $compareMonth = $month ?? ($currentMonth == 1 ? 12 : $currentMonth - 1);

        $isBirthdayMonth = false;
        if ($admin->birthday) {
            $isBirthdayMonth = Carbon::parse($admin->birthday)->month == $compareMonth;
        }

        $listYears = $this->repoWorkingtime->getQueryBuilder()->selectRaw('YEAR(date) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return $dataTable->with('admin_id', $admin->id)->render('packages_superadmin::admin.salary', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Quản lý nhân viên'), 'superadmin.admin.index')->add(trans('Tính lương'))->add($admin->fullname),
            'admin' => $admin,
            'salary_data' => $salaryData,
            'list_years' => $listYears,
            'is_birthday_month' => $isBirthdayMonth
        ]);
    }
}
