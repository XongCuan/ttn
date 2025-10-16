<?php

namespace TCore\Accounting\DataTables\Receipt;

use App\Models\Receipt;
use TCore\DataTable\Supports\DataTables;

class ReceiptDataTable extends DataTables
{
    public string $nameTable = 'receipt';

    public function __construct(
        public Receipt $model
    )
    {
        
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = [
            'type_id', 'receipt_date'
        ];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = [
            'receipt_date'
        ];
    }

    public function query()
    {
        return $this->model->makeQuery(filter: [], relations: ['type']);
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'type_id' => fn($q, $k) => $q->whereRelation('type', 'name', 'like', "%$k%")
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'receipt_date' => fn($row) => format_date($row->receipt_date),
            'type_id' => fn($row) => $row->type->name,
            'amount' => fn($row) => format_price($row->amount),
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_accounting::receipts.datatables.columns.action'
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            
            'receipt_date' => [
                'title' => 'Ngày',
                'orderable' => false,
            ],

            'type_id' => [
                'title' => 'Loại',
                'orderable' => false,
            ],

            'amount' => [
                'title' => 'Số tiền',
                'orderable' => false,
            ],

            'desc' => [
                'title' => 'Mô tả',
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