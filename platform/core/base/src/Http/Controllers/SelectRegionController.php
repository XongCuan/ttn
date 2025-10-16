<?php

namespace TCore\Base\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Base\Models\District;
use TCore\Base\Models\Province;
use TCore\Base\Models\Ward;

class SelectRegionController extends Controller
{
    public function __construct()
    {
        
    }

    public function getProvinces(Request $request)
    {
        $provinces = Province::select('code', 'name');

        if($keyword = $request->get('term', ''))
        {
            $provinces = $provinces->where('name', 'like', "%{$keyword}%");
        }

        return [
            'results' => $provinces->get()->map(fn($item) => ['id' => $item->code, 'text' => $item->name])
        ];
    }
    
    public function getDistricts($province_code, Request $request)
    {
        $districts = District::select('code', 'name')->where('province_code', $province_code);

        if($keyword = $request->get('term', ''))
        {
            $districts = $districts->where('name', 'like', "%{$keyword}%");
        }

        return [
            'results' => $districts->get()
                ->map(fn($item) => ['id' => $item->code, 'text' => $item->name])
        ];
    }

    public function getWards($district_code, Request $request)
    {
        $wards = Ward::select('code', 'name')->where('district_code', $district_code);

        if($keyword = $request->get('term', ''))
        {
            $wards = $wards->where('name', 'like', "%{$keyword}%");
        }

        return [
            'results' => $wards->get()
                ->map(fn($item) => ['id' => $item->code, 'text' => $item->name])
        ];
    }
}