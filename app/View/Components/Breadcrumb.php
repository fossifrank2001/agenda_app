<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Create a new component instance.
     */
    public $parent;
    public $url;
    public $child;

    public function __construct($parent, $url = null, $child = null)
    {
        $this->parent = $parent;
        $this->url = $url;
        $this->child = $child;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
