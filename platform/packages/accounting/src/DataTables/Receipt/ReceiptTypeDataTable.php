<?php

namespace TCore\Accounting\DataTables\Receipt;

use App\Models\ReceiptType;
use TCore\DataTable\Supports\DataTables;

class ReceiptTypeDataTable extends DataTables
{
    public string $nameTable = 'receiptType';

    public function __construct(
        public ReceiptType $model
    )
    {
        
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = [
            'name'
        ];
    }

    public function query()
    {
        return $this->model->makeQuery(filter: []);
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_accounting::receipts.types.datatables.columns.action'
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'desc'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            
            'name' => [
                'title' => 'Tên',
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