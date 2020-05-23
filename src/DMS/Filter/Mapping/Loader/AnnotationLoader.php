<?php
declare(strict_types=1);

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Mapping\ClassMetadataInterface;
use DMS\Filter\Rules;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use ReflectionProperty;

/**
 * Loader that reads filtering data from Annotations
 */
class AnnotationLoader implements LoaderInterface
{
    protected Reader $reader;

    /**
     * Constructor
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
     * @return bool|void
     */
    public function loadClassMetadata(ClassMetadataInterface $metadata): bool
    {
        $reflClass = $metadata->getReflectionClass();

        //Iterate over properties to get annotations
        foreach ($reflClass->getProperties() as $property) {
            $this->readProperty($property, $metadata);
        }

        return true;
    }

    /**
     * Reads annotations for a selected property in the class
     */
    private function readProperty(ReflectionProperty $property, ClassMetadataInterface $metadata): void
    {
        // Skip if this property is not from this class
        if (
            $property->getDeclaringClass()->getName()
            !== $metadata->getClassName()
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
