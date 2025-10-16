<?php

namespace Theme\Cms\Views\Components;

use Illuminate\View\Component;
use Theme\Cms\Sidebar\SidebarData;

class SidebarLeft extends Component
{
    /**
     * The alert type.
     *
     * @var array
     */
    public $sidebarData;

    public $logo;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->sidebarData = SidebarData::make()->setData();

        $this->logo = 'public/images/logo.png';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('themes_cms::layouts.sidebar-left');
    }
}