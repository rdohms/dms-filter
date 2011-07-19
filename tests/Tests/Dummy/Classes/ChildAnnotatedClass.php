<?php

namespace Tests\Dummy\Classes;

use DMS\Filter\Rules as Filter;

class ChildAnnotatedClass extends AnnotatedClass implements AnnotatedInterface
{
    /**
     * @Filter\Trim()
     * 
     * @var string
     */
    public $surname;
    
}