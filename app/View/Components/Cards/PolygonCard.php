<?php

namespace App\View\Components\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**Componente card con forma de flecha. */

class PolygonCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $title, public string $message1, public string $message2, public string $src, public string $alt)
    {
        $this->title = $title;
        $this->message1 = $message1;
        $this->src = $src;
        $this->alt = $alt;
        $this->message2 = $message2;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.polygon-card');
    }
}
