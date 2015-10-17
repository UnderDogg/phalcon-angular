<?php

namespace Bitfalls\Phalcon;

use Phalcon\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

/**
 * Modules trait.<br><br>
 * Use this file to manage register services in one place.<br>
 * To use this trait, set your module like Phalcon Module.php but extend \Extend\ModulesAbstract<br>
 * Setup $controller_namespace property for Module class to your default controller namespace<br>
 * Set $module_full_path property to __DIR__ for easy to manage.<br>
 */

/**
 * This is an extensible Module configurator for Multi Module apps. Just extend and give it a namespace
 * equal to module name, and it should work.
 *
 * Class ModuleConfig
 */
class ModuleConfig implements ModuleDefinitionInterface
{

    /** @var string */
    protected $sReflectionPath = '';
    /** @var null */
    protected $mConfig = null;

    public function registerAutoloaders(\Phalcon\DiInterface $di = null)
    {
    }

    /**
     * Register specific services for the module
     */
    public function registerServices(\Phalcon\DiInterface $di = null)
    {

        /** @var Dispatcher $dispatcher */
        $dispatcher = $di->get('dispatcher');
        $sModuleName = explode(DIRECTORY_SEPARATOR, trim($this->getReflectionPath(), '/'));
        $sModuleName = array_pop($sModuleName);
        //$dispatcher->setDefaultNamespace(ucfirst($sModuleName)."\Controllers\\");

/*
        echo "for debug purposes : the dispatchernamespace is:<br />";
        echo "<pre>";
        print_r($dispatcher->getControllerName());
        echo "</pre>";
        echo "my current modulename is ".$sModuleName."<br />";
*/


        $di->set('dispatcher', $dispatcher);

        //Registering the view component
        /** @var View $view */
        $view = $di->get('view');
        $path = $this->getReflectionPath();
        $view->setViewsDir($path . 'views/');
        $view->setLayoutsDir('../../views/layouts/');
        $view->setPartialsDir('../../views/partials/');
        $view->setVar('moduleName', $sModuleName);
        $view->setVar('bLoadModuleMenu', true);
        $di->set('view', $view);
    }

    /**
     * @param null $sPath
     * @return mixed
     */
    public function getConfig($sPath = null)
    {
        if (!$this->mConfig) {
            if (!$sPath) {
                $sPath = $this->getReflectionPath() . '/config/config.php';
            }
            if (is_readable($sPath)) {
                $this->mConfig = include_once $sPath;
            }
        }
        return $this->mConfig;
    }

    /**
     * @return mixed|string
     */
    protected function getReflectionPath()
    {
        if (empty($this->sReflectionPath)) {
            $oReflectionClass = new \ReflectionClass($this);
            $this->sReflectionPath = str_replace('Module.php', '', $oReflectionClass->getFileName());
        }
        return $this->sReflectionPath;
    }
}