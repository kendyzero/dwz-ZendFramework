<?php
date_default_timezone_set('Etc/GMT-8');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../application/modules/models'),
    get_include_path(),
)));

include 'Zend/Loader.php';
@Zend_Loader::registerAutoload();

/** zend 注册器 */
$registry = Zend_Registry::getInstance();

/** load configuration */
$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
$registry->set('config', $config);

/** setup database */
$db = Zend_Db::factory($config->resources->db);
$registry->set('db', $db);

//$log = Zend_Log::factory();
//$registry->set('log', $log);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();

?>