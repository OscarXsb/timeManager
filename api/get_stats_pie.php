<?php
session_start();
require_once '../api/lib/Connect_db.php';

$db = ConnectMysqli::getIntance();

if (isset($_POST['format'])) {
    $format = $_POST['format'];
    $data = array();
    $index = array();
    if ($format == "day") {
        $datestamp = date("Y-m-d", $_POST['datestamp']);
        $sql = "SELECT * FROM time_arrange WHERE date = '{$datestamp}'";
        $list = $db->getAll($sql);
        
        
            $i = 0;
            foreach ($list as $value) {
                $data[$i]['value'] = $value['item_time'];
                $data[$i]['name'] = $value['item_name'];
                $data[$i]['start_time'] = $value['start_time'];
                $data[$i]['finish_time'] = $value['finish_time'];
                $i++;
            }
        

        
    }

    if ($format == "week") {
        $datestamp = date("Y-m-d", $_POST['datestamp']);
        $first = 1;
        $w = date('w', strtotime($datestamp));
        $week_start = date('Y-m-d', strtotime("$datestamp -" . ($w ? $w - $first : 6) . ' days'));
        $week_end = date('Y-m-d', strtotime("$week_start +6 days"));

        $sql = "SELECT * FROM time_arrange WHERE date between '{$week_start}' and '{$week_end}'";
        $list = $db->getAll($sql);
        
            $i = 0;
            foreach ($list as $value) {
                $data[$i]['value'] = $value['item_time'];
                $data[$i]['name'] = $value['item_name'];
                $data[$i]['start_time'] = $value['start_time'];
                $data[$i]['finish_time'] = $value['finish_time'];
                $i++;
            }
        

        
    }

    if ($format == "month") {
        $datestamp = date("Y-m-d", $_POST['datestamp']);
        $month_start = date('Y-m-01', strtotime($datestamp));
        $month_end = date('Y-m-d', strtotime("$month_start +1 month -1 day"));

        $sql = "SELECT * FROM time_arrange WHERE date between '{$month_start}' and '{$month_end}'";
        $list = $db->getAll($sql);
        
            $i = 0;
            foreach ($list as $value) {
                $data[$i]['value'] = $value['item_time'];
                $data[$i]['name'] = $value['item_name'];
                $data[$i]['start_time'] = $value['start_time'];
                $data[$i]['finish_time'] = $value['finish_time'];
                $i++;
            }
        

        
    }

    if ($format == "season") {

        $season = ceil((date('n',$_POST['datestamp'])) / 3);

        $season_start = date('Y-m-d', mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y')));

        $season_end = date('Y-m-d', mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date("Y"))), date('Y')));

        $sql = "SELECT * FROM time_arrange WHERE date between '{$season_start}' and '{$season_end}'";
        $list = $db->getAll($sql);
        
            $i = 0;
            foreach ($list as $value) {
                $data[$i]['value'] = $value['item_time'];
                $data[$i]['name'] = $value['item_name'];
                $data[$i]['start_time'] = $value['start_time'];
                $data[$i]['finish_time'] = $value['finish_time'];
                $i++;
            }
        

        
    }

    if ($format == "year") {
        $datestamp = date("Y", $_POST['datestamp']);
        $year_start = $datestamp . "-01-01";
        $year_end = $datestamp. "-12-31";
        $sql = "SELECT * FROM time_arrange WHERE date between '{$year_start}' and '{$year_end}'";
        $list = $db->getAll($sql);
        
            $i = 0;
            foreach ($list as $value) {
                $data[$i]['value'] = $value['item_time'];
                $data[$i]['name'] = $value['item_name'];
                $data[$i]['start_time'] = $value['start_time'];
                $data[$i]['finish_time'] = $value['finish_time'];
                $i++;
            }
        

        
    }
    
    if ($_POST['type'] == "single") {
        echo json_encode($data);
    }else{
        $data_merge=array();
        foreach($data as $value){
            if(in_array($value['name'],$index)){
                $data_merge[$value['name']]['value']+=$value['value'];
                continue;
            }
            $data_merge[$value['name']]['value'] = $value['value'];
            $data_merge[$value['name']]['name'] = $value['name'];
            array_push($index,$value['name']);
        }
        echo json_encode(array_values($data_merge));
    }
} else {
    die("Error: no parameters");
}
