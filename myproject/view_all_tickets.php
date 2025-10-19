<?php
session_start();
include  'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit("Insufficient permissions");
}

$sql = "SELECT t.id, t.title, t.category, t.priority, t.status, 
               t.created_at, u.name AS submitter, i.name AS assignee
        FROM tickets t
        LEFT JOIN users u ON t.user_id = u.user_id
        LEFT JOIN users i ON t.assigned_to = i.user_id
        ORDER BY t.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Tickets</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>All Tickets</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Submitter</th>
                <th>Assignee</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
        <?php if($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= htmlspecialchars($row['priority']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['submitter']) ?></td>
                    <td><?= htmlspecialchars($row['assignee'] ?? '-') ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">No tickets found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
