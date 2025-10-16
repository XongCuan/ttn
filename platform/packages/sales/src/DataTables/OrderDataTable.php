<?php

namespace TCore\Sales\DataTables;

use App\Enums\Order\OrderStatus;
use TCore\DataTable\Supports\DataTables;
use TCore\Sales\Repositories\Order\OrderRepositoryInterface;

class OrderDataTable extends DataTables
{

    public string $nameTable = 'orderTable';

    public function __construct(
        public OrderRepositoryInterface $repo
    )
    {
        
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['id', 'name', 'customer_id', 'admin_id', 'status', 'assigns', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => OrderStatus::asSelectArray()
            ]
        ];
    }

    protected function setFilterColumns(): void
    {
        $this-> filterColumns = [
            'customer_id' => fn($q, $k) => $q->whereRelation('customer', 'fullname', 'like', "%{$k}%"),
            'admin_id' => fn($q, $k) => $q->whereRelation('creator', 'fullname', 'like', "%{$k}%"),
            'assigns' => fn($q, $k) => $q->whereRelation('assigns', 'fullname', 'like', "%{$k}%")
        ];
    }

    protected function setRemoveColumns(): void
    {
        if(get_auth_admin()->hasLeaderShipRoleSales() == false)
        {
            $this->removeColumns = [
                'assigns', 'admin_id'
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

        if(get_auth_admin()->isRoleEmployee())
        {
            $filter[] = ['assigns', 'relation', ['id', auth('admin')->id()]];
        }elseif(get_auth_admin()->isRoleLeader()) {
            $filter['team_id'] = get_auth_admin()->team_id;
        }

        return $this->repo->getByQueryBuilder(filter: $filter, relations: ['assigns', 'creator', 'customer'])->withSum('arises', 'amount')
        ->withSum('payments', 'amount');
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'name' => fn($data) => view('packages_sales::orders.datatables.columns.name')->with('data', $data),
            'status' => fn($data) => view('packages_sales::orders.datatables.columns.status')->with('data', $data),
            'total' => fn($data) => view('packages_sales::orders.datatables.columns.total')->with('data', $data),
            'customer_id' => fn($data) => $data->customer->displayText(),
            'admin_id' => fn($data) => $data->creator->fullname,
            'created_at' => fn($row) => format_date($row->created_at)
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'assigns' => fn($data) => $data->assigns->pluck('fullname')->implode(', '),
            'action' => 'packages_sales::orders.datatables.columns.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'name', 'status', 'total'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'id' => [
                'title' => 'ID',
                'orderable' => false,
            ],
            'name' => [
                'title' => 'Tên đơn hàng',
                'orderable' => false,
                'visible' => false
            ],
            'customer_id' => [
                'title' => 'Khách hàng',
                'orderable' => false,
                'visible' => false
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'total' => [
                'title' => 'Tổng tiền',
                'orderable' => false,
            ],
            'admin_id' => [
                'title' => 'Người tạo',
                'orderable' => false,
                'visible' => false
            ],
            'assigns' => [
                'title' => 'Phân công',
                'orderable' => false,
                'visible' => false
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