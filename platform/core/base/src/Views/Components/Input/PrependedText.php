<?php

namespace TCore\Base\Views\Components\Input;

use TCore\Base\Views\Components\Input;

class PrependedText extends Input
{
    public $value;

    public $pText;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pText = '', $value = '', $required = false)
    {
        //
        parent::__construct('text', $required);
        $this->pText = str()->finish($pText, '/');
        $this->value = $value;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core_base::components.input.prepended-text');
    }
}
