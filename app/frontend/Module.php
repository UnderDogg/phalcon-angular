<?php

namespace Modules\Frontend;


use Bitfalls\Phalcon\ModuleConfig;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql as MySQLAdapter;

/*
 *  This Module file will set up the specific namespaces for this module
 *  It extends ModulesAbstract with itself extends a ModulesTrait (new since PHP 5.4)
 *  The ModulesTrait will register a view Service (very important!) and hooks itself
 *  into the dispatcher service, to handle non-existent paths (projects/index/dontknowwhere should be handled!)
 *  Eventually it will set up specific routes for this module through a routes file
 **/
class Module extends ModuleConfig
{
  protected $controller_namespace = 'Modules\\Frontend\\Controllers';
  protected $module_full_path = __DIR__;
    /**
     * @param \Phalcon\DiInterface $di
     */
    public function registerServices(DiInterface $di) {
        parent::registerServices($di);
        $view = $di->get('view');
        $view->setVar('bLoadModuleMenu', false);
        $di->set('view', $view);
    } /* registerServices */
}