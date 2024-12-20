<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmitButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $id,public string $name, public string $message, public ?string $class = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->message = $message;
        $this->class = $class;
    }
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.buttons.submit-button');
    }
}
