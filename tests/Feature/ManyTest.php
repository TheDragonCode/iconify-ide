<?php

use DragonCode\IconifyIde\Commands\DefaultCommand;
use DragonCode\IconifyIde\Commands\PublishCommand;

use function PHPUnit\Framework\assertDirectoryExists;
use function PHPUnit\Framework\assertFileDoesNotExist;
use function PHPUnit\Framework\assertFileExists;

it('default', function () {
    $this->artisan(DefaultCommand::class, ['--all' => true])->assertExitCode(
        PublishCommand::PUBLISHED
    );
});

it('published', function (string $ide) {
    refreshTempDirectory($suffix = 'many-published');

    assertDirectoryExists(
        $directory = tempDirectory($suffix)
    );

    fakeComposer($directory);
    fakeComposer($directory . '/foo');

    ensureTempDirectory($suffix . '/' . $ide);
    ensureTempDirectory($suffix . '/foo/' . $ide);

    $this->artisan(DefaultCommand::class, ['--path' => $directory, '--all' => true])->assertExitCode(
        PublishCommand::PUBLISHED
    );

    assertFileExists($directory . '/' . $ide . '/icon.svg');
    assertFileExists($directory . '/foo/' . $ide . '/icon.svg');
})->with('ide');

it('skipped without composer detecting', function (string $ide) {
    refreshTempDirectory($suffix = 'many-published');

    assertDirectoryExists(
        $directory = tempDirectory($suffix)
    );

    ensureTempDirectory($suffix . '/' . $ide);
    ensureTempDirectory($suffix . '/foo/' . $ide);

    $this->artisan(DefaultCommand::class, ['--path' => $directory, '--all' => true])->assertExitCode(
        PublishCommand::PUBLISHED
    );

    assertFileDoesNotExist($directory . '/' . $ide . '/icon.svg');
    assertFileDoesNotExist($directory . '/foo/' . $ide . '/icon.svg');
})->with('ide');

it('skipped without IDE', function (string $ide) {
    refreshTempDirectory($suffix = 'many-published');

    assertDirectoryExists(
        $directory = tempDirectory($suffix)
    );

    fakeComposer($directory);
    fakeComposer($directory . '/foo');

    $this->artisan(DefaultCommand::class, ['--path' => $directory, '--all' => true])->assertExitCode(
        PublishCommand::PUBLISHED
    );

    assertFileDoesNotExist($directory . '/' . $ide . '/icon.svg');
    assertFileDoesNotExist($directory . '/foo/' . $ide . '/icon.svg');
})->with('ide');
