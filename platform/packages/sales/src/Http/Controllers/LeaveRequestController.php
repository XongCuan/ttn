<?php

namespace TCore\Sales\Http\Controllers;

use TCore\Sales\DataTables\LeaveRequestDataTable;
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