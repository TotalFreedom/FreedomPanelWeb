function makeGetRequest(url) {
  $.get(url, function(data) {
  return data;
});
}

function testConnection() {
  // This function will test the connection to the web server, and eventually to the backend also.
  serverResponse = makeGetRequest('global/scripts/getdata.php?data=testConnection')
  console.log(serverResponse);
  var debugInfo = JSON.parse(serverResponse);
  console.log(debugInfo);
  var Time = Math.floor(Date.now() / 1000);

}

function retrieveLogs() {
  console.log(makeGetRequest('global/scripts/getdata.php'));
}
