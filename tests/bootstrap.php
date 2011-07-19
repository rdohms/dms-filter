<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;

define('ROOT_DIR', __DIR__ . '/..');
define('VENDOR_DIR', __DIR__ . '/../vendors');

require VENDOR_DIR . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

//Add autoloader
$loader = new UniversalClassLoader();

$loader->registerNamespaces(array(
    'Symfony\Component' => 
            array(VENDOR_DIR . '/Symfony', 
                  VENDOR_DIR . '/doctrine2/lib/vendor/Symfony'),
    'Doctrine' => array(VENDOR_DIR . '/doctrine-common/lib'),
    'DMS' => array(ROOT_DIR . '/src', ROOT_DIR . 'tests'),
    'Tests' => ROOT_DIR . '/tests',
));


$loader->register();