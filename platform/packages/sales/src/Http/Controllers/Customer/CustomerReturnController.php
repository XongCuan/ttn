<?php

namespace TCore\Sales\Http\Controllers\Customer;

use App\Enums\Customer\CustomerReturnStatus;
use TCore\Sales\DataTables\CustomerReturnDataTable;
use TCore\Sales\Http\Requests\CustomerReturnRequest;
use TCore\Sales\Models\CustomerReturn;
use Theme\Cms\Http\Controllers\Controller;

class CustomerReturnController extends Controller
{
    public function __construct(
        public CustomerReturn $model
    )
    {
        
    }
    public function index(CustomerReturnDataTable $dataTable)
    {
        return $dataTable->render('packages_sales::customer_returns.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Khách hàng quay lại'))
        ]);
    }

    public function create()
    {
        return view('packages_sales::customer_returns.modal.create');
    }

    public function store(CustomerReturnRequest $request)
    {
        $data = $request->validated();
        $data['status'] = CustomerReturnStatus::Consulting;
        $data['admin_id'] = auth('admin')->id();

        $this->model->create($data);

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        return view('packages_sales::customer_returns.modal.edit')

        ->with('status', CustomerReturnStatus::asSelectArrayAvailable())
        
        ->with('data', $this->model->findOrFail($id)->load(['customer']));
    }

    public function update(CustomerReturnRequest $request)
    {
        $this->model->findOrFail($request->input('id'))->update($request->validated());

        return utilities()->responseAjax();
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();

        return utilities()->responseAjax();
    }
}