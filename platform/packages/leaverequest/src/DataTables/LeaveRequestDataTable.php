<?php

namespace TCore\LeaveRequest\DataTables;

use App\Models\LeaveRequest;
use TCore\Base\Enums\LeaveRequest\LeaveRequestStatus;
use TCore\Base\Enums\LeaveRequest\LeaveRequestType;
use TCore\DataTable\Supports\DataTables;

class LeaveRequestDataTable extends DataTables
{

    public string $nameTable = 'leaveRequestTable';
    public function __construct(
        public LeaveRequest $model
    ) {}

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = get_auth_admin()->isSuperadmin() 
            ? ['admin_id', 'type', 'status'] 
            : ['type', 'status'];
    }


    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => LeaveRequestStatus::asSelectArray()
            ],
            'type' => [
                'data' => LeaveRequestType::asSelectArray()
            ]
        ];
    }
    

    protected function makeBuilderDataTable($query): void
    {
        $this->instanceDataTable = datatables()->eloquent($query)->addIndexColumn();
    }

    protected function setRemoveColumns(): void
    {
        if (!get_auth_admin()->isSuperadmin()) {
            $this->removeColumns = ['admin_id', 'action'];
        }
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LeaveRequest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $filter = [];

        if (!get_auth_admin()->isSuperadmin()) {
            $filter['admin_id'] = auth('admin')->id();
        }

        if ($filter_month = request()->get('filter_month')) {
            $filter[] = ['date', 'month', $filter_month];
        }

        if ($filter_year = request()->get('filter_year')) {
            $filter[] = ['date', 'year', $filter_year];
        }

        return $this->model->makeQuery($filter, ['admin']);
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
            'admin_id' => fn($working_time) => view('packages_leaverequest::datatables.columns.admin', ['working_time' => $working_time]),
            'type' => fn($leave_request) => view('packages_leaverequest::datatables.columns.type', ['leave_request' => $leave_request]),
            'status' => fn($leave_request) => view('packages_leaverequest::datatables.columns.status', ['leave_request' => $leave_request]),
            'reason' => fn($leave_request) => view('packages_leaverequest::datatables.columns.reason', ['leave_request' => $leave_request]),

        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'datetime' => fn($leave_request) => view('packages_leaverequest::datatables.columns.info', ['leave_request' => $leave_request]),
            'number_of_days' => fn($leave_request) => view('packages_leaverequest::datatables.columns.number-of-days', ['leave_request' => $leave_request]), 
            'action' => fn($leave_request) => view('packages_leaverequest::datatables.columns.action', ['leave_request' => $leave_request]),
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'admin_id', 'status', 'type'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'admin_id' => [
                'title' => 'Nhân viên',
                'orderable' => false,
            ],
            'title' => [
                'title' => 'Tiêu đề',
                'orderable' => false,
            ],
            'type' => [
                'title' => 'Loại nghỉ phép',
                'orderable' => false,
            ],
            'datetime' => [
                'title' => 'Thời gian',
                'orderable' => false,
            ],
            'number_of_days' => [
                'title' => 'Số ngày',
                'orderable' => false,
            ],
            'reason' => [
                'title' => 'Lý do',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'action' => [
                'title' => 'Thao tác',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'align-middle text-center'
            ],
        ];
    }
}
