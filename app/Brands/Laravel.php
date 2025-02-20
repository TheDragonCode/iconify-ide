<?php

declare(strict_types=1);

namespace App\Brands;

class Laravel extends Brand
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
