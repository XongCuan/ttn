<?php

namespace TCore\Outsource\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Base\Http\Controllers\Controller;
use App\Models\ProjectRequirement;

class SelectRequirementController extends Controller
{
    public function __construct(
        public ProjectRequirement $model
    )
    {
        
    }
    public function lists(Request $request)
    {
        $keyword = $request->get('term', '');

        $requirements = $this->model->whereAny(['id', 'title'], 'like', "%{$keyword}%")->done();

        return [
            'results' => $requirements->get()->map(fn($item) => ['id' => $item->id, 'text' => $item->title])
        ];
    }
}