<?php

namespace TCore\Superadmin\DataTables;

use TCore\Superadmin\Repositories\Admin\AdminRepositoryInterface;
use TCore\Base\Enums\Gender;
use TCore\DataTable\Supports\DataTables;

class AdminDataTable extends DataTables
{

    public string $nameTable = 'adminTable';

    public function __construct(
        public AdminRepositoryInterface $repository
    ){

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['fullname', 'phone', 'email', 'gender', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'gender' => [
                'data' => Gender::asSelectArray()
            ]
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->orderBy('id', 'desc');
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'gender' => fn($row) => $row->gender?->description(),
            'created_at' => fn($row) => format_date($row->created_at)
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'packages_superadmin::admin.datatables.columns.action',
            'role' => fn($row) => view('packages_superadmin::admin.datatables.columns.role', ['admin' => $row])
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'role'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'fullname' => [
                'title' => 'Họ và tên',
                'orderable' => false,
            ],
            'phone' => [
                'title' => 'SĐT',
                'orderable' => false,
            ],
            'email' => [
                'title' => 'Email',
                'orderable' => false,
            ],
            'gender' => [
                'title' => 'Giới tính',
                'orderable' => false,
            ],
            'role' => [
                'title' => 'Vai trò',
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
