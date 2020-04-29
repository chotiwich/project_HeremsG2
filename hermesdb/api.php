<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './api/vendor/autoload.php';
$config=[
    'settings'=>[
        'displayErrorDetails'=>true,
    "db" => [
        "host" => "127.0.0.1",
        "dbname" => "demo",
        "user" => "root",
        "pass" => "usbw"
        ],
    ],
];

$app = new \Slim\App($config);

// DIC configuration
$container = $app->getContainer();

// PDO database library 
$container ['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO(
        "mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'] . ";charset=UTF8",
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
$app->get('/getdb' , function (Request $request,Request $response,array $args){
    $sql = "select re.resinfo_id,r.room_id,re.resinfo_first_name,re.resinfo_last_name,re.resinfo_telno,re.resinfo_email,r.room_name from reservation_info re
    join book_log bl
    on re.resinfo_id = bl.bl_reservation
    join rooms r
    on bl.bl_room = r.room_id
    group by re.resinfo_id;";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);



});
$app->get('/getdb/{id}' , function (Request $request,Request $response,array $args) {
    $id = $args['id'];
    $sql = "select re.resinfo_id,r.room_id,re.resinfo_first_name,re.resinfo_last_name,re.resinfo_telno,re.resinfo_email,r.room_name from reservation_info re
    join book_log bl
    on re.resinfo_id = bl.bl_reservation
    join rooms r
    on bl.bl_room = r.room_id
    group by re.resinfo_id;";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);



});
$app->get('/getdb/{idcheck}', function (Request $request, Response $response, array $args) {
    $sql = "select username from users";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->run();
?>

