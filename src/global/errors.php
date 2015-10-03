<?php
/*
1 - 10 MySQL Errors
11-30 Permission Errors
31-40 Content Errors
41-50 Request errors
61-90 General errors
200-250 API or CURL errors
*/
$error_ids = [
  // MySQL Errors
  '1' => [
    'Summary' => 'Could not connect to MySQL database.',
    'Solution' => 'Contact the webmaster quoting error code 2.'
    ],
  '2' => [
    'Summary' => 'MySQL authentication failed.',
    'Solution' => 'Contact the webmaster quoting error code 2.'
    ],
  '3' => [
    'Summary' => 'MySQL permissions error.',
    'Solution' => 'Contact the webmaster quoting error code 3.'
  ],
  '4' => [
    'Summary' => 'Recieved data from database, data was not stored as expected.',
    'Solution' => 'Contact the webmaster quoting error code 3 - please state what you were attempting to do.'
  ],

  // Permission Errors

  '11' => [
    'Summary' => 'You do not have permission to perform this action.',
    'Solution' => 'You may not be the correct rank, if you believe you should be able to perform this action please contact an administrator.',
  ],
  '13' => [
    'Summary' => 'Account does not have permission to login',
    'Solution' => 'Please ensure that you are authorized access - if you have been denied in error please contact an adminstrator'
  ],
  '14' => [
    'Summary' => 'Account does not exist.',
    'Solution' => 'Please ensure you have an account, and are typing the account name correctly.'
    ],

  '15' => [
    'Summary' => 'Login Failed',
    'Solution' => 'Please ensure you have entered a valid account name.'
  ],

  // Content Errors

  '31' => [
    'Summary' => 'This content does not exist.',
    'Solution' => 'Please ensure you have typed the correct URL, and that the requested page should exist. If you believe this has been caused in error please contact the webmaster.'
    ],


  // Request Errors

  '41' => [
    'Summary' => 'Invalid Request.',
    'Solution' => 'Please ensure you have structured your request correctly.'
  ],
  '42' => [
    'Summary' => 'GET/POST Data missing or incorrect',
    'Solution' => 'Please ensure that you have included all neccessary data with your request.'
  ],
  '43' => [
    'Summary' => 'General request error.',
    'Solution' => 'Please ensure that you have sent the correct request. If you believe this is caused in error please contact the webmaster.'
  ],

  // General errors

  '61' => [
    'Summary' => 'A general error occured.',
    'Solution' => ''
  ],

  // CURL / API Errors

  '200' => [
    'Summary' => 'General API error',
    'Solution' => 'Please retry your action in one minute, if this does not work please contact an adminstrator.'
  ],
  '201' => [
    'Summary' => 'API connection timed out',
    'Solution' => 'The server may be down, please try again momentarily.'
  ],
  '202' => [
    'Summary' => 'Could not connect to API',
    'Solution' => 'The server may be down, please try again momentarily.'
  ],
  '210' => [
    'Summary' => 'API authentication failed',
    'Solution' => 'Please Contact the webmaster quoting error code 210.'
  ],
  '220' => [
    'Summary' => 'Did not recieve expected HTTP Status code (200) from the API',
    'Solution' => 'Please retry in a few minutes - if this does not work please contact a TFM Developer quoting "The API didnt return HTTP 200"'
  ],
  '221' => [
    'Summary' => 'API response was empty.',
    'Solution' => 'Please retry in a few minutes - if this does not work please contact a TFM Developer quoting "The API returned an empty response"'
  ],
  '222' => [
    'Summary' => 'API Status returned false.',
    'Solution' => 'Please retry your action in a few minutes (If you used the /command then the server may be down)'
  ],
  '223' => [
    'Summary' => 'This API action is disabled.',
    'Solution' => 'This action may have been temporarily disabled. If you believe it should be enabled or has been disabled in error please contact the webmaster.'
    ]
];

$json_error_ids = json_encode($error_ids, true);

DEFINE('ERROR_IDS', $json_error_ids);

?>
