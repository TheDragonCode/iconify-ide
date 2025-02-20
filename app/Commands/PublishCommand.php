<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Commands;

use DragonCode\IconifyIde\Ide\Ide;
use DragonCode\IconifyIde\Services\Publisher;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Attribute\AsCommand;

use function config;
use function is_dir;

#[AsCommand('iconify')]
class PublishCommand extends Command
{
    protected $signature = 'iconify {--all}';

    protected $description = 'Display an inspiring quote';

    public function handle(Publisher $publisher): void
    {
        foreach ($this->ide() as $class) {
            $ide = $this->initializeIde($class);

            $this->components->info($ide->getName());

            if (! $this->hasIde($ide)) {
                $this->info('Not Found');

                continue;
            }

            foreach ($ide->getBrands() as $brand) {
                if (! $brand->isFound()) {
                    $this->components->twoColumnDetail($brand->getName(), 'NOT FOUND');
                    continue;
                }

                $publisher->publish($ide, $brand);

                $this->components->twoColumnDetail($brand->getName(), 'PUBLISHED');
            }
        }
    }

    protected function hasIde(Ide $ide): bool
    {
        return is_dir('./' . $ide->getDirectoryName());
    }

    protected function initializeIde(string $ide): Ide
    {
        return new $ide();
    }

    protected function ide(): array
    {
        return config('data.ide');
    }
}
