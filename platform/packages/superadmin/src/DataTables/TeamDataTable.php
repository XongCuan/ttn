<?php

namespace TCore\Superadmin\DataTables;

use App\Models\Team;
use TCore\Base\Enums\Department;
use TCore\DataTable\Supports\DataTables;

class TeamDataTable extends DataTables
{

    public string $nameTable = 'teamTable';

    public function __construct(
        public Team $model
    ){

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['name', 'department', 'leader_id', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'department' => [
                'data' => Department::asSelectArray()
            ]
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->model->makeQuery(relations: ['leader', 'managers'])->withCount(['members']);
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'leader_id' => fn($q, $k) => $q->whereRelation('leader', 'fullname', 'like', "%$k%")
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'department' => fn($row) => $row->department->description(),
            'leader_id' => fn($row) => $row->leader->fullname,
            'created_at' => fn($row) => format_date($row->created_at)
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_superadmin::teams.datatables.columns.action',
            'qty_member' => fn($row) => $row->members_count
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'role'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'name' => [
                'title' => 'Tên',
                'orderable' => false,
            ],
            'department' => [
                'title' => 'Phòng ban',
                'orderable' => false,
            ],
            'leader_id' => [
                'title' => 'Leader',
                'orderable' => false,
            ],
            'qty_member' => [
                'title' => 'SL NV',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'Ngày tạo',
                'orderable' => false,
                'visible' => false,
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
