# Nisimpo Auth Package

<a href="https://packagist.org/packages/nisimpo/auth"><img src="https://img.shields.io/packagist/dt/nisimpo/auth" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/nisimpo/auth"><img src="https://img.shields.io/packagist/v/nisimpo/auth" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/nisimpo/auth"><img src="https://img.shields.io/packagist/l/nisimpo/auth" alt="License"></a>

## Introduction

This package does provide a basic starting point using [Bootstrap](https://getbootstrap.com/), [React](https://reactjs.org/), and / or [Vue](https://vuejs.org/) that will be helpful for many applications. By default, Laravel uses [NPM](https://www.npmjs.org/) to install both of these frontend packages.

> This legacy package is a very simple authentication scaffolding built on the Bootstrap CSS framework. While it continues to work with the latest version of Laravel, you should consider using [Laravel Breeze](https://github.com/laravel/breeze) for new projects. Or, for something more robust, consider [Laravel Jetstream](https://github.com/laravel/jetstream).

## Official Documentation

### Supported Versions

Only the latest major version of Laravel UI receives bug fixes. The table below lists compatible Laravel versions:

| Version | Laravel Version |
|---- |----|
| [1.x](https://github.com/laravel/ui/tree/1.x) | 5.8, 6.x |
| [2.x](https://github.com/laravel/ui/tree/2.x) | 7.x |
| [3.x](https://github.com/laravel/ui/tree/3.x) | 8.x, 9.x |
| [4.x](https://github.com/laravel/ui/tree/4.x) | 9.x, 10.x, 11.x |

### Installation

The Bootstrap and Vue scaffolding provided by Nisimpo is located in the `nisimpo/auth` Composer package, which may be installed in your new laravel app using Composer:

```bash
composer require nisimpo/auth:dev-main
```

Once the `nisimpo/auth` package has been installed, you may install the frontend scaffolding using the `ui` Artisan command:

```bash
// Generate login / registration scaffolding...
php artisan ui bootstrap --auth
```
Setup the database of your choice in .env file
```bash
// Run migration and seeder to get started
php artisan migrate:fresh --seed
```
Your good to go start app by using the following credentials
```bash
[user]: test@bizytech.com
password: password
```
### Integrating with the package direct from vendor on development
This is when your doing development in this package and you need to test you code from package.
You dont need this if your using the package
```json 
"repositories": {
  "dev-package": {
    "type": "path",
    "url": "/Users/bizytech/Herd/auth",
    "options": {
      "symlink": true
    }
  }
}
```
Add this to you `composer.json` file of a new laravel application to test your package development directly
On the url replace the `/Users/bizytech/Herd/auth` with the complete path of your package directory

## License

Nisimpo AUTH is open-sourced software licensed under the [MIT license](LICENSE.md).
