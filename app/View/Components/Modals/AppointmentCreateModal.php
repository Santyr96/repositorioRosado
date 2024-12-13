<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppointmentCreateModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct( public $services, public $hairdresser,public string $modalTitle, public string $modalMessage, public ?string $id)

    {
        $this->modalTitle = $modalTitle;
        $this->modalMessage = $modalMessage; 
        $this->id = $id;
        $this->services = $services;
        $this->hairdresser = $hairdresser;
    }

    public function render(): View|Closure|string
    {
        return view('components.modals.appointment-create-modal');
    }
}
