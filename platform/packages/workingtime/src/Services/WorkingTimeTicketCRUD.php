<?php

namespace TCore\WorkingTime\Services;

use App\Models\WorkingTime;
use App\Models\WorkingTimeTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\WorkingTimeStatus;
use TCore\Base\Services\File\FileUploadService;
use TCore\WorkingTime\Enums\WorkingTimeTicketStatus;
use TCore\WorkingTime\Enums\WorkingTimeTicketType;
use TCore\WorkingTime\Http\Requests\WorkingTimeTicketRequest;

class WorkingTimeTicketCRUD
{
    public function __construct(
        public WorkingTimeTicket $model,
        public WorkingTime $modelWT,
        public FileUploadService $fileUploadService,
    )
    {
        
    }

    public function update(WorkingTimeTicketRequest $request)
    {
        $data = $request->validated();

        $ticket = $this->model->findOrFail($request->input('id'));

        if (!empty($data['attachment_path']))
        {
            $file = json_decode($data['attachment_path'], true);
            $filename = pathinfo($file['name'], PATHINFO_FILENAME);

            if(strpos($ticket->attachment_path, $filename) == false)
            {
                $data['attachment_path'] = $this->fileUploadService->setFolder('admins/' . get_auth_admin()->id)
                ->setFile($data['attachment_path'])
                ->uploadFilepondEncode()
                ->getInstance();
            }else {
                unset($data['attachment_path']);
            }
        }

        $ticket->update($data);

        return $ticket;
    }

    public function store(WorkingTimeTicketRequest $request)
    {
        $data = $request->validated();

        $data['status'] = WorkingTimeTicketStatus::Pending;

        $data['admin_id'] = get_auth_admin()->id;

        if (!empty($data['attachment_path']))
        {
            $data['attachment_path'] = $this->fileUploadService->setFolder('admins/' . get_auth_admin()->id)
            ->setFile($data['attachment_path'])
            ->uploadFilepondEncode()
            ->getInstance();
        }

        return $this->model->create($data);
    }

    public function checkSync(WorkingTimeTicketType $type, $date, $admin_id): bool
    {
        $wt = $this->modelWT->makeQuery(filter: ['date' => $date, 'admin_id' => $admin_id])->first();

        if($type == WorkingTimeTicketType::Checkin || $type == WorkingTimeTicketType::Fullday)
        {
            return $wt == null;
        }

        if($type == WorkingTimeTicketType::Checkout)
        {
            return $wt != null && $wt->check_out == null;
        }

        return false;
    }

    public function confirm(Request $request)
    {
        DB::beginTransaction();
        try {
            $status = $request->enum('status', WorkingTimeTicketStatus::class);

            if($status)
            {
                $data = $this->model->findOrFail($request->input('id'));

                if(working_time_ticket_service()->isStatusPending($data) == false)
                {
                    return false;
                }

                $data->update([
                    'status' => $status,
                    'reason_refuse' => $request->input('reason_refuse')
                ]);

                $this->syncToWorkingTime($data);

                DB::commit();

                return true;
            }
            
            return false;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        
    }

    public function syncToWorkingTime(WorkingTimeTicket $ticket)
    {
        if(WorkingTimeTicketService::isStatusApproved($ticket) && $this->checkSync($ticket->type, $ticket->ticket_date->format('Y-m-d'), $ticket->admin_id))
        {
            $wt = $this->modelWT->makeQuery(filter: ['date' => $ticket->ticket_date->format('Y-m-d'), 'admin_id' => $ticket->admin_id])->first();
            $settings = app()->make('App\Models\Setting');

            if(WorkingTimeTicketService::isTypeCheckin($ticket) && $wt == null)
            {
                $this->modelWT->create([
                    'admin_id' => $ticket->admin_id,
                    'status' => WorkingTimeStatus::OnTime,
                    'date' => $ticket->ticket_date->format('Y-m-d'),
                    'check_in' => $settings->getValue('start_working_time'),
                    'note' => trans('Được bổ sung checkin')
                ]);
            }elseif(WorkingTimeTicketService::isTypeCheckout($ticket) && $wt)
            {
                $timeLimit = Carbon::createFromFormat('H:i', $settings->getValue('almost_ontime_working_time'))->addHours(9)->addMinutes(30);
                $timeTicket = $wt->check_in->addHours(9)->addMinutes(30);

                $time = $timeLimit->greaterThan($timeTicket) ? $timeTicket : $timeLimit;
                
                $wt->update([
                    'check_out' => $time
                ]);

            }elseif(WorkingTimeTicketService::isTypeFullday($ticket) && $wt == null) {
                $this->modelWT->create([
                    'admin_id' => $ticket->admin_id,
                    'status' => WorkingTimeStatus::OnTime,
                    'date' => $ticket->ticket_date->format('Y-m-d'),
                    'check_in' => $settings->getValue('start_working_time'),
                    'check_out' => Carbon::createFromFormat('H:i', $settings->getValue('start_working_time'))->addHours(9)->addMinutes(30),
                    'note' => trans('Được bổ sung điểm danh cả ngày')
                ]);
            }
        }
    }
}