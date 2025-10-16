<?php

namespace TCore\Sales\DataTables;

use App\Enums\Customer\CustomerReturnStatus;
use TCore\DataTable\Supports\DataTables;
use TCore\Sales\Models\CustomerReturn;

class CustomerReturnDataTable extends DataTables
{
    public string $nameTable = 'customerReturnTable';

    public function __construct(
        public CustomerReturn $model
    )
    {
        
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['customer_id', 'status', 'admin_id', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => CustomerReturnStatus::asSelectArray()
            ]
        ];
    }

    protected function setFilterColumns(): void
    {
        $this-> filterColumns = [
            'customer_id' => fn($q, $k) => $q->whereHas('customer', fn($q) => $q->whereAny(['fullname', 'phone'], 'like', "%{$k}%")),
            'admin_id' => fn($q, $k) => $q->whereRelation('creator', 'fullname', 'like', "%{$k}%")
        ];
    }

    protected function setRemoveColumns(): void
    {
        if(get_auth_admin()->hasLeaderShipRoleSales() == false)
        {
            $this->removeColumns = [
                'admin_id'
            ];
        }
    }

    public function query()
    {
        return $this->model->makeQuery(relations: ['customer', 'creator']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'status' => fn($data) => '<span class="badge '. $data->status->badge() .'">' . $data->status->description() . '</span>',
            'admin_id' => fn($data) => $data->creator->fullname,
            'created_at' => fn($row) => format_date($row->created_at)
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'customer_id' => fn($data) => $data->customer->displayText(),
            'action' => fn($data) => view('packages_sales::customer_returns.datatables.columns.action')->with('data', $data),
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'status'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'customer_id' => [
                'title' => 'Khách hàng',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'admin_id' => [
                'title' => 'Người tạo',
                'orderable' => false,
            ],
            'note' => [
                'title' => 'Ghi chú',
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