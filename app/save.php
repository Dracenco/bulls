<?php

$buttonId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$buttonId){
    die('missing id');
}
$date = date('Y-m-d');
$time = date('H:i:s');
$userIp = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

$filepath = "../logs/{$date}-click.log";
$line = "$time\t$buttonId\t$userIp\n";

file_put_contents($filepath,$line,FILE_APPEND);
echo "log file has been created successfully ".$line;

require_once 'helpers/Database.php';

$dataBase = new Database();
$tableName = 'logs';
$insertLogsSql = "INSERT INTO $tableName (time, button_id, user_ip) VALUES ('$date $time', $buttonId, '$userIp')";

$dataBase->insertData($insertLogsSql);