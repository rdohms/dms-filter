<?php
namespace DMS\Filter\Rules;

/**
 * Zend Rule
 *
 * Allows the use for Zend Filters
 *
 * @Annotation
 */
class Zend extends Rule
{
    /**
     * Zend\Filter class, can be either a FQN or just Boolean for example
     *
     * @var string
     */
    public $class;

    /**
     * Array of options to be passed into the Zend Filter
     *
     * @var array
     */
    public $zendOptions = array();

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'class';
    }
}
