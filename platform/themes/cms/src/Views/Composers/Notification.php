<?php
 
namespace Theme\Cms\Views\Composers;

use Illuminate\View\View;

class Notification
{
    public function compose(View $view): void
    {
        $view->with('notifications', get_auth_admin()->notifications()->limit(10)->get());
    }
}