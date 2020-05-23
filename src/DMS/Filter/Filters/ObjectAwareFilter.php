<?php


namespace DMS\Filter\Filters;

/**
 * Interface ObjectAwareFilter
 *
 * Allows filters to be aware of the object they are being applied to.
 *
 * @package DMS\Filter\Filters
 */
interface ObjectAwareFilter
{
    /**
     * Set the current object so that the filter can access it
     *
     * @param $object
     */
    public function setCurrentObject($object);

    /**
     * Retrieves the current Object to be used
     *
     * @return object|null
     */
    public function getCurrentObject();
}
