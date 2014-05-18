<?php

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Exception\MappingException;
use DMS\Filter\Mapping\ClassMetadataInterface;
use Symfony\Component\Yaml\Parser as YamlParser;
use DMS\Filter\Rules;

class YamlFileLoader extends FileLoader
{
    private $yamlParser;

    /**
     * An array of YAML class descriptions
     *
     * @var array
     */
    protected $classes = null;

    /**
     * {@inheritdoc}
     */
    public function loadClassMetadata(ClassMetadataInterface $metadata)
    {
        if (null === $this->classes) {
            if (!stream_is_local($this->file)) {
                throw new \InvalidArgumentException(sprintf('This is not a local file "%s".', $this->file));
            }

            if (!file_exists($this->file)) {
                throw new \InvalidArgumentException(sprintf('File "%s" not found.', $this->file));
            }

            if (null === $this->yamlParser) {
                $this->yamlParser = new YamlParser();
            }

            $this->classes = $this->yamlParser->parse(file_get_contents($this->file));

            // empty file
            if (null === $this->classes) {
                return false;
            }

            // not an array
            if (!is_array($this->classes)) {
                throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', $this->file));
            }
        }

        if (isset($this->classes[$metadata->getClassName()])) {
            $yaml = $this->classes[$metadata->getClassName()];

            if (isset($yaml['properties']) && is_array($yaml['properties'])) {
                foreach ($yaml['properties'] as $property => $rules) {
                    if (null !== $rules) {
                        foreach ($this->getRules($rules) as $rule) {
                            $metadata->addPropertyRule($property, $rule);
                        }
                    }
                }
            }

            return true;
        }

        return false;
    }

    protected function getRules(array $nodes)
    {
        $rules = array();

        foreach($nodes as $name => $options) {
            if (strpos($name, '\\') !== false) {
                $className = (string) $name;
            } else {
                $className = 'DMS\\Filter\\Rules\\' . $name;
            }

            if (!class_exists($className)) {
                throw new MappingException(sprintf("Rule class '%s' does not exist", $className));
            }

            if ($className instanceof Rules\Rule) {
                throw new MappingException(sprintf("class '%s' is not a rule", $className));
            }

            $rules[] = new $className($options);
        }

        return $rules;
    }
}
