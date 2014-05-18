<?php

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Exception\MappingException;
use DMS\Filter\Rules\Rule;

abstract class AbstractLoader implements LoaderInterface
{
    /**
     * Contains all known namespaces indexed by their prefix
     * @var array
     */
    protected $namespaces = array();

    /**
     * Adds a namespace alias.
     *
     * @param string $alias     The alias
     * @param string $namespace The PHP namespace
     */
    protected function addNamespaceAlias($alias, $namespace)
    {
        $this->namespaces[$alias] = $namespace;
    }

    /**
     * Creates a new rule instance for the given rule name.
     *
     * @param string $name   The rule name. Either a rule relative
     *                       to the default rule namespace, or a fully
     *                       qualified class name
     * @param mixed $options The rule options
     *
     * @return Rule
     *
     * @throws MappingException If the namespace prefix is undefined
     */
    protected function newRule($name, $options)
    {
        if (strpos($name, '\\') !== false && class_exists($name)) {
            $className = (string) $name;
        } elseif (strpos($name, ':') !== false) {
            list($prefix, $className) = explode(':', $name, 2);

            if (!isset($this->namespaces[$prefix])) {
                throw new MappingException(sprintf('Undefined namespace prefix "%s"', $prefix));
            }

            $className = $this->namespaces[$prefix].$className;
        } else {
            $className = 'DMS\\Filter\\Rules\\'.$name;
        }

        if (!class_exists($className)) {
            throw new MappingException(sprintf("Rule class '%s' does not exist", $className));
        }

        if ($className instanceof Rule) {
            throw new MappingException(sprintf("class '%s' is not a rule", $className));
        }

        return new $className($options);
    }
}
