<?php

namespace TCore\LeaveRequest\Http\Controllers;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\LeaveRequest\HalfDayType;
use TCore\Base\Enums\LeaveRequest\LeaveRequestStatus;
use TCore\Base\Enums\LeaveRequest\LeaveRequestType;
use TCore\Base\Services\File\FileUploadService;
use TCore\LeaveRequest\DataTables\LeaveRequestDataTable;
use TCore\LeaveRequest\Http\Requests\LeaveRequestRequest;
use Theme\Cms\Http\Controllers\Controller;

class LeaveRequestController extends Controller
{
    public function __construct(
        public LeaveRequest $model,
        public FileUploadService $fileUploadService
    ) {}
    public function index(LeaveRequestDataTable $dataTable)
    {
        $lea = $this->model->find(1);
        $listYears = $this->model->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        return $dataTable->render('packages_leaverequest::index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Nghỉ phép')),
            'list_years' => $listYears,
            'lea' => $lea
        ]);
    }

    public function create()
    {
        return view('packages_leaverequest::modal.create')
            ->with('types', LeaveRequestType::asSelectArray())
            ->with('haft_day_types', HalfDayType::asSelectArray())
            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Nghỉ phép'), 'leave_request.index')->add(trans('Thêm')));
    }

    public function store(LeaveRequestRequest $request)
    {
        try {
            $data = $request->validated();

            $data['status'] = LeaveRequestStatus::Pending;

            $data['admin_id'] = get_auth_admin()->id;

            if (empty($data['is_half_day'])) {
                unset($data['half_day_type']);
            }
            if($data['type'] == LeaveRequestType::Remote->value)
            {
                $data['is_half_day'] = 0;
                $data['half_day_type'] = null;

            }elseif ($data['type'] == LeaveRequestType::AnnualLeave->value) {
                $admin = get_auth_admin();
                $daysToCheck = 0;
    
                if (!empty($data['is_half_day'])) {
                    $daysToCheck = 0.5;
                } else {
                    if (!empty($data['end_date'])) {
                        $startDate = Carbon::parse($data['start_date']);
                        $endDate = Carbon::parse($data['end_date']);
                        
                        $daysToCheck = $startDate->diffInDaysFiltered(function (Carbon $date) {
                            return !$date->isWeekend();
                        }, $endDate) + 1;
                    } else {
                        $daysToCheck = 1;
                    }
                }
                
                if ($admin->leave_days < $daysToCheck) {
                    DB::rollBack();
                    return utilities()->responseAjax(error: true, msg: 'Số ngày nghỉ phép năm không đủ.');
                }
            }


            if (isset($data['file']) && $data['file']) {
                $data['file'] = $this->fileUploadService->setFolder('admins/' . get_auth_admin()->id)
                    ->setFile($data['file'])
                    ->uploadFilepondEncode()
                    ->getInstance();
            }
            $this->model->create($data);
            return utilities()->responseAjax();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $leaveRequest = $this->model->findOrFail($id);
        return view('packages_leaverequest::modal.show')
            ->with('leave_request', $leaveRequest)
            ->with('types', LeaveRequestType::asSelectArray())
            ->with('haft_day_types', HalfDayType::asSelectArray());
    }

    public function update(LeaveRequestRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if ($request->input('submitter') == 'reject') {
                $data['status'] = LeaveRequestStatus::Refused;
            } else {
                $data['status'] = LeaveRequestStatus::Approved;
            }

            $leaveRequest = $this->model->findOrFail($data['id']);

            if ($data['status'] == LeaveRequestStatus::Approved && $leaveRequest->type == LeaveRequestType::AnnualLeave) {
                $admin = $leaveRequest->admin;

                if ($admin) {
                    $daysToDeduct = 0;

                    if ($leaveRequest->is_half_day) {
                        $daysToDeduct = 0.5;
                    } else {
                        if ($leaveRequest->end_date) {
                            $startDate = Carbon::parse($leaveRequest->start_date);
                            $endDate = Carbon::parse($leaveRequest->end_date);

                            // Đếm số ngày làm việc (không tính T7, CN)
                            $daysToDeduct = $startDate->diffInDaysFiltered(function (Carbon $date) {
                                return !$date->isWeekend();
                            }, $endDate) + 1;
                        } else {
                            $daysToDeduct = 1;
                        }
                    }

                    if ($admin->leave_days >= $daysToDeduct) {
                        $admin->leave_days = $admin->leave_days - $daysToDeduct;
                        $admin->save();

                        $leaveRequest->update($data);

                        DB::commit();
                        return utilities()->responseAjax();
                    } else {
                        return utilities()->responseAjax(error: true, msg: 'Số ngày nghỉ phép năm không đủ.');
                    }
                }
            }
            $leaveRequest->update($data);
            DB::commit();
            return utilities()->responseAjax();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
