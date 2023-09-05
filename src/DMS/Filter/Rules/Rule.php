<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use DMS\Filter\Exception\InvalidOptionsException;
use DMS\Filter\Exception\MissingOptionsException;
use DMS\Filter\Exception\RuleDefinitionException;
use stdClass;

use function array_flip;
use function array_keys;
use function count;
use function implode;
use function is_array;
use function is_string;
use function key;
use function property_exists;
use function sprintf;
use function str_replace;

/**
 * Base class for a Filtering Rule, it implements common behaviour
 *
 * Rules are classes that define the metadata supported by
 * each filter and are used to annotate objects.
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
     */
    public function __construct(mixed $options = null)
    {
        $result = $this->parseOptions($options);

        if (count($result->invalidOptions) > 0) {
            throw new InvalidOptionsException(
                sprintf(
                    'The options "%s" do not exist in rule %s',
                    implode('", "', $result->invalidOptions),
                    static::class,
                ),
                $result->invalidOptions,
            );
        }

        if (count($result->missingOptions) > 0) {
            throw new MissingOptionsException(
                sprintf(
                    'The options "%s" must be set for rule %s',
                    implode('", "', array_keys($result->missingOptions)),
                    static::class,
                ),
                array_keys($result->missingOptions),
            );
        }
    }

    /**
     * Parses provided options into their properties and returns results
     * for the parsing process
     */
    private function parseOptions(mixed $options): stdClass
    {
        $parseResult                 = new stdClass();
        $parseResult->invalidOptions = [];
        $parseResult->missingOptions = array_flip($this->getRequiredOptions());
        $options                     = $this->extractFromValueOption($options);

        if ($options === null) {
            return $parseResult;
        }

        //Parse Option Array
        if ($this->isNonEmptyMap($options)) {
            $this->parseOptionsArray($options, $parseResult);

            return $parseResult;
        }

        //Parse Single Value
        if ($options !== []) {
            $this->parseSingleOption($options, $parseResult);

            return $parseResult;
        }

        return $parseResult;
    }

    /**
     * Parses Options in the array format
     *
     * @param mixed[] $options
     */
    private function parseOptionsArray(array $options, stdClass $result): void
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
     * @param string|mixed[]|scalar $options
     *
     * @throws RuleDefinitionException
     */
    private function parseSingleOption(mixed $options, stdClass $result): void
    {
        $option = $this->getDefaultOption();

        //No Default set, unsure what to do
        if ($option === null) {
            throw new RuleDefinitionException(
                sprintf('No default option is configured for rule %s', static::class),
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
     * @see __construct()
     *
     * @return string[]
     */
    public function getRequiredOptions(): array
    {
        return [];
    }

    /**
     * Returns the name of the default option
     *
     * Override this method to define a default option.
     *
     * @see __construct()
     */
    public function getDefaultOption(): string|null
    {
        return null;
    }

    /**
     * Retrieves the Filter class that is responsible for executing this filter
     * It may also be a service name. By default it loads a class with the
     * same name from the Filters namespace.
     */
    public function getFilter(): string
    {
        return str_replace('Rules', 'Filters', static::class);
    }

    /**
     * Doctrine parses constructor parameter into 'value' array param, restore it
     */
    private function extractFromValueOption(mixed $options): mixed
    {
        if (is_array($options) && count($options) === 1 && isset($options['value'])) {
            $options = $options['value'];
        }

        return $options;
    }

    private function isNonEmptyMap(mixed $options): bool
    {
        return is_array($options) && count($options) > 0 && is_string(key($options));
    }
}
