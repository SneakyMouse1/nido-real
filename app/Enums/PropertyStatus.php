<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PropertyStatus: string implements HasLabel
{
    case Draft = 'draft';
    case Pending = 'pending';         // Waiting for admin approval
    case Published = 'published';
    case Moderated = 'moderated';     // Hidden by admin (global mute/ban)
    case Rejected = 'rejected';       // Explicitly rejected by admin
    case Sold = 'sold';
    case Archived = 'archived';

    /**
     * Get localized label for the property status.
     */
    public function label(string $locale = 'es'): string
    {
        return match ($this) {
            self::Draft     => $locale === 'es' ? 'Borrador' : 'Draft',
            self::Pending   => $locale === 'es' ? 'Pendiente' : 'Pending',
            self::Published => $locale === 'es' ? 'Publicado' : 'Published',
            self::Moderated => $locale === 'es' ? 'Moderado' : 'Moderated',
            self::Rejected  => $locale === 'es' ? 'Rechazado' : 'Rejected',
            self::Sold      => $locale === 'es' ? 'Vendido' : 'Sold',
            self::Archived  => $locale === 'es' ? 'Archivado' : 'Archived',
        };
    }

    public function getLabel(): ?string
    {
        return $this->label(app()->getLocale());
    }
}
