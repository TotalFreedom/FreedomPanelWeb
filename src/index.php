<?php
require_once('global/global.php');
$users->checkLoginStatus();
$panel->init();
$panel->generateBasePage();
$panel->generateUserInformation($users->userInfo());
$panel->setupColourScheme();
$panel->generateNavBar();


if (!isset($_GET['page'])) {
  $page = 'dashboard';
} else {
  $page = $_GET['page'];
}

switch ($page) {
    case "dashboard":
        require_once('pages/dashboard.php');
        break;
    case "maps":
        require_once('pages/maps.php');
        break;
    case "logs":
        require_once('pages/logs.php');
        break;
    case "console":
        require_once('pages/console.php');
        break;
    case "account":
        require_once('pages/accounts.php');
        break;
    case "admin":
        require_once('pages/admin.php');
        break;
    default:
        $panel->setPageTitle('ERROR');
        $panel->setPageHeader('An Error Occured');
        $panel->setPageDescription('While trying to load content');
        $panel->setPageContent('This often occurs when you attempt to view a page that doesn\'t exist - this page could be a 404 page if it really wanted to be, too bad it\'s not');
}

// And finally, display the page
$panel->displayContent();



?>
