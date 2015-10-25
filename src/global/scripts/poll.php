<?php
require_once('../global.php');
header('Content-type: application/json');
// And here we have the file that the client will poll periodically.

// Possible actions (each to be added in the GET request as &var=true)
// The response will only exist within the JSON IF the user has permission. This script will error silently.
//E.G. http://192.168.0.99/global/scripts/poll.php?power_status=true&server_information=true&online_players=true&online_admins=true&100_log_lines=true
/*
power_status
server_information
online_players
online_admins
player_numbers
10_log_lines
50_log_lines
100_log_lines
1000_log_lines
10000_log_lines
session_info
*/


// Create array
$pollingResponse = [];
$pollingResponse['status'] = true;
$pollingResponse['panel_info'] = [
  'host' => $config['root_dir_url'],
  'time' => time(),
  'signature' => $_SERVER['SERVER_SOFTWARE']
];

if ($users->userHasPermission('access_status') && isset($_GET['power_status']) && $_GET['power_status'] == TRUE) {

  $pollingResponse['power_status'] = [
    'is_on' => TRUE,
    'ping' => '27'
  ];

}

if ($users->userHasPermission('can_login') && isset($_GET['server_information']) && $_GET['server_information'] == TRUE) {
  $pollingResponse['server_information'] = [
    'server_host' => '64.34.190.101',
    'server_port' => '25565'
  ];
}

if ($users->userHasPermission('access_status') && isset($_GET['online_players']) && $_GET['online_players'] == TRUE) {
  $pollingResponse['online_players'] = [
    'currentplayers' => '10',
    'maxplayers' => '45',
    'players' => [
      'xxxxxxxx',
      'yyyyyyyy',
      'zzzzzzzz'
    ],
  ];
}

if ($users->userHasPermission('access_status') && isset($_GET['online_admins']) && $_GET['online_admins'] == TRUE) {
  $pollingResponse['online_admins'] = '';
}

if ($users->userHasPermission('access_logs') && isset($_GET['ten_log_lines']) && $_GET['ten_log_lines'] == TRUE) {
  $pollingResponse['ten_log_lines'] = '';
}

if ($users->userHasPermission('access_logs') && isset($_GET['fifty_log_lines']) && $_GET['fifty_log_lines'] == TRUE) {
  $pollingResponse['fifty_log_lines'] = 'LOGS';
}

if ($users->userHasPermission('access_logs') && isset($_GET['onehundred_log_lines']) && $_GET['onehundred_log_lines'] == TRUE) {
  $pollingResponse['onehundred_log_lines'] = '';
}

if ($users->userHasPermission('access_logs') && isset($_GET['onethousand_log_lines']) && $_GET['onethousand_log_lines'] == TRUE) {
  $pollingResponse['onethousand_log_lines'] = '';
}

if ($users->userHasPermission('access_logs') && isset($_GET['tenthousand_log_lines']) && $_GET['tenthousand_log_lines'] == TRUE) {
  $pollingResponse['tenthousand_log_lines'] = '';
}

if ($users->userHasPermission('can_login') && isset($_GET['session_info']) && $_GET['session_info'] == TRUE) {
  $pollingResponse['session_info'] = $_SESSION;
}
if ($users->userHasPermission('can_login') && isset($_GET['pending_actions']) && $_GET['pending_actions'] == TRUE) {
  $pollingResponse['pending_actions'] = [];
}

$response = json_encode($pollingResponse, JSON_PRETTY_PRINT);
echo $response;


?>
