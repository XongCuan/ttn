<?php

namespace TCore\Marketing\DataTables;

use TCore\Base\Enums\Gender;
use TCore\DataTable\Supports\DataTables;
use TCore\Marketing\Models\Employee;

class EmployeeDataTable extends DataTables
{
    public string $nameTable = 'employeeTable';

    public function __construct(
        public Employee $model
    ){

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['fullname', 'email', 'phone', 'gender', 'birthday'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'gender' => [
                'data' => Gender::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        return $this->model->makeQuery();
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'gender' => fn($row) => $row->gender->description(),
            'birthday' => fn($row) => format_date($row->birthday)
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['gender'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'fullname' => [
                'title' => 'Họ và tên',
                'orderable' => false,
            ],
            'email' => [
                'title' => 'Email',
                'orderable' => false,
            ],
            'phone' => [
                'title' => 'Số điện thoại',
                'orderable' => false,
            ],
            'gender' => [
                'title' => 'Giới tính',
                'orderable' => false,
            ],
            'birthday' => [
                'title' => 'Sinh nhật',
                'orderable' => false,
                'visible' => false,
            ]
        ];
    }
}