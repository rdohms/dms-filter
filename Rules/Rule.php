<?php

namespace DMS\Filter\Rules;

use DMS\Filter\Exception\InvalidOptionsException;
use DMS\Filter\Exception\MissingOptionsException;
use DMS\Filter\Exception\RuleDefinitionException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * Base class for a Filtering Rule, it implements common behaviour
 *
 * Rules are classes that define the metadata supported by
 * each filter and are used to annotate objects.
 *
 * @package DMS
 * @subpackage Filter
 * @category Rule
 *
 */
abstract class Rule
{
    /**
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
     */
    public function __construct($options = null)
    {

        $result = $this->parseOptions($options);

        if (count($result->invalidOptions) > 0) {
            throw new InvalidOptionsException(
                sprintf(
                    'The options "%s" do not exist in rule %s',
                    implode('", "', $result->invalidOptions),
                    get_class($this)
                ),
                $result->invalidOptions
            );
        }

        if (count($result->missingOptions) > 0) {
            throw new MissingOptionsException(
                sprintf(
                    'The options "%s" must be set for rule %s',
                    implode('", "', array_keys($result->missingOptions)),
                    get_class($this)
                ),
                array_keys($result->missingOptions)
            );
        }
    }

    /**
     * Parses provided options into their properties and returns results
     * for the parsing process
     *
     * @param mixed $options
     * @return \stdClass
     */
    private function parseOptions($options)
    {
        $parseResult = new \stdClass();
        $parseResult->invalidOptions = array();
        $parseResult->missingOptions = array_flip((array)$this->getRequiredOptions());

        //Doctrine parses constructor parameter into 'value' array param, restore it
        if (is_array($options) && count($options) == 1 && isset($options['value'])) {
            $options = $options['value'];
        }

        //Parse Option Array
        if (is_array($options) && count($options) > 0 && is_string(key($options))) {
            $this->parseOptionsArray($options, $parseResult);
            return $parseResult;
        }

        //Parse Single Value
        if (null !== $options && ! (is_array($options) && count($options) === 0)) {
            $this->parseSingleOption($options, $parseResult);
            return $parseResult;
        }

        return $parseResult;
    }

    /**
     * Parses Options in the array format
     *
     * @param array $options
     * @param \stdClass $result
     */
    private function parseOptionsArray($options, $result)
    {
        foreach ($options as $option => $value) {

            if (! property_exists($this, $option)) {
                $result->invalidOptions[] = $option;
                continue;
            }

            //Define Option
            $this->$option = $value;
            unset($result->missingOptions[$option]);
        }
    }

    /**
     * Parses single option received
     *
     * @param string $options
     * @param \stdClass $result
     * @throws \DMS\Filter\Exception\RuleDefinitionException
     */
    private function parseSingleOption($options, $result)
    {
        $option = $this->getDefaultOption();

        //No Default set, usnsure what to do
        if (null === $option) {
            throw new RuleDefinitionException(
                sprintf('No default option is configured for rule %s', get_class($this))
            );
        }

        //Default option points to invalid one
        if (! property_exists($this, $option)) {
            $result->invalidOptions[] = $option;
            return;
        }

        //Define Option
        $this->$option = $options;
        unset($result->missingOptions[$option]);
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

    /**
     * Retrieves the Filter class that is responsible for executing this filter
     * It may also be a service name. By default it loads a class with the
     * same name from the Filters namespace.
     *
     * @return string
     */
    public function getFilter()
    {
        return str_replace('Rules', 'Filters', get_class($this));
    }
}
