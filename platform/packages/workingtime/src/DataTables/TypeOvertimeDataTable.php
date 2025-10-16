<?php

namespace TCore\WorkingTime\DataTables;

use App\Models\TypeOvertime;
use TCore\DataTable\Supports\DataTables;

class TypeOvertimeDataTable extends DataTables
{
    public string $nameTable = 'typeOvertimeTable';

    public function __construct(
        public TypeOvertime $model
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
            'action' => 'packages_workingtime::type_overtimes.datatables.columns.action',
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
            'value' => [
                'title' => 'Giá trị',
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