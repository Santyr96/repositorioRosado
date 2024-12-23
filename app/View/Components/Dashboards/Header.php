<?php

namespace App\View\Components\Dashboards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $class = null, public $notifications)
    {
        $this->class = $class;   
        $this->notifications = $notifications; 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboards.header');
    }
}
