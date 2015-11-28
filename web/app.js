var express = require('express');

var app = express();

app.use('/static', express.static('resources'));

app.set('twig options', {
    strict_variables: false
})
app.set('view engine', 'twig');

app.get('/', function (request, response) {
    response.render('index', {message: 'Hello, world.'});
})


var server = app.listen(8080, function () {
    var host = server.address().address;
    var port = server.address().port;

    console.log('Server listening on http://%s:%s', host, port);
})
