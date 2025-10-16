<?php

namespace TCore\Outsource\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Outsource\Http\DataView\DashboardData;
use Theme\Cms\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct(
        public DashboardData $data
    )
    {
        
    }

    public function index(Request $request)
    {
        $data = $this->data->make($request);

        $calc = $data->getDataCalc();

        return view('packages_outsource::dashboard.index')

        ->with('count_p_all', $calc->countAll())

        ->with('count_p_late', $calc->countLate())

        ->with('count_p_done', $calc->countDone())

        ->with('percent_p_done', $calc->percentDone())

        ->with('percent_p_late', $calc->percentLate())

        ->with('employees', $data->getEmployees())
        
        ->with('breadcrumbs', $this->breadcrumbs()->addByUrl(trans('Dự án'), route('outsource.project.index'))->add('Thống kê'));
    }
}