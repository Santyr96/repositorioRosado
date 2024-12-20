<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdviceModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $modalTitle, public string $modalMessage, public ?string $id, public string $class, public $child)

    {
       
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.advice-modal');
    }
}
