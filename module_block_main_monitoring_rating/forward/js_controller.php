<?php
$server = $_GET['server'];
$password = $_GET['password'];

if (isset($server) && !empty($server) && strpos($server,":") && isset($password) && !empty($password) && $password == 'ТВОЙ ПАРОЛЬ')
{
    $json_data = file_get_contents('php://input');
    $myfile = fopen($_SERVER['DOCUMENT_ROOT']."/app/modules/module_block_main_monitoring_rating/servers/".$server.".json", 'w');
    fputs($myfile, $json_data);
    fclose($myfile); 
}
else echo("What are you, retarded? Why the fuck did you come here if you don't know how to use it?");
?>