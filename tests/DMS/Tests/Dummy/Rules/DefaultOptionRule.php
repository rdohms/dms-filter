<?php

namespace DMS\Tests\Dummy\Rules;

use DMS\Filter\Rules\Rule;

class DefaultOptionRule extends Rule
{
    /**
     * @var mixed
     */
    public $config;

    public function applyFilter($value)
    {
        return $value;
    }

    public function getDefaultOption(): ?string
    {
        return 'config';
    }
}
