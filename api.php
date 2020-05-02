<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './api/vendor/autoload.php';

$config = [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        // Database connection settings
        "db" => [
            "host" => "127.0.0.1",
            "dbname" => "hermes",
            "user" => "root",
            "pass" => "usbw"
        ],
    ],
];

$app = new \Slim\App($config);

// DIC configuration
$container = $app->getContainer();


// PDO database library 
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO(
        "mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'] . ";charset=utf8",
        $settings['user'],
        $settings['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
};


$app->get('/getdb', function (Request $request, Response $response, array $args) {

    $sql = "select a.agency_name,r.resinfo_id,r.resinfo_first_name,r.resinfo_last_name, r.resinfo_email, r.resinfo_telno, r.resinfo_comments, 
            rm.room_name, rt.rtype_eng, rs.rstatus_eng, rv.rview_eng, b.building_name from book_log bl
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
            on rm.room_building = b.building_id ";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    return $this->response->withJson($sth);
});

$app->get('/editReservation/{resinfo_id}', function (Request $request, Response $response, array $args) {
    $resinfo_id = $args['resinfo_id'];
    // $sql = "DELETE FROM hermes
    //             WHERE resinfo_id = $resinfo_id";

    $sql = "select a.agency_name,r.resinfo_id,r.resinfo_first_name,r.resinfo_last_name, r.resinfo_email, r.resinfo_telno, r.resinfo_comments, 
    rm.room_name, rt.rtype_eng, rs.rstatus_eng, rv.rview_eng, b.building_name from book_log bl
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
    where r.resinfo_id = $resinfo_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

// $app->get('/getdb/{id}', function (Request $request, Response $response, array $args) {
//     $id = $args['id'];
//     $sql = "select a.agency_name, r.resinfo_first_name,r.resinfo_last_name, r.resinfo_email, r.resinfo_telno, r.resinfo_comments, 
//             rm.room_name, rt.rtype_eng, rs.rstatus_eng, rv.rview_eng, b.building_name from book_log bl
//             join reservation_info r
//             on bl.bl_reservation = r.resinfo_id
//             join agency a
//             on r.resinfo_agency = a.agency_id 
//             join rooms rm
//             on bl.bl_room = rm.room_id
//             join room_type rt 
//             on rm.room_type = rt.rtype_id
//             join room_status rs
//             on bl.bl_status = rs.rstatus_id
//             join room_view rv 
//             on rm.room_view = rv.rview_id
//             join building b
//             on rm.room_building = b.building_id";
//     $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

//     return $this->response->withJson($sth);
// });

$app->run();