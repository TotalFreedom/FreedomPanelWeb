<?php
$panel->setPageTitle('Console');
$panel->setPageHeader('Console');
$panel->setPageDescription('Interact with the server');

if (!$panel->userHasPermission('access_console')) {
  $panel->setPageContent('You do not have permission to access this content');
  return;
}

if ($panel->userHasPermission('control_power')) {
  $powerControls = <<<EOF
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Power</h3>
    </div>
    <div class="panel-body">
      <button type="button" class="btn btn-success">Start Server</button>&nbsp;
      <button type="button" class="btn btn-info">Restart Server</button>&nbsp;
      <button type="button" class="btn btn-warning">Stop Server</button>&nbsp;
      <button type="button" class="btn btn-danger">Force Stop Server</button>&nbsp;
    </div>
  </div>
EOF;
} else {
  $powerControls = '';
}

$content = <<<EOF
$powerControls

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-terminal"></i>&nbsp;&nbsp;Console</h3>
  </div>
  <div class="panel-body">
  <textarea class="form-control" id='consoleBox' rows="15">
  </textarea>
  <form class="form-inline">
  <div class="form-group" >
    <label class="sr-only" for="consoleCommand">Command</label>
    <div class="input-group">
      <div class="input-group-addon"><i class='fa fa-terminal'></i></div>
      <input type="text" class="form-control"  id="consoleCommand" placeholder="Command">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Execute</button>
</form>
  </div>
</div>

EOF;

$panel->setPageContent($content);
?>
