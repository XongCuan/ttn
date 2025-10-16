<?php

namespace TCore\Sales\Services\Order;

use App\Enums\Contact\ContactStatus;
use App\Enums\Customer\CustomerReturnStatus;
use App\Enums\Customer\CustomerType;
use App\Enums\Order\OrderStatus;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use TCore\Sales\Http\Requests\OrderRequest;
use TCore\Sales\Models\CustomerReturn;
use TCore\Sales\Repositories\Order\OrderRepositoryInterface;

class OrderService
{
    public static OrderRequest $request;

    public Order $order;

    public function __construct(
        public OrderRepositoryInterface $repo
    )
    {
        
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            //code...
            $data = static::$request->validated();

            $customer = $this->getCustomer();

            $data['order']['team_id'] = $this->teamSalesId();
            $data['order']['status'] = $this->statusOrder();
            $data['order']['customer_id'] = $customer->id;
            $data['order']['customer_type'] = $customer->enumCustomerType();
            $data['order']['total'] = $data['order']['sub_total'] = $this->totalAmountService();
            $data['order']['admin_id'] = auth('admin')->id();

            $this->order = $this->repo->create($data['order']);

            $this->order->services()->createMany($data['service']);

            if (static::$request->has('payment'))
            {
                $this->order->payments()->createMany($data['payment']);
            }

            if (get_auth_admin()->hasLeaderShipRoleSales() && static::$request->has('assigns'))
            {
                $this->order->assigns()->attach($data['assigns']);
            }

            DB::commit();

            return $this;

        } catch (\Throwable $th) {
            DB::rollBack();            
            throw $th;
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            //code...
            $data = static::$request->validated();
            $data['order']['team_id'] = $this->teamSalesId();

            $this->order = $this->repo->update($data['order']['id'], $data['order']);

            if(get_auth_admin()->hasLeaderShipRoleSales())
            {
                $this->order->assigns()->sync(static::$request->input('assigns', []));
            }

            $this->updateConditionCustomer();

            DB::commit();

            return $this;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $order = $this->repo->findOrFail(static::$request->route('id'));

            $order->services()->delete();

            $order->arises()->delete();

            $order->payments()->delete();

            $order->delete();
            
            DB::commit();
            
            return true;
        } catch (\Throwable $th) {
            
            DB::rollBack();
            throw $th;
        }
    }

    public function updateConditionCustomer()
    {
        if($this->order->wasChanged('status') && static::$request->enum('order.status', OrderStatus::class) == OrderStatus::Completed)
        {
            $this->order->customer->update([
                'is_new' => false
            ]);
        }
    }

    public function teamSalesId()
    {
        if(get_auth_admin()->hasManagerShipRoleSales())
        {
            return static::$request->input('order.team_id');
        }

        return get_auth_admin()->team_id;
    }

    public function getCustomer(): Customer
    {
        if(static::$request->has('order.customer_id'))
        {
            $customer = Customer::findOrFail(static::$request->input('order.customer_id'));

        }elseif(static::$request->has('order.customer_return_id')) {

            $customerReturn = CustomerReturn::findOrFail(static::$request->input('order.customer_return_id'));

            $customerReturn->update([
                'status' => CustomerReturnStatus::Completed
            ]);

            $customer = $customerReturn->customer;

        }else {

            $contact = Contact::findOrFail(static::$request->input('order.contact_id'));

            $contact->update([
                'status' => ContactStatus::Completed
            ]);

            $customer = $contact->cloneToCustomer();
        }

        return $customer;
    }

    public function statusOrder()
    {
        return static::$request->has('payment') ? OrderStatus::Deposited : OrderStatus::Unpaid;
    }

    public function totalAmountService()
    {
        return array_sum(array_column(static::$request->input('service'), 'amount'));
    }

    public static function make(OrderRequest $request)
    {
        static::$request = $request;

        return new static(app()->make(OrderRepositoryInterface::class));
    }
}