window.freedomPanel = [];
function pollBackend() {
  $.get("global/scripts/poll.php?power_status=true&server_information=true&online_players=true&online_admins=true&fifty_log_lines=true&session_info=true&pending_actions=true", function(data) {
    window.freedomPanel.pollResponse = data;
    var date = new Date();
    window.freedomPanel.lastPoll = date.getTime()/1000;
    processBackendPoll();
  });
  processBackendPoll();
}

function processBackendPoll() {
  if (typeof window.freedomPanel.pollResponse === 'undefined') {
    setConnectionState(false);
    return;
  }

  // Check if the poll is recent (last 10 seconds)
  var date = new Date();
  var unixTime = date.getTime()/1000;
  if (unixTime - freedomPanel.lastPoll < 10) {
    if (window.freedomPanel.pollResponse.status != true) {
      setConnectionState(false);
      return;
    } else {
      setConnectionState(true);
    }
  } else {
    setConnectionState(false);
    return;
  }


  // Fill the console, if neccessary
  if (document.getElementById('consoleBox')) {
    document.getElementById('consoleBox').innerHTML=window.freedomPanel.pollResponse.fifty_log_lines;
  }

}

function setConnectionState(state) {
  if (state == true) {
      document.getElementById('connected').style.display='inline';
      document.getElementById('disconnected').style.display='none';
  } else {
    document.getElementById('connected').style.display='none';
    document.getElementById('disconnected').style.display='inline';
  }
}

function setLoadingSpinnerState(state) {
  if (state == 'toggle') {
    var currentState = document.getElementById('loadingSpinner').style.display;

    if (currentState == 'none') {
      document.getElementById('loadingSpinner').style.display = 'inline';
    } else {
      document.getElementById('loadingSpinner').style.display = 'none';
    }

  }

  if (state == true) {
    document.getElementById('loadingSpinner').style.display = 'inline';
  }

  if (state == false) {
    document.getElementById('loadingSpinner').style.display = 'none';
  }
}


function changePassword() {

  var currentPassword = document.getElementById('currentPassword').value;
  var newPassword = document.getElementById('newPassword').value;
  var newPasswordConfirm = document.getElementById('newPasswordConfirm').value;

  if (newPassword != newPasswordConfirm) {
    document.getElementById('passwordErrorText').innerHTML='Confirmation password doesnt match.';
    document.getElementById('passwordError').style.display='inline';
    return;
  }
  if (newPassword == '') {
    document.getElementById('passwordErrorText').innerHTML='Please enter a password';
    document.getElementById('passwordError').style.display='inline';
    return;
  }
  setLoadingSpinnerState(true);
  $.post( "global/scripts/useractions.php?action=change_password", {current: currentPassword, new_password: newPassword})
  .done(function(data) {
    setLoadingSpinnerState(false);
    console.log(data.success);
    if (data.success == true) {
      window.location.replace('global/scripts/useractions.php?action=logout');
    } else {
      document.getElementById('passwordErrorText').innerHTML = data;
      document.getElementById('passwordError').style.display='inline';
      console.log('An error occured' + data);
    }
  });
}

function generateNewAPIKey() {
  setLoadingSpinnerState(true);
  $.post( "global/scripts/useractions.php?action=generate_new_api_key", {place: ''})
  .done(function(data) {
    setLoadingSpinnerState(false);
    console.log(data.success);
    if (data.success == true) {
      window.location.replace('global/scripts/useractions.php?action=logout');
    } else {
      console.log('An error occured' + data);
    }
})
}

function toggleAPIKeyVisibility() {
  if (document.getElementById('api_key_box')) {
    if (document.getElementById('api_key_box').type == 'password') {
      document.getElementById('api_key_box').type = 'text'
    } else {
      document.getElementById('api_key_box').type = 'password'
    }
  }
}




// Task to loop the poll and process functions
