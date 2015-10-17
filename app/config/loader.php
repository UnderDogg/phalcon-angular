<?php

include_once '../vendor/autoload.php';

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$loader->registerDirs(
  array(
    $config->application->controllersDir,
    $config->application->modelsDir,
    $config->application->libraryDir,
    $config->application->pluginsDir,
    $config->application->logDir,
  )
)->register(); /* End Registering Directories */

/**
 * register namespaces
 */
$loader->registerNamespaces(
  array(
    'Modules\Frontend\Controllers' => $config->application->controllersDir,
    'Modules\Backend\Controllers'    => '../app/backend/controllers/',
    'Libraries'            => $config->application->libraryDir,
    'Modules\Models'      => '../models/'
  )
)->register(); /* End Registering Namespaces */

/*
    'Modules\Frontend\Controllers' => '../app/frontend/controllers/',
    'Modules\Frontend\Models'      => '../app/frontend/models/',
    'Modules\Backend\Controllers'    => '../app/admin/controllers/',
    'Modules\Backend\Models'         => '../app/admin/models/',
 **/