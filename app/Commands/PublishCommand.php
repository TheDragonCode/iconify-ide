<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Commands;

use Closure;
use DragonCode\IconifyIde\Brands\Brand;
use DragonCode\IconifyIde\Ide\Ide;
use DragonCode\IconifyIde\Services\Filesystem;
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

    protected ?Filesystem $files = null;

    protected bool $isPublished = false;

    public function handle(): int
    {
        foreach ($this->ide() as $ideClass) {
            $ide = $this->initializeIde($ideClass);

            $this->info->title($ide->getName());

            if (! $this->hasIde($ide)) {
                $this->info->notFound($ide);

                continue;
            }

            if ($this->detect($ide, fn (Brand $brand) => $brand->isDetectedName())) {
                continue;
            }

            $this->detect($ide, fn (Brand $brand) => $brand->isDetectedDependencies());
        }

        return $this->isPublished
            ? static::PUBLISHED
            : static::SKIPPED;
    }

    protected function detect(Ide $ide, Closure $when, bool $isPublished = false): bool
    {
        foreach ($ide->getBrands() as $brandClass) {
            $brand = $this->initializeBrand($brandClass);

            if ($isPublished) {
                $this->info->skipped($brand);

                continue;
            }

            if (! $when($brand)) {
                $this->info->notFound($brand);

                continue;
            }

            (new Publisher($this->getFilesystem()))->publish($ide, $brand);

            $this->info->published($brand);

            $isPublished = true;

            $this->isPublished = true;
        }

        return $isPublished;
    }

    protected function hasIde(Ide $ide): bool
    {
        return is_dir($this->getPath() . '/' . $ide->getDirectoryName());
    }

    protected function initializeIde(string $ide): Ide
    {
        return new $ide($this->getFilesystem());
    }

    protected function initializeBrand(string $brand): Brand
    {
        return new $brand($this->getFilesystem());
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

    protected function getFilesystem(): Filesystem
    {
        return $this->files ??= new Filesystem($this->getPath());
    }
}
