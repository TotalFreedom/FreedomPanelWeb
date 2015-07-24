<?php
class panel extends users {

  public $_pageContent;
  public $config;

  public function __construct($config) {
    $this->config = $config;
    $this->newConnection(SQL_SERVER, SQL_USERNAME, SQL_PASSWORD, SQL_DATABASE);
  }

  public function init() {
    $this->_pageContent = file_get_contents('pages/pageparts/template.html');
  }

  public function pageContent() {
    return $this->_pageContent;
  }

  public function displayContent() {
    echo $this->pageContent();
  }

  public function generateBasePage() {
    $this->_pageContent = str_replace('<[PAGE_LARGE_TITLE]>', $this->config['panel_title_long'], $this->_pageContent);
    $this->_pageContent = str_replace('<[PAGE_SMALL_TITLE]>', $this->config['panel_title_short'], $this->_pageContent);
    $this->_pageContent = str_replace('<[SUBTEXT]>', $this->config['subtext'], $this->_pageContent);
    $this->_pageContent = str_replace('<[COPYRIGHT_TEXT]>', $this->config['copyright_text'], $this->_pageContent);
  }

  public function generateUserInformation($user) {
    $this->_pageContent = str_replace('<[USERNAME]>', $user['username'], $this->_pageContent);
    $this->_pageContent = str_replace('<[SKIN_HEAD_URL]>', 'global/scripts/minecraft/face.php?u=' . $user['username'], $this->_pageContent);
    $this->_pageContent = str_replace('<[RANK]>', $user['human_role_name'], $this->_pageContent);
  }

  public function setupColourScheme() {
    if (!isset($_COOKIE['colour_scheme'])) {
      $colour_scheme = $this->config['default_colour_scheme'];
    } else {
      $colour_scheme = $_COOKIE['colour_scheme'];
    }
    $this->_pageContent = str_replace('<[COLOUR_SCHEME]>', $colour_scheme, $this->_pageContent);
  }

  public function setPageTitle($title) {
    $this->_pageContent = str_replace('<[PAGE_TITLE]>', $this->config['page_title'] . ' ' . $title, $this->_pageContent);
  }
  public function setPageHeader($header) {
    $this->_pageContent = str_replace('<[PAGE_HEADER]>', $header, $this->_pageContent);
  }
  public function setPageDescription($description) {
    $this->_pageContent = str_replace('<[PAGE_DESCRIPTION]>', $description, $this->_pageContent);
  }
  public function setPageContent($content) {
    $this->_pageContent = str_replace('<[PAGE_CONTENT]>', $content, $this->_pageContent);
  }
  public function setNavBar($navbar) {
    $this->_pageContent = str_replace('<[NAVBAR]>', $navbar, $this->_pageContent);
  }

  public function generateNavBar() {
    $layout = '<li><a href="{href}"><i class="fa fa-{icon}"></i> <span>{name}</span></a></li>';
    $navbarDB = $this->query_getNavbarList();
    // Create an array of each Navbar value, it's URL and it's icon
    $navbarValues = [];
    $navbar = '';
    foreach ($navbarDB as &$value) {
      if ($this->userHasPermission($value['permission_name'])) {
        $navbarValues[$value['name']] = [
          'name' => $value['name'],
          'href' => $value['href'],
          'icon' => $value['icon'],
          'permission' => $value['permission_name']
        ];

        $navbarTmp = '';


        $navbarTmp = str_replace('{name}', $navbarValues[$value['name']]['name'], $layout);
        $navbarTmp = str_replace('{icon}', $navbarValues[$value['name']]['icon'], $navbarTmp);
        $navbar .= str_replace('{href}', $navbarValues[$value['name']]['href'], $navbarTmp);
      }

    }
    $this->setNavBar($navbar);

  }

  public function addToCache($name, $data, $validLength) {
    $options = [
      'name' => $name,
      'data' => base64_encode($data),
      'validUntil' => time() + $validLength
    ];

    $this->query_addToCache($options);

  }

  public function retrieveFromCache($name) {
    $options = [
      'name' => $name
    ];

    $dataRAW = $this->query_retrieveFromCache($options);
    $data = base64_decode($dataRAW[0]['data']);
    return $data;
  }

  public function checkCacheValidity($name) {
    // Will check if an item is in the cache, and if the cache is still valid

    $options = [
      'name' => $name
    ];
    $cacheTimesRaw = $this->query_getCacheTimes($options);

    if (!isset($cacheTimesRaw[0]['valid_until'])) {
      return false;
    }

    // Check if current time is less than valid until
    if ($cacheTimesRaw[0]['valid_until'] <= time()) {
      return false;
    } else {
      return true;
    }

  }

  public function getLogs() {
    // For now this will just retrieve them from a DB Cache - this will need to interface with the backend

    if ($this->checkCacheValidity('log_data')) {
      $data = $this->retrieveFromCache('log_data');
    } else {
      //$data = $this->backend_downloadLatestLog(); ENABLE THIS WHEN THE BACKEND HAS BEEN WRITTEN
    }

    return $data;
  }

  public function getMaps($name) {
    $options = [
      'name' => $name
    ];
    $maps = [];
    $mapsRaw = $this->query_getMaps($options);
    foreach ($mapsRaw as &$value) {
      $maps[$value['name']] = [
        'id' => $value['id'],
        'name' => $value['name'],
        'filename' => $value['filename'],
      ];
    }
    return $maps;
  }

  public function getMapImage($name) {

    $options = [
      'name' => $name
    ];

    $imageRaw = $this->query_getMapImage($options);
    $image = base64_decode($imageRaw[0]['image']);
    return $image;


  }

  public function listRanks() {
    $options = [
      'role_id' => '*'
    ];
    $rolesRaw = $this->query_getRoleName($options);
    $roles = [];
    foreach($rolesRaw as &$value) {
      $roles[$value['role_name']] = $value;
    }

    return $roles;
  }

}

?>
