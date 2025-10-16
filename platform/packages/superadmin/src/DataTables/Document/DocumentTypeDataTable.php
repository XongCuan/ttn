<?php

namespace TCore\Superadmin\DataTables\Document;

use App\Models\DocumentType;
use TCore\DataTable\Supports\DataTables;

class DocumentTypeDataTable extends DataTables
{
    public string $nameTable = 'documentType';

    public function __construct(
        public DocumentType $model
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
        return $this->model->getFlatTree();
    }

    protected function makeBuilderDataTable($query): void
    {
        $this->instanceDataTable = datatables()->collection($query);
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_superadmin::documents.types.datatables.columns.action'
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'name' => fn($row) => str_repeat('-', $row->depth) . ' ' . $row->name
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