<?php

// This script will return a JSON output of whatever data the client is requesting, it will also check whether or not the client is authorised to access the data

require_once('../global.php');

if (!isset($_GET['data'])) {
  $dataPiece = $panel->generateError('41');
} else {
  switch ($_GET['data']) {
    case "logs":
      // Check if user has permission to access this
      if ($users->userHasPermission('access_logs')) {
        $dataPiece = $panel->getLogs();

      } else {
        $dataPiece = $panel->generateError('11');
      }
    break;
    case "testConnection":
      if ($users->userHasPermission("can_login")) {
        $dataPiece = [
          'success' => TRUE,
          'data' => [
            'time' => time(),
            'known_issues' => FALSE,
            'serverconnection' => TRUE
            ]
        ];
      } else {
        $dataPiece = $panel->generateError('11');
      }
    break;
    default:
      $dataPiece = $panel->generateError('41', ['RequestedData' => $_GET['data'], 'UserAgent' => $_SERVER['HTTP_USER_AGENT']]);
    break;
  }
}
header('Content-type: application/json');
echo json_encode($dataPiece);

?>
