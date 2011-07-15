<?php

namespace DMS\Filter\Rules;

/**
 * Base class for a Filtering Rule, it implements common behaviour
 * 
 * @package DMS
 * @subpackage Filter
 * @category Rule
 * 
 */
abstract class Rule
{
    
    /**
     * Applies actual filter rule to the value and returns the filtered
     * value to be replaced in the original object
     * 
     * @param mixed $value
     * @return mixed
     */
    abstract function applyFilter($value);
    
    /**
     * ** Attribution: This function is based on the Symfony Validator Constraint **
     * 
     * Initializes the filter rule with its options
     *
     * @param mixed $options The options (as associative array)
     *                       or the value for the default
     *                       option (any other type)
     *
     * @throws InvalidOptionsException       When you pass the names of non-existing
     *                                       options
     * @throws MissingOptionsException       When you don't pass any of the options
     *                                       returned by getRequiredOptions()
     * @throws ConstraintDefinitionException When you don't pass an associative
     *                                       array, but getDefaultOption() returns
     *                                       NULL
     * 
     * @link https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Validator/Constraint.php
     */
    public function __construct($options = null)
    {
        $invalidOptions = array();
        $missingOptions = array_flip((array) $this->getRequiredOptions());

        if (is_array($options) && count($options) == 1 && isset($options['value'])) {
            $options = $options['value'];
        }

        if (is_array($options) && count($options) > 0 && is_string(key($options))) {
            foreach ($options as $option => $value) {
                if (property_exists($this, $option)) {
                    $this->$option = $value;
                    unset($missingOptions[$option]);
                } else {
                    $invalidOptions[] = $option;
                }
            }
        } else if (null !== $options && ! (is_array($options) && count($options) === 0)) {
            $option = $this->getDefaultOption();

            if (null === $option) {
                throw new ConstraintDefinitionException(
                    sprintf('No default option is configured for constraint %s', get_class($this))
                );
            }

            if (property_exists($this, $option)) {
                $this->$option = $options;
                unset($missingOptions[$option]);
            } else {
                $invalidOptions[] = $option;
            }
        }

        if (count($invalidOptions) > 0) {
            throw new InvalidOptionsException(
                sprintf('The options "%s" do not exist in constraint %s', implode('", "', $invalidOptions), get_class($this)),
                $invalidOptions
            );
        }

        if (count($missingOptions) > 0) {
            throw new MissingOptionsException(
                sprintf('The options "%s" must be set for constraint %s', implode('", "', array_keys($missingOptions)), get_class($this)),
                array_keys($missingOptions)
            );
        }
    }
    
    /**
     * Returns the name of the required options
     *
     * Override this method if you want to define required options.
     *
     * @return array
     * @see __construct()
     */
    public function getRequiredOptions()
    {
        return array();
    }
    
    /**
     * Returns the name of the default option
     *
     * Override this method to define a default option.
     *
     * @return string
     * @see __construct()
     */
    public function getDefaultOption()
    {
        return null;
    }
}
