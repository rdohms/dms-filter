<?php
declare(strict_types=1);

namespace DMS\Filter;

/**
 * Filter Object, responsible for retrieving the filtering rules
 * for the object and applying them
 */
use DMS\Filter\Filters\Loader\FilterLoaderInterface;
use DMS\Filter\Mapping\ClassMetadataFactoryInterface;
use DMS\Filter\Rules\Rule;
use ReflectionException;

use function get_class;

/**
 * Executor, receives objects that need filtering and executes attached rules.
 */
class Filter implements FilterInterface
{
    protected Mapping\ClassMetadataFactory $metadataFactory;

    protected FilterLoaderInterface $filterLoader;

    /**
     * Constructor
     */
    public function __construct(Mapping\ClassMetadataFactory $metadataFactory, FilterLoaderInterface $filterLoader)
    {
        $this->metadataFactory = $metadataFactory;
        $this->filterLoader    = $filterLoader;
    }

    /**
     * {@inheritDoc}
     */
    public function filterEntity($object): void
    {
        $this->walkObject($object);
    }

    /**
     * {@inheritDoc}
     */
    public function filterProperty($object, $property): void
    {
        $this->walkObject($object, $property);
    }

    /**
     * {@inheritDoc}
     */
    public function filterValue($value, $rule)
    {
        if ($rule instanceof Rules\Rule) {
            $filter = $this->filterLoader->getFilterForRule($rule);

            return $filter->apply($rule, $value);
        }

        return $this->walkRuleChain($value, $rule);
    }

    public function getMetadataFactory(): ClassMetadataFactoryInterface
    {
        return $this->metadataFactory;
    }

    /**
     * Iterates over annotated properties in an object filtering the selected
     * values
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    protected function walkObject(?object $object, ?string $limitProperty = null): void
    {
        if ($object === null) {
            return;
        }

        $metadata = $this->metadataFactory->getClassMetadata(get_class($object));

        //Get a Object Handler/Walker
        $walker = new ObjectWalker($object, $this->filterLoader);

        //Get all filtered properties or limit with selected
        $properties = $limitProperty !== null ? [$limitProperty] : $metadata->getFilteredProperties();

        //Iterate over properties with filters
        foreach ($properties as $property) {
            $walker->applyFilterRules($property, $metadata->getPropertyRules($property));
        }
    }

    /**
     * Iterates over an array of filters applying all to the value
     *
     * @param mixed  $value
     * @param Rule[] $rules
     *
     * @return mixed
     */
    protected function walkRuleChain($value, array $rules)
    {
        foreach ($rules as $rule) {
            $filter = $this->filterLoader->getFilterForRule($rule);
            $value  = $filter->apply($rule, $value);
        }

        return $value;
    }
}
