<?php

use DragonCode\IconifyIde\Commands\DefaultCommand;
use DragonCode\IconifyIde\Commands\PublishCommand;

use function PHPUnit\Framework\assertDirectoryExists;
use function PHPUnit\Framework\assertFileDoesNotExist;
use function PHPUnit\Framework\assertFileExists;

it('default', function () {
    $this->artisan(DefaultCommand::class)->assertExitCode(
        PublishCommand::PUBLISHED
    );
});

it('published', function (string $ide) {
    refreshTempDirectory($suffix = 'one-published');

    assertDirectoryExists(
        $directory = tempDirectory($suffix)
    );

    fakeComposer($directory);

    ensureTempDirectory($suffix . '/' . $ide);

    $this->artisan(DefaultCommand::class, ['--path' => $directory])->assertExitCode(
        PublishCommand::PUBLISHED
    );

    assertFileExists($directory . '/' . $ide . '/icon.svg');
})->with('ide');

it('skipped without composer detecting', function (string $ide) {
    refreshTempDirectory($suffix = 'one-published');

    assertDirectoryExists(
        $directory = tempDirectory($suffix)
    );

    ensureTempDirectory($suffix . '/' . $ide);

    $this->artisan(DefaultCommand::class, ['--path' => $directory])->assertExitCode(
        PublishCommand::PUBLISHED
    );

    assertFileDoesNotExist($directory . '/' . $ide . '/icon.svg');
})->with('ide');

it('skipped without IDE', function (string $ide) {
    refreshTempDirectory($suffix = 'one-published');

    assertDirectoryExists(
        $directory = tempDirectory($suffix)
    );

    fakeComposer($directory);

    $this->artisan(DefaultCommand::class, ['--path' => $directory])->assertExitCode(
        PublishCommand::PUBLISHED
    );

    assertFileDoesNotExist($directory . '/' . $ide . '/icon.svg');
})->with('ide');
