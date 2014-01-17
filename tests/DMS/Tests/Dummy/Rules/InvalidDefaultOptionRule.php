<?php

namespace DMS\Tests\Dummy\Rules;

use DMS\Filter\Rules\Rule;

class InvalidDefaultOptionRule extends Rule
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
