<?php

namespace App\Filament\Concerns;

use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Trait for handling Spatie Media Library saves on Property Create/Edit pages.
 * Used in both Admin and Agency PropertyResource pages.
 */
trait HandlesPropertyMedia
{
    /**
     * Save floor plans from Repeater data into the 'floor_plans' Spatie collection.
     *
     * Supports three operations per row:
     * - existing (media_uuid set, no file) → update custom_properties only
     * - existing removed (not present in items) → delete from Spatie
     * - new (file set) → add to Spatie collection
     *
     * Each item: [
     *   'media_uuid'        => '...',    // present for existing floor plans
     *   'existing_filename' => '...',    // display only
     *   'file'              => 'tmp/...', // present for new uploads
     *   'title_es'          => '...',
     *   'title_en'          => '...',
     * ]
     */
    protected function saveFloorPlans(Property $record): void
    {
        $items = $this->data['floor_plans_data'] ?? [];

        // Build list of existing UUIDs the user kept in the Repeater
        $keptUuids = collect($items)
            ->pluck('media_uuid')
            ->filter()
            ->values()
            ->toArray();

        // Delete floor plans that were removed from the Repeater
        $record->getMedia('floor_plans')
            ->each(function ($media) use ($keptUuids) {
                if (! in_array($media->uuid, $keptUuids)) {
                    $media->delete();
                    Log::debug("HandlesPropertyMedia: Deleted floor plan UUID {$media->uuid}");
                }
            });

        foreach ($items as $item) {
            $path      = $item['file'] ?? null;
            $mediaUuid = $item['media_uuid'] ?? null;

            // Normalize array-wrapped path (Filament FileUpload quirk)
            if (is_array($path)) {
                $path = reset($path);
            }

            // ── Existing floor plan: update custom properties only ─────────
            if (! $path && $mediaUuid) {
                $existing = $record->getMedia('floor_plans')->firstWhere('uuid', $mediaUuid);
                if ($existing) {
                    $existing->setCustomProperty('title_es', $item['title_es'] ?? '');
                    $existing->setCustomProperty('title_en', $item['title_en'] ?? '');
                    $existing->save();
                }
                continue;
            }

            // ── New floor plan: move from tmp/ into Spatie collection ──────
            if (! $path) {
                continue;
            }

            $absolutePath = Storage::disk('public')->path($path);

            if (! file_exists($absolutePath)) {
                Log::warning("HandlesPropertyMedia: floor plan file not found at {$absolutePath}");
                continue;
            }

            try {
                $record->addMedia($absolutePath)
                    ->withCustomProperties([
                        'title_es' => $item['title_es'] ?? '',
                        'title_en' => $item['title_en'] ?? '',
                    ])
                    ->toMediaCollection('floor_plans');
            } catch (\Exception $e) {
                Log::error("HandlesPropertyMedia: Failed to add floor plan - " . $e->getMessage());
            }
        }

        // Clear the repeater data so stale state doesn't persist
        $this->data['floor_plans_data'] = [];
    }

    /**
     * Save documents from Repeater data into the 'documents' Spatie collection.
     *
     * Supports three operations per row:
     * - existing doc (media_uuid set, no file) → update custom_properties only
     * - existing doc removed (not present in items) → delete from Spatie
     * - new doc (file set) → add to Spatie collection
     *
     * Each item: [
     *   'media_uuid'        => '...',    // present for existing docs
     *   'existing_filename' => '...',    // display only, not used for saving
     *   'file'              => 'tmp/...',// present for new uploads
     *   'title'             => '...',
     *   'is_public'         => bool,
     * ]
     */
    protected function saveDocuments(Property $record): void
    {
        $items = $this->data['documents_data'] ?? [];

        // Build list of existing-document UUIDs the user kept in the Repeater
        $keptUuids = collect($items)
            ->pluck('media_uuid')
            ->filter()
            ->values()
            ->toArray();

        // Delete documents that were removed from the Repeater
        $record->getMedia('documents')
            ->each(function ($media) use ($keptUuids) {
                if (! in_array($media->uuid, $keptUuids)) {
                    $media->delete();
                    Log::debug("HandlesPropertyMedia: Deleted document UUID {$media->uuid}");
                }
            });

        foreach ($items as $item) {
            $path      = $item['file'] ?? null;
            $mediaUuid = $item['media_uuid'] ?? null;

            // Normalize array-wrapped path (Filament FileUpload quirk)
            if (is_array($path)) {
                $path = reset($path);
            }

            // ── Existing document: just update its custom properties ──────
            if (! $path && $mediaUuid) {
                $existing = $record->getMedia('documents')->firstWhere('uuid', $mediaUuid);
                if ($existing) {
                    $existing->setCustomProperty('title', $item['title'] ?? '');
                    $existing->setCustomProperty('is_public', (bool) ($item['is_public'] ?? false));
                    $existing->save();
                }
                continue;
            }

            // ── New document: move from tmp/ into Spatie collection ───────
            if (! $path) {
                continue;
            }

            $absolutePath = Storage::disk('public')->path($path);

            if (! file_exists($absolutePath)) {
                Log::warning("HandlesPropertyMedia: document file not found at {$absolutePath}");
                continue;
            }

            try {
                $record->addMedia($absolutePath)
                    ->withCustomProperties([
                        'title'     => $item['title'] ?? '',
                        'is_public' => (bool) ($item['is_public'] ?? false),
                    ])
                    ->toMediaCollection('documents');
            } catch (\Exception $e) {
                Log::error("HandlesPropertyMedia: Failed to add document - " . $e->getMessage());
            }
        }

        // Clear the repeater data so stale state doesn't persist
        $this->data['documents_data'] = [];
    }
}
