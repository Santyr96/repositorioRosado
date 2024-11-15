<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class imageRounded extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct( 
        public string $src, public string $alt, public ?string $class = null)
    {
          $this->src = $src;
          $this->alt = $alt;
          $this->class = $class;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-rounded');
    }
}
