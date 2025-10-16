<?php

namespace Theme\Cms\Http\Controllers;

use TCore\Support\Breadcrumb\SimpleBreadcrumb;
use TCore\Support\Http\Controllers\BaseController;

class Controller extends BaseController
{
    public function breadcrumbs(): SimpleBreadcrumb
    {
        $breadcrumbs = (new SimpleBreadcrumb)->addByRouteName(trans('THIẾT BỊ ĐIỆN TTN'), 'dashboard.index');

        $this->breadcrumbs = $breadcrumbs;

        return $breadcrumbs;
    }
}