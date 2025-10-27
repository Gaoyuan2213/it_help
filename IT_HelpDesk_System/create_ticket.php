<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'employee') {
    exit("insufficient permission");
}

$userid = $_SESSION['id'];
$message = "";

if (isset($_POST['create_ticket'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);
    $priority = $conn->real_escape_string($_POST['priority']);

    $sql = "INSERT INTO tickets (user_id, title, description, category, priority) 
        VALUES ('$userid', '$title', '$description', '$category', '$priority')";


    if ($conn->query($sql)) {
        $message = "ticket created！";
    } else {
        $message = "fialed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Ticket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Create Ticket</h2>
    <?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-control" required>
                <option value="Password">Password</option>
                <option value="Printer">Printer</option>
                <option value="Network">Network</option>
                <option value="Software">Software</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Priority</label>
            <select name="priority" class="form-control">
                <option value="Low">Low</option>
                <option value="Medium" selected>Medium</option>
                <option value="High">High</option>
            </select>
        </div>
        <button type="submit" name="create_ticket" class="btn btn-primary">Submit Ticket</button>
    </form>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
