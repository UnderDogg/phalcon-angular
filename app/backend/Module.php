<?php

namespace Modules\Backend;

use Bitfalls\Phalcon\ModuleConfig;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

class Module extends ModuleConfig
{
  protected $controller_namespace = 'Modules\\Companies\\Controllers';
  protected $module_full_path = __DIR__;

}