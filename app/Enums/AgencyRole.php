<?php

namespace App\Enums;

enum AgencyRole: string
{
    case Manager = 'manager';
    case Agent = 'agent';

    /**
     * Get localized label for the agency role.
     */
    public function label(string $locale = 'es'): string
    {
        return match ($this) {
            self::Manager => $locale === 'es' ? 'Gestor de agencia' : 'Agency Manager',
            self::Agent   => $locale === 'es' ? 'Agente' : 'Agent',
        };
    }
}
