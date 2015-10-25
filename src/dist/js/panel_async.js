function poll() {
  pollBackend();
  setTimeout(poll, 5000)
}
poll();


function loadLogs() {

    if (!document.getElementById('logs')) {
      return;
    }
setLoadingSpinnerState(true);

    $.get("global/scripts/poll.php?onethousand_log_lines=true", function(data) {
      document.getElementById('logs').innerHTML=data.onethousand_log_lines;
      setLoadingSpinnerState(true);
    });
}
