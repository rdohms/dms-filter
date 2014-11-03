<?php

namespace DMS\Filter\Mapping\Loader;

/**
 * Loads multiple yaml mapping files
 *
 * @author Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * @see DMS\Filter\Mapping\Loader\FilesLoader
 */
class YamlFilesLoader extends FilesLoader
{
    /**
     * {@inheritdoc}
     */
    public function getFileLoaderInstance($file)
    {
        return new YamlFileLoader($file);
    }
}
