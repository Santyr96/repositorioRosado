<?php

namespace App\View\Components\Inputs;

use Closure;
use Dotenv\Parser\Value;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type,
        public string $name,
        public ?string $class = null,
        public ?string $placeholder = null,
        public ?string $value = null
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->value = $value;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.input');
    }
}
