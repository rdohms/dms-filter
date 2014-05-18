<?php

namespace DMS\Filter\Mapping\Loader;

/**
 * Creates mapping loaders for array of files.
 *
 * Abstract class, used by
 *
 * @author Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * @see DMS\Filter\Mapping\Loader\YamlFileLoader
 * @see DMS\Filter\Mapping\Loader\XmlFileLoader
 */
abstract class FilesLoader extends LoaderChain
{
    /**
     * Array of mapping files.
     *
     * @param array $paths Array of file paths
     */
    public function __construct(array $paths)
    {
        parent::__construct($this->getFileLoaders($paths));
    }

    /**
     * Array of mapping files.
     *
     * @param array $paths Array of file paths
     *
     * @return LoaderInterface[] Array of metadata loaders
     */
    protected function getFileLoaders($paths)
    {
        $loaders = array();
        foreach ($paths as $path) {
            $loaders[] = $this->getFileLoaderInstance($path);
        }

        return $loaders;
    }

    /**
     * Takes mapping file path.
     *
     * @param string $file
     *
     * @return LoaderInterface
     */
    abstract protected function getFileLoaderInstance($file);
}