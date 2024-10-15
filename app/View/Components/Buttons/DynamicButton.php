<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DynamicButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $href, public string $class, public string $message, public ?string $download = null)
    {
        $this->href = $href;
        $this->class = $class;
        $this->message = $message;
        $this->download = $download;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.buttons.dynamic-button');
    }
}
