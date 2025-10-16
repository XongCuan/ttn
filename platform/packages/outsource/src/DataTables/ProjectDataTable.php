<?php

namespace TCore\Outsource\DataTables;

use App\Enums\Order\OrderStatus;
use App\Enums\Project\ProjectPriority;
use App\Enums\Project\ProjectStatus;
use TCore\Base\Enums\Department;
use TCore\DataTable\Supports\DataTables;
use TCore\Outsource\Repositories\Project\ProjectRepositoryInterface;
class ProjectDataTable extends DataTables
{

    public string $nameTable = 'projectTable';

    public function __construct(
        public ProjectRepositoryInterface $repo
    ) {

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = get_auth_admin()->hasLeaderShipRoleOutsource() ? ['name', 'status', 'priority', 'created_at', 'assigns', 'deadline'] : ['name', 'status', 'priority', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => ProjectStatus::asSelectArray()
            ],
            'priority' => [
                'data' => ProjectPriority::asSelectArray()
            ],
            'deadline' => [
                'data' => [
                    0 => trans('Trễ'),
                    1 => trans('Đúng')
                ]
            ]
        ];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'admin_id' => fn($q, $k) => $q->whereRelation('creator', 'fullname', 'like', "%{$k}%"),
            'assigns' => fn($q, $k) => $q->whereRelation('assigns', 'fullname', 'like', "%{$k}%"),
            'deadline' => fn($q, $k) => $q->where('demo_ontime', $k)
        ];
    }

    protected function setRemoveColumns(): void
    {
        if (get_auth_admin()->hasLeaderShipRoleOutsource() == false) {
            $this->removeColumns = [
                'assigns'
            ];
        }
    }

    public function query()
    {
        $filter = [];

        if ($filter_month = request()->get('filter_month'))
        {
            $filter[] = ['created_at', 'month', $filter_month];
        }

        if ($filter_year = request()->get('filter_year'))
        {
            $filter[] = ['created_at', 'year', $filter_year];
        }

        if (get_auth_admin()->isRoleEmployee()) {
            $filter[] = ['assigns', 'relation', ['id', auth('admin')->id()]];
        } elseif (get_auth_admin()->isRoleLeader()) {
            $filter['team_id'] = get_auth_admin()->team_id;
        }

        $filter['department'] = Department::Outsource;

        return $this->repo->getByQueryBuilder(filter: $filter, relations: ['assigns']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'name' => fn($data) => view('packages_outsource::datatables.columns.name')->with('data', $data),
            'status' => fn($data) => view('packages_outsource::datatables.columns.status')->with('data', $data),
            'priority' => fn($data) => view('packages_outsource::datatables.columns.priority')->with('data', $data),
            'admin_id' => fn($data) => $data->creator->fullname,
            'created_at' => fn($row) => format_date($row->created_at)
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'assigns' => fn($data) => $data->assigns->pluck('fullname')->implode(', '),
            'action' => 'packages_outsource::datatables.columns.action',
            'deadline' => fn($data) => view('packages_outsource::datatables.columns.deadline')->with('data', $data)
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'name', 'status', 'priority', 'deadline'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'name' => [
                'title' => 'Tên dự án',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'priority' => [
                'title' => 'Độ ưu tiên',
                'orderable' => false,
            ],
            'deadline' => [
                'title' => 'Deadline',
                'orderable' => false,
            ],
            'assigns' => [
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