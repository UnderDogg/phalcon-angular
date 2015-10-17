<?php

// @todo [phalconbegins][multi modules] register modules here.
/*
define('APP_PATH', realpath('..') . '/');
define('BASE_DIR', str_replace('\\', '/', dirname(__DIR__)));
define('APP_DIR', BASE_DIR . '/app');
*/
// register modules -------------------------------------------------------------------------

$application->registerModules(
  array(
    'frontend'      => array(
      'namespace' => 'Modules\Frontend',
      'className' => 'Modules\Frontend\Module',
      'path'      => APP_DIR . '/frontend/Module.php',
    ),
    'backend' => array(
      'namespace' => 'Modules\Backend',
      'className' => 'Modules\Backend\Module',
      'path'      => APP_DIR . '/backend/Module.php',
    ),
    'administrations' => array(
      'namespace' => 'Modules\Administrations',
      'className' => 'Modules\Administrations\Module',
      'path'      => APP_DIR . '/modules/administrations/Module.php',
    ),
  )
);  /* End register modules --------------------------------------------------------------------*/