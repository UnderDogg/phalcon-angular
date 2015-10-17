<?php

error_reporting(E_ALL ^ E_NOTICE);
defined('PHALCONDEBUG') || define('PHALCONDEBUG', true);

try {

	define('APP_PATH', realpath('..') . '/');
  /**
   * Define some useful constants
   */
  define('BASE_DIR', str_replace('\\', '/', dirname(__DIR__)));
  define('APP_DIR', BASE_DIR . '/app');

  /**
   * Read the configuration
   */
  $config = include APP_DIR . '/config/config.php';

  /**
   * Read auto-loader
   */
  include APP_DIR . '/config/loader.php';

  /**
   * Read services
   */
  include APP_DIR . '/config/services.php';

  /**
   * Handle the request
   */
  $application = new \Phalcon\Mvc\Application($di);
  set_exception_handler('\Bitfalls\Exceptions\Handler::handle');

  // register modules
  include APP_DIR . '/config/modules.php';

  echo $application->handle()->getContent();

} catch (PDOException $e) {

  echo "<!DOCTYPE html>\n<html>\n<head>\n";
  echo "<link href='/css/bootstrap.min.css' media='screen' rel='stylesheet' type='text/css' />\n";
  echo "</head>\n";
  echo "<body>\n";
  echo "<div class='jumbotron'>\n";
  echo "<h2>PhalconPDO Exception" . $e->getMessage() . "</h2><br />";
  echo "<strong>TraceAsString:</strong><br />\n";
  echo nl2br(htmlentities($e->getTraceAsString()));
  echo "
    </div>\n\n";
  echo "</body>\n</html>";
  exit;
} catch (Phalcon\Exception $e) {

  if (preg_match("/Module (.*) isn't registered/ius", $e->getMessage()) == 1) {
    // caught module is not registered error!
    // @todo [phalconbegins][multi modules] find the way to use error controller.
    header('HTTP/1.0 404 Not Found');
    echo "<!DOCTYPE html>\n<html>\n<head>\n";
    echo "<link href='/css/bootstrap.css' media='screen' rel='stylesheet' type='text/css' />\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "<div class='jumbotron'>\n";
    // another error!
    echo "<h1>Module (.*) isn't registered</h1>";
    echo "<h2>" . get_class($e), ": ", $e->getMessage(), "</h2><br />\n";
    //echo " File=", $e->getFile(), "<br />\n";
    //echo " Line=", $e->getLine(), "<br />\n";
    echo "<strong>TraceAsString:</strong><br />\n";
    echo nl2br(htmlentities($e->getTraceAsString()));
    echo "
    </div>\n\n";
    echo "</body>\n</html>";
    exit;
  } else {
    echo "<!DOCTYPE html>\n<html>\n<head>\n";
    echo "<link href='/css/bootstrap.css' media='screen' rel='stylesheet' type='text/css' />\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "<div class='jumbotron'>\n";
    echo "<h1>Hellloooow Custom error handler please</h1>";
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
    echo "
    </div>\n\n";
    echo "</body>\n</html>";
  }
}
