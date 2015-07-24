<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
// Load Config for SQL details
require_once('config.php');
set_include_path($includePath);
// Load Classes
require_once('global/Classes/MySQLi.php');
require_once('global/Classes/users.php');
require_once('global/Classes/panel.php');

// Instantiate Classes

$sql = new sqlInt();
$sql->newConnection(SQL_SERVER, SQL_USERNAME, SQL_PASSWORD, SQL_DATABASE);

// Get panel config
$config = $sql->executeQuery('SELECT * FROM config');
$configAssoc = $sql->getRows();

foreach ($configAssoc as &$value) {
  $config[$value['config_name']] = $value['config_val'];
}

$users = new users($config);
$panel = new panel($config);
//var_dump($_SESSION);


// Init User Info (This will update the _SESSION Global variable)
$users->userInfo()


?>
