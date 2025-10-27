<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <div class="dashboard">
    <div style="text-align:center; margin-bottom: 20px;">
      <img src="https://via.placeholder.com/80" 
           alt="User Avatar" 
           style="border-radius:50%; margin-bottom:10px;">
      <h1>Welcome, <?php echo htmlspecialchars($name); ?> (<?php echo $role; ?>)</h1>
    </div>
    <nav>
      <a href="dashboard.php">Home</a>
      <a href="logout.php">Logout</a>
    </nav>
    <?php if ($role == 'employee') { ?>
      <div class="card employee-card">
        <h2>Employee Menu</h2>
        <ul>
          <li><a href="my_profile.php">My Profile</a></li>
          <li><a href="create_ticket.php">Create Ticket</a></li>
          <li><a href="my_ticket.php">My Tickets</a></li>
        </ul>
      </div>
    <?php } ?>
    <?php if ($role == 'it_staff') { ?>
      <div class="card itstaff-card">
        <h2>IT Staff Menu</h2>
        <ul>
          <li><a href="my_profile.php">My Profile</a></li>
          <li><a href="assigned_tickets.php">Assigned Tickets</a></li>
          <li><a href="open_tickets.php">All Open Tickets</a></li>
        </ul>
      </div>
    <?php } ?>

    <?php if ($role == 'admin') { ?>
      <div class="card admin-card">
        <h2>Admin Menu</h2>
        <ul>
          <li><a href="my_profile.php">My Profile</a></li>
          <li><a href="manage_user.php">User Management</a></li>
          <li><a href="view_all_tickets.php">View All Tickets</a></li>
          <li><a href="dashboard_reports.php">Reports / Dashboard</a></li>
        </ul>
      </div>
    <?php } ?>
  </div>
</body>
</html>
