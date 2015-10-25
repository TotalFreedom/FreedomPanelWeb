<?php
require_once('../global.php');

// Check an action is given.
if(!isset($_GET['action'])) {
echo json_encode($panel->generateError('42'));
die();
}

if (!$users->userHasPermission('access_admin')) {
  echo json_encode($panel->generateError('11'));
  die();
}


switch($_GET['action']) {
  case 'add_user':
      // Required variables in $_GET array 'username', 'password', 'role'
      if (isset($_GET['username']) && isset($_GET['password']) && isset($_GET['role'])) {
          $users->createUser($_GET['username'], $_GET['password'], $_GET['role']);
      } else {
        echo json_encode($panel->generateError('42'));
        die();
      }
      break;
  case 'delete_user':
      // Required variables in $_GET array 'username'
      if (isset($_GET['username'])) {
        $users->deleteUser($_GET['username']);
      } else {
        echo json_encode($panel->generateError('42'));
        die();
      }
      break;
  case 'change_user_password':
    // Required variables in $_GET array 'username', 'password'
    if (isset($_GET['username']) && isset($_GET['password'])) {
      $users->changePassword($_GET['username'], $_GET['password']);
      $users->invalidateLoginToken($_GET['username'], '*');
    } else {
      echo json_encode($panel->generateError('42'));
      die();
    }
      break;
  case 'change_user_role':
      // Required variables in $_GET array 'username', 'role'
      if (isset($_GET['username']) && isset($_GET['role'])) {
        $users->changeRole($_GET['username'], $_GET['role']);
      } else {
        echo json_encode($panel->generateError('42'));
        die();
      }
      break;
  default:
    echo json_encode($panel->generateError('42'));
    die();
}



?>
