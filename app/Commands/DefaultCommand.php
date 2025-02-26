<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Commands;

use DragonCode\Support\Facades\Filesystem\Directory;
use Illuminate\Support\Str;
use InvalidArgumentException;

use function array_unshift;
use function count;
use function file_exists;
use function filled;
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
        $count = count($directories = $this->getDirectories());

        $this->process($directories, $count);
    }

    protected function process(array $directories, int $count): void
    {
        $count === 1
            ? $this->processOnce($directories[0])
            : $this->processMany($directories);
    }

    protected function processOnce(string $directory): void
    {
        $this->call(PublishCommand::class, ['--path' => $directory]);
    }

    protected function processMany(array $directories): void
    {
        $this->info->title('Recursive search for projects ...');

        foreach ($directories as $directory) {
            $status = $this->callSilent(PublishCommand::class, ['--path' => $directory]);

            $this->info->status($directory, $status);
        }
    }

    protected function getDirectories(): array
    {
        if (! $this->hasAll()) {
            return [$this->getPath()];
        }

        $paths = Directory::allPaths($this->getPath(), static function (string $path) {
            return Str::doesntContain($path, ['.git', 'vendor', 'node_modules', 'tests']);
        }, recursive: true);

        array_unshift($paths, realpath($this->getPath()));

        return $paths;
    }

    protected function getPath(): string
    {
        if (filled($path = $this->option('path'))) {
            return $this->validatePath($path);
        }

        return '.';
    }

    protected function hasAll(): bool
    {
        return $this->option('all');
    }

    protected function validatePath(string $path): string
    {
        if (! file_exists($path)) {
            throw new InvalidArgumentException("The directory does not exist ($path).");
        }

        if (! is_dir($path)) {
            throw new InvalidArgumentException("The specified path is not a directory ($path).");
        }

        return $path;
    }
}
