<?php

namespace TCore\Marketing\Http\Controllers;

use App\Models\Sector;
use TCore\Marketing\DataTables\SectorDataTable;
use TCore\Marketing\Http\Requests\SectorRequest;
use Theme\Cms\Http\Controllers\Controller;

class SectorController extends Controller
{
    public function __construct(
        public Sector $model
    )
    {
        
    }

    public function index(SectorDataTable $datatable)
    {
        return $datatable->render('packages_marketing::sectors.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Phân loại KH/LH'))->add(trans('Lĩnh vực'))
        ]);
    }

    public function create()
    {
        return view('packages_marketing::sectors.modal.create');
    }

    public function store(SectorRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth('admin')->id();

        $this->model->create($data);

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        return view('packages_marketing::sectors.modal.edit')->with('data', $this->model->findOrFail($id));
    }

    public function update(SectorRequest $request)
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