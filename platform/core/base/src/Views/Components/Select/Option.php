<?php

namespace TCore\Base\Views\Components\Select;

use Illuminate\View\Component;

class Option extends Component
{
    public $value;

    public $title;

    public $selected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $value = '', $selected = null)
    {
        //
        $this->value = $value;
        $this->title = $title;
        $this->selected = $selected;

    }

    public function isSelected()
    {
        if(is_array($this->selected))
        {
            return in_array($this->value, $this->selected) ? 'selected' : '';
        }

        return $this->value === $this->selected ? 'selected' : '';
    }
    
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core_base::components.select.option');
    }
}