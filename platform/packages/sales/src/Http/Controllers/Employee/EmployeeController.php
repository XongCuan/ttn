<?php

namespace TCore\Sales\Http\Controllers\Employee;

use TCore\Sales\DataTables\EmployeeDataTable;
use Theme\Cms\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index(EmployeeDataTable $datatable)
    {
        return $datatable->render('packages_sales::employees.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Quản lý nhân viên'))
        ]);
    }
}