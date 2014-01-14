<?php
namespace DMS\Filter\Rules;

/**
 * Callback Rule
 */
class Callback extends Rule
{
    /**
     * Method name, should be in the same class.
     *
     * @var string
     */
    public $method = null;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'method';
    }
}
