<?php

    $db_host = getenv('MYSQLHOST'); 

    $db_user = getenv('MYSQLUSER'); 

  
    $db_pass = getenv('MYSQL_ROOT_PASSWORD'); 

    $db_name = getenv('MYSQL_DATABASE'); 

    $db_port = getenv('MYSQLPORT'); 

    
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, (int)$db_port);

    if ($conn->connect_error) {
        die("Connect failed! Error: " . $conn->connect_error);
    }
    

    $conn->set_charset("utf8mb4");

    // ...
?>