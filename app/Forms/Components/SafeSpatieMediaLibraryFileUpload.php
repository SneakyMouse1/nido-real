<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

/**
 * Wraps SpatieMediaLibraryFileUpload to prevent accidental photo deletion.
 *
 * Root cause:
 * SpatieMediaLibraryFileUpload uses ->dehydrated(false), which means the
 * component's UUID state is NOT persisted in Livewire's reactive $data
 * between requests. On form save, deleteAbandonedFiles() sees an empty state
 * and deletes ALL existing photos.
 *
 * Fix:
 * Disable deleteAbandonedFiles() by default (shouldDeleteAbandoned = false).
 * Set ->deleteAbandoned(true) only when you explicitly want deletion behavior.
 *
 * Reference: https://github.com/filamentphp/filament/issues (known issue)
 */
class SafeSpatieMediaLibraryFileUpload extends SpatieMediaLibraryFileUpload
{
    protected bool|Closure $shouldDeleteAbandoned = false;

    /**
     * Enable or disable deleteAbandonedFiles() behavior.
     * Default: disabled (safe mode).
     */
    public function deleteAbandoned(bool|Closure $condition = true): static
    {
        $this->shouldDeleteAbandoned = $condition;

        return $this;
    }

    /**
     * Override: only delete abandoned files when explicitly enabled.
     */
    public function deleteAbandonedFiles(): void
    {
        if (! $this->evaluate($this->shouldDeleteAbandoned)) {
            return;
        }

        parent::deleteAbandonedFiles();
    }
}
