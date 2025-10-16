<?php

namespace TCore\Sales\Http\Requests;

use App\Enums\Order\OrderPriority;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\ServiceType;
use Illuminate\Validation\Rules\Enum;
use TCore\Support\Http\Requests\Request;

class OrderRequest extends Request
{
    protected function methodGet()
    {
        if($this->routeIs('sales.order.create'))
        {
            return [
                'customer_return_id' => ['nullable', 'exists:TCore\Sales\Models\CustomerReturn,id'],
                'contact_id' => ['nullable', 'exists:App\Models\Contact,id']
            ];
        }    
    }

    protected function methodPost()
    {
        return [
            'order.customer_id' => ['nullable', 'exists:App\Models\Customer,id'],
            'order.contact_id' => ['nullable', 'exists:App\Models\Contact,id'],
            'order.customer_return_id' => ['nullable', 'exists:TCore\Sales\Models\CustomerReturn,id'],
            'order.team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigns' => ['nullable', 'array'],
            'assigns.*' => ['nullable', 'exists:TCore\Sales\Models\Employee,id'],
            'order.priority' => ['required', new Enum(OrderPriority::class)],
            'order.name' => ['required', 'string'],
            'order.desc' => ['nullable'], 
            'order.type' => ['nullable'], 
            'order.type_id' => ['nullable'], 
            'service' => ['required', 'array'],
            'services.*.type' => ['required', new Enum(ServiceType::class)],
            'services.*.amount' => ['required', 'numeric'],
            'services.*.day_begin' => ['nullable', 'date_format:Y-m-d'],
            'services.*.day_end' => ['nullable', 'date_format:Y-m-d'],
            'payment' => ['nullable', 'array'],
            'payment.*.amount' => ['required', 'integer', 'min:0'],
            'payment.*.name' => ['required', 'string'],
            'payment.*.desc' => ['required']
        ];
    }

    protected function methodPut()
    {
        return [
            'order.id' => ['required', 'exists:App\Models\Order,id'],
            'order.team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'order.priority' => ['required', new Enum(OrderPriority::class)],
            'order.status' => ['required', new Enum(OrderStatus::class)],
            'assigns' => ['nullable', 'array'],
            'assigns.*' => ['nullable', 'exists:TCore\Sales\Models\Employee,id'],
            'order.name' => ['required', 'string'],
            'order.status' => ['required', new Enum(OrderStatus::class)],
            'order.desc' => ['nullable']
        ];
    }
}