<?php

namespace Tests\Dummy\Rules;

class InvalidDefaultOptionRule extends \DMS\Filter\Rules\Rule
{
    public $config;
    
    public function applyFilter($value)
    {
        return $value;
    }

    public function getDefaultOption()
    {
        return 'path';
    }

}