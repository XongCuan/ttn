<?php

namespace TCore\Notification\Http\Controllers;

use Theme\Cms\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        return view('packages_notification::auth.index')

        ->with('notifications', get_auth_admin()->notifications()->paginate(10));
    }

    public function show($id)
    {
        $data = get_auth_admin()->notifications()->where('id', $id)->firstOrFail();

        $data->markAsRead();

        return redirect(url($data['data']['url']));
    }
}