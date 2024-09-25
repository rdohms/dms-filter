<?php

declare(strict_types=1);

namespace DMS\Filter\Mapping;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;

use function ltrim;

/**
 * Responsible for loading metadata for selected classes
 */
class ClassMetadataFactory implements ClassMetadataFactoryInterface
{
    /** @var string[] */
    protected array $parsedClasses = [];

    /**
     * Constructor
     * Receives a Loader and a Doctrine Compatible cache instance
     */
    public function __construct(protected Loader\LoaderInterface $loader, protected AdapterInterface|null $cache = null)
    {
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     */
    public function getClassMetadata($class): ClassMetadataInterface
    {
        $class = ltrim($class, '\\');

        //Already parsed
        if ($this->isParsed($class)) {
            return $this->getParsedClass($class);
        }

        //Check Cache for it
        if ($this->cache !== null && $this->cache->getItem($class)->isHit()) {
            $this->setParsedClass($class, $this->cache->getItem($class)->get());

            return $this->getParsedClass($class);
        }

        //Parse unloaded and uncached class
        return $this->parseClassMetadata($class);
    }

    /**
     * Reads class metadata for a new and unparsed class
     * @throws InvalidArgumentException
     */
    private function parseClassMetadata(string $class): ClassMetadataInterface
    {
        $metadata = new ClassMetadata($class);

        //Load up parent and interfaces
        $this->loadParentMetadata($metadata);
        $this->loadInterfaceMetadata($metadata);

        //Load Attributes from Reader
        $this->loader->loadClassMetadata($metadata);

        //Store internally
        $this->setParsedClass($class, $metadata);

        if ($this->cache !== null) {
            $cachedClass = $this->cache->getItem($class);
            $cachedClass->set($metadata);
            $this->cache->save($cachedClass);
        }

        return $metadata;
    }

    /**
     * Checks if a class has already been parsed
     */
    private function isParsed(string $class): bool
    {
        return isset($this->parsedClasses[$class]);
    }

    /**
     * Retrieves data from a class already parsed
     */
    private function getParsedClass(string $class): ClassMetadataInterface|null
    {
        if (! $this->isParsed($class)) {
            return null;
        }

        return $this->parsedClasses[$class];
    }

    /**
     * Stores data from a parsed class
     */
    private function setParsedClass(string $class, ClassMetadataInterface $metadata): void
    {
        $this->parsedClasses[$class] = $metadata;
    }

    /**
     * Checks if the class being parsed has a parent and cascades parsing
     * to its parent
     * @throws InvalidArgumentException
     */
    protected function loadParentMetadata(ClassMetadataInterface $metadata): void
    {
        $parent = $metadata->getReflectionClass()->getParentClass();

        if (! $parent) {
            return;
        }

        $metadata->mergeRules($this->getClassMetadata($parent->getName()));
    }

    /**
     * Checks if the object has interfaces and cascades parsing of attributes
     * to all the interfaces
     * @throws InvalidArgumentException
     */
    protected function loadInterfaceMetadata(ClassMetadataInterface $metadata): void
    {
        foreach ($metadata->getReflectionClass()->getInterfaces() as $interface) {
            $metadata->mergeRules($this->getClassMetadata($interface->getName()));
        }
    }
}
