<?php

namespace TCore\Superadmin\Http\Controllers\Document;

use App\Models\DocumentType;
use TCore\Superadmin\DataTables\Document\DocumentTypeDataTable;
use TCore\Superadmin\Http\Requests\Document\DocumentTypeRequest;
use Theme\Cms\Http\Controllers\Controller;

class DocumentTypeController extends Controller
{
    public function __construct(
        public DocumentType $model
    )
    {
        
    }

    public function index(DocumentTypeDataTable $dataTable)
    {
        return $dataTable->render('packages_superadmin::documents.types.index', [
            'breadcrumbs' => $this->breadcrumbs()->add('Tài liệu')->addByRouteName(trans('Loại'))
        ]);
    }

    public function create()
    {
        return view('packages_superadmin::documents.types.modal.create')->with('parents', $this->model->getFlatTree());
    }

    public function store(DocumentTypeRequest $res)
    {
        $this->model->create($res->validated());

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        return view('packages_superadmin::documents.types.modal.edit')

        ->with('parents', $this->model->getFlatTree())

        ->with('data', $this->model->findOrFail($id));
    }

    public function update(DocumentTypeRequest $res)
    {
        $this->model->findOrFail($res->input('id'))->update($res->validated());

        return utilities()->responseAjax();
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();

        return utilities()->responseAjax();
    }
}