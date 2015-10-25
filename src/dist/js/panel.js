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








// Task to loop the poll and process functions
