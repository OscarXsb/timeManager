<?php
session_start();
require_once '../api/lib/Connect_db.php';

$db = ConnectMysqli::getIntance();

$item_name = $_POST['content'];
$item_time = $_POST['item_time'];
$rest_time = $_POST['rest_time'];

$arr = [
        'item_name' => $item_name,
        'item_time' => $item_time,
        'rest_time' => $rest_time,
        'create_time' => date("Y-m-d H:i:s", time())
];

$sql = "SELECT * FROM pomodoro_item WHERE item_name = '{$item_name}'";
$list = $db->getAll($sql);
if (count($list) == 0) {
        $db->insert('pomodoro_item', $arr);
} else {
        $up_arr=[
                'item_name' => $item_name,
                'item_time' => $item_time,
                'rest_time' => $rest_time,
                'display' => 0
        ];
        $up = $db->update("pomodoro_item", $up_arr, "id = '{$list[0]['id']}'");
}
