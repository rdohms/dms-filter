<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

/**
 * Allows filters to be aware of the object they are being applied to.
 */
interface ObjectAwareFilter
{
    /**
     * Set the current object so that the filter can access it
     */
    public function setCurrentObject(object $object): void;

    /**
     * Retrieves the current Object to be used
     */
    public function getCurrentObject(): ?object;
}
