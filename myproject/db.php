<?php

$db_host = "sql113.infinityfree.com"; 
$db_user = "if0_40208890";           
$db_pass = "7CNxUs0EiOj"; 
$db_name = "if0_40208890_helpDesk";   
$db_port = 3306;                      


$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);


if ($conn->connect_error) {
    die("Connect failed! Error: " . $conn->connect_error);
}


$conn->set_charset("utf8mb4");


?>
