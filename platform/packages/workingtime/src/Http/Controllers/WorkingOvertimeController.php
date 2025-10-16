<?php

namespace TCore\WorkingTime\Http\Controllers;

use App\Models\WorkingOvertime;
use Illuminate\Http\Request;
use TCore\WorkingTime\DataTables\WorkingTimeOvertimeDataTable;
use TCore\WorkingTime\Http\Requests\WorkingTimeOvertimeRequest;
use Theme\Cms\Http\Controllers\Controller;

class WorkingOvertimeController extends Controller
{
    public function __construct(
        public WorkingOvertime $model
    ) {}
    public function index(WorkingTimeOvertimeDataTable $dataTable)
    {
        return $dataTable->render('packages_workingtime::working_overtimes.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('OT')),
        ]);
    }

    public function create()
    {
        return view('packages_workingtime::working_overtimes.create')
            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('OT'), 'working_overtime.index')->add(trans('Thêm')));
    }

    public function store(WorkingTimeOvertimeRequest $request)
    {
        try {

            $data = $request->validated();

            $workingOvertime = $this->model->create($data);

            return $request->input('submitter') == 'save'
                ? utilities()->toRoute('working_overtime.edit', $workingOvertime->id)
                : utilities()->toRoute('working_overtime.index');
        } catch (\Throwable $th) {

            // throw $th;
            return utilities()->responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function edit($id)
    {
        $workingOvertime = $this->model->findOrFail($id)->load(['admin', 'type']);

        return view('packages_workingtime::working_overtimes.edit')

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('OT'), 'working_overtime.index')->add(trans('Sửa')))

            ->with('working_overtime', $workingOvertime);
    }

    public function update(WorkingTimeOvertimeRequest $request)
    {
        try {

            $data = $request->validated();

            $this->model->findOrFail($request->id)->update($data);

            return $request->input('submitter') == 'save'
                ? utilities()->responseBack()
                : utilities()->toRoute('working_overtime.index');
        } catch (\Throwable $th) {

            // throw $th;

            return utilities()->responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function delete($id)
    {
        try {

            $this->model->findOrFail($id)->delete();

            if (request()->ajax()) {
                return utilities()->responseAjax();
            }

            return utilities()->toRoute('working_overtime.index');
        } catch (\Throwable $th) {

            // throw $th;

            if (request()->ajax()) {
                return utilities()->responseAjax(error: true, msg: $th->getMessage());
            }

            return utilities()->responseBack(error: true, msg: $th->getMessage());
        }
    }
}
