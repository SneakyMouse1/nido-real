<?php

namespace App\Enums;

enum FeatureCategory: string
{
    case Interior = 'interior';
    case Exterior = 'exterior';
    case Building = 'building';
    case Security = 'security';
    case Technology = 'technology';

    /**
     * Get localized label for the feature category.
     */
    public function label(string $locale = 'es'): string
    {
        return match ($this) {
            self::Interior   => $locale === 'es' ? 'Interior' : 'Interior',
            self::Exterior   => $locale === 'es' ? 'Exterior' : 'Exterior',
            self::Building   => $locale === 'es' ? 'Edificio' : 'Building',
            self::Security   => $locale === 'es' ? 'Seguridad' : 'Security',
            self::Technology => $locale === 'es' ? 'Tecnología' : 'Technology',
        };
    }
}
