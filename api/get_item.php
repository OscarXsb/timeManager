<?php
session_start();
require_once '../api/lib/Connect_db.php';

$db = ConnectMysqli::getIntance();

$sql="SELECT * FROM pomodoro_item WHERE display = 0";
$list=$db->getAll($sql);
echo json_encode($list);
