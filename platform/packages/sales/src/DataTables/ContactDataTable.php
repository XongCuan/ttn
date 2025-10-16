<?php

namespace TCore\Sales\DataTables;

use App\Enums\Contact\ContactStatus;
use App\Models\Contact;
use TCore\Base\Enums\Department;
use TCore\DataTable\Supports\DataTables;

class ContactDataTable extends DataTables
{
    public string $nameTable = 'contactTable';

    public function __construct(
        public Contact $model
    ){

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['info', 'status', 'admin_id', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => ContactStatus::asSelectArray()
            ]
        ];
    }

    protected function setFilterColumns(): void
    {
        $this-> filterColumns = [
            'admin_id' => fn($q, $k) => $q->whereRelation('creator', 'fullname', 'like', "%{$k}%"),
            'assigns' => fn($q, $k) => $q->whereRelation('assigns', 'fullname', 'like', "%{$k}%")
        ];
    }

    protected function setRemoveColumns(): void
    {
        if(get_auth_admin()->hasLeaderShipRole(Department::Sales) == false)
        {
            $this->removeColumns = [
                'assigns', 'admin_id'
            ];
        }
    }

    public function query()
    {
        return $this->model->makeQuery(relations: ['source', 'type', 'sector', 'rangePrice', 'province', 'district', 'ward', 'assigns', 'creator'])->followBySales();
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'status' => fn($row) => '<span class="badge '. $row->status->badge() .'">' . $row->status->description() . '</span>',
            'admin_id' => fn($data) => view('packages_sales::contacts.datatables.columns.creator')->with('data', $data),
            'created_at' => fn($row) => format_date($row->created_at)
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'info' => fn($data) => view('packages_sales::contacts.datatables.columns.info')->with('data', $data),
            'taxonomy' => fn($data) => view('packages_sales::contacts.datatables.columns.taxonomy')->with('data', $data),
            'action' => fn($data) => view('packages_sales::contacts.datatables.columns.action')->with('data', $data),
            'assigns' => fn($data) => $data->assigns->pluck('fullname')->implode(', '),
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'status', 'taxonomy', 'admin_id', 'info'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'info' => [
                'title' => 'Thông tin',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            // 'taxonomy' => [
            //     'title' => 'Phân loại',
            //     'orderable' => false,
            // ],
            'assigns' => [
                'title' => 'Phân Công',
                'orderable' => false,
            ],
            'admin_id' => [
                'title' => 'Người tạo',
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