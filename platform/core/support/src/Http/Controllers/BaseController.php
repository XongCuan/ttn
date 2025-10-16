<?php

namespace TCore\Support\Http\Controllers;

use Illuminate\Routing\Controller;
use TCore\Support\Breadcrumb\SimpleBreadcrumb;

class BaseController extends Controller
{
    /**
     * array chứa $breadcrums
     *
     * @var Breadcrums
     */
    protected $breadcrumbs;
}
