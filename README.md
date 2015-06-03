[![Build Status](https://img.shields.io/travis/kristijanhusak/laravel4-form-builder/master.svg?style=flat)](https://travis-ci.org/kristijanhusak/laravel4-form-builder)
[![Coverage Status](http://img.shields.io/scrutinizer/coverage/g/kristijanhusak/laravel4-form-builder.svg?style=flat)](https://scrutinizer-ci.com/g/kristijanhusak/laravel4-form-builder/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/kris/laravel4-form-builder.svg?style=flat)](https://packagist.org/packages/kris/laravel4-form-builder)
[![Latest Stable Version](https://img.shields.io/packagist/v/kris/laravel4-form-builder.svg?style=flat)](https://packagist.org/packages/kris/laravel4-form-builder)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)

# Laravel 4 form builder

Form builder for **Laravel 4** inspired by Symfony's form builder. With help of Laravels FormBuilder class creates forms that can be easy modified and reused.
By default it supports Bootstrap 3.

## Laravel 5
For laravel 5 version check [laravel-form-builder](https://github.com/kristijanhusak/laravel-form-builder)

## Documentation
For detailed documentation refer to [http://kristijanhusak.github.io/laravel-form-builder/](http://kristijanhusak.github.io/laravel-form-builder/).

**Note** There are small differences between version 4 and 5 (Configuration path, etc.), so please be aware of those.

## Changelog
Changelog can be found [here](https://github.com/kristijanhusak/laravel4-form-builder/blob/master/CHANGELOG.md)

###Installation

``` json
{
    "require": {
        "kris/laravel4-form-builder": "1.5.*"
    }
}
```

run `composer update`

Then add Service provider to `config/app.php`

``` php
    'providers' => [
        // ...
        'Kris\LaravelFormBuilder\FormBuilderServiceProvider'
    ]
```

And Facade (also in `config/app.php`)

``` php
    'aliases' => [
        // ...
        'FormBuilder' => 'Kris\LaravelFormBuilder\Facades\FormBuilder'
    ]

```

### Basic usage

Creating form classes is easy. Lets assume PSR-4 is set for loading namespace `Project` in `app/Project` folder. With a simple artisan command we can create form:

``` sh
    php artisan make:form app/Project/Forms/PostForm
```

you create form class in path `app/Project/Forms/PostForm.php` that looks like this:

``` php
<?php namespace Project\Forms;

use Kris\LaravelFormBuilder\Form;

class PostForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
    }
}
```

You can add fields which you want when creating command like this:

``` sh
php artisan make:form app/Project/Forms/SongForm --fields="name:text, lyrics:textarea, publish:checkbox"
```

And that will create form in path `app/Project/Forms/SongForm.php` with content:

``` php
<?php namespace Project\Forms;

use Kris\LaravelFormBuilder\Form;

class SongForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text')
            ->add('lyrics', 'textarea')
            ->add('publish', 'checkbox');
    }
}
```

#### Usage in controllers

Forms can be used in controller like this:

``` php
<?php namespace Project\Http\Controllers;

use Illuminate\Routing\Controller;
use Kris\LaravelFormBuilder\FormBuilder;

class SongsController extends BaseController {

    protected $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    public function create()
    {
        $form = $this->formBuilder->create('Project\Forms\SongForm', [
            'method' => 'POST',
            'url' => route('song.store')
        ]);

        return view('song.create', compact('form'));
    }

    public function store()
    {
    }
}
```

#### Usage in views

From controller they can be used in views like this:

``` html
<!-- resources/views/song/create.blade.php -->

@extend('layouts.master')

@section('content')
    {{ form($form) }}
@endsection
```

`{{ form($form) }}` Will generate this html:

``` html
<form method="POST" action="http://example.dev/songs">
    <input name="_token" type="hidden" value="FaHZmwcnaOeaJzVdyp4Ml8B6l1N1DLUDsZmsjRFL">
    <div class="form-group">
        <label for="name" class="control-label">name</label>
        <input type="text" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="lyrics" class="control-label">lyrics</label>
        <textarea name="lyrics" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="publish" class="control-label">publish</label>
        <input type="checkbox" name="publish" id="publish">
    </div>
</form>
```


### Quick start

Creating form classes is easy. Lets assume PSR-4 is set for loading namespace `App` in `app/Project` folder. With a simple artisan command we can create form:

```sh
php artisan make:form app/Project/Forms/SongForm --fields="name:text, lyrics:textarea, publish:checkbox"
```

Form is created in path `app/Project/Forms/SongForm.php` with content:

```php
<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class SongForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text')
            ->add('lyrics', 'textarea')
            ->add('publish', 'checkbox');
    }
}
```

If you want to instantiate empty form without any fields, just skip passing `--fields` parameter:

```sh
    php artisan make:form app/Project/Forms/PostForm
```

Gives:

```php
<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PostForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
    }
}
```

After that instantiate the class in the controller and pass it to view:

```php
<?php namespace App/Http/Controllers;

use Illuminate\Routing\Controller as BaseController;
use Kris\LaravelFormBuilder\FormBuilder;

class SongsController extends BaseController {

    public function create()
    {
        $form = \FormBuilder::create('App\Forms\SongForm', [
            'method' => 'POST',
            'url' => route('song.store')
        ]);

        return view('song.create', compact('form'));
    }
}
```

Print the form in view with `form()` helper function:

```html
<!-- resources/views/song/create.blade.php -->

@extend('layouts.master')

@section('content')
    {{{ form($form) }}}
@endsection
```

Above code will generate this html:

```html
<form method="POST" action="http://example.dev/songs">
    <input name="_token" type="hidden" value="FaHZmwcnaOeaJzVdyp4Ml8B6l1N1DLUDsZmsjRFL">
    <div class="form-group">
        <label for="name" class="control-label">Name</label>
        <input type="text" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="lyrics" class="control-label">Lyrics</label>
        <textarea name="lyrics" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="publish" class="control-label">Publish</label>
        <input type="checkbox" name="publish" id="publish">
    </div>
</form>
```
