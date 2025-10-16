<?php

namespace TCore\Internal\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Base\Http\Controllers\Controller;
use App\Models\Order;

class SelectOrderController extends Controller
{
    public function __construct(
        public Order $model
    )
    {
        
    }
    public function lists(Request $request)
    {
        $orders = $this->model->select('id', 'name', 'desc');

        if($keyword = $request->get('term', ''));
        {
            $orders = $orders->whereAny(['id', 'name'], 'like', "%{$keyword}%")->inProgress();
        }

        return [
            'results' => $orders->get()->map(fn($item) => ['id' => $item->id, 'text' => $item->name . ' - #' . $item->id])
        ];
    }
}