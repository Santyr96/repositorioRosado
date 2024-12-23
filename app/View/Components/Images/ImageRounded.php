<?php

namespace App\View\Components\Images;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageRounded extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $src, public string $alt, public ?string $class = null, public ?string $id = null)
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->class = $class;
        $this->id = $id;

        
    }

    
    public function render(): View|Closure|string
    {
        return view('components.images.image-rounded');
    }
}
