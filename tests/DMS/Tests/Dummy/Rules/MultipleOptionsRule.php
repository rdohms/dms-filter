<?php

namespace DMS\Tests\Dummy\Rules;

use DMS\Filter\Rules\Rule;

class MultipleOptionsRule extends Rule
{

    public $config;
    public $path;
    public $url;

    public function applyFilter($value)
    {
        return $value;
    }


}
