<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

/**
 * Zend Rule
 *
 * Allows the use for Zend Filters
 *
 * @deprecated Replaced with {@link Laminas}
 *
 * @Annotation
 */
class Zend extends Rule
{
    /**
     * Zend\Filter class, can be either a FQN or just Boolean for example
     */
    public string $class;

    /**
     * Array of options to be passed into the Zend Filter
     *
     * @var mixed[]
     */
    public array $zendOptions = [];

    public function getDefaultOption(): ?string
    {
        return 'class';
    }
}
