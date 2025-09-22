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
          <li><a href="#">My Profile</a></li>
          <li><a href="#">Create Ticket</a></li>
          <li><a href="#">My Tickets</a></li>
        </ul>
      </div>
    <?php } ?>
    <?php if ($role == 'it_staff') { ?>
      <div class="card itstaff-card">
        <h2>IT Staff Menu</h2>
        <ul>
          <li><a href="#">My Profile</a></li>
          <li><a href="#">Assigned Tickets</a></li>
          <li><a href="#">All Open Tickets</a></li>
          <li><a href="#">Update Ticket Status</a></li>
        </ul>
      </div>
    <?php } ?>

    <?php if ($role == 'admin') { ?>
      <div class="card admin-card">
        <h2>Admin Menu</h2>
        <ul>
          <li><a href="#">My Profile</a></li>
          <li><a href="#">User Management</a></li>
          <li><a href="#">View All Tickets</a></li>
          <li><a href="#">Reports / Dashboard</a></li>
        </ul>
      </div>
    <?php } ?>
  </div>
</body>
</html>
