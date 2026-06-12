<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EnergyCertificate: string implements HasLabel
{
    case A = 'A';
    case B = 'B';
    case C = 'C';
    case D = 'D';
    case E = 'E';
    case F = 'F';
    case G = 'G';
    case Pending = 'pending';
    case Exempt = 'exempt';

    /**
     * Get localized label for the energy certificate.
     */
    public function label(string $locale = 'es'): string
    {
        return match ($this) {
            self::Pending => $locale === 'es' ? 'En trámite' : 'Pending',
            self::Exempt  => $locale === 'es' ? 'Exento' : 'Exempt',
            default       => $this->value, // A-G are universal
        };
    }

    public function getLabel(): ?string
    {
        return $this->label(app()->getLocale());
    }
}
