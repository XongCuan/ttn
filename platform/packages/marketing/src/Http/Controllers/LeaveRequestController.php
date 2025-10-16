<?php

namespace TCore\Marketing\Http\Controllers;

use TCore\Marketing\DataTables\LeaveRequestDataTable;
use TCore\Sales\Repositories\Order\OrderRepositoryInterface;
use Theme\Cms\Http\Controllers\Controller;

class LeaveRequestController extends Controller
{
    public function __construct(
        public OrderRepositoryInterface $orderRepo
    ) {

    }
    public function index(LeaveRequestDataTable $dataTable)
    {
        return $dataTable->render('packages_outsource::leave_request.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Duyệt nghỉ phép'))
        ]);
    }
}