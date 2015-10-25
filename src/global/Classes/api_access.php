<?php
/*
This class exists primarily to facilitate communcation between the web UI and
the backend API.

This class handles authentication with the API, and processing of the
response from the API.

*/

class api extends panel {

  public $_config;

  public function __construct($config) {
      $this->_config = $config;
      $this->newConnection(SQL_SERVER, SQL_USERNAME, SQL_PASSWORD, SQL_DATABASE);
  }

  public function postToAPI($options) {
    /*
    $options expects
    'location' => E.G. list (will connect to $url/list)
    'data' => an array to include in the request

    This function will return an array contianing
    bool success TRUE/FALSE
    string response "JSON ENCODED API RESPONSE"
    */
    $output = false;

    $url = $options['location'];

    // This exists as a whitelist of commands that are to be allowed.
    // It can be used to temporarily disable access to an API command.
    $approvedLocations = [
      'list' => true,
      'start' => true,
      'stop' => true,
      'command' => true,
      'list' => true,
      'logs' => true,
      'logs_raw', false
    ];

    if (in_array($url, $approvedLocations) && $approvedLocations[$url] === true) {
      $url = $this->_config['backend_api_address'] . "/" . $options['location'];
    } else {
      return $this->generateError('223', ['action' => $url]);
    }

    $params = [
      'user' => $this->_config['backend_api_user'],
      'api_user' => $this->_config['backend_api_user'],
      'api_key' => $this->_config['backend_api_key'],
      'data' => json_encode($options['data'])
    ];

       $postData = '';
       foreach($params as $k => $v) {
          $postData .= $k . '='.$v.'&';
       }
       rtrim($postData, '&');

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, '1000');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch,CURLOPT_USERAGENT, "PHP/" . phpversion() . " / " . php_uname('s') ." " . php_uname('r') . " " . php_uname('m') . "(FreedomPanelWeb " . PANEL_VERSION .")");
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);
        $response = $this->checkResponseForErrors($response, curl_getinfo($ch), $ch);

          // On success
          /*$output = [
            'success' => TRUE,
            'response' => $response
          ];*/
          //var_dump($response);
          $output = json_decode($response, TRUE);


        curl_close($ch);
        return $output;
  }

  public function checkResponseForErrors($response, $curlInfo, $ch) {
    if ($response === false) {
      return json_encode($this->generateError('202', curl_getinfo($ch)));
    } else if ($curlInfo['http_code'] != '200') {
      return json_encode($this->generateError('220', curl_getinfo($ch)));
    } else if ($response == '') {
      return json_encode($this->generateError('221', curl_getinfo($ch)));
    }

    if (json_decode($response, TRUE)['status'] != TRUE) {
      return json_encode($this->generateError('222', curl_getinfo($ch)));
    }
    return $response;
  }

}

?>
