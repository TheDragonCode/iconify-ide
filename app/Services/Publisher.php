<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Services;

use DragonCode\IconifyIde\Brands\Brand;
use DragonCode\IconifyIde\Ide\Ide;

class Publisher
{
    public function __construct(
        protected Filesystem $files
    ) {}

    public function publish(Ide $ide, Brand $brand, string $path): void
    {
        $this->files->copy(
            $this->sourcePath($brand),
            $this->targetPath($ide, $path)
        );
    }

    protected function sourcePath(Brand $brand): string
    {
        return __DIR__ . '/../../resources/brands/' . $brand->getFilename() . '.svg';
    }

    protected function targetPath(Ide $ide, string $path): string
    {
        return $path . '/' . $ide->getDirectoryName() . '/' . $ide->getFilename();
    }
}
