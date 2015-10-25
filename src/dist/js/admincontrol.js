function createAccount() {
  var username = document.getElementById('admin_add_username').value;
  var password = document.getElementById('admin_add_password').value;
  var role = document.getElementById('admin_add_role').value;

  if (username == '') {
    alert('An error occured whilst creating the user');
    return;
  }
  if (password == '') {
    alert('An error occured whilst creating the user');
    return;
  }
  setLoadingSpinnerState(true);
  $.post( "global/scripts/adminactions.php?action=add_user", {username: username, password: password, role: role})
  .done(function(data) {
    setLoadingSpinnerState(false);
    if (data.success == 'true') {
      location.reload();
    } else {
      alert('An error occured whilst creating the user');
      console.log('An error occured' + data);
    }
  });
  setLoadingSpinnerState(false);
}


function deleteAccount(username) {
  var confirmation = confirm('Are you sure you want to delete ' + username);
  if (!confirmation) {
    return;
  }
  setLoadingSpinnerState(true);
  $.post( "global/scripts/adminactions.php?action=delete_user", {username: username})
  .done(function(data) {
    setLoadingSpinnerState(false);
    if (data.success == 'true') {
      location.reload();
    } else {
      alert('An error occured whilst deleting the user');
      console.log('An error occured' + data);
    }
  });
  setLoadingSpinnerState(false);
}

function changeUserPassword(username, password) {

  if (password == 'Placeholder') {
    return;
  }
  var confirmation = confirm('Are you sure you want to change ' + username + '\'s password?');
  if (!confirmation) {
    return;
  }
  setLoadingSpinnerState(true);
  $.post( "global/scripts/adminactions.php?action=change_user_password", {username: username, password: password})
  .done(function(data) {
    setLoadingSpinnerState(false);
    if (data.success == 'true') {
    } else {
      alert('An error occured whilst updating the user\'s password');
      console.log('An error occured' + data);
    }
  });
  setLoadingSpinnerState(false);
}

function changeUserRole(username, role) {

  setLoadingSpinnerState(true);
  $.post( "global/scripts/adminactions.php?action=change_user_role", {username: username, role: role})
  .done(function(data) {

    if (data.success == 'true') {
      location.reload();
    } else {
      alert('An error occured whilst updating the user\'s role');
      console.log('An error occured' + data);
      console.log(data);
      setLoadingSpinnerState(false);
    }
  });
  setLoadingSpinnerState(false);
}

function saveAccountInformation(id) {
  // Handles both password changes and rank changes

  var username = document.getElementById('username_' + id).value;
  var password = document.getElementById('password_' + id).value;
  var role = document.getElementById('role_' + id).value;

  changeUserRole(username, role);
  changeUserPassword(username, password)

  location.reload();

}
