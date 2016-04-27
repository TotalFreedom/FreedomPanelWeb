<?php
require_once('classes/config.class.php');
require_once('classes/core.class.php');
require_once('classes/db.class.php');
require_once('classes/users.class.php');

// Initial Config Setup
$config = new Config();
require_once('config.php');

$core = new Core();

$db = new Db; // DB Using https://github.com/indieteq/indieteq-php-my-sql-pdo-database-class

$users = new Users();



 ?>
