# Laraccount (Laravel 5 package)


[![Build Status](https://api.travis-ci.com/gorankrgovic/laraccount.svg?branch=master)](https://travis-ci.com/gorankrgovic/laraccount)
[![Latest Stable Version](https://poser.pugx.org/gorankrgovic/laraccount/v/stable)](https://packagist.org/packages/gorankrgovic/laraccount)
[![Total Downloads](https://poser.pugx.org/gorankrgovic/laraccount/downloads)](https://packagist.org/packages/gorankrgovic/laraccount)
[![License](https://poser.pugx.org/gorankrgovic/laraccount/license)](https://packagist.org/packages/gorankrgovic/laraccount)
[![Monthly Downloads](https://poser.pugx.org/gorankrgovic/laraccount/d/monthly)](https://packagist.org/packages/gorankrgovic/laraccount)
[![Daily Downloads](https://poser.pugx.org/gorankrgovic/laraccount/d/daily)](https://packagist.org/packages/gorankrgovic/laraccount)


Laraccount is an easy and flexible way to add account authorization capability to **Laravel 5 (>=5.2.32)**.

## Installation, Configuration and Usage

Via composer

```bash
composer require gorankrgovic/laraccount
```

After that publish the config file

```bash
php artisan vendor:publish --tag="laraccount"
```

And run the setup command.

```bash
php artisan laraccount:setup
```

Finally, run the migrations and you are ready

```bash
php artisan migrate
```

## What does Laraccount support?

- Multiple user models.
- Multiple accounts can be attached to users.
- Accounts caching.
- Events when accounts are attached, detached or synced.

## License

Laraccount is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Contributing

Please report any issue you find in the issues page. Pull requests are more than welcome.
