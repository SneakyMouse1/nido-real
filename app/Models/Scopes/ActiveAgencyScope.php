<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * ActiveAgencyScope — hides properties from inactive agencies.
 * In Filament panels, use withoutGlobalScope(ActiveAgencyScope::class) so
 * admins can see blocked agency properties.
 */
class ActiveAgencyScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereHas('agency', function (Builder $query) {
            $query->where('is_active', true);
        });
    }
}
