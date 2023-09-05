<?php

namespace DMS\Tests\Dummy\Classes;

use DMS\Filter\Rules as Filter;

class ChildAnnotatedClass extends AnnotatedClass
{
    /**
     * @Filter\Trim()
     *
     * @var string
     */
    public string $surname;
}
