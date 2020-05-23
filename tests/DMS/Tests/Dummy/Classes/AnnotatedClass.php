<?php

namespace DMS\Tests\Dummy\Classes;

use DMS\Filter\Rules as Filter;

class AnnotatedClass
{
    /**
     * @Filter\StripTags()
     *
     * @var string
     */
    public string $name;

    /**
     * @Filter\StripTags()
     *
     * @var string
     */
    public string $nickname;

    /**
     * @Filter\StripTags("<b><i>")
     *
     * @var string
     */
    public string $description;

    /**
     * @var string
     * @Filter\Callback("callbackMethod")
     */
    public ?string $callback = null;

    /**
     * @var string
     * @Filter\Callback({"DMS\Tests\Dummy\Classes\AnnotatedClass", "anotherCallback"})
     */
    public ?string $callback2 = null;

    /**
     * @var string
     * @Filter\Zend("StringToLower")
     */
    public ?string $zend = null;

    /**
     * @var string
     * @Filter\Zend(class="Boolean", zendOptions={"casting"=false})
     */
    public ?string $zendalternate = null;

    /**
     * @param $value
     * @return string
     */
    public function callbackMethod($value): string
    {
        return 'called_back';
    }

    /**
     * @param $value
     * @return string
     */
    public static function anotherCallback($value): string
    {
        return 'called_back';
    }
}
