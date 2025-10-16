<?php

namespace TCore\Superadmin\DataTables\Document;

use App\Models\Document;
use TCore\DataTable\Supports\DataTables;

class DocumentDataTable extends DataTables
{
    public string $nameTable = 'document';

    public function __construct(
        public Document $model
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
            'document_date'
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
            'document_date' => fn($row) => format_date($row->document_date),
            'type_id' => fn($row) => $row->type->name,
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_superadmin::documents.datatables.columns.action'
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            
            'document_date' => [
                'title' => 'Ngày',
                'orderable' => false,
            ],

            'type_id' => [
                'title' => 'Loại',
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