# Yafo Challange

Service that connect to "Aleph" to fill cmdb table

## Features

- Aleph API Integration
- CMDB Export
- CMDB Import
- CMDB CRUD
- Cached responses

## Installation

```sh
git clone https://github.com/frannbian/yafo-challange
cd yafo-challange
cp .env.example .env
composer install
php artisan migrate

```

## Connect to aleph API
Please fill the environment variable "ALEPH_API_KEY" with the correspondient api key

#### How to run pint

``` bash
./vendor/bin/pint
```

#### How to run test

``` bash
./vendor/bin/phpunit
```

#### Documentation

The API documentations are on postman collection

## Packages

This project is currently extended with the following packages.

| Plugin | README |
| ------ | ------ |
| Pint            | [https://laravel.com/docs/11.x/pint && https://cs.symfony.com/doc/rules/index.html] |
| PestPHP            | [https://pestphp.com/] |
