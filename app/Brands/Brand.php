<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Brands;

use DragonCode\IconifyIde\Contracts\Named;
use DragonCode\IconifyIde\Services\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

use function array_keys;
use function class_basename;
use function is_string;

abstract class Brand implements Named
{
    protected array $projects;

    protected ?string $name = null;

    public function __construct(
        protected Filesystem $filesystem
    ) {}

    public function getName(): string
    {
        return $this->name ??= $this->classBasename()->snake(' ')->apa()->toString();
    }

    public function getFilename(): string
    {
        return $this->classBasename()->snake()->toString();
    }

    public function isDetectedName(): bool
    {
        return $this->isDetectedComposer(['name'])
            || $this->isDetectedNode(['name']);
    }

    public function isDetectedDependencies(): bool
    {
        return $this->isDetectedComposer()
            || $this->isDetectedNode();
    }

    protected function isDetectedComposer(?array $names = null): bool
    {
        $names ??= [
            'require',
            'require-dev',
        ];

        return $this->search($this->filesystem->getComposer(), $names);
    }

    protected function isDetectedNode(?array $names = null): bool
    {
        $names ??= [
            'dependencies',
            'devDependencies',
        ];

        return $this->search($this->filesystem->getNode(), $names);
    }

    protected function search(array $dependencies, array $sections): bool
    {
        foreach ($sections as $section) {
            if (! isset($dependencies[$section])) {
                continue;
            }

            foreach ($this->dependencyNames($section, $dependencies) as $dependency) {
                foreach ($this->projects as $project) {
                    if (Str::is($project, $dependency)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    protected function dependencyNames(string $key, array $dependencies): array
    {
        return is_string($dependencies[$key]) ? [$dependencies[$key]] : array_keys($dependencies[$key]);
    }

    protected function classBasename(): Stringable
    {
        return Str::of(class_basename(static::class));
    }
}
