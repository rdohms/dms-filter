<?php

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Exception\MappingException;
use DMS\Filter\Mapping\ClassMetadataInterface;
use DMS\Filter\Rules;
use DMS\Filter\Mapping;

/**
 * Loader that reads filtering data from XML
 *
 * @package DMS
 * @subpackage Filter
 */
class XmlFileLoader extends FileLoader
{
    /**
     * An array of SimpleXMLElement instances.
     *
     * @var \SimpleXMLElement[]
     */
    protected $classes = null;

    /**
     * Load a Class Metadata.
     *
     * @param ClassMetadataInterface $metadata A metadata
     *
     * @return Boolean
     * @throws MappingException
     */
    public function loadClassMetadata(ClassMetadataInterface $metadata)
    {
        if (null === $this->classes) {
            $this->classes = array();
            $xml = simplexml_load_file($this->file);

            foreach ($xml->class as $class) {
                $this->classes[(string) $class['name']] = $class;
            }
        }

        if (isset($this->classes[$metadata->getClassName()])) {
            $xml = $this->classes[$metadata->getClassName()];

            foreach ($xml->property as $property) {
                if (!$propertyName = (string) $property->attributes()->{'name'}) {
                    throw new MappingException('property must have a name attribute');
                }

                foreach($property->rule as $rule) {
                    $metadata->addPropertyRule($propertyName, $this->getRule($rule));
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @param \SimpleXMLElement $node
     * @return Rules\Rule
     * @throws MappingException
     */
    protected function getRule(\SimpleXMLElement $node)
    {
        if (!$name = (string) $node->attributes()->{'name'}) {
            throw new MappingException('rule must have a name attribute');
        }

        if (strpos($name, '\\') !== false) {
            $className = (string) $name;
        } else {
            $className = 'DMS\\Filter\Rules\\' . $name;
        }

        if (!class_exists($className)) {
            throw new MappingException(sprintf("Rule class '%s' does not exist", $className));
        }

        if ($className instanceof Rules\Rule) {
            throw new MappingException(sprintf("class '%s' is not a rule", $className));
        }

        $options = current($node->attributes()); // convert to array
        unset($options['name']);

        return new $className($options);
    }
}
