<?php
$panel->setPageTitle('Status');
$panel->setPageHeader('Status');
$panel->setPageDescription('View Server Status');


$content = <<<EOF

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Players</h3>
  </div>
  <div class="panel-body">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
      </tr>
    </thead>
    <tbody id='playersTable'>

    </tbody>
  </table>


  </div>
</div>

EOF;

$panel->setPageContent($content);
?>
