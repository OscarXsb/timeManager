<?php
session_start();
require_once '../api/lib/Connect_db.php';

$db = ConnectMysqli::getIntance();

if (isset($_POST['format'])) {
    $format = $_POST['format'];
    if ($format == "day") {
        $datestamp = date("Y-m-d", $_POST['datestamp']);
        $sql = "SELECT * FROM time_arrange WHERE date = '{$datestamp}'";
        $list = $db->getAll($sql);
        $data = array();
        $i = 0;
        foreach ($list as $value) {
            $data[$i]['value'] = $value['item_time'];
            $data[$i]['name'] = $value['item_name'];
            $data[$i]['start_time'] = $value['start_time'];
            $data[$i]['finish_time'] = $value['finish_time'];
            $i++;
        }
        echo json_encode($data);
    }
} else {
    die("Error: no parameters");
}
