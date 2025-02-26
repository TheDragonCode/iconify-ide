<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Commands;

use DirectoryIterator;
use DragonCode\IconifyIde\Services\Filesystem;
use InvalidArgumentException;

use function config;
use function file_exists;
use function filled;
use function in_array;
use function is_dir;
use function realpath;

class DefaultCommand extends Command
{
    protected $signature = 'default'
        . ' {--all : Publishing files in all projects of the current directory}'
        . ' {--path= : Indicates the way to the search directory}';

    protected $description = 'Publishes icons to improve project display in IDE';

    public function handle(): void
    {
        if ($this->hasAll()) {
            $this->info->title('Recursive search for projects ...');

            $this->processWithStatus($this->getPath());
            $this->processMany($this->getPath(), new Filesystem($this->getPath()));

            return;
        }

        $this->processOnce($this->getPath());
    }

    protected function processOnce(string $path, bool $silent = false): int
    {
        return $silent
            ? $this->callSilent(PublishCommand::class, ['--path' => $path])
            : $this->call(PublishCommand::class, ['--path' => $path]);
    }

    protected function processMany(string $path, Filesystem $files): void
    {
        foreach ($files->directory($path) as $directory) {
            if ($this->skip($directory)) {
                continue;
            }

            $this->processWithStatus($directory->getRealPath());

            if (! $directory->isDot()) {
                $this->processMany($directory->getRealPath(), new Filesystem($directory->getRealPath()));
            }
        }
    }

    protected function processWithStatus(string $path): void
    {
        $this->info->status($path, $this->processOnce($path, true));
    }

    protected function skip(DirectoryIterator $directory): bool
    {
        if (! $directory->isDir() || $directory->isDot()) {
            return true;
        }

        return (bool) (in_array($directory->getBasename(), config('data.exclude'), true));
    }

    protected function getPath(): string
    {
        if (filled($path = $this->option('path'))) {
            return $this->validatePath($path);
        }

        return '.';
    }

    protected function validatePath(string $path): string
    {
        if (! file_exists($path)) {
            throw new InvalidArgumentException("The directory does not exist ($path).");
        }

        if (! is_dir($path)) {
            throw new InvalidArgumentException("The specified path is not a directory ($path).");
        }

        return realpath($path);
    }

    protected function hasAll(): bool
    {
        return $this->option('all');
    }
}
