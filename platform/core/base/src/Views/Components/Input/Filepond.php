<?php

namespace TCore\Base\Views\Components\Input;

use TCore\Base\Views\Components\Input;

class Filepond extends Input
{
    public $value;

    public $name;

    public $multiple;

    public $maxFiles;
    
    public $targetFile;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $type = 'file', $value = '', $multiple = false, $maxFiles = 1, $required = false)
    {
        //
        parent::__construct($type, $required);
        $this->name = $name;
        $this->value = $value;
        $this->multiple = $multiple;
        $this->maxFiles = $maxFiles;
        $this->targetFile = uniqid_real();
    }

    public function marcoValue($value)
    {
        if(gettype($value) == 'object')
        {
            return $value ? implode(',', $value->toArray()) : '';
        }elseif(gettype($value) == 'array') {

            return $value ? implode(',', $value) : '';
        }elseif(gettype($value) == 'string') {
            
            return $value;
        }

        return '';
    }

    public function multiple()
    {
        if($this->multiple == true)
        {
            return "multiple data-max-files={$this->maxFiles}";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core_base::components.input.filepond');
    }
}
