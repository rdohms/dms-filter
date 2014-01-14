<?php

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Mapping\ClassMetadataInterface;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use DMS\Filter\Rules;
use DMS\Filter\Mapping;
use ReflectionProperty;

/**
 * Loader that reads filtering data from Annotations
 *
 * @package DMS
 * @subpackage Filter
 */
class AnnotationLoader implements LoaderInterface
{
    /**
     *
     * @var Reader
     */
    protected $reader;

    /**
     * Constructor
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;

        //Register Filter Rules Annotation Namespace
        AnnotationRegistry::registerAutoloadNamespace('DMS\Filter\Rules', __DIR__ . '/../../../../');

    }

    /**
     * Loads annotations data present in the class, using a Doctrine
     * annotation reader
     *
     * @param ClassMetadataInterface $metadata
     * @return bool|void
     */
    public function loadClassMetadata(ClassMetadataInterface $metadata)
    {

        $reflClass = $metadata->getReflectionClass();

        //Iterate over properties to get annotations
        foreach ($reflClass->getProperties() as $property) {

            $this->readProperty($property, $metadata);

        }

    }

    /**
     * Reads annotations for a selected property in the class
     *
     * @param ReflectionProperty $property
     * @param ClassMetadataInterface $metadata
     */
    private function readProperty(ReflectionProperty $property, ClassMetadataInterface $metadata)
    {
        // Skip if this property is not from this class
        if ($property->getDeclaringClass()->getName()
            != $metadata->getClassName()
        ) {
            return;
        }

        //Iterate over all annotations
        foreach ($this->reader->getPropertyAnnotations($property) as $rule) {

            //Skip is its not a rule
            if (! $rule instanceof Rules\Rule) {
                continue;
            }

            //Add Rule
            $metadata->addPropertyRule($property->getName(), $rule);

        }

    }

}
