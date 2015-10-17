$router = new Phalcon\Mvc\Router();

$router->removeExtraSlashes(true);

$router->setDefaults(array(
'namespace'  => 'Modules\Backend\Controllers',
'module'     => 'backend',
'controller' => 'index',
'action' => 'index'
));

$aDefaults = array(
'namespace'  => 'Modules\Backend\Controllers',
'module'     => 'backend',
'controller' => 'index',
'action'     => 'index',
);

$aDefaultAction = array(
'namespace'  => 'Modules\Backend\Controllers',
'module'     => 'backend',
'controller' => 1,
'action'     => 'index',
);

$aControllerAction = array(
'namespace'  => 'Modules\Backend\Controllers',
'module'     => 'backend',
'controller' => 1,
'action'     => 2,
);


$router->add('/admin/', $aDefaults);



$router->add('/admin/:controller', $aDefaultAction);



$router->add('/admin/:controller/:action', $aControllerAction);




$router->add('/admin/:controller/:action/:params', array(
'namespace'  => 'Modules\Backend\Controllers',
'module'     => 'backend',
'controller' => 1,
'action'     => 2,
'params'     => 3
));

return $router;