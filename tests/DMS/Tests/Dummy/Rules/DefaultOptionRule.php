<?php

namespace DMS\Tests\Dummy\Rules;

use DMS\Filter\Rules\Rule;

class DefaultOptionRule extends Rule
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
