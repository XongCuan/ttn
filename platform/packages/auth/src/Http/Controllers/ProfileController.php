<?php

namespace TCore\Auth\Http\Controllers;

use TCore\Auth\Http\Requests\ProfileRequest;
use TCore\Base\Enums\Gender;
use Theme\Cms\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $auth = get_auth_admin();

        return view('packages_auth::profile', [
            'auth' => $auth,
            'gender' => Gender::asSelectArray(), 
            'breadcrumbs' => $this->breadcrumbs()->add(__('Hồ sơ'))
        ]);
    }

    public function update(ProfileRequest $request)
    {
        get_auth_admin()->update($request->validated());

        return utilities()->responseBack();
    }

    public function updateLocation(ProfileRequest $request)
    {
        return auth('admin')->user()->update($request->validated());
    }

}
