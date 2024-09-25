<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * Laminas Rule
 *
 * Allows the use for Laminas Filters
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Laminas extends Rule
{
    /**
     * @param string $class can be either a FQN or just Boolean for example
     * @param array $laminasOptions Array of options to be passed into the Laminas Filter
     */
    public function __construct(
        public string $class,
        public array $laminasOptions = []
    ) {
    }
}
