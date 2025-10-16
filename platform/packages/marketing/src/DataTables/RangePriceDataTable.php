<?php

namespace TCore\Marketing\DataTables;

use App\Models\RangePrice;
use TCore\DataTable\Supports\DataTables;

class RangePriceDataTable extends DataTables
{
    public string $nameTable = 'rangePriceTable';

    public function __construct(
        public RangePrice $model
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
            'range_price' => fn($row) => format_price($row->min_price) . ' - ' . format_price($row->max_price),
            'action' => 'packages_marketing::range_prices.datatables.columns.action',
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
            'range_price' => [
                'title' => 'Khoảng giá',
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