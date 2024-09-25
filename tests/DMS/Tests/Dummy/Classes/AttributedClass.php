<?php

namespace DMS\Tests\Dummy\Classes;

use DMS\Filter\Rules as Filter;

class AttributedClass
{
    #[Filter\StripTags]
    public string $name;

    #[Filter\StripTags]
    public string $nickname;

    #[Filter\StripTags("<b><i>")]
    public string $description;

    #[Filter\Callback("callbackMethod")]
    public ?string $callback = null;

    #[Filter\Callback(["DMS\Tests\Dummy\Classes\AnnotatedClass", "anotherCallback"])]
    public ?string $callback2 = null;

    public function callbackMethod(): string
    {
        return 'called_back';
    }

    public static function anotherCallback(): string
    {
        return 'called_back';
    }
}
