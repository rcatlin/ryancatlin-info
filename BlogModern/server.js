var cors = require('cors');
var express = require('express');
var fs = require('fs');

let app = express();

const PORT = 8080;

app.use(cors());
app.use('/css', express.static('public/css'));
app.use('/js', express.static('public/js'));
app.use('/img', express.static('public/img'));

app.get("/", function(request, response) {
  response.status(200)
    .sendFile(__dirname + '/public/index.html');
});


var server = app.listen(PORT, function () {
  var host = server.address().address;
  var port = server.address().port;

  console.log("HTTP server started on: http://%s:%s", host, port);
});
