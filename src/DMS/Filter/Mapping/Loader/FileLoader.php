<?php

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Exception\MappingException;

abstract class FileLoader implements LoaderInterface
{
    protected $file;

    /**
     * Constructor.
     *
     * @param string $file The mapping file to load
     *
     * @throws MappingException if the mapping file does not exist
     * @throws MappingException if the mapping file is not readable
     */
    public function __construct($file)
    {
        if (!is_file($file)) {
            throw new MappingException(sprintf('The mapping file %s does not exist', $file));
        }

        if (!is_readable($file)) {
            throw new MappingException(sprintf('The mapping file %s is not readable', $file));
        }

        $this->file = $file;
    }
}
