<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RegenerateSlugsCommand extends Command
{
    protected $signature = 'properties:regenerate-slugs
                            {--dry-run : Show changes without applying them}';

    protected $description = 'Regenerate all property slugs to {id}-{title-slug} format';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $total = Property::withTrashed()->count();

        if ($total === 0) {
            $this->info('No properties found.');
            return self::SUCCESS;
        }

        $this->info(($dryRun ? '[DRY RUN] ' : '') . "Regenerating slugs for {$total} properties...");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $updated = 0;

        Property::withTrashed()
            ->select(['id', 'title', 'slug'])
            ->lazy(200)
            ->each(function (Property $property) use ($dryRun, &$updated, $bar) {
                $newSlug = $property->id . '-' . Str::slug($property->title);

                if ($property->slug !== $newSlug) {
                    if (!$dryRun) {
                        $property->slug = $newSlug;
                        $property->saveQuietly();
                    } else {
                        $this->newLine();
                        $this->line("  #{$property->id}: {$property->slug} → {$newSlug}");
                    }
                    $updated++;
                }

                $bar->advance();
            });

        $bar->finish();
        $this->newLine(2);

        $prefix = $dryRun ? '[DRY RUN] Would update' : 'Updated';
        $this->info("{$prefix} {$updated} of {$total} slugs.");

        return self::SUCCESS;
    }
}
