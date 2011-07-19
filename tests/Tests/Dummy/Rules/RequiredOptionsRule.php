<?php

namespace Tests\Dummy\Rules;

class RequiredOptionsRule extends \DMS\Filter\Rules\Rule
{
    
    public $config;
    public $path;
    public $url;
    
    public function applyFilter($value)
    {
        return $value;
    }

    public function getDefaultOption()
    {
        return 'config';
    }

    public function getRequiredOptions()
    {
        return array('config', 'path');
    }

}