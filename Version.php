<?php

namespace DMS\Filter;

/**
 * Holds version information for the Filter package
 * 
 * @package DMS
 * @subpackage Filter
 */
class Version
{
    const VERSION = "0.1-DEV";
    
    /**
     * Compares a version with the current one.
     *
     * @param string $version Version to compare.
     * @return int Returns -1 if older, 0 if it is the same, 1 if version 
     *             passed as argument is newer.
     */
    public static function compare($version)
    {
        $currentVersion = str_replace(' ', '', strtolower(self::VERSION));
        $version = str_replace(' ', '', $version);

        return version_compare($version, $currentVersion);
    }
}
