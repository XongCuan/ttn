<?php

namespace TCore\Webadmin\DataTables;

use App\Enums\Project\ProjectRequirementStatus;
use App\Enums\Project\ProjectStatus;
use TCore\DataTable\Supports\DataTables;
use TCore\Webadmin\Models\PRequirement;

class ProjectRequirementDataTable extends DataTables
{
    public string $nameTable = 'pRequirementTable';

    public function __construct(
        public PRequirement $model
    )
    {
        
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = [
            'title', 'status', 'created_at', 'status_project'
        ];

        if(get_auth_admin()->hasLeaderShipRoleWebadmin())
        {
            $this->columnHasSearch[] = 'assigned_by';
        }
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => ProjectRequirementStatus::asSelectArray()
            ],
            'status_project' => [
                'data' => ProjectStatus::asSelectArray()
            ]
        ];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'assigned_by' => fn($q, $k) => $q->whereRelation('assign', 'fullname', 'like', "%{$k}%"),
        ];
    }

    protected function setRemoveColumns(): void
    {
        if (get_auth_admin()->hasManagerShipRoleOutsource() == false)
        {
            $this->removeColumns = [
                'assigned_by'
            ];
        }
    }

    public function query()
    {
        $filter = [];

        if (get_auth_admin()->isRoleEmployee())
        {
            $filter['assigned_by'] = auth('admin')->id();

        } elseif (get_auth_admin()->isRoleLeader()) {

            $filter['team_id'] = get_auth_admin()->team_id;
        }

        return $this->model->makeQuery(filter: $filter, relations: ['assign', 'project']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'status' => fn($data) => view('packages_webadmin::project_requirements.datatables.columns.status')->with('data', $data),
            'status_project' => fn($data) => view('packages_webadmin::project_requirements.datatables.columns.status_project')->with('data', $data),
            'assigned_by' => fn($data) => $data->assign->fullname,
            'created_at' => fn($row) => format_date($row->created_at),
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_webadmin::project_requirements.datatables.columns.action'
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'status'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'title' => [
                'title' => 'Tên yêu cầu',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'status_project' => [
                'title' => 'Trạng thái DA',
                'orderable' => false,
            ],
            'assigned_by' => [
                'title' => 'Phân công',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'Ngày tạo',
                'orderable' => false,
                'visible' => false
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