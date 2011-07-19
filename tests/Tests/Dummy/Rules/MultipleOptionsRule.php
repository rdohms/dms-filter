<?php

namespace Tests\Dummy\Rules;

class MultipleOptionsRule extends \DMS\Filter\Rules\Rule
{
    
    public $config;
    public $path;
    public $url;
    
    public function applyFilter($value)
    {
        return $value;
    }

    
}