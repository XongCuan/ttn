<?php

namespace TCore\Accounting\Http\Controllers\Receipt;

use App\Models\ReceiptType;
use TCore\Accounting\DataTables\Receipt\ReceiptTypeDataTable;
use TCore\Accounting\Http\Requests\Receipt\ReceiptTypeRequest;
use Theme\Cms\Http\Controllers\Controller;

class ReceiptTypeController extends Controller
{
    public function __construct(
        public ReceiptType $model
    )
    {
        
    }

    public function index(ReceiptTypeDataTable $dataTable)
    {
        return $dataTable->render('packages_accounting::receipts.types.index', [
            'breadcrumbs' => $this->breadcrumbs()->add('Biên lai - chứng từ')->addByRouteName(trans('Loại'))
        ]);
    }

    public function create()
    {
        return view('packages_accounting::receipts.types.modal.create');
    }

    public function store(ReceiptTypeRequest $res)
    {
        $this->model->create($res->validated());

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        return view('packages_accounting::receipts.types.modal.edit')

        ->with('data', $this->model->findOrFail($id));
    }

    public function update(ReceiptTypeRequest $res)
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