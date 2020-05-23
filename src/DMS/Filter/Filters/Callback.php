<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use Closure;
use DMS\Filter\Exception\FilterException;
use DMS\Filter\Exception\InvalidCallbackException;
use DMS\Filter\Rules\Callback as CallbackRule;
use DMS\Filter\Rules\Rule;

use function call_user_func;
use function get_class;
use function is_callable;
use function method_exists;
use function sprintf;

/**
 * Callback Filter
 */
class Callback extends BaseFilter implements ObjectAwareFilter
{
    protected ?object $currentObject = null;

    /**
     * Set the current object so that the filter can access it
     */
    public function setCurrentObject(object $object): void
    {
        $this->currentObject = $object;
    }

    /**
     * Retrieves the current Object to be used
     */
    public function getCurrentObject(): ?object
    {
        return $this->currentObject;
    }

    /**
     * {@inheritDoc}
     *
     * @param CallbackRule $rule
     */
    public function apply(Rule $rule, $value)
    {
        if ($value === null) {
            return null;
        }

        $type = $rule->getInputType();

        if ($type === CallbackRule::SELF_METHOD_TYPE) {
            return $this->useObjectMethod($rule->callback, $value);
        }

        if ($type === CallbackRule::CALLABLE_TYPE) {
            return $this->useCallable($rule->callback, $value);
        }

        if ($type === CallbackRule::CLOSURE_TYPE) {
            return $this->useClosure($rule->callback, $value);
        }

        throw new InvalidCallbackException('Unsupported callback provided, failed to filter property');
    }

    /**
     * Filters by executing a method in the object
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws InvalidCallbackException
     * @throws FilterException
     */
    protected function useObjectMethod(string $method, $value)
    {
        $currentObject = $this->getCurrentObject();

        if ($currentObject === null) {
            throw new FilterException(
                "The target object was not provided to the filter, can't execute method. Please report this."
            );
        }

        if (! method_exists($currentObject, $method)) {
            throw new InvalidCallbackException(
                sprintf(
                    "CallbackFilter: Method '%s' not found in object of type '%s'",
                    $method,
                    get_class($currentObject)
                )
            );
        }

        return $currentObject->$method($value);
    }

    /**
     * Filters using a callable.
     *
     * @param mixed             $value
     * @param string[]|callable $callable
     *
     * @return mixed
     *
     * @throws InvalidCallbackException
     */
    protected function useCallable($callable, $value)
    {
        if (! is_callable($callable, false, $input)) {
            throw new InvalidCallbackException(sprintf('The callable %s could not be resolved.', $input));
        }

        return call_user_func($callable, $value);
    }

    /**
     * @param mixed          $value
     * @param string|Closure $closure
     *
     * @return mixed
     *
     * @throws InvalidCallbackException
     */
    protected function useClosure($closure, $value)
    {
        if (! $closure instanceof Closure) {
            throw new InvalidCallbackException('CallbackFilter: the provided closure is invalid');
        }

        return $closure($value);
    }
}
