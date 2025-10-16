<?php

namespace TCore\Internal\Http\Controllers;

use App\Enums\Order\OrderPriority;
use App\Enums\Project\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\Department;
use TCore\Internal\DataTables\ProjectDataTable;
use TCore\Internal\Http\Requests\ProjectRequest;
use TCore\Internal\Repositories\Project\ProjectRepositoryInterface;
use TCore\Sales\Repositories\Order\OrderRepositoryInterface;
use Theme\Cms\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function __construct(
        public ProjectRepositoryInterface $repo,
        public OrderRepositoryInterface $orderRepo,
    ) {

    }
    public function index(ProjectDataTable $dataTable)
    {
        return $dataTable->render('packages_internal::index', [
            'breadcrumbs' => $this->breadcrumbs()->addByRouteName(trans('Dự án'))
        ]);
    }

    public function create()
    {
        return view('packages_internal::create')
            ->with('priority', OrderPriority::asSelectArray())

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Dự án'), 'internal.project.index')->add('Thêm'));
    }

    public function store(ProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['admin_id'] = get_auth_admin()->id;
            $data['status'] = ProjectStatus::Todo;
            $data['department'] = Department::Internal;

            $project = $this->repo->create($data);
            if (!empty($data['assigns'])) {
                $project->assigns()->attach($data['assigns']);
            }

            DB::commit();
            return utilities()->toRoute('internal.project.edit', $project->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }

    public function edit($id)
    {
        $project = $this->repo->findOrFail($id, ['assigns', 'order', 'teamInternal']);

        return view('packages_internal::edit')

            ->with('status', ProjectStatus::asSelectArray())

            ->with('priority', OrderPriority::asSelectArray())

            ->with('project', $project)

            ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Dự án'), 'internal.project.index')->add('Sửa'));

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

        return utilities()->toRoute('internal.project.index');
    }

    public function changeStatus($id)
    {
        return view('packages_internal::modal.change-status')->with('data', $this->repo->findOrFail($id))->with('status', ProjectStatus::asSelectArray());
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
        return view('packages_internal::partials.order-info')->with('order', $order)->render();
    }

    public function show($id)
    {
        return view('packages_internal::modal.show')->with('data', $this->repo->findOrFail($id));
    }
}