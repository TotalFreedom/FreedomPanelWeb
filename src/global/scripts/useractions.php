<?php
require_once('../global.php');

// Check which are here
if(!isset($_GET['action'])) { die(); }

if ($_GET['action'] == 'logout') {
  $users->logOut();
}

if ($_GET['action'] == 'login') {

  if (isset($_POST['remember'])) {
    if ($_POST['remember'] == 'on') {
      $remember = true;
    } else {
      $remember = false;
    }
  } else {
    $remember = false;
  }

  if (isset($_POST['username'])) {
    $username = $_POST['username'];
  } else {
    $username = false;
  }

  if (isset($_POST['password'])) {
    $password = $_POST['password'];
  } else {
    $password = false;
  }

  if (!$password OR !$username) {
    header('Location: ../../pages/login.php?incorrect=true');
    echo 'Username or password not supplied';
    die();
  }

  // Check the password

  $passwordCheckResult = $users->checkPassword($username, $password);
  if ($passwordCheckResult === TRUE) {
    $users->login($username, $remember);
  } else {
    header('Location: ../../pages/login.php?incorrect=true');
    echo 'Username or password incorrect';
    die();
  }

}
?>
