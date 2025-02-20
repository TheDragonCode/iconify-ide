<?php

declare(strict_types=1);

namespace App\Services;

use App\Brands\Brand;
use App\Ide\Ide;
use League\Flysystem\Filesystem;

class Publisher
{
    public function __construct(
        protected Filesystem $files
    ) {}

    public function publish(Ide $ide, Brand $brand): void
    {
        $this->files->copy(
            $this->sourcePath($brand),
            $this->targetPath($ide)
        );
    }

    protected function sourcePath(Brand $brand): string
    {
        return __DIR__ . '/../../resources/brands/' . $brand->getName() . '.svg';
    }

    protected function targetPath(Ide $ide): string
    {
        return './' . $ide->getDirectoryName() . '/' . $ide->getFilename();
    }
}
