<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;
use DMS\Filter\Exception\FilterException;

/**
 * ToUpper Filter
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class ToUpper extends BaseFilter
{
    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\ToUpper $rule
     */
    public function apply(Rule $rule, $value)
    {
        if ($this->useEncoding($rule)) {
            return mb_strtoupper((string) $value, $rule->encoding);
        }

        return strtoupper((string) $value);
    }

    /**
     * Verify is encoding is set and if we have the proper
     * function to use it
     *
     * @param \DMS\Filter\Rules\ToUpper $rule
     *
     * @throws \DMS\Filter\Exception\FilterException
     * @return boolean
     */
    public function useEncoding($rule)
    {
        if ($rule->encoding === null) {
            return false;
        }

        if (!function_exists('mb_strtoupper')) {
            throw new FilterException(
                'mbstring is required to use ToLower with an encoding.');
        }

        $this->encoding = (string) $rule->encoding;
        $encodings = array_map('strtolower', mb_list_encodings());

        if (!in_array(strtolower($rule->encoding), $encodings)) {
            throw new FilterException(
                "mbstring does not support the '".$rule->encoding."' encoding"
            );
        }

        return true;
    }
}
