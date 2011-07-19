<?php

namespace Tests\Dummy\Rules;

class NoOptionsRule extends \DMS\Filter\Rules\Rule
{
    public function applyFilter($value)
    {
        return $value;
    }

}