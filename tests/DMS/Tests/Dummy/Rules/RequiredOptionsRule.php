<?php

namespace DMS\Tests\Dummy\Rules;

use DMS\Filter\Rules\Rule;

class RequiredOptionsRule extends Rule
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
