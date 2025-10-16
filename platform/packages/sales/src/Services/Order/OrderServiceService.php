<?php

namespace TCore\Sales\Services\Order;

use App\Enums\Order\ServiceType;
use TCore\Sales\Http\Requests\OrderServiceRequest;

class OrderServiceService
{
    public static $request;

    public function create()
    {
        $serviceType = static::$request->enum('service_type', ServiceType::class) ?: ServiceType::Website;

        return view('packages_sales::orders.services.create.modal')

        ->with('service_type_domain', ServiceType::Domain)

        ->with('service_type_hosting', ServiceType::Hosting)

        ->with('service_type', $serviceType);
    }

    public function storeFakeMultiple()
    {
        return $this->storeFakeWebsite() . $this->storeFakeDomain() . $this->storeFakeHosting() . $this->storeFakeSeo();
    }

    public function storeFakeSeo()
    {
        if(static::$request->has('is_service_seo') && static::$request->input('is_service_seo') == true)
        {
            return $this->storeFakeItem(ServiceType::Seo);
        }

        return '';
    }

    public function storeFakeDomain()
    {
        if(static::$request->has('is_service_domain') && static::$request->input('is_service_domain') == true)
        {
            return $this->storeFakeItem(ServiceType::Domain);
        }

        return '';
    }

    public function storeFakeHosting()
    {
        if(static::$request->has('is_service_hosting') && static::$request->input('is_service_hosting') == true)
        {
            return $this->storeFakeItem(ServiceType::Hosting);
        }

        return '';
    }

    public function storeFakeWebsite()
    {
        if(static::$request->has('is_service_website') && static::$request->input('is_service_website') == true)
        {
            return $this->storeFakeItem(ServiceType::Website);
        }

        return '';
    }

    public function storeFakeItem(ServiceType $service_type)
    {
        $responseData = [
            'service_type' => $service_type,
            'service_data' => static::$request->input('service.' . $service_type->value),
            'uniqid' => uniqid_real(3)
        ];

        return view('packages_sales::orders.services.create.item-table', $responseData)->render();
    }

    public static function make(OrderServiceRequest $request)
    {
        static::$request = $request;

        return new static;
    }
}