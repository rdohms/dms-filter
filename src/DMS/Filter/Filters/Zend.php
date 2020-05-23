<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\InvalidZendFilterException;
use DMS\Filter\FilterInterface;
use DMS\Filter\Rules\Zend as ZendRule;
use DMS\Filter\Rules\Rule;
use ReflectionException;
use ReflectionMethod;

/**
 * Zend Filter
 *
 * Instantiates and runs Zend Filters (from ZF2)
 *
 * @package DMS
 * @subpackage Filter
 */
class Zend extends BaseFilter
{
    /**
     * {@inheritDoc}
     *
     * @param ZendRule $rule
     */
    public function apply(Rule $rule, $value)
    {
        return $this->getZendInstance($rule->class, $rule->zendOptions)->filter($value);
    }

    /**
     * Instantiates a configured Zend Filter, if it exists
     *
     * @param string $class
     * @param array $options
     * @return FilterInterface|object
     * @throws InvalidZendFilterException
     */
    public function getZendInstance($class, $options): object
    {
        if (strpos($class, 'Zend\Filter') === false) {
            $class = "Zend\Filter\\".$class;
        }

        if (! class_exists($class)) {
            throw new InvalidZendFilterException("Could not find or autoload: $class");
        }

        try {
            new ReflectionMethod($class, 'setOptions');

            $filter = new $class();
            $filter->setOptions($options);

            return $filter;
        } catch (ReflectionException $e) {
            return new $class($options);
        }
    }
}
