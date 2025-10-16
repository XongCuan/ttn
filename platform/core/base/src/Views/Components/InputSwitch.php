<?php

namespace TCore\Base\Views\Components;

use TCore\Base\Views\Components\Input;

class InputSwitch extends Input
{
    public $label;
    public $checked;
    public $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $checked = false, $value = '', $type = 'text', $required = false)
    {
        //
        parent::__construct($type, $required);
        $this->label = $label;
        $this->value = $value;
        $this->checked = $checked;
    }
    public function isRequired()
    {
        return $this->required === true ? [
            'required' => true, 
            'data-parsley-required-message' => __('Trường này không được bỏ trống.')
        ] : [];
    }
    public function isChecked()
    {
        return  $this->value == $this->checked ? 'checked' : '';
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core_base::components.input.switch');
    }
}
