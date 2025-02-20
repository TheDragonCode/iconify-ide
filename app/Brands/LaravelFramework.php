<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Brands;

class LaravelFramework extends Brand
{
    protected array $projects = [
        'laravel/framework',
    ];

    protected array $sections = [
        'require',
        'require-dev',
    ];

    public function isFound(): bool
    {
        return $this->search($this->filesystem->getComposer());
    }
}
