<?php
    $conn = new mysqli("localhost", "root","","it_helpdesk");
    if($conn -> connect_error){
        die("connect failed!". $conn->connect_error);
    }
?>