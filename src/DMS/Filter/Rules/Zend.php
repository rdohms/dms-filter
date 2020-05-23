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
    public string $class;

    /**
     * Array of options to be passed into the Zend Filter
     *
     * @var array
     */
    public array $zendOptions = [];

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption(): ?string
    {
        return 'class';
    }
}
