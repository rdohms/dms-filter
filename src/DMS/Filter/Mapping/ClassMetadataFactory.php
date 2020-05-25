<?php
declare(strict_types=1);

namespace DMS\Filter\Mapping;

use Doctrine\Common\Cache\Cache;

use function ltrim;

/**
 * Responsible for loading metadata for selected classes
 */
class ClassMetadataFactory implements ClassMetadataFactoryInterface
{
    protected Loader\LoaderInterface $loader;

    protected ?Cache $cache;

    /** @var string[] */
    protected array $parsedClasses = [];

    /**
     * Constructor
     * Receives a Loader and a Doctrine Compatible cache instance
     */
    public function __construct(Loader\LoaderInterface $loader, ?Cache $cache = null)
    {
        $this->loader = $loader;
        $this->cache  = $cache;
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
     */
    private function parseClassMetadata(string $class): ClassMetadataInterface
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
     */
    private function isParsed(string $class): bool
    {
        return isset($this->parsedClasses[$class]);
    }

    /**
     * Retrieves data from a class already parsed
     */
    private function getParsedClass(string $class): ?ClassMetadataInterface
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
     * Checks if the object has interfaces and cascades parsing of annotatiosn
     * to all the interfaces
     */
    protected function loadInterfaceMetadata(ClassMetadataInterface $metadata): void
    {
        foreach ($metadata->getReflectionClass()->getInterfaces() as $interface) {
            $metadata->mergeRules($this->getClassMetadata($interface->getName()));
        }
    }
}
