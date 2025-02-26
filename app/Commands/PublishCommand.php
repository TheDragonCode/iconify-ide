<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Commands;

use DragonCode\IconifyIde\Ide\Ide;
use DragonCode\IconifyIde\Services\Publisher;
use Symfony\Component\Console\Attribute\AsCommand;

use function config;
use function is_dir;
use function realpath;

#[AsCommand('publish')]
class PublishCommand extends Command
{
    public const PUBLISHED = 0;
    public const SKIPPED   = 1;

    protected $signature = 'publish'
    . ' {--path= : Indicates the way to the search directory}';

    protected $description = 'Publishes icons to improve project display in IDE';

    protected bool $isPublished = false;

    public function handle(Publisher $publisher): int
    {
        foreach ($this->ide() as $class) {
            $ide = $this->initializeIde($class);

            $this->info->title($ide->getName());

            if (! $this->hasIde($ide)) {
                $this->info->notFound($ide);

                continue;
            }

            $published = false;

            foreach ($ide->getBrands() as $brand) {
                if ($published) {
                    $this->info->skipped($brand);

                    continue;
                }

                if (! $brand->isDetected()) {
                    $this->info->notFound($brand);

                    continue;
                }

                $publisher->publish($ide, $brand, $this->getPath());
                $this->info->published($brand);

                $published = true;

                $this->isPublished = true;
            }
        }

        return $this->isPublished
            ? static::PUBLISHED
            : static::SKIPPED;
    }

    protected function hasIde(Ide $ide): bool
    {
        return is_dir($this->getPath() . '/' . $ide->getDirectoryName());
    }

    protected function initializeIde(string $ide): Ide
    {
        return $this->app->make($ide);
    }

    protected function ide(): array
    {
        return config('data.ide');
    }

    protected function getPath(): string
    {
        if ($this->hasOption('path')) {
            return $this->option('path');
        }

        return realpath('.');
    }
}
