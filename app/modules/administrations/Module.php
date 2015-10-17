<?php

namespace Modules\Administrations;

use Bitfalls\Phalcon\ModuleConfig;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Loader;

/*
 *  This Module file will set up the specific namespaces for this module
 *  It extends ModulesAbstract with itself extends a ModulesTrait (new since PHP 5.4)
 *  The ModulesTrait will register a view Service (very important!) and hooks itself
 *  into the dispatcher service, to handle non-existent paths (projects/index/dontknowwhere should be handled!)
 *  Eventually it will set up specific routes for this module through a routes file
 **/
class Module extends ModuleConfig
{
  protected $controller_namespace = 'Modules\\Administrations\\Controllers';
  protected $module_full_path = __DIR__;
  protected $sModuleName = 'administrations';

  /**
   * Register a specific autoloader for the module
   */
  public function registerAutoloaders(\Phalcon\DiInterface $di = null) {
    $loader = new Loader();

    $config = include APP_DIR . '/config/config.php';

    $loader->registerNamespaces(
      array(
        'Modules\Administrations\Controllers' => __DIR__ . '/controllers/',
        'Modules\Administrations\Models'      => __DIR__ . '/models/',
        'Modules\Administrations\Forms'       => __DIR__ . '/forms',
        'Modules\\Invoices\\Models'     => $config->application->modulesDir .'/invoices/models/',
        'Modules\\Products\\Models'     => $config->application->modulesDir .'/products/models/',
        'Vokuro\Controllers'            => APP_DIR . '/controllers/',
      )
    );
    $loader->register();
  } /* registerAutoloaders */

  /**
   * Register specific services for the module
   */
  public function registerServices(\Phalcon\DiInterface $di = null)
  {

    /** @var Dispatcher $dispatcher */
    $dispatcher = $di->get('dispatcher');
    //$sModuleName = explode(DIRECTORY_SEPARATOR, trim($this->getReflectionPath(), '/'));
    //$sModuleName = array_pop($sModuleName);
    //$dispatcher->setDefaultNamespace(ucfirst($sModuleName)."\Controllers\\");

    /*
            echo "for debug purposes : the dispatchernamespace is:<br />";
            echo "<pre>";
            print_r($dispatcher->getControllerName());
            echo "</pre>";
            echo "my current modulename is ".$sModuleName."<br />";
    */


    //$di->set('dispatcher', $dispatcher);

    //Registering the view component
    /** @var View $view */
    $view = $di->get('view');
    $path = $this->getReflectionPath();
    $view->setViewsDir($path . 'views/');
    //$view->setLayoutsDir('../../../views/layouts/');
    $view->setPartialsDir('../../../views/partials/');
    $view->setVar('moduleName', $this->sModuleName);
    $view->setVar('bLoadModuleMenu', true);
    $di->set('view', $view);
  }


}