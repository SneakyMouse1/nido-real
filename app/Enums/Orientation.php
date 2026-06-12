<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Orientation: string implements HasLabel
{
    case North = 'north';
    case South = 'south';
    case East = 'east';
    case West = 'west';
    case NorthEast = 'north_east';
    case NorthWest = 'north_west';
    case SouthEast = 'south_east';
    case SouthWest = 'south_west';

    /**
     * Get localized label for the orientation.
     */
    public function label(string $locale = 'es'): string
    {
        return match ($this) {
            self::North     => $locale === 'es' ? 'Norte' : 'North',
            self::South     => $locale === 'es' ? 'Sur' : 'South',
            self::East      => $locale === 'es' ? 'Este' : 'East',
            self::West      => $locale === 'es' ? 'Oeste' : 'West',
            self::NorthEast => $locale === 'es' ? 'Noreste' : 'North-East',
            self::NorthWest => $locale === 'es' ? 'Noroeste' : 'North-West',
            self::SouthEast => $locale === 'es' ? 'Sureste' : 'South-East',
            self::SouthWest => $locale === 'es' ? 'Suroeste' : 'South-West',
        };
    }

    public function getLabel(): ?string
    {
        return $this->label(app()->getLocale());
    }
}
