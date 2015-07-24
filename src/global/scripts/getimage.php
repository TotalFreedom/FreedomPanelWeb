<?php
require_once('../global.php');


if (!isset($_GET['data'])) {
  $dataPiece = [
    'success' => FALSE,
    'error_info' => 'NoDataRequested'
  ];
  echo json_encode($dataPiece);
  die();
}

switch ($_GET['data']) {
  case "map":
  if (!isset($_GET['name'])) {
    $dataPiece = [
      'success' => FALSE,
      'error_info' => 'NoNameProvided'
    ];
    echo json_encode($dataPiece);
    die();
  }
  header('Content-type: image/png');
  echo $panel->getMapImage($_GET['name']);
  break;
  default:
    $dataPiece = [
      'success' => FALSE,
      'error_info' => 'InvalidDataRequested'
    ];
    echo json_encode($dataPiece);
    break;
}

 ?>
