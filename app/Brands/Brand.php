<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Brands;

use DragonCode\IconifyIde\Services\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class Brand
{
    protected array $projects;

    protected ?string $name = null;

    protected bool $composer = true;

    public function __construct(
        protected Filesystem $filesystem
    ) {}

    public function getName(): string
    {
        return $this->name ??= Str::of(static::class)->basename()->snake(' ')->apa()->toString();
    }

    public function getFilename(): string
    {
        return Str::of(static::class)->basename()->snake()->toString();
    }

    public function isFound(): bool
    {
        if ($this->composer) {
            return $this->search($this->filesystem->getComposer(), [
                'require',
                'require-dev',
            ]);
        }

        return false;
    }

    protected function search(array $dependencies, array $sections): bool
    {
        foreach ($sections as $section) {
            if (Arr::hasAny($dependencies[$section] ?? [], $this->projects)) {
                return true;
            }
        }

        return false;
    }
}
