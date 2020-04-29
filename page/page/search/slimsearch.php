<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './api/vendor/autoload.php';
$config=[
    'settings'=>[
        'displayErrorDetails'=>true,
    "db" => [
        "host" => "127.0.0.1",
        "dbname" => "hermes",
        "user" => "root",
        "pass" => "usbw"
        ],
    ],
];

$app = new \Slim\App ($config);

// DIC configuration
$container = $app->getContainer();

// PDO database library 
$container ['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
};

$app->get("/getdb/{idclick}", function (Request $request, Response $response, array $args) {
    $idclick = $args['idclick'];
    $sql = "Select * from person where id='".$idclick."'";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    
    return $this->response->withJson($sth);
});

$app->run();

?>