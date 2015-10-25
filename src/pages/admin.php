<?php
$panel->setPageTitle('Admin');
$panel->setPageHeader('Admin');
$panel->setPageDescription('Panel Admin Options');

if (!$panel->userHasPermission('access_admin')) {
  $panel->setPageContent('You do not have permission to access this content');
  return;
}

$userInformation = $users->getAllUserInfo();
$rankInformation = $panel->listRanks();

// Users and User Permissions Logoc
$tableOutput = '';
foreach ($userInformation as &$user) {
  $userRanks = '';
  foreach ($rankInformation as &$rank) {
    if ($rank['human_role_name'] == $user['human_role_name']) {
      $userRanks .= '<option selected value="' . $rank['role_id'] . '"">' . $rank['human_role_name'] . '</option>';
    } else {
      $userRanks .= '<option value="' . $rank['role_id'] . '"">' . $rank['human_role_name'] . '</option>';
    }
  }

  $tableOutput .= '
  <tr>
          <th scope="row">' . $user['id'] . '</th>
          <td><input type="text" disabled class="form-control" placeholder="Username" value="' . $user['username'] . '"></td>
          <td><input type="password" class="form-control" placeholder="Change Password" value="Placeholder"></td>
          <td><select class="form-control">' . $userRanks . '</select></td>
          <td><button type="submit" class="btn btn-danger">Delete</button>&nbsp;<button type="submit" class="btn btn-primary">Save</button></td>
        </tr>
    ';

  }


// Add New User Logic
$createRanks = '';
foreach ($rankInformation as &$rank) {
    $createRanks .= '<option value="' . $rank['role_id'] . '"">' . $rank['human_role_name'] . '</option>';
}

$content = <<<EOF
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Users and User Permissions</h3>
  </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Password</th>
          <th>Rank</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
      $tableOutput
      </tbody>
    </table>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new User</h3>
  </div>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Username</th>
        <th>Password</th>
        <th>Rank</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>
    <tr>
            <td><input type="text" class="form-control" placeholder="Username" value=""></td>
            <td><input type="password" class="form-control" placeholder="Password"></td>
            <td><select class="form-control">$createRanks</select></td>
            <td><button type="submit" class="btn btn-primary">Add</button>
    </tr>
    </tbody>
  </table>
</div>


EOF;


$panel->setPageContent($content);

?>
