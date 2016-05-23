import express from 'express';
import fs from 'fs';

let app = express();

const PORT = 8000;

app.use('/css', express.static('app/css'));
app.use('/js', express.static('app/js'));
app.use('/img', express.static('app/img'));

app.get("/", function(request, response) {
  response.status(200)
    .sendFile(__dirname + '/app/index.html');
});


var server = app.listen(PORT, function () {
  var host = server.address().address;
  var port = server.address().port;

  console.log("HTTP server started on: http://%s:%s", host, port);
});
