<?php

namespace TCore\Base\Views\Components\Input;

use TCore\Base\Views\Components\Input;

class Password extends Input
{
    public $type = 'password';
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core_base::components.input.password');
    }
}
