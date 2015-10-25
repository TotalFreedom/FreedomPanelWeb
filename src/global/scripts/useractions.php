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
    $panel->generateError('15', ['Username' => $username, 'User_Agent' => $_SERVER['HTTP_USER_AGENT']]);
    echo 'Username or password incorrect';
    die();
  }

}

if ($_GET['action'] == 'change_password') {
  header('Content-type: application/json');
  if (isset($_POST['current']) && isset($_POST['new_password']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $current = $_POST['current'];
    $password = $_POST['new_password'];
    if ($passwordCheckResult = $users->checkPassword($username, $current)) {
      $users->changePassword($username, $password);
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  } else {
    echo json_encode(['success' => true]);
  }
}

if ($_GET['action'] == 'generate_new_api_key') {
    header('Content-type: application/json');
    $users->generateAPIkey($_SESSION['username']);
    echo json_encode(['success' => true]);
}

?>
