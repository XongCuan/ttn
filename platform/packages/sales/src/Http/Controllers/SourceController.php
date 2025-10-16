<?php

namespace TCore\Sales\Http\Controllers;

use App\Models\Source;
use TCore\Sales\DataTables\SourceDataTable;
use TCore\Sales\Http\Requests\SourceRequest;
use Theme\Cms\Http\Controllers\Controller;

class SourceController extends Controller
{
    public function __construct(
        public Source $model
    )
    {
        
    }

    public function index(SourceDataTable $datatable)
    {
        return $datatable->render('packages_sales::sources.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Phân loại KH/LH'))->add(trans('Nguồn'))
        ]);
    }

    public function create()
    {
        return view('packages_sales::sources.modal.create');
    }

    public function store(SourceRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth('admin')->id();

        $this->model->create($data);

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        return view('packages_sales::sources.modal.edit')->with('data', $this->model->findOrFail($id));
    }

    public function update(SourceRequest $request)
    {
        $this->model->findOrFail($request->input('id'))
        ->update($request->validated());
     
        return utilities()->responseAjax();
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return utilities()->responseAjax();
    }
}