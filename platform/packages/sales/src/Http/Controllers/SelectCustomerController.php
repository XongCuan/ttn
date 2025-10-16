<?php

namespace TCore\Sales\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Base\Http\Controllers\Controller;
use App\Models\Customer;

class SelectCustomerController extends Controller
{
    public function __construct(
        public Customer $model
    )
    {
        
    }
    public function lists(Request $request)
    {
        $customers = $this->model->select('id', 'fullname', 'phone')->followBySales();

        if($keyword = $request->get('term', ''));
        {
            $customers = $customers->whereAny(['fullname', 'phone'], 'like', "%{$keyword}%");
        }

        return [
            'results' => $customers->get()->map(fn($item) => ['id' => $item->id, 'text' => $item->displayText()])
        ];
    }
}