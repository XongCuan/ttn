<?php

namespace TCore\Sales\Http\Requests;

use TCore\Support\Http\Requests\Request;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Order\ServiceType;
use TCore\Support\Rules\StringToNumber;

class OrderServiceRequest extends Request
{
    protected function methodGet()
    {
        return [
            'service_type' => ['required', new Enum(ServiceType::class)]
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        $validate = [];
        
        if($this->routeIs('admin.order_service.store_fake'))
        {
            $validate['service.*.amount'] = ['required', new StringToNumber];
            $validate['service.*.day_begin'] = ['nullable', 'date_format:Y-m-d'];
            $validate['service.*.day_end'] = ['nullable', 'date_format:Y-m-d'];
            $validate['service.*.desc'] = ['nullable'];

            if($this->has('is_service_website') && $this->input('is_service_website') == true)
            {
                $validate['service.*.type'] = ['required', new Enum(ServiceType::class)];
                
                // $validate = [
                //     'service.*.type' => ['required', new Enum(ServiceType::class)],
                //     'service.10.day_begin' => ['nullable', 'date_format:Y-m-d'],
                //     'service.10.day_end' => ['nullable', 'date_format:Y-m-d'],
                // ];
            }

        }

        return $validate;
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\OrderService,id'],
            'amount' => ['required', new StringToNumber],
            'day_begin' => ['nullable', 'date_format:Y-m-d'],
            'day_end' => ['nullable', 'date_format:Y-m-d'],
            'desc' => ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'service.*.amount' => trans('Vui lòng nhập số tiền'),
            'service.*.day_begin' => trans('Vui lòng nhập ngày bắt đầu sử dụng'),
            'service.*.day_end' => trans('Vui lòng nhập ngày hết hạn')
        ];
    }
}