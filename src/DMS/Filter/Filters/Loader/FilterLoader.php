<?php
namespace DMS\Filter\Filters\Loader;

use DMS\Filter\Filters\BaseFilter;
use DMS\Filter\Rules\Rule;
use UnexpectedValueException;

/**
 * Class FilterLoader
 *
 * Loads the filter that enforces a specific rule.
 *
 * @package DMS\Filter\Filters\Loader
 */
class FilterLoader implements FilterLoaderInterface
{

    /**
     * Finds the filter responsible for executing a specific rule
     *
     * @param Rule $rule
     *
     * @throws UnexpectedValueException If filter can't be located
     * @return BaseFilter
     */
    public function getFilterForRule(Rule $rule): BaseFilter
    {
        $filterIdentifier = $rule->getFilter();

        if (class_exists($filterIdentifier)) {
            return new $filterIdentifier;
        }

        $error = "Unable to locate filter for: $filterIdentifier defined in " . get_class($rule);
        throw new UnexpectedValueException($error);
    }
}
