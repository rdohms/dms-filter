<?php

namespace DMS\Tests\Dummy\Classes;

use DMS\Filter\Rules as Filter;

class ChildAttributedClass extends AttributedClass
{
    #[Filter\Trim]
    public string $surname;
}
