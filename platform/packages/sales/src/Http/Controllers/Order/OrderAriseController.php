<?php

namespace TCore\Sales\Http\Controllers\Order;

use App\Models\OrderArise;
use Illuminate\Support\Facades\DB;
use TCore\Base\Http\Controllers\Controller;
use TCore\Sales\Http\Requests\OrderAriseRequest;

class OrderAriseController extends Controller
{
    public function __construct(
        public OrderArise $model
    )
    {
        
    }

    public function create($order_id)
    {
        return view('packages_sales::orders.arises.create.modal')->with('order_id', $order_id);
    }

    public function store(OrderAriseRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['amount'] = string_to_integer($data['amount']);

            $arise = $this->model->create($data);

            $arise->order->update([
                'total' => $arise->amount + $arise->order->total
            ]);

            DB::commit();

            session()->flash('success', trans('Thêm phát sinh thành công'));

            return utilities()->responseAjax();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show($id)
    {
        $arise = $this->model->findOrFail($id);

        return view('packages_sales::orders.arises.show')->with('arise', $arise);
    }

    public function edit($id)
    {
        $arise = $this->model->findOrFail($id);

        return view('packages_sales::orders.arises.edit')->with('arise', $arise);
    }

    public function update(OrderAriseRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['amount'] = string_to_integer($data['amount']);

            $arise = $this->model->findOrFail($data['id'])->load(['order']);

            if($data['amount'] - $arise->amount != 0)
            {
                $arise->order->update([
                    'total' => $arise->order->total + $data['amount'] - $arise->amount
                ]);
            }
            
            $arise->update($data);

            DB::commit();

            return utilities()->toRoute('sales.order.edit', $arise->order_id);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $arise = $this->model->findOrFail($id)->load('order');

            $arise->order->update([
                'total' => $arise->order->total - $arise->amount
            ]);

            $arise->delete();

            DB::commit();

            return utilities()->toRoute('sales.order.edit', $arise->order->id);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}