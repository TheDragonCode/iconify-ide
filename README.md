# Iconify Your Projects

![](https://preview.dragon-code.pro/dragon-code/iconify%20IDE%20projects.svg?background=5865f2&preposition=with&mode=auto)

[![Stable Version][badge_stable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![Github Workflow Status][badge_build]][link_build]
[![License][badge_license]][link_license]

## Compare

> ![before - after](/.github/images/compare.png)

## Installation

To get the latest version of `Iconify IDE`, simply require the package using [Composer](https://getcomposer.org):

```bash
composer global require dragon-code/iconify-ide:*
```

## Usage

To publish the icon only to the startup folder, run the console command:

```bash
iconify
```

To recursively discover projects and publish icons, call the console command with a parameter pass:

```bash
iconify --all
```

By default, the search is performed in the current folder for which the console command is called (`./`).

To search in another folder you can use the `--path` parameter:

```bash
iconify --path=foo/bar
iconify --path=./foo/bar
iconify --path=../foo/bar
iconify --path=/foo/bar

iconify --all --path=foo/bar
iconify --all --path=./foo/bar
iconify --all --path=../foo/bar
iconify --all --path=/foo/bar
```

## Contributing

> [!TIP]
> Creating classes for new brands and IDEs is compatible
> with [Laravel Idea](https://plugins.jetbrains.com/plugin/13441-laravel-idea).
>
> ![Laravel Idea](/.github/images/laravel-idea.png)

### Adding a new brand

1. Place the SVG file in the `resources/brands` folder. The file name should be in `snake_case`. Or you can override the
   `getFilename` method in the brand class. The method should return the file name without extension.
2. Create a brand class in the `app/Brands` folder. The name should be in `PascalCase`.
3. Specify a reference to the created class in the `config/data.php` configuration file.
   Pay attention to the order of references - the higher the class is specified, the higher its priority.

### Adding a new IDE

1. Create an IDE class in the `app/Ide` folder. The name should be in `PascalCase`.
2. Specify a reference to the created class in the `config/data.php` configuration file.

## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:          https://img.shields.io/github/actions/workflow/status/TheDragonCode/iconify-ide/phpunit.yml?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/iconify-ide.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/iconify-ide.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/iconify-ide?label=packagist&style=flat-square

[link_build]:           https://github.com/TheDragonCode/iconify-ide/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/iconify-ide
