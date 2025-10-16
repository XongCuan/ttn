<?php

namespace TCore\Notification\Http\Controllers;

use App\Models\Admin;
use App\Models\NotificationContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use TCore\Base\Enums\Department;
use TCore\Base\Enums\SuperDepartment;
use TCore\Notification\DataTables\NotificationContentDataTable;
use TCore\Notification\Http\Requests\NotificationContentRequest;
use TCore\Notification\Notifications\SendToEmployee;
use Theme\Cms\Http\Controllers\Controller;

class NotificationContentController extends Controller
{
    public function __construct(
        public NotificationContent $model,
        public Admin $modelEmployee
    )
    {
        
    }

    public function index(NotificationContentDataTable $dataTable)
    {
        return $dataTable->render('packages_notification::index', [
            'breadcrumbs' => $this->breadcrumbs()->add('Thông báo')
        ]);
    }

    public function create()
    {
        $departments = Department::asSelectArray();

        if (get_auth_admin()->isRoleSuperManager())
        {
            $dSuper = get_auth_admin()->super_department;

            foreach($departments as $key => $value)
            {
                if(Department::from($key)->super() != $dSuper)
                {
                    unset($departments[$key]);
                }
            }
        }elseif(get_auth_admin()->isRoleManager()) {

            $departments = [];
        }

        return view('packages_notification::modal.create')->with('departments', $departments);
    }

    public function store(NotificationContentRequest $res)
    {
        DB::beginTransaction();

        try {
            
            $data = $res->validated();
            $data['created_by'] = get_auth_admin()->id;

            if(get_auth_admin()->isRoleManager())
            {
                $data['target_deparments'] = get_auth_admin()->managerDepartments->pluck('department')->map(fn($item) => $item->value)->toArray();

                $employees = $this->modelEmployee->makeQuery(
                    [
                        ['team_id', '!=', null], 
                        ['team', 'HAS', fn($q) => $q->whereIn('department', $data['target_deparments'])]
                    ]
                )->get();

            } elseif ($res->has('is_all') && $res->is_all == true && get_auth_admin()->isSuperadmin()) {

                $data['target_deparments'] = [];

                $employees = $this->modelEmployee->makeQuery(['is_superadmin' => false])->get();

            }else {

                if(empty($data['target_deparments']))
                {
                    return utilities()->responseAjax(error: true, msg: trans('Vui lòng chọn phòng ban!'));
                }

                $employees = $this->modelEmployee->where(
                    fn($q) => $q->whereHas('team', fn($q1) => $q1->whereIn('department', $data['target_deparments']))->orWhereHas('managerDepartments', fn($q2) => $q2->whereIn('department', $data['target_deparments']))
                )->get();

            }

            $nContent = $this->model->create($data);

            Notification::send($employees, new SendToEmployee($nContent));

            DB::commit();

            return utilities()->responseAjax();

        } catch (\Throwable $th) {

            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id)
    {
        return view('packages_notification::modal.edit')

        ->with('data', $this->model->findOrFail($id));
    }

    public function show($id)
    {
        return view('packages_notification::show')

        ->with('data', $this->model->findOrFail($id));
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();

        return utilities()->responseAjax();
    }
}