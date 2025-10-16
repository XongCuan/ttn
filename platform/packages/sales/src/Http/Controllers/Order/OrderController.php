<?php

namespace TCore\Sales\Http\Controllers\Order;

use App\Enums\Contact\ContactStatus;
use App\Enums\Customer\CustomerReturnStatus;
use App\Enums\Order\OrderPriority;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\ServiceType;
use App\Models\Contact;
use App\Models\Project;
use Illuminate\Http\Request;
use TCore\Sales\DataTables\OrderDataTable;
use TCore\Sales\Http\Requests\OrderRequest;
use TCore\Sales\Models\CustomerReturn;
use TCore\Sales\Repositories\Order\OrderRepositoryInterface;
use TCore\Sales\Services\Order\OrderService;
use Theme\Cms\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct(
        public OrderRepositoryInterface $repo,
        public CustomerReturn $modelCR,
        public Contact $modelContact,
        public Project $modelProject
    )
    {
        
    }
    public function index(OrderDataTable $dataTable)
    {
        $listYears = $this->repo->getQueryBuilder()
        ->selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

        return $dataTable->render('packages_sales::orders.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Đơn hàng')),
            'list_years' => $listYears
        ]);
    }

    public function create(OrderRequest $request)
    {
        $type = null;

        if($request->has('customer_return_id'))
        {
            $type = $this->modelCR->findByOrFail([
                'id' => $request->customer_return_id,
                ['status', '!=', CustomerReturnStatus::Completed]
            ])->load(['customer']);

        }elseif($request->has('contact_id')) {
            
            $type = $this->modelContact->findByOrFail([
                'id' => $request->contact_id,
                ['status', '!=', ContactStatus::Completed]
            ]);
        }

        return view('packages_sales::orders.create')

        ->with('service_type', ServiceType::asSelectArray())

        ->with('type', $type)

        ->with('priority', OrderPriority::asSelectArray())

        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Đơn hàng'), 'sales.order.index')->add('Thêm'));
    }

    public function store(OrderRequest $request)
    {
        $order = OrderService::make($request)->store()->getOrder();

        return utilities()->toRoute('sales.order.edit', $order->id);
    }

    public function edit($id)
    {
        $order = $this->repo->findOrFail($id, ['services', 'customer', 'creator', 'assigns', 'payments', 'arises']);

        $projects = $this->modelProject->getBy(filter: ['order_id' => $id], relations: ['teamInternal', 'teamOutsource', 'assigns']);

        return view('packages_sales::orders.edit')

        ->with('service_type', ServiceType::asSelectArray())

        ->with('status', OrderStatus::asSelectArray())

        ->with('priority', OrderPriority::asSelectArray())

        ->with('order', $order)

        ->with('projects', $projects)

        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Đơn hàng'), 'sales.order.index')->add(trans('Sửa Đơn hàng ID: #:id', ['id' => $order->id])));
    }

    public function update(OrderRequest $request)
    {
        OrderService::make($request)->update();

        return utilities()->responseBack();
    }

    public function info($id)
    {
        return view('packages_sales::orders.modals.info')

        ->with('data', $this->modelProject->getBy(filter: ['order_id' => $id], relations: ['teamInternal', 'teamOutsource', 'assigns']));
    }

    public function delete($id, OrderRequest $request)
    {
        OrderService::make($request)->delete();
        if($request->ajax())
        {
            return utilities()->responseAjax();
        }

        return utilities()->toRoute('sales.order.index');
    }
}