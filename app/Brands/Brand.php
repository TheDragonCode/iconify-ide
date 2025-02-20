<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Brands;

use DragonCode\IconifyIde\Services\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class Brand
{
    protected array $projects;

    protected array $sections;

    abstract public function isFound(): bool;

    public function __construct(
        protected Filesystem $filesystem
    ) {}

    public function getName(): string
    {
        return Str::of(static::class)->basename()->snake()->toString();
    }

    protected function search(array $dependencies): bool
    {
        foreach ($this->sections as $section) {
            if (Arr::hasAny($dependencies[$section] ?? [], $this->projects)) {
                return true;
            }
        }

        return false;
    }
}
