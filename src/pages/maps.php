<?php
$panel->setPageTitle('Maps');
$panel->setPageHeader('Maps');
$panel->setPageDescription('Wipe and Update the servers\'s maps');

if (!$panel->userHasPermission('access_maps')) {
  $panel->setPageContent('You do not have permission to access this content');
  return;
}

$layout = '<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><a data-toggle="collapse" data-parent="#maps" href="#{NAME}">{NAME}</a></h3>
  </div>
  <div id="{NAME}" class="panel-body panel-collapse collapse">
    <img width="100%" src=\'{img_url}\' />
  </div>
  <div class="panel-footer">
    <button type="button" class="btn btn-default">Reset Map</button>
  </div>  </div>';

$output = '';
foreach ($panel->getMaps('*') as $value) {
  $currentOutput = str_replace('{img_url}', $config['root_dir_url'] . '/global/scripts/getimage.php?data=map&name=' . $value['name'], $layout);
  //$currentOutput = str_replace(); No button yet, don't do anything
  $output .= str_replace('{NAME}', $value['name'], $currentOutput);
  $currentOutput = '';
}

if ($users->userHasPermission('upload_map')) {
$uploadButton = '<button type="button" class="btn btn-default">Upload Map</button>';
} else {
  $uploadButton = '';
}

$content = <<<EOF

<div class="panel-group" id="maps">
$output
</div>

$uploadButton


EOF;






$panel->setPageContent($content);

?>
