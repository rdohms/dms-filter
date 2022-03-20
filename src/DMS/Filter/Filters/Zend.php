<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\InvalidZendFilterException;
use DMS\Filter\FilterInterface;
use DMS\Filter\Rules\Rule;
use DMS\Filter\Rules\Zend as ZendRule;
use ReflectionException;
use ReflectionMethod;

use function class_exists;
use function sprintf;
use function strpos;

/**
 * Zend Filter
 *
 * Instantiates and runs Zend Filters (from ZF2)
 *
 * @deprecated Replaced with {@link Laminas}
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
     * @param mixed[] $options
     *
     * @return FilterInterface|object
     *
     * @throws InvalidZendFilterException
     */
    public function getZendInstance(string $class, array $options): object
    {
        if (strpos($class, 'Zend\Filter') === false) {
            $class = 'Zend\Filter\\' . $class;
        }

        if (! class_exists($class)) {
            throw new InvalidZendFilterException(sprintf('Could not find or autoload: %s', $class));
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
