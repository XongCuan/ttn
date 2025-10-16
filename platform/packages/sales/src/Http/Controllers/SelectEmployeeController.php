<?php

namespace TCore\Sales\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Base\Http\Controllers\Controller;
use TCore\Sales\Models\Employee;

class SelectEmployeeController extends Controller
{
    public function __construct(
        public Employee $model
    )
    {
        
    }
    public function lists(Request $request, $team_id = null)
    {
        $employees = $this->model->select('id', 'fullname');
        // dd($employees->get());

        if($team_id)
        {
            $employees = $employees->where('team_id', $team_id);
        }

        if($keyword = $request->get('term', ''));
        {
            $employees = $employees->where('fullname', 'like', "%{$keyword}%");
        }

        return [
            'results' => $employees->get()->map(fn($item) => ['id' => $item->id, 'text' => $item->fullname])
        ];
    }
}