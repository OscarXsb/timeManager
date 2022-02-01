<?php
session_start();
require_once '../api/lib/Connect_db.php';

$db = ConnectMysqli::getIntance();
$arr=[
    'item_id' => $_POST['item_id'],
    'item_name' => $_POST['item_name'],
    'item_time' => $_POST['last_time']*60,
    'start_time' => date("Y-m-d H:i:s", $_POST['start_time']),
    'finish_time' => date("Y-m-d H:i:s", $_POST['end_time']),
    'date' => date("Y-m-d", $_POST['start_time']),
];

echo time();

$db->insert('time_arrange', $arr);
