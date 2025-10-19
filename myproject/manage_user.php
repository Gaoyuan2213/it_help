<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit("permission insufficient");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $password = $conn->real_escape_string($_POST['password']); 
    $hash = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO users (name, email, role, password) 
            VALUES ('$name', '$email', '$role', '$hash')";

    
    if ($conn->query($sql)) {
        $message = "Users create success！";
    } else {
        $message = "Creation failed: " . $conn->error;
    }
}


if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM users WHERE user_id = $delete_id");
    header("Location: manage_user.php");
    exit();
}

// 查询所有用户
$result = $conn->query("SELECT user_id, name, email, role FROM users ORDER BY user_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Manage Users</h2>

    <?php if($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <!-- 新增用户表单 -->
    <h4 class="mt-4">Add New User</h4>
    <form method="POST" class="row g-3">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="Name" required>
        </div>
        <div class="col-md-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-2">
            <select name="role" class="form-select" required>
                <option value="employee">Employee</option>
                <option value="it_staff">IT Staff</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col-md-2">
            <button type="submit" name="add_user" class="btn btn-success">Add User</button>
        </div>
    </form>

    <!-- 用户表格 -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                    <td>
                        <a href="manage_user.php?delete_id=<?= $row['user_id'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No users found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
