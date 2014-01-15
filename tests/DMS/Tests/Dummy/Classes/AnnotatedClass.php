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
    public $name;

    /**
     * @Filter\StripTags()
     *
     * @var string
     */
    public $nickname;

    /**
     * @Filter\StripTags("<b><i>")
     *
     * @var string
     */
    public $description;

    /**
     * @var string
     * @Filter\Callback("callbackMethod")
     */
    public $callback;

    /**
     * @var string
     * @Filter\Callback({"DMS\Tests\Dummy\Classes\AnnotatedClass", "anotherCallback"})
     */
    public $callback2;

    /**
     * @param $value
     * @return string
     */
    public function callbackMethod($value)
    {
        return 'called_back';
    }

    /**
     * @param $value
     * @return string
     */
    public static function anotherCallback($value)
    {
        return 'called_back';
    }
}
