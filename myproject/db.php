<?php
// InfinityFree 数据库连接信息
$db_host = "sql113.infinityfree.com"; // MySQL Host Name
$db_user = "if0_40208890";           // MySQL User Name
$db_pass = "(Your vPanel Password)";  // MySQL Password，填你在 InfinityFree 的 vPanel 密码
$db_name = "if0_40208890_helpDesk";   // MySQL DB Name
$db_port = 3306;                      // MySQL 默认端口

// 尝试连接
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

// 检查连接是否成功
if ($conn->connect_error) {
    die("Connect failed! Error: " . $conn->connect_error);
}

// 设置字符集
$conn->set_charset("utf8mb4");

// 现在你可以正常使用 $conn 执行数据库操作
?>