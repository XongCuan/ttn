<?php

namespace TCore\Outsource\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Base\Http\Controllers\Controller;
use TCore\Outsource\Models\Employee;

class SelectEmployeeController extends Controller
{
    public function __construct(
        public Employee $model
    ) {

    }
    public function lists(Request $request, $team_id = null)
    {
        $employees = $this->model->select('id', 'fullname')->withoutGlobalScope('employee_outsource');
        
        if ($keyword = $request->get('term', ''))
        {
            $employees = $employees->where('fullname', 'like', "%{$keyword}%");
        }

        $employees = $employees->currentHasManager($team_id);


        return [
            'results' => $employees->get()->map(fn($item) => ['id' => $item->id, 'text' => $item->fullname])
        ];
    }
}