var express = require('express');
var app = express();

// Setup Named Routes
var Router = require('named-routes');
var router = new Router();
router.extendExpress(app);
router.registerAppHelpers(app);

// Define Static Resources Directory with virtual path
app.use('/static', express.static('resources'));

// Setup Twig
var twig = require('twig');
twig.extendFunction('is_granted', function (role_name) {
    return true;
});
app.set('twig options', {
    strict_variables: false
})
app.set('view engine', twig.__express);

// Routing
app.get('/', 'index', function (request, response) {
    response.render('index.html.twig', {articles: []});
})

// Init Server and Listen
var server = app.listen(8080, function () {
    var host = server.address().address;
    var port = server.address().port;

    console.log('Server listening on http://%s:%s', host, port);
})
