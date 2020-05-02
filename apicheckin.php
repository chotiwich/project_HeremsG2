<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './api/vendor/autoload.php';
// edit password database for open
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
// $container ['db'] = function ($check) {
//     $settings = $check->get('settings')['db'];
//     $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
//         $settings['user'], $settings['pass']);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//     return $pdo;
// };

$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO(
        "mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'].";charset=UTF8",
        $settings['user'],
        $settings['pass'] 
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
};



$app->get('/getdb', function (Request $request, Response $response, array $args) {
    $sql = "SELECT b.bl_id,g.ginfo_id,g.ginfo_first_name,r.room_name,a.agency_name,re.resinfo_telno,b.bl_checkin,re.resinfo_bookdate,re.resinfo_first_name
    FROM rooms r join book_log b on r.room_id=b.bl_room 
    join reservation_info re on b.bl_reservation = re.resinfo_id
    join agency a on re.resinfo_agency=a.agency_id 
    join guest_info g on b.bl_ginfo = g.ginfo_id
    group by b.bl_id,re.resinfo_first_name,r.room_name,a.agency_name,re.resinfo_telno,b.bl_checkin,re.resinfo_bookdate,g.ginfo_id,g.ginfo_first_name";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

$app->get('/getdb/{keyword}', function (Request $request, Response $response, array $args) {
    $id = $args['keyword'];
    $sql = "SELECT b.bl_id,g.ginfo_id,g.ginfo_first_name,r.room_name,a.agency_name,re.resinfo_telno,b.bl_checkin,re.resinfo_bookdate,re.resinfo_first_name
    FROM rooms r join book_log b on r.room_id=b.bl_room 
    join reservation_info re on b.bl_reservation = re.resinfo_id
    join agency a on re.resinfo_agency=a.agency_id 
    join guest_info g on b.bl_ginfo = g.ginfo_id
    where re.resinfo_first_name ='".$id."' or r.room_name ='".$id."' or a.agency_name ='".$id."' or re.resinfo_telno ='".$id."'
    group by b.bl_id,re.resinfo_first_name,r.room_name,a.agency_name,re.resinfo_telno,b.bl_checkin,re.resinfo_bookdate,g.ginfo_id,g.ginfo_first_name";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->get('/getroomva', function (Request $request, Response $response, array $args) {
    $sql = "SELECT rm.room_id,rm.room_name,b.building_name,rt.rtype_eng,rv.rview_eng,rm.room_price,rm.room_guest,rs.rstatus_eng from book_log bl
    join reservation_info r
    on bl.bl_reservation = r.resinfo_id
    join agency a
    on r.resinfo_agency = a.agency_id 
    join rooms rm
    on bl.bl_room = rm.room_id
    join room_type rt 
    on rm.room_type = rt.rtype_id
    join room_status rs
    on bl.bl_status = rs.rstatus_id
    join room_view rv 
    on rm.room_view = rv.rview_id
    join building b
    on rm.room_building = b.building_id
    where rs.rstatus_eng='Avaliable'
    group by rm.room_id,rm.room_name,b.building_name,rt.rtype_eng,rv.rview_eng,rm.room_price,rm.room_guest,rs.rstatus_eng";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->run();
