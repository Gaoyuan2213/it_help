<?php


    $db_host = getenv('MYSQL_HOST'); 

    $db_user = getenv('MYSQL_USER'); 


    $db_pass = getenv('MYSQL_PASSWORD'); 

    $db_name = getenv('MYSQL_DATABASE'); 

    $db_port = getenv('MYSQL_PORT'); 

    if (!$db_host || !$db_user || !$db_pass || !$db_name) {
 
        die("Error: Required database environment variables are missing.");
    }
    
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, (int)$db_port);

    if ($conn->connect_error) {
   
        die("Connect failed! Error: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");

    // ...
?>