<?php

namespace App\View\Components\Tables;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServiceTable extends Component
{
    public $services;
    public $hairdresser;

    /**
     * Create a new component instance.
     */
    public function __construct($services, $hairdresser)
    {
        $this->services = $services;
        $this->hairdresser = $hairdresser;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tables.service-table');
    }
}
