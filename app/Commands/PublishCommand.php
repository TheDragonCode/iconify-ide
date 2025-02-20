<?php

declare(strict_types=1);

namespace App\Commands;

use App\Ide\Ide;
use App\Ide\PhpStorm;
use App\Services\Publisher;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Attribute\AsCommand;

use function is_dir;

#[AsCommand('iconify')]
class PublishCommand extends Command
{
    protected $signature = 'iconify {--all}';

    protected $description = 'Display an inspiring quote';

    /** @var list<class-string<\App\Ide\Ide>> */
    protected array $ide = [
        PhpStorm::class,
    ];

    public function handle(Publisher $publisher): void
    {
        foreach ($this->ide as $class) {
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
}
