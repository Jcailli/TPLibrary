<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Button
{
    public string $path;
    public string $type;

    public function getIcon(): string
    {
        return match ($this->type) {
            'show' => 'bi:eye-fill',
            'edit' => 'bi:pencil-square',
            'new' => 'bi:plus-circle',
            'back' => 'bi:arrow-left-circle',
            'borrow' => 'bi:book',
            'reserve' => 'bi:bookmark',
            'return' => 'bi:journal-arrow-down',
        };
    }

    public function getTitle(): string
    {
        return match ($this->type) {
            'show' => 'Details',
            'edit' => 'Edit',
            'new' => 'New',
            'back' => 'Back',
            'borrow' => 'Borrow',
            'reserve' => 'Reserve',
            'return' => 'Return',
        };
    }

    public function getBtn(): string
    {
        return match ($this->type) {
            'show' => 'btn-info',
            'edit' => 'btn-warning',
            'new' => 'btn-primary',
            'back' => 'btn-secondary',
            'borrow' => 'btn-primary',
            'reserve' => 'btn-primary',
            'return' => 'btn-primary',
        };
    }
}
