<?php

namespace TCore\Base\Views\Components\Input;

use TCore\Base\Views\Components\Input;

class Checkbox extends Input
{
    public $label;
    public $checked;
    public $value;
    public $depth;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $depth = 0, $checked = null, $value = '', $type = 'text', $required = false)
    {
        //
        parent::__construct($type, $required);
        $this->label = $label;
        $this->value = $value;
        $this->checked = $checked;
        $this->depth = $depth * 15;
    }
    public function isRequired(){
        return $this->required === true ? [
            'required' => true,
            'data-parsley-required-message' => __('Trường này không được bỏ trống.')
        ] : [];
    }

    public function isChecked()
    {
        if(is_array($this->checked) && in_array($this->value, $this->checked))
        {
            return 'checked';
        }

        return  $this->value == $this->checked ? 'checked' : '';
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core_base::components.input.checkbox');
    }
}
