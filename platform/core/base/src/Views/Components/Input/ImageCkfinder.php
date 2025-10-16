<?php

namespace TCore\Base\Views\Components\Input;

use TCore\Base\Views\Components\Input;

class ImageCkfinder extends Input
{

    public $value;

    public $showImage;

    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $showImage = '', $type = 'text', $value = '', $required = false)
    {
        //
        parent::__construct($type, $required);
        $this->name = $name;
        $this->showImage = $showImage ?: uniqid_real(6);
        $this->value = $value ?: core_public_asset('base', 'images/default-image.png');
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core_base::components.input.image-ckfinder');
    }
}
