<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\InvalidZendFilterException;
use DMS\Filter\FilterInterface;
use DMS\Filter\Rules\Laminas as LaminasRule;
use DMS\Filter\Rules\Rule;
use ReflectionException;
use ReflectionMethod;

use function class_exists;
use function sprintf;
use function strpos;

/**
 * Laminas Filter
 *
 * Instantiates and runs Laminas Filters (from ZF2)
 */
class Laminas extends BaseFilter
{
    /**
     * {@inheritDoc}
     *
     * @param LaminasRule $rule
     */
    public function apply(Rule $rule, $value)
    {
        return $this->getLaminasInstance($rule->class, $rule->laminasOptions)->filter($value);
    }

    /**
     * Instantiates a configured Laminas Filter, if it exists
     *
     * @param mixed[] $options
     *
     * @return FilterInterface|object
     *
     * @throws InvalidZendFilterException
     */
    public function getLaminasInstance(string $class, array $options): object
    {
        if (strpos($class, 'Laminas\Filter') === false) {
            $class = 'Laminas\Filter\\' . $class;
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
