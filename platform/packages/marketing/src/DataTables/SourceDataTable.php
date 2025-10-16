<?php

namespace TCore\Marketing\DataTables;

use App\Models\Source;
use TCore\DataTable\Supports\DataTables;

class SourceDataTable extends DataTables
{
    public string $nameTable = 'sourceTable';

    public function __construct(
        public Source $model
    ){

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['name', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    public function query()
    {
        return $this->model->makeQuery();
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'created_at' => fn($row) => format_date($row->created_at)
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_marketing::sources.datatables.columns.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action'];
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