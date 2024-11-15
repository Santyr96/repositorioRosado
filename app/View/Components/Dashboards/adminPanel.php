<?php

namespace App\View\Components\Dashboards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class adminPanel extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $class = null)
    {
        $this->class = $class;    
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboards.admin-panel');
    }
}
