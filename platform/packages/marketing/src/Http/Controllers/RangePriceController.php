<?php

namespace TCore\Marketing\Http\Controllers;

use App\Models\RangePrice;
use TCore\Marketing\DataTables\RangePriceDataTable;
use TCore\Marketing\Http\Requests\RangePriceRequest;
use Theme\Cms\Http\Controllers\Controller;

class RangePriceController extends Controller
{
    public function __construct(
        public RangePrice $model
    )
    {
        
    }

    public function index(RangePriceDataTable $datatable)
    {
        return $datatable->render('packages_marketing::range_prices.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Phân loại KH/LH'))->add(trans('Tầm giá'))
        ]);
    }

    public function create()
    {
        return view('packages_marketing::range_prices.modal.create');
    }

    public function store(RangePriceRequest $request)
    {
        $data = $request->validated();
        $data['min_price'] = string_to_integer($data['min_price']);
        $data['max_price'] = string_to_integer($data['max_price']);
        $data['admin_id'] = auth('admin')->id();
        
        $this->model->create($data);

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        return view('packages_marketing::range_prices.modal.edit')->with('data', $this->model->findOrFail($id));
    }

    public function update(RangePriceRequest $request)
    {
        $data = $request->validated();
        $data['min_price'] = string_to_integer($data['min_price']);
        $data['max_price'] = string_to_integer($data['max_price']);

        $this->model->findOrFail($request->input('id'))
        ->update($data);
     
        return utilities()->responseAjax();
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return utilities()->responseAjax();
    }
}