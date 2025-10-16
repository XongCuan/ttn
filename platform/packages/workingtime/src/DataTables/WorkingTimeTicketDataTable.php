<?php

namespace TCore\WorkingTime\DataTables;

use App\Models\WorkingTimeTicket;
use TCore\DataTable\Supports\DataTables;
use TCore\WorkingTime\Enums\WorkingTimeTicketStatus;
use TCore\WorkingTime\Enums\WorkingTimeTicketType;

class WorkingTimeTicketDataTable extends DataTables
{
    public string $nameTable = 'workingtimeTicket';

    public function __construct(
        public WorkingTimeTicket $model
    ){

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['status', 'type', 'admin_id', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => WorkingTimeTicketStatus::asSelectArray()
            ],
            'type' => [
                'data' => WorkingTimeTicketType::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        $query = $this->model->makeQuery(relations: ['admin']);

        if(get_auth_admin()->isSuperadmin())
        {
            return $query;
        }

        if(request()->routeIs('workingtime_ticket.index'))
        {
            return $query->where('admin_id', get_auth_admin()->id);
        }

        return $query->currentAuth();
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'admin_id' => fn($q, $k) => $q->whereRelation('admin', 'fullname', 'like', "%$k%")
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'status' => fn($row) => sprintf('<span class="badge %s">%s</span>', $row->status->badge(), $row->status->description()),
            'type' => fn($row) => sprintf('<span class="badge %s">%s</span>', $row->type->badge(), $row->type->description()),
            'admin_id' => fn($row) => $row->admin?->fullname,
            'ticket_date' => fn($row) => format_date($row->ticket_date),
            'created_at' => fn($row) => format_date($row->created_at),
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => fn($row) => view('packages_workingtime::working_time_tickets.datatables.columns.action')->with('data', $row),
        ];
    }

    protected function setRemoveColumns(): void
    {
        if(request()->routeIs('workingtime_ticket.index') && get_auth_admin()->isSuperadmin() == false)
        {
            $this->removeColumns = ['admin_id'];
        }
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'status', 'type'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'ticket_date' => [
                'title' => 'Ngày bổ sung',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'type' => [
                'title' => 'Loại',
                'orderable' => false,
            ],
            'admin_id' => [
                'title' => 'Nhân viên',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'Ngày tạo',
                'orderable' => false,
            ],
            'action' => [
                'title' => 'Hành động',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'text-center'
            ]
        ];
    }
}