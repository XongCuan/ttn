<?php

namespace TCore\WorkingTime\Http\Controllers;

use App\Models\Admin;
use App\Models\WorkingTime;
use App\Models\WorkingTimeTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use TCore\Base\Services\File\FileUploadService;
use TCore\WorkingTime\DataTables\WorkingTimeTicketDataTable;
use TCore\WorkingTime\Enums\WorkingTimeTicketStatus;
use TCore\WorkingTime\Enums\WorkingTimeTicketType;
use TCore\WorkingTime\Http\Requests\WorkingTimeTicketRequest;
use TCore\WorkingTime\Mail\NewWorkingTimeTicket;
use TCore\WorkingTime\Services\WorkingTimeTicketCRUD;
use Theme\Cms\Http\Controllers\Controller;

class WorkingTimeTicketController extends Controller
{
    public function __construct(
        public WorkingTimeTicket $model,
        
        public WorkingTimeTicketCRUD $crud
    )
    {
        
    }

    public function index(WorkingTimeTicketDataTable $dataTable)
    {
        return $dataTable->render('packages_workingtime::working_time_tickets.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Bổ sung điểm danh'))
        ]);
    }

    public function create()
    {
        return view('packages_workingtime::working_time_tickets.modal.create')
        
        ->with('type', WorkingTimeTicketType::asSelectArray());
    }

    public function store(WorkingTimeTicketRequest $request)
    {
        if($this->crud->checkSync($request->enum('type', WorkingTimeTicketType::class), $request->input('ticket_date'), get_auth_admin()->id) == false)
        {
            return utilities()->responseAjax(error: true, msg: trans('Dữ liệu bổ sung không đồng bộ!'));
        }

        $ticket = $this->crud->store($request);

        $department = get_auth_admin()->enumDepartment();

        if(count($department))
        {
            $managerDepartment = Admin::whereRelation('managerDepartments', 'department', $department[0])->first();

            if($managerDepartment)
            {
                Mail::to($managerDepartment->email)->send(new NewWorkingTimeTicket($ticket, $managerDepartment));
            }
        }

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        $data = $this->model->findOrFail($id);

        if(working_time_ticket_service()->isStatusPending($data) == false)
        {
            return utilities()->responseAjax(error: true, msg: trans('Không thể sửa'));
        }
        
        return view('packages_workingtime::working_time_tickets.modal.edit')
        
        ->with('type', WorkingTimeTicketType::asSelectArray())

        ->with('data', $data);
    }

    public function update(WorkingTimeTicketRequest $request)
    {
        if($this->crud->checkSync($request->enum('type', WorkingTimeTicketType::class), $request->input('ticket_date'), get_auth_admin()->id) == false)
        {
            return utilities()->responseAjax(error: true, msg: trans('Dữ liệu bổ sung không đồng bộ!'));
        }

        $this->crud->update($request);

        return utilities()->responseAjax();
    }

    public function delete($id)
    {
        $data = $this->model->findOrFail($id);

        if(working_time_ticket_service()->isStatusPending($data) == false)
        {
            return utilities()->responseAjax(error: true, msg: trans('Không thể xóa'));
        }

        $data->delete();

        return utilities()->responseAjax();
    }

    public function show($id)
    {
        $data = $this->model->findOrFail($id);
        
        return view('packages_workingtime::working_time_tickets.modal.show')
        
        ->with('data', $data);
    }

    public function confirm($id)
    {
        $data = $this->model->findOrFail($id);

        if(working_time_ticket_service()->isStatusPending($data) == false)
        {
            return utilities()->responseAjax(error: true, msg: trans('Không thể truy cập'));
        }
        
        return view('packages_workingtime::working_time_tickets.modal.confirm')
        
        ->with('data', $data);
    }

    public function handleConfirm(Request $request)
    {
        if($request->enum('status', WorkingTimeTicketStatus::class)){
            if($this->crud->confirm($request))
        {
            return utilities()->responseAjax();
        }

        return utilities()->responseAjax(error: true, msg: trans('Dữ liệu không đồng bộ'));
        }

        return utilities()->responseAjax(error: true, msg: trans('Vui lòng chọn duyệt hoặc từ chối!'));
    }
}