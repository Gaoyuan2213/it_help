<?php
session_start();
include '../db.php';

// 必须登录
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

// 从 Session 中拿当前用户ID
$userid = $_SESSION['id'];

// 查询当前登录用户资料
$sql = "SELECT name, email, role FROM users WHERE user_id = $userid";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h2>My Profile</h2>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($user['role']); ?></p>
        </div>
        <div class="card-footer text-center">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
