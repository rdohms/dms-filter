<?php

namespace Tests\Dummy\Rules;

class DefaultOptionRule extends \DMS\Filter\Rules\Rule
{
    public $config;
    
    public function applyFilter($value)
    {
        return $value;
    }

    public function getDefaultOption()
    {
        return 'config';
    }

}