<?php

namespace TCore\WorkingTime\DataTables;

use App\Models\WorkingOvertime;
use TCore\Base\Enums\WorkingTimeStatus;
use TCore\DataTable\Supports\DataTables;

class WorkingTimeOvertimeDataTable extends DataTables
{

    public string $nameTable = 'workingOvertimeTable';
    public function __construct(
        public WorkingOvertime $model
    ) {}

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = get_auth_admin()->isSuperadmin() ? ['date', 'admin_id'] : ['date'];
    }


    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['date'];
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
     * @param \App\Models\Admin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $filter = [];

        if (!get_auth_admin()->isSuperadmin()) {
            $filter['admin_id'] = auth('admin')->id();
        }

        return $this->model->makeQuery($filter, ['admin', 'type']);
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
            'date' => '{{ format_date($date, "d/m/Y") }}',
            'type_overtime_id' => 'packages_workingtime::working_overtimes.datatables.columns.type-overtime',
            'admin_id' => fn($working_overtime) => view('packages_workingtime::working_overtimes.datatables.columns.admin', ['working_overtime' => $working_overtime]),
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_workingtime::working_overtimes.datatables.columns.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'admin_id'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'date' => [
                'title' => 'Ngày',
                'orderable' => false
            ],
            'hour' => [
                'title' => 'Số giờ',
                'orderable' => false,
            ],
            'type_overtime_id' => [
                'title' => 'Loại OT',
                'orderable' => false,
            ],
            'admin_id' => [
                'title' => 'Nhân viên',
                'orderable' => false,
            ],
            'note' => [
                'title' => 'Ghi chú',
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
