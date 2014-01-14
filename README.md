# DMS Filter Component

This library provides a service that can be used to filter object values based on annotations

## Install

Use composer to add DMS\Filter to your app

`composer require dms/dms-filter:~2.0`

This will get you the latest compatible version with 2.0 without BC breaks.

## Usage

Your Entity:

```php
<?php

namespace App\Entity;

//Import Annotations
use DMS\Filter\Rules as Filter;

class User
{

    /**
    * @Filter\StripTags()
    * @Filter\Trim()
    * @Filter\StripNewlines()
    *
    * @var string
    */
    public $name;

    /**
    * @Filter\StripTags()
    * @Filter\Trim()
    * @Filter\StripNewlines()
    *
    * @var string
    */
    public $email;

}
?>
```

Filtering:

```php
<?php
    //Get Doctrine Reader
    $reader = new Annotations\AnnotationReader();
    $reader->setEnableParsePhpImports(true);

    //Load AnnotationLoader
    $loader = new Mapping\Loader\AnnotationLoader($reader);
    $this->loader = $loader;

    //Get a MetadataFactory
    $metadataFactory = new Mapping\ClassMetadataFactory($loader);

    //Get a Filter
    $filter = new DMS\Filter\Filter($metadataFactory);


    //Get your Entity
    $user = new App\Entity\User();
    $user->name = "My <b>name</b>";
    $user->email = " email@mail.com";

    //Filter you entity
    $filter->filter($user);

    echo $user->name; //"My name"
    echo $user->email; //"email@mail.com"
?>
```

Full example: https://gist.github.com/1098352

## Dependencies

This package relies on these external libraries:

* Doctrine Annotations

## Contributing

Feel free to send pull requests, just follow these guides:

* Fork
* Code
* Test
    * Just create FilterTestCase and run `phpunit`
* Submit PR

## Credits

This library is inspired by the Symfony 2 Validator component and is meant to work alongside it.

Symfony 2 Validator: https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Validator
