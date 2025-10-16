<?php

namespace TCore\Outsource\Http\Controllers;

use App\Enums\Project\ProjectPriority;
use App\Enums\Project\ProjectScale;
use App\Enums\Project\ProjectStatus;
use App\Models\ProjectRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\Department;
use TCore\Outsource\DataTables\ProjectDataTable;
use TCore\Outsource\Http\Requests\ProjectRequest;
use TCore\Outsource\Repositories\Project\ProjectRepositoryInterface;
use TCore\Sales\Repositories\Order\OrderRepositoryInterface;
use Theme\Cms\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function __construct(
        public ProjectRepositoryInterface $repo,
        public OrderRepositoryInterface $orderRepo,
        public ProjectRequirement $modelPR
    ) {

    }
    public function index(ProjectDataTable $dataTable)
    {
        $listYears = $this->repo->getQueryBuilder()
        ->selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

        return $dataTable->render('packages_outsource::index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Dự án')),
            'list_years' => $listYears
        ]);
    }

    public function create()
    {
        return view('packages_outsource::create')
            
        ->with('scale', ProjectScale::asSelectArray())

        ->with('priority', ProjectPriority::asSelectArray())

        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Dự án'), 'outsource.project.index')->add('Thêm'));
    }

    public function store(ProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['admin_id'] = get_auth_admin()->id;
            $data['status'] = ProjectStatus::Todo;
            $data['department'] = Department::Outsource;

            $project = $this->repo->create($data);
            
            if (!empty($data['assigns']))
            {
                $project->assigns()->attach($data['assigns']);
            }

            if(!empty($data['requirement_id']))
            {
                $this->modelPR->findOrFail($data['requirement_id'])->update([
                    'project_id' => $project->id
                ]);
            }

            DB::commit();
            return utilities()->toRoute('outsource.project.edit', $project->id);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id)
    {
        $project = $this->repo->findOrFail($id, ['assigns', 'order', 'teamOutsource']);

        return view('packages_outsource::edit')

            ->with('status', ProjectStatus::asSelectArray())

            ->with('scale', ProjectScale::asSelectArray())

            ->with('priority', ProjectPriority::asSelectArray())

            ->with('project', $project)

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Dự án'), 'outsource.project.index')->add('Sửa'));

    }

    public function update(ProjectRequest $request)
    {
        $data = $request->validated();

        $project = $this->repo->update($data['id'], $data);

        if (isset($data['assigns'])) {
            $project->assigns()->sync($data['assigns']);
        } else {
            $project->assigns()->sync([]);
        }

        return utilities()->responseBack();
    }

    public function delete($id, Request $request)
    {
        $this->repo->delete($id);
        if ($request->ajax()) {
            return utilities()->responseAjax();
        }

        return utilities()->toRoute('outsource.project.index');
    }

    public function changeStatus($id)
    {
        return view('packages_outsource::modal.change-status')->with('data', $this->repo->findOrFail($id))->with('status', ProjectStatus::asSelectArray());
    }

    public function updateStatus(ProjectRequest $request)
    {
        $data = $request->validated();
        $this->repo->update($data['id'], $data);
        return utilities()->responseAjax();
    }

    public function orderInfo(Request $request)
    {
        $order = $this->orderRepo->findOrFail($request->order_id)->load('services');
        return view('packages_outsource::partials.order-info')->with('order', $order)->render();
    }

    public function requirementInfo(Request $request)
    {
        $requirement = $this->modelPR->findOrFail($request->order_id);

        return view('packages_outsource::partials.requirement-info')->with('requirement', $requirement)->render();
    }

    public function show($id)
    {
        return view('packages_outsource::modal.show')->with('data', $this->repo->findOrFail($id, ['order.assigns']));
    }
}