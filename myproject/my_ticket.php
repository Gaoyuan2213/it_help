<?php
session_start();
include  'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'employee') {
    header("Location: index.php");
    exit();
}
if (!isset($_SESSION['id'])) {
    die("用户未登录，缺少 user_id");
}
$userid = $_SESSION['id'];

$sql = "SELECT * FROM tickets WHERE user_id = $userid ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Tickets</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <div class="dashboard">
    <h1>My Tickets</h1>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top:20px;">
      <tr>
        <th>Ticket ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Priority</th>
        <th>Status</th>
      </tr>
      <?php if ($result->num_rows > 0) { ?>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td><?php echo htmlspecialchars($row['priority']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="5">No tickets found.</td>
        </tr>
      <?php } ?>
    </table>
  </div>
</body>
</html>
