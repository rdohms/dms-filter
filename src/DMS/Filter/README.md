# DMS Filter Component

This library provides a service that can be used to filter object values based on annotations

## Usage

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
    $filter = new Filter($metadataFactory);

    //Filter object
    $filter->filter($object);
?>
```

## Dependencies

This package relies on these external libraries:

* Doctrine Common: Reader and Cache

## Contributing

Feel free to send pull requests, just follow these guides:

* Fork
* Code
* Test
    * Tests are in: https://github.com/rdohms/DMS
    * Just create Testcase and run `phpunit` inside the `tests` folder
* Submit PR

## Credits

This library is inspired by the Symfony 2 Validator component and is meant to work alongside it. 

Symfony 2 Validator: https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Validator