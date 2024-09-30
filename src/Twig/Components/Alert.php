<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Alert
{
    public string $type = 'success';
    public string $message;

    public function getIcon(): string
    {
        return match ($this->type) {
            'success' => 'bi:check-circle',
            'danger' => 'bi:exclamation-circle',
        };
    }
}
