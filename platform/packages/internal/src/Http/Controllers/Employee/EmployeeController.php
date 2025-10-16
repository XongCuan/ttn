<?php

namespace TCore\Internal\Http\Controllers\Employee;

use TCore\Internal\DataTables\EmployeeDataTable;
use Theme\Cms\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index(EmployeeDataTable $datatable)
    {
        return $datatable->render('packages_internal::employees.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Quản lý nhân viên'))
        ]);
    }
}