<?php

namespace DMS\Tests\Dummy\Rules;

use DMS\Filter\Rules\Rule;

class NoOptionsRule extends Rule
{
    public function applyFilter($value)
    {
        return $value;
    }
}
