<?php

namespace TCore\Sales\Http\Controllers\Order;

use App\Models\OrderPayment;
use TCore\Base\Http\Controllers\Controller;
use TCore\Sales\Http\Requests\OrderPaymentRequest;

class OrderPaymentController extends Controller
{ 
    public function __construct(
        public OrderPayment $model
    )
    {
        
    }

    public function create($order_id = null)
    {
        if($order_id)
        {
            return view('packages_sales::orders.payments.edit.modal-add')->with('order_id', $order_id);
        }

        return view('packages_sales::orders.payments.create.modal');
    }

    public function storeFake(OrderPaymentRequest $request)
    {
        $data = $request->validated();
        
        return utilities()->responseAjax(data: [
            'html' => view('packages_sales::orders.payments.create.item-table')->with('uniqid', uniqid_real(3))->with('payment_data', $data)->render()
        ]);
    }

    public function store(OrderPaymentRequest $request)
    {
        $data = $request->validated();
        $data['amount'] = string_to_integer($data['amount']);

        $this->model->create($data);

        return utilities()->responseAjax();
    }

    public function show($id)
    {
        $payment = $this->model->findOrFail($id);

        return view('packages_sales::orders.payments.show.modal')->with('payment', $payment);
    }

    public function edit($id)
    {
        $payment = $this->model->findOrFail($id);

        return view('packages_sales::orders.payments.edit.modal-edit')->with('payment', $payment);
    }

    public function update(OrderPaymentRequest $request)
    {
        $data = $request->validated();
        
        $data['amount'] = string_to_integer($data['amount']);

        $payment = $this->model->findOrFail($data['id']);

        $payment->update($data);

        return utilities()->toRoute('sales.order.edit', $payment->order_id);
    }
}