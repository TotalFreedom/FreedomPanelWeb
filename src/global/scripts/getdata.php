<?php

// This script will return a JSON output of whatever data the client is requesting, it will also check whether or not the client is authorised to access the data

require_once('../global.php');


if (!isset($_GET['data'])) {
  $dataPiece = [
    'success' => FALSE,
    'error_info' => 'NoDataRequested'
  ];
} else {
  switch ($_GET['data']) {
    case "logs":
      // Check if user has permission to access this
      if ($users->userHasPermission('access_logs')) {
        $dataPiece = [
          'success' => TRUE,
          'data' => [
            'name' => 'logs',
            'value' => $panel->getLogs()
            ]
        ];
      } else {
        $dataPiece = [
          'success' => FALSE,
          'error_info' => 'NoPermission'
        ];
      }
      break;
    default:
      $dataPiece = [
        'success' => FALSE,
        'error_info' => 'InvalidDataRequested'
      ];
      break;
  }
}

echo json_encode($dataPiece);

?>
