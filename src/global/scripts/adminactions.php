<?php
sleep(3);
require_once('../global.php');
header('Content-type: application/json');
// Check an action is given.
if(!isset($_GET['action'])) {
  $response = $panel->generateError('42');
  echo json_encode($response);
}

if (!$users->userHasPermission('access_admin')) {
  $response = $panel->generateError('11');
  echo json_encode($response);
  die();
}


switch($_GET['action']) {
  case 'add_user':
      // Required variables in $_POST array 'username', 'password', 'role'
      if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
          $users->createUser($_POST['username'], $_POST['password'], $_POST['role']);
          $response = ['success' => 'true'];

      } else {
        $response = $panel->generateError('42');
      }
      break;
  case 'delete_user':
      // Required variables in $_POST array 'username'
      if (isset($_POST['username'])) {
        $users->deleteUser($_POST['username']);
        $users->invalidateLoginToken($_POST['username'], '*');
        $response = ['success' => 'true'];
      } else {
        $response = $panel->generateError('42');
      }
      break;
  case 'change_user_password':
    // Required variables in $_POST array 'username', 'password'
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $users->changePassword($_POST['username'], $_POST['password']);
      $users->invalidateLoginToken($_POST['username'], '*');
      $response = ['success' => 'true'];
    } else {
        $response = $panel->generateError('42');
    }
      break;
  case 'change_user_role':
      // Required variables in $_POST array 'username', 'role'
      if (isset($_POST['username']) && isset($_POST['role'])) {
        $users->changeRole($_POST['username'], $_POST['role']);
        $response = ['success' => 'true'];
      } else {
        $response = $panel->generateError('42');
      }
      break;
  default:
    $response = $panel->generateError('42');
}


echo json_encode($response);

?>
