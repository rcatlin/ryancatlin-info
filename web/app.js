var express = require('express');

var app = express();

app.use('/static', express.static('resources'));

app.get('/', function (request, response) {
    response.send('Hello, world.');
})


var server = app.listen(8080, function () {
    var host = server.address().address;
    var port = server.address().port;

    console.log('Server listening on http://%s:%s', host, port);
})
