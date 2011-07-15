<?php

namespace DMS\Filter\Rules;

class StripTags extends Rule
{
    public $allowed = "";
    
    public function applyFilter($value)
    {
        return strip_tags($value, $this->allowed);
    }

}