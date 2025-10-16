<?php

namespace TCore\Webadmin\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Base\Enums\Department;
use TCore\Base\Http\Controllers\Controller;
use App\Models\Team;

class SelectTeamController extends Controller
{
    public function __construct(
        public Team $model
    )
    {
        
    }
    public function lists(Request $request)
    {
        $teams = $this->model->select('id', 'name')->where('department', Department::Webadmin);

        if($keyword = $request->get('term', ''));
        {
            $teams = $teams->where('name', 'like', "%{$keyword}%");
        }

        return [
            'results' => $teams->get()->map(fn($item) => ['id' => $item->id, 'text' => $item->name])
        ];
    }
}