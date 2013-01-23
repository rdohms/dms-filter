<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;
use DMS\Filter\Exception\FilterException;

/**
 * ToLower Filter
 *
 * @package DMS
 * @subpackage Filter
 */
class ToLower extends BaseFilter
{

    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\ToLower $rule
     */
    public function apply(Rule $rule, $value)
    {
        if ($this->useEncoding($rule)) {
            return mb_strtolower((string) $value, $rule->encoding);
        }

        return strtolower((string) $value);
    }

    /**
     * Verify is encoding is set and if we have the proper
     * function to use it
     *
     * @param \DMS\Filter\Rules\ToLower $rule
     *
     * @throws \DMS\Filter\Exception\FilterException
     * @return boolean
     */
    public function useEncoding($rule)
    {
        if ($rule->encoding === null) {
            return false;
        }

        if (!function_exists('mb_strtolower')) {
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
