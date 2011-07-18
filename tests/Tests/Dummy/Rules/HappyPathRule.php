<?php

namespace Tests\Dummy\Rules;

class HappyPathRule extends \DMS\Filter\Rules\Rule
{
    public function applyFilter($value)
    {
        return $value;
    }

}