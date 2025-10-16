<?php

namespace TCore\WorkingTime\Http\Controllers;

use App\Models\TypeOvertime;
use TCore\Support\Http\Requests\Request;
use TCore\WorkingTime\DataTables\TypeOvertimeDataTable;
use TCore\WorkingTime\Http\Requests\TypeOvertimeRequest;
use Theme\Cms\Http\Controllers\Controller;

class TypeOvertimeController extends Controller
{
    public function __construct(
        public TypeOvertime $model
    ) {}

    public function index(TypeOvertimeDataTable $datatable)
    {
        return $datatable->render('packages_workingtime::type_overtimes.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Loại OT'))
        ]);
    }

    public function create()
    {
        return view('packages_workingtime::type_overtimes.modal.create');
    }

    public function store(TypeOvertimeRequest $request)
    {
        $data = $request->validated();

        $data['admin_id'] = auth('admin')->id();

        $this->model->create($data);

        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        return view('packages_workingtime::type_overtimes.modal.edit')->with('data', $this->model->findOrFail($id));
    }

    public function update(TypeOvertimeRequest $request)
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

    public function selectSearch(Request $request)
    {
        return [
            'results' => $this->model
                ->whereAny(['name'], 'like', '%' . $request->input('term', '') . '%')
                ->get()
                ->map(fn($item) => ['id' => $item->id, 'text' => $item->name . ' (x' . $item->value . ')'])
        ];
    }
}
