<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AvatarModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct( public string $modalTitle, public string $modalMessage)

    {
        $this->modalTitle = $modalTitle;
        $this->modalMessage = $modalMessage; 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.avatar-modal');
    }
}
