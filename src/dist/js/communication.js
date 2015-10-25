function makeGetRequest(url) {
  $.get(url, function(data) {
  return data;
});
}

function retrieveLogs() {
  console.log(makeGetRequest('global/scripts/getdata.php'));
}
