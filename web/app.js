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
    return false;
});
app.set('twig options', {
    strict_variables: false
})
app.set('view engine', twig.__express);

// Main Routes
app.get('/', 'index', function (request, response) {
    response.render('index.html.twig', {articles: []});
});
app.get('/login', 'fos_user_security_logout', function (request, response) { response.send('TODO'); });
app.post('/login', 'fos_user_security_check', function (request, response) { response.send('TODO'); });
app.get('/about', 'about', function (request, response) { response.send('TODO'); });

// Article Routes
app.get('/article/:slug', 'article', function (request, response) { response.send('TODO'); });
app.get('/articles', 'article_list', function (request, response) { response.send('TODO'); });
app.get('/tag/:name', 'articles_by_tag', function (request, response) { response.send('TODO'); });

// Init Server and Listen
var server = app.listen(8080, function () {
    var host = server.address().address;
    var port = server.address().port;

    console.log('Server listening on http://%s:%s', host, port);
})
