<?php

namespace TCore\Internal\DataTables;

use App\Enums\Order\OrderStatus;
use App\Enums\Project\ProjectPriority;
use App\Enums\Project\ProjectStatus;
use TCore\Base\Enums\Department;
use TCore\DataTable\Supports\DataTables;
use TCore\Internal\Repositories\Project\ProjectRepositoryInterface;
class ProjectDataTable extends DataTables
{

    public string $nameTable = 'projectTable';

    public function __construct(
        public ProjectRepositoryInterface $repo
    ) {

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = get_auth_admin()->hasManagerShipRoleInternal() ? ['name', 'order_id', 'status', 'priority', 'created_at', 'start_date', 'end_date'] : ['name', 'status', 'priority', 'created_at', 'start_date', 'end_date'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at', 'start_date', 'end_date'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => ProjectStatus::asSelectArray()
            ],
            'priority' => [
                'data' => ProjectPriority::asSelectArray()
            ]
        ];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'order_id' => fn($q, $k) => $q->whereRelation('order', 'name', 'like', "%{$k}%"),
            'admin_id' => fn($q, $k) => $q->whereRelation('creator', 'fullname', 'like', "%{$k}%"),
            'assigns' => fn($q, $k) => $q->whereRelation('assigns', 'fullname', 'like', "%{$k}%")
        ];
    }

    protected function setRemoveColumns(): void
    {
        if (get_auth_admin()->hasManagerShipRoleInternal() == false) {
            $this->removeColumns = [
                'assigns',
                'order_id'
            ];
        }
    }

    public function query()
    {
        $filter = [];

        if (get_auth_admin()->isRoleEmployee()) {
            $filter[] = ['assigns', 'relation', ['id', auth('admin')->id()]];
        } elseif (get_auth_admin()->isRoleLeader()) {
            $filter['team_id'] = get_auth_admin()->team_id;
        }

        $filter['department'] = Department::Internal;

        return $this->repo->getByQueryBuilder(filter: $filter, relations: ['assigns']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'name' => fn($data) => view('packages_internal::datatables.columns.name')->with('data', $data),
            'status' => fn($data) => view('packages_internal::datatables.columns.status')->with('data', $data),
            'priority' => fn($data) => view('packages_internal::datatables.columns.priority')->with('data', $data),
            'admin_id' => fn($data) => $data->creator->fullname,
            'created_at' => fn($row) => format_date($row->created_at),
            'order_id' => fn($data) => $data->order->name,
            'start_date' => fn($data) => format_date($data->start_date), 
            'end_date' => fn($data) => format_date($data->end_date),  
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'assigns' => fn($data) => $data->assigns->pluck('fullname')->implode(', '),
            'action' => 'packages_internal::datatables.columns.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'name', 'status', 'priority'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'name' => [
                'title' => 'Tên dự án',
                'orderable' => false,
            ],
            'order_id' => [
                'title' => 'Tên đơn hàng',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'start_date' => [
                'title' => 'Ngày bắt đầu',
                'orderable' => false,
            ],
            'end_date' => [
                'title' => 'Ngày bắt đầu',
                'orderable' => false,
            ],
            'priority' => [
                'title' => 'Độ ưu tiên',
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