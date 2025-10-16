<?php

namespace TCore\Sales\Http\Controllers\Contact;

use App\Models\ContactActiviTy;
use Illuminate\Http\Request;

class ActivityController
{
    public function __construct(
        public ContactActiviTy $model
    )
    {
        
    }

    public function index($contact_id)
    {
        $data = $this->model->makeQuery(filter: ['contact_id' => $contact_id])->get();

        return view('packages_sales::contacts.activities.modals.index')->with('data', $data)->with('contact_id', $contact_id);
    }

    public function create($contact_id)
    {
        return view('packages_sales::contacts.activities.modals.create')->with('contact_id', $contact_id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['admin_id'] = auth('admin')->id();

        $this->model->create($request->all());

        return utilities()->responseAjax();
    }
}