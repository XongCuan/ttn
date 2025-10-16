<?php

namespace TCore\Superadmin\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\Department;
use TCore\Superadmin\DataTables\TeamDataTable;
use TCore\Superadmin\Http\Requests\TeamRequest;
use TCore\Superadmin\Repositories\Admin\AdminRepositoryInterface;
use Theme\Cms\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function __construct(
        public Team $model,
        public AdminRepositoryInterface $repoAdmin
    )
    {
        
    }
    public function index(TeamDataTable $dataTable)
    {
        return $dataTable->render('packages_superadmin::teams.index', [
            'breadcrumbs' => $this->breadcrumbs()->add(trans('Quản lý Team'))
        ]);
    }

    public function create()
    {
        return view('packages_superadmin::teams.create')

        ->with('employees', $this->repoAdmin->getBy(['team_id' => null, 'is_superadmin' => false, ['managerDepartments', 'DOESNTHAVE', true]]))

        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Quản lý Team'), 'superadmin.team.index')->add(trans('Thêm')))
        
        ->with('departments', Department::asSelectArray());
    }

    public function edit($id)
    {
        $team = $this->model->findOrFail($id)->load(['members']);

        return view('packages_superadmin::teams.edit')

        ->with('breadcrumbs', $this->breadcrumbs()->addByRouteName(trans('Quản lý Team'), 'superadmin.team.index')->add(trans('Sửa')))

        ->with('departments', Department::asSelectArray())

        ->with('employees', $this->repoAdmin->getBy(['team_id' => null, 'is_superadmin' => false, ['managerDepartments', 'DOESNTHAVE', true]]))

        ->with('team', $team);
    }

    public function store(TeamRequest $request)
    {
        DB::beginTransaction();
        try {
            //code...

            $data = $request->validated();

            $team = $this->model->create($data);
            
            $memberIds = $request->input('member', []);
            
            if(isset($data['leader_id']) && in_array($data['leader_id'], $memberIds) == false)
            {
                array_push($memberIds, $data['leader_id']);
            }

            $memberIds = array_unique($memberIds);
            
            $this->repoAdmin->getByQueryBuilder([['id', 'in', $memberIds]])
            ->update([
                'team_id' => $team->id
            ]);

            DB::commit();

            return $request->input('submitter') == 'save' 
                ? utilities()->toRoute('superadmin.team.edit', $team->id)
                : utilities()->toRoute('superadmin.team.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(TeamRequest $request)
    {
        DB::beginTransaction();
        try {
            //code...

            $data = $request->validated();

            $team = $this->model->findOrFail($data['id'])->load(['members']);
            
            $team->update($data);

            $memberIds = $request->input('member', []);
            
            if(isset($data['leader_id']) && in_array($data['leader_id'], $memberIds) == false)
            {
                array_push($memberIds, $data['leader_id']);
            }
            
            $removeMember = $team->members->filter(fn($item, $key) => in_array($item->id, $memberIds) == false)->pluck('id')->toArray();
            
            if(count($removeMember) > 0)
            {
                $this->repoAdmin->getByQueryBuilder([['id', 'in', $removeMember]])
                ->update([
                    'team_id' => null
                ]);
            }

            $this->repoAdmin->getByQueryBuilder([['id', 'in', $memberIds]])
            ->update([
                'team_id' => $team->id
            ]);

            DB::commit();

            return $request->input('submitter') == 'save' 
                ? utilities()->toRoute('superadmin.team.edit', $team->id)
                : utilities()->toRoute('superadmin.team.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id)
    {
        try {

            $this->model->destroy($id);

            if(request()->ajax())
            {
                return utilities()->responseAjax();
            }

            return utilities()->toRoute('superadmin.team.index');

        } catch (\Throwable $th) {

            //throw $th;

            if(request()->ajax())
            {
                return utilities()->responseAjax(error: true, msg: $th->getMessage());
            }

            return utilities()->responseBack(error: true, msg: $th->getMessage());
        }
    }

}