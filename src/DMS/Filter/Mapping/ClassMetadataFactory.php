<?php

namespace DMS\Filter\Mapping;

use Doctrine\Common\Cache\Cache;

/**
 * Responsible for loading metadata for selected classes
 *
 * @package DMS
 * @subpackage Filter
 */
class ClassMetadataFactory implements ClassMetadataFactoryInterface
{
    /**
     * @var Loader\LoaderInterface
     */
    protected Loader\LoaderInterface $loader;

    /**
     * @var Cache
     */
    protected ?Cache $cache;

    /**
     * @var array
     */
    protected array $parsedClasses = [];

    /**
     * Constructor
     * Receives a Loader and a Doctrine Compatible cache instance
     *
     * @param Loader\LoaderInterface $loader
     * @param Cache $cache
     */
    public function __construct(Loader\LoaderInterface $loader, Cache $cache = null)
    {
        $this->loader = $loader;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassMetadata($class): ClassMetadataInterface
    {
        $class = ltrim($class, '\\');

        //Already parsed
        if ($this->isParsed($class)) {
            return $this->getParsedClass($class);
        }

        //Check Cache for it
        if ($this->cache !== null && $this->cache->contains($class)) {
            $this->setParsedClass($class, $this->cache->fetch($class));
            return $this->getParsedClass($class);
        }

        //Parse unloaded and uncached class
        return $this->parseClassMetadata($class);
    }

    /**
     * Reads class metadata for a new and unparsed class
     *
     * @param string $class
     * @return ClassMetadataInterface
     */
    private function parseClassMetadata($class)
    {
        $metadata = new ClassMetadata($class);

        //Load up parent and interfaces
        $this->loadParentMetadata($metadata);
        $this->loadInterfaceMetadata($metadata);

        //Load Annotations from Reader
        $this->loader->loadClassMetadata($metadata);

        //Store internally
        $this->setParsedClass($class, $metadata);

        if ($this->cache !== null) {
            $this->cache->save($class, $metadata);
        }

        return $metadata;
    }

    /**
     * Checks if a class has already been parsed
     *
     * @param string $class
     * @return boolean
     */
    private function isParsed($class): bool
    {
        return isset($this->parsedClasses[$class]);
    }

    /**
     * Retrieves data from a class already parsed
     *
     * @param string $class
     * @return ClassMetadataInterface
     */
    private function getParsedClass($class): ?ClassMetadataInterface
    {
        if (! $this->isParsed($class)) {
            return null;
        }

        return $this->parsedClasses[$class];
    }

    /**
     * Stores data from a parsed class
     *
     * @param string $class
     * @param ClassMetadataInterface $metadata
     */
    private function setParsedClass($class, ClassMetadataInterface $metadata): void
    {
        $this->parsedClasses[$class] = $metadata;
    }

    /**
     * Checks if the class being parsed has a parent and cascades parsing
     * to its parent
     *
     * @param ClassMetadataInterface $metadata
     */
    protected function loadParentMetadata(ClassMetadataInterface $metadata): void
    {
        $parent = $metadata->getReflectionClass()->getParentClass();

        if ($parent) {
            $metadata->mergeRules($this->getClassMetadata($parent->getName()));
        }
    }

    /**
     * Checks if the object has interfaces and cascades parsing of annotatiosn
     * to all the interfaces
     *
     * @param ClassMetadataInterface $metadata
     */
    protected function loadInterfaceMetadata(ClassMetadataInterface $metadata): void
    {
        foreach ($metadata->getReflectionClass()->getInterfaces() as $interface) {
            $metadata->mergeRules($this->getClassMetadata($interface->getName()));
        }
    }
}
