<?php
require_once('global.php');
header('Content-type: application/json');
if (isset($_GET['api_key'])) {
  if ($config['enabled_api'] != 'true') {
    echo json_encode($panel->generateError('62'));
    die();
  }
  $authtype = 'key';
  $options = [
    'api_key' => $_GET['api_key']
  ];

    $usernameDB = $sql->query_getUserFromAPIKey($options);
    if ($usernameDB) {
      $username = $usernameDB[0]['username'];
      $users->login($username, false, false);
      $userinfo = $users->retrieveUserInfo($username, true);
    } else {
      echo json_encode($panel->generateError('14'));
      die();
    }



} else {
  if (!$users->isLoggedIn()) {
    echo json_encode($panel->generateError('11'));
    die();
  }
}

if (!$users->isLoggedIn()) {
  echo json_encode($panel->generateError('11'));
  die();
}


if (!isset($_GET['api_action'])) {
  echo json_encode($panel->generateError('42'));
  die();
} else {
  $api_action = $_GET['api_action'];
}


switch ($api_action) {
  case 'start':
    // Start the server
    $response = true; // TRUE or FALSE
    break;

  case 'stop':
    // Stop the server
    $response = true; // TRUE or FALSE
    break;

  case 'restart':
    // Restart the server
    $response = true; // TRUE or FALSE
    break;

  case 'cmd':
    // Send a command to the server
    $response = true; // TRUE or False
    break;

  case 'status':
    // Return the server status in a JSON array
    $response = true; //JSON array OR false
    break;

  case 'logs':
    //
    $response = true; // JSON array of logs
    break;

  case 'listmaps':
    //
    $response = true; // JSON array of maps, and related information about maps
    break;

  case 'resetmap':
    //
    $response = true; // TRUE or FALSE
    break;

  case 'online_players':
    //
    $response = true; // FALSE or JSON array of online players, UUID and Ranks
    break;

  case 'online_admins':
    //
    $response = true; // FALSE or JSON array of Online Admins, UUID and Ranks
    break;
  case 'list_admins':
    //
    $response = true; // FALSE or JSON array of Admins, UUID's and Ranks
    break;

  default:
    echo json_encode($panel->generateError('42'));
    die();
    break;
}


if ($authtype = 'key') {
  session_destroy();
}
 ?>
