<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Services;

use DragonCode\IconifyIde\Commands\PublishCommand;
use DragonCode\IconifyIde\Contracts\Named;
use Illuminate\Console\View\Components\Factory;

class ConsoleOutput
{
    public function __construct(
        protected Factory $output
    ) {}

    public function title(string $title): void
    {
        $this->output->info($title);
    }

    public function notFound(Named|string $title): void
    {
        $this->columns($title, 'NOT FOUND', 'comment');
    }

    public function skipped(Named|string $title): void
    {
        $this->columns($title, 'SKIPPED', 'comment');
    }

    public function published(Named|string $title): void
    {
        $this->columns($title, 'PUBLISHED', 'info');
    }

    public function status(string $title, int $code): void
    {
        $status = match ($code) {
            PublishCommand::PUBLISHED => 'PUBLISHED',
            PublishCommand::SKIPPED   => 'NOT FOUND',
        };

        $style = match ($code) {
            PublishCommand::PUBLISHED => 'info',
            PublishCommand::SKIPPED   => 'comment',
        };

        $this->columns($title, $status, $style);
    }

    protected function columns(Named|string $title, string $status, string $style): void
    {
        if ($title instanceof Named) {
            $title = $title->getName();
        }

        $this->output->twoColumnDetail($title, "<$style>$status</>");
    }
}
