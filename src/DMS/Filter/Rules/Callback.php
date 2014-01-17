<?php
namespace DMS\Filter\Rules;

use Closure;
use DMS\Filter\Exception\InvalidCallbackException;

/**
 * Callback Rule
 *
 * @Annotation
 */
class Callback extends Rule
{
    const SELF_METHOD_TYPE = 'self_method';
    const CALLABLE_TYPE    = 'callable';
    const CLOSURE_TYPE     = 'closure';

    /**
     * Callback, can be:
     * - string: method of filtered object or function
     * - array: [Class, Method] to be called
     * - Closure
     *
     * @var string
     */
    public $callback = null;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'callback';
    }

    /**
     * Figures out which type of input was provided
     *
     * @return string
     * @throws \DMS\Filter\Exception\InvalidCallbackException
     */
    public function getInputType()
    {
        switch (true) {
            case $this->callback instanceof Closure:
                return self::CLOSURE_TYPE;

            case is_callable($this->callback, false):
                return self::CALLABLE_TYPE;

            case is_string($this->callback):
                return self::SELF_METHOD_TYPE;
        }

        throw new InvalidCallbackException(
            "The input provided for Callback filter is not supported or the callable not valid.
            Please refer to the class documentation."
        );
    }
}
