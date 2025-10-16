<?php

namespace TCore\Marketing\Http\Controllers\Employee;

use TCore\Marketing\DataTables\EmployeeDataTable;
use Theme\Cms\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index(EmployeeDataTable $datatable)
    {
        return $datatable->render('packages_marketing::employees.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Quản lý nhân viên'))
        ]);
    }
}