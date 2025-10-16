<?php

namespace TCore\Base\Views\Components;

use TCore\Base\Views\Components\Input;

class Select extends Input
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core_base::components.select');
    }
}