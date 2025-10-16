<?php

namespace TCore\Webadmin\Http\Controllers;

use App\Enums\Project\ProjectRequirementStatus;
use App\Enums\Project\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Sales\Repositories\Order\OrderRepositoryInterface;
use TCore\Webadmin\DataTables\ProjectRequirementDataTable;
use TCore\Webadmin\Http\Requests\PRequirementRequest;
use TCore\Webadmin\Models\PRequirement;
use Theme\Cms\Http\Controllers\Controller;

class ProjectRequirementController extends Controller
{
    public function __construct(
        public OrderRepositoryInterface $orderRepo,
        public PRequirement $model
    )
    {
        
    }
    public function index(ProjectRequirementDataTable $dataTable)
    {
        return $dataTable->render('packages_webadmin::project_requirements.index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Yêu cầu dự án'))
        ]);
    }

    public function create()
    {
        return view('packages_webadmin::project_requirements.create')
            
        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Yêu cầu dự án'), 'webadmin.project_requirement.index')->add('Thêm'));
    }

    public function store(PRequirementRequest $request)
    {
        $data = $request->validated();
        $data['status'] = ProjectRequirementStatus::Todo;

        $project = $this->model->create($data);

        return utilities()->toRoute('webadmin.project_requirements.edit', $project->id);
    }

    public function edit($id)
    {
        $data = $this->model->findOrFail($id)->load(['assign', 'order', 'team', 'project']);
        
        return view('packages_webadmin::project_requirements.edit')

        ->with('status', ProjectRequirementStatus::asSelectArray())

        ->with('data', $data)

        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Yêu cầu dự án'), 'webadmin.project_requirement.index')->add('Sửa'));

    }

    public function update(PRequirementRequest $request)
    {
        $data = $request->validated();

        $this->model->findOrFail($data['id'])->update($data);

        return utilities()->responseBack();
    }

    public function orderInfo(Request $request)
    {
        $order = $this->orderRepo->findOrFail($request->order_id)->load('services');

        return view('packages_outsource::partials.order-info')->with('order', $order)->render();
    }

    public function changeStatus($id)
    {
        return view('packages_webadmin::project_requirements.modal.change-status')
        
        ->with('data', $this->model->findOrFail($id))
        
        ->with('status', ProjectRequirementStatus::asSelectArray());
    }

    public function updateStatus(PRequirementRequest $request)
    {
        $data = $request->validated();

        $this->model->findOrFail($data['id'])->update($data);

        return utilities()->responseAjax();
    }

    public function delete($id, Request $request)
    {
        $this->model->findOrFail($id)->delete();

        if ($request->ajax())
        {
            return utilities()->responseAjax();
        }

        return utilities()->toRoute('webadmin.project_requirement.index');
    }

    public function confirmDemo($id)
    {
        return view('packages_webadmin::project_requirements.modal.confirm-demo')
        
        ->with('data', $this->model->findOrFail($id)->load(['project']));
    }

    public function handleConfirmDemo(PRequirementRequest $request)
    {
        $data = $request->validated();

        $this->model->findOrFail($data['id'])->project()->update([
            'status' => ProjectStatus::Done
        ]);

        return utilities()->responseAjax();
    }
}