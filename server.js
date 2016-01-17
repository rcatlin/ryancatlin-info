var express = require('express');
var fs = require('fs');
var app = express();

const PORT = 8000;

app.use('/css', express.static('blogapp/css'));
app.use('/js', express.static('blogapp/js'));

app.get("/", function(request, response) {
  response.status(200)
    .sendFile(__dirname + '/blogapp/index.html');
});


var server = app.listen(PORT, function () {
  var host = server.address().address;
  var port = server.address().port;

  console.log("HTTP server started on: http://%s:%s", host, port);
});
