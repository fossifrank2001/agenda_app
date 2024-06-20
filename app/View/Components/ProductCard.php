<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{
    public $imageUrl;
    public $name;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($imageUrl, $name, $class = '')
    {
        $this->imageUrl = $imageUrl;
        $this->name = $name;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}
