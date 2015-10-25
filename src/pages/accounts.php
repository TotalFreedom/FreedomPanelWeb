<?php
$panel->setPageTitle('Account');
$panel->setPageHeader('Account');
$panel->setPageDescription($_SESSION['username']);
$api_key = $_SESSION['API_KEY'];
if (!$panel->userHasPermission('can_login')) {
  $panel->setPageContent('You do not have permission to access this content');
  return;
}


$content = <<<EOF

<div class="panel panel-default">
  <div class="panel-heading">Password</div>
  <div class="panel-body">
  <form class="form-horizontal">
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Current Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="currentPassword" placeholder="Current Password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">New Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="newPassword" placeholder="New Password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Confirm New Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="newPasswordConfirm" placeholder="Confirm New Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary" onclick='event.preventDefault(); changePassword();'>Change Password</button>
    </div>
  </div>
  <div id='passwordError' style='display: none' class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Error!</strong> An error occured while changing password: <span id='passwordErrorText'></span>
  </div></div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">API key</div>
  <div class="panel-body">
  <div class="form-group">
  <form class="form-horizontal">
    <label for="api_key_box" class="col-sm-2 control-label">Your API key</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" disabled id="api_key_box" placeholder="API key" value="$api_key">

    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="button" class="btn btn-info" onclick='toggleAPIKeyVisibility();'>Toggle Visibility</button>&nbsp;
      <button type="submit" class="btn btn-primary" onclick='event.preventDefault(); generateNewAPIKey();'>Generate new API key</button>&nbsp;
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#api_key_information">More Information</button>
    </div>
  </div></div>
</div>

<div id="api_key_information" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">About API Key's</h4>
      </div>
      <div class="modal-body">
        <p>An API key is the key that is used when communicating with the webserver. This key is used for sending commands to and from the backend.
        This key can also be used in any third party applications. However, any activity under this key is your responsibility.
        All actions are logged, and this key is tied to your username. KEEP IT SAFE
        If you wish to develop applications that use this API key, there are standards laid out on Github.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

EOF;









$panel->setPageContent($content);

?>
