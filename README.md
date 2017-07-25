# Laravel Categorizable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mayoz/laravel-categorizable.svg?style=flat-square)](https://packagist.org/packages/mayoz/laravel-categorizable)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/mayoz/laravel-categorizable/master.svg?style=flat-square)](https://travis-ci.org/mayoz/laravel-categorizable)
[![StyleCI](https://styleci.io/repos/71335427/shield?branch=master)](https://styleci.io/repos/71335427)

Easily add the ability to category your Eloquent models in Laravel 5.

* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
* [Extending](#extending)
* [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require mayoz/categorizable
```

Register the service provider in your `config/app.php` configuration file:

```php
'providers' => [
    ...
    Mayoz\Categorizable\CategorizableServiceProvider::class,
    ...
];
```

You can publish the migration with:

```bash
php artisan vendor:publish --provider="Mayoz\Categorizable\CategorizableServiceProvider" --tag="migrations"
```

The migration has been published you can create the `categories` and `categorizable` tables. You are feel free for added new fields that you need. After, run the migrations:

```bash
php artisan migrate
```

## Usage

Suppose, you have the `Post` model as follows:

```php
<?php

namespace App;

use Mayoz\Categorizable\Categorizable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Categorizable;
}
```

Associate new categories for the `Post` model:

```php
$post = Post::find(1);

$post->categorize([1, 2, 3, 4, 5]);

return $post;
```

Now, the `post` model is associated with categories ids of `1`, `2`, `3`, `4` and `5`.

Remove the existing category association for the `Post` model:

```php
$post = Post::find(1);

$post->uncategorize([3, 5]);

return $post;
```

The `post` model is associated with categories ids of `1`, `2` and `4`.

Rearrange the category relationships for the `Post` model:

```php
$post = Post::find(1);

$post->recategorize([1, 5]);

return $post;
```

The `post` model is associated with categories ids of `1` and `5`.

## Extending

I suggest, you always extend the `Category` model to define your relationships directly. Create you own `Category` model:

```php
<?php

namespace App;

use Mayoz\Categorizable\Category as BaseCategory;

class Category extends BaseCategory
{
    /**
     * Get all posts for the relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function posts()
    {
        return $this->categorized(Post::class);
    }
}
```

You publish the package config:

```bash
php artisan vendor:publish --provider="Mayoz\Categorizable\CategorizableServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Namespace
    |--------------------------------------------------------------------------
    |
    | Change these values when you need to extend the default category model
    | or if the user model needs to be served in a different namespace.
    |
    */

    'category' => App\Category::class,

];
```

That is all. Now let's play for relationship query with the category.

```php
/**
 * Respond the post
 *
 * @param  \App\Category  $category
 * @return \Illuminate\Http\Response
 */
public function index(Category $category)
{
    return $category->posts()->paginate(10);
}
```

If we did not extend the `Category` model, as had to use;

```php
/**
 * Respond the post
 *
 * @param  \App\Category  $category
 * @return \Illuminate\Http\Response
 */
public function index(Category $category)
{
    return $category->categorize(Post::class)->paginate(10);
}
```

## License

This package is licensed under [The MIT License (MIT)](LICENSE).
