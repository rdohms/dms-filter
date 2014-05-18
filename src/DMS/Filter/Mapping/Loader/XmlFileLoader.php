<?php

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Exception\MappingException;
use DMS\Filter\Mapping\ClassMetadataInterface;
use DMS\Filter\Rules;
use Symfony\Component\Config\Util\XmlUtils;

class XmlFileLoader extends FileLoader
{
    /**
     * An array of SimpleXMLElement instances.
     *
     * @var \SimpleXMLElement[]
     */
    protected $classes = null;

    /**
     * {@inheritdoc}
     */
    public function loadClassMetadata(ClassMetadataInterface $metadata)
    {
        if (null === $this->classes) {
            $this->classes = array();
            $xml = $this->parseFile($this->file);

            foreach ($xml->namespace as $namespace) {
                $this->addNamespaceAlias((string) $namespace['prefix'], trim((string) $namespace));
            }

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

                foreach($this->parseRules($property->rule) as $rule) {
                    $metadata->addPropertyRule($propertyName, $rule);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Parses a collection of "rules" XML nodes.
     *
     * @param \SimpleXMLElement $nodes The XML nodes
     *
     * @return array The Rule instances
     */
    protected function parseRules(\SimpleXMLElement $nodes)
    {
        $rules = array();

        foreach ($nodes as $node) {
            if (count($node) > 0) {
                if (count($node->option) > 0) {
                    $options = $this->parseOptions($node->option);
                } else {
                    $options = array();
                }
            } elseif (strlen((string) $node) > 0) {
                $options = trim($node);
            } else {
                $options = null;
            }

            $rules[] = $this->newRule((string) $node['name'], $options);
        }

        return $rules;
    }

    /**
     * Parses a collection of "option" XML nodes.
     *
     * @param \SimpleXMLElement $nodes The XML nodes
     *
     * @return array The options
     */
    protected function parseOptions(\SimpleXMLElement $nodes)
    {
        $options = array();

        foreach ($nodes as $node) {
            if (count($node) > 0) {
                if (count($node->option) > 0) {
                    $value = $this->parseOptions($node->option);
                } else {
                    $value = array();
                }
            } else {
                $value = XmlUtils::phpize($node);
                if (is_string($value)) {
                    $value = trim($value);
                }
            }

            $options[(string) $node['name']] = $value;
        }

        return $options;
    }

    /**
     * Parse a XML File.
     *
     * @param string $file Path of file
     *
     * @return \SimpleXMLElement
     *
     * @throws MappingException
     */
    protected function parseFile($file)
    {
        try {
            $dom = XmlUtils::loadFile($file);
        } catch (\Exception $e) {
            throw new MappingException($e->getMessage(), $e->getCode(), $e);
        }

        return simplexml_import_dom($dom);
    }
}
