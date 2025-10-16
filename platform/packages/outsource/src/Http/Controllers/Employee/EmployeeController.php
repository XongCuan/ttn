<?php

namespace TCore\Outsource\Http\Controllers\Employee;

use TCore\Outsource\DataTables\EmployeeDataTable;
use Theme\Cms\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index(EmployeeDataTable $datatable)
    {
        return $datatable->render('packages_outsource::employees.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Quản lý nhân viên'))
        ]);
    }
}