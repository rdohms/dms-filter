# DMS Filter Component

This library provides a service that can be used to filter object values based on annotations

[![Latest Stable Version](https://poser.pugx.org/dms/dms-filter/v/stable.png)](https://packagist.org/packages/dms/dms-filter) [![Total Downloads](https://poser.pugx.org/dms/dms-filter/downloads.png)](https://packagist.org/packages/dms/dms-filter) [![Latest Unstable Version](https://poser.pugx.org/dms/dms-filter/v/unstable.png)](https://packagist.org/packages/dms/dms-filter) [![License](https://poser.pugx.org/dms/dms-filter/license.png)](https://packagist.org/packages/dms/dms-filter) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/bb7f41c3-ee7c-4473-8fbf-806453a9e899/mini.png)](https://insight.sensiolabs.com/projects/bb7f41c3-ee7c-4473-8fbf-806453a9e899) [![Build Status](https://travis-ci.org/rdohms/dms-filter.png?branch=master)](https://travis-ci.org/rdohms/dms-filter)![Unit Tests](https://github.com/rdohms/dms-filter/workflows/Unit%20Tests/badge.svg)

## Install

Use composer to add DMS\Filter to your app

`composer require dms/dms-filter`

## Usage

Your Entity:

```php
<?php

namespace App\Entity;

//Import Attributes
use DMS\Filter\Rules as Filter;

class User
{
    #[Filter\StripTags]
    #[Filter\Trim]
    #[Filter\StripNewlines]
    public string $name;

    #[Filter\StripTags]
    #[Filter\Trim]
    #[Filter\StripNewlines]
    public string $email;
}
?>
```

Filtering:
```php
<?php
    //Load AttributeLoader
    $loader = new Mapping\Loader\AttributeLoader();

    //Get a MetadataFactory
    $metadataFactory = new Mapping\ClassMetadataFactory($loader);

    //Get a FilterLoader
    $filterLoader = new \DMS\Filter\Filters\Loader\FilterLoader();

    //Get a Filter
    $filter = new DMS\Filter\Filter($metadataFactory, $filterLoader);


    //Get your Entity
    $user = new App\Entity\User();
    $user->name = "My <b>name</b>";
    $user->email = " email@mail.com";

    //Filter you entity
    $filter->filterEntity($user);

    echo $user->name; //"My name"
    echo $user->email; //"email@mail.com"
?>
```
## Contributing

Feel free to send pull requests, just follow these guides:

* Fork
* Code
* Test
    * Just create FilterTestCase and run `phpunit`
* Submit PR

## Credits

This library is inspired by the Symfony 2 Validator component and is meant to work alongside it.

Symfony Validator: https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Validator
