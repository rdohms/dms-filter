<?php
declare(strict_types=1);

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Mapping\ClassMetadataInterface;
use DMS\Filter\Rules\Rule;
use ReflectionAttribute;
use ReflectionProperty;

class AttributeLoader implements LoaderInterface
{
    public function loadClassMetadata(ClassMetadataInterface $metadata): bool
    {
        foreach ($metadata->getReflectionClass()->getProperties() as $property) {
            $this->readProperty($property, $metadata);
        }

        return true;
    }
    
    private function readProperty(ReflectionProperty $property, ClassMetadataInterface $metadata): void
    {
        if ($property->getDeclaringClass()->getName() !== $metadata->getClassName()) {
            return;
        }

        foreach ($property->getAttributes(Rule::class, ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
            $metadata->addPropertyRule($property->getName(), $attribute->newInstance());
        }
    }
}
