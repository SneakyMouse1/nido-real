<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DealType: string implements HasLabel
{
    case Sale = 'sale';
    case Rent = 'rent';

    /**
     * Get localized label for the deal type.
     */
    public function label(string $locale = 'es'): string
    {
        return match ($this) {
            self::Sale => $locale === 'es' ? 'Venta' : 'Sale',
            self::Rent => $locale === 'es' ? 'Alquiler' : 'Rent',
        };
    }

    public function getLabel(): ?string
    {
        return $this->label(app()->getLocale());
    }
}
