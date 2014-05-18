<?php

namespace DMS\Filter\Mapping\Loader;

/**
 * Loads multiple xml mapping files
 *
 * @author Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * @see DMS\Filter\Mapping\Loader\FilesLoader
 */
class XmlFilesLoader extends FilesLoader
{
    /**
     * {@inheritdoc}
     */
    public function getFileLoaderInstance($file)
    {
        return new XmlFileLoader($file);
    }
}
