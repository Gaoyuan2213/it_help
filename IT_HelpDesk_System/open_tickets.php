<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'it_staff') {
    exit("Insufficient permissions");
}

$staff_id = $_SESSION['id'];
$message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $ticket_id = intval($_POST['ticket_id']);
    $new_status = isset($_POST['status']) ? $_POST['status'] : null;

    if ($new_status) {
        $update_sql = "UPDATE tickets 
                       SET status = '$new_status' 
                       WHERE id = $ticket_id AND assigned_to = $staff_id";
        if ($conn->query($update_sql)) {
            $message = "Ticket status updated！";
        } else {
            $message = "Operation failed: " . $conn->error;
        }
    } else {
        $message = "Please select a valid status! ";
    }
}

$sql = "SELECT t.id, t.title, t.category, t.priority, t.status, u.name as submitter
        FROM tickets t
        JOIN users u ON t.user_id = u.user_id
        WHERE t.assigned_to = $staff_id
        ORDER BY t.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Assigned Tickets</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>My Assigned Tickets</h2>

    <?php if($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Submitter</th>
                <th>Action</th>
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
                    <td>
                        <form method="POST" class="d-flex gap-1">
                            <input type="hidden" name="ticket_id" value="<?= $row['id'] ?>">
                            <select name="status" class="form-select form-select-sm">
                                <option value="Assigned" <?= $row['status']=='Assigned'?'selected':'' ?>>Assigned</option>
                                <option value="In Progress" <?= $row['status']=='In Progress'?'selected':'' ?>>In Progress</option>
                                <option value="Resolved" <?= $row['status']=='Resolved'?'selected':'' ?>>Resolved</option>
                                <option value="Closed" <?= $row['status']=='Closed'?'selected':'' ?>>Closed</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No assigned tickets</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
