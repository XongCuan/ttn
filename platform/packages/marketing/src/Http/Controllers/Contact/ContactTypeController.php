<?php

namespace TCore\Marketing\Http\Controllers\Contact;

use App\Models\ContactType;
use TCore\Marketing\DataTables\ContactTypeDataTable;
use TCore\Marketing\Http\Requests\ContactTypeRequest;
use Theme\Cms\Http\Controllers\Controller;

class ContactTypeController extends Controller
{
    public function __construct(
        public ContactType $model
    )
    {
        
    }

    public function index(ContactTypeDataTable $datatable)
    {
        return $datatable->render('packages_marketing::contact_types.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Phân loại KH/LH'))->add(trans('Loại'))
        ]);
    }

    public function create()
    {
        return view('packages_marketing::contact_types.modal.create');
    }

    public function store(ContactTypeRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth('admin')->id();

        $this->model->create($data);

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        return view('packages_marketing::contact_types.modal.edit')->with('data', $this->model->findOrFail($id));
    }

    public function update(ContactTypeRequest $request)
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