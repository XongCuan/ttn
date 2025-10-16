<?php

namespace TCore\Sales\Http\Controllers\Order;

use App\Models\OrderService;
use Illuminate\Support\Facades\DB;
use TCore\Base\Http\Controllers\Controller;
use TCore\Sales\Http\Requests\OrderServiceRequest;
use TCore\Sales\Services\Order\OrderServiceService;

class OrderServiceController extends Controller
{
    public function __construct(
        public OrderService $model
    )
    {
        
    }

    public function create(OrderServiceRequest $request)
    {
        return OrderServiceService::make($request)->create();
    }

    public function storeFake(OrderServiceRequest $request)
    {
        $html = OrderServiceService::make($request)->storeFakeMultiple();

        return utilities()->responseAjax(data: [
            'html' => $html
        ]);
    }

    public function show($id)
    {
        $service = $this->model->findOrFail($id);
        
        return view('packages_sales::orders.services.edit.show')
        ->with('service', $service);
    }

    public function edit($id)
    {
        $service = $this->model->findOrFail($id);
        
        return view('packages_sales::orders.services.edit.modal-edit')
        ->with('service', $service);
    }

    public function update(OrderServiceRequest $request)
    {
        $service = $this->model->findOrFail($request->input('id'));

        DB::beginTransaction();
        try {
            //code...
            $data = $request->validated();
            $data['amount'] = string_to_integer($data['amount']);

            $service->update($data);

            DB::commit();

            return utilities()->responseBack();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();

        return utilities()->responseAjax();
    }
}