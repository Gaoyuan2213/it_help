<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit("Insufficient permissions");
}

$total_sql = "SELECT COUNT(*) AS total FROM tickets";
$total_res = $conn->query($total_sql);
$total = $total_res->fetch_assoc()['total'] ?? 0;

$status_sql = "SELECT status, COUNT(*) AS count FROM tickets GROUP BY status";
$status_res = $conn->query($status_sql);
$status_data = [];
while($row = $status_res->fetch_assoc()) {
    $status_data[$row['status']] = intval($row['count']);
}

$priority_sql = "SELECT priority, COUNT(*) AS count FROM tickets GROUP BY priority";
$priority_res = $conn->query($priority_sql);
$priority_data = [];
while($row = $priority_res->fetch_assoc()) {
    $priority_data[$row['priority']] = intval($row['count']);
}

$category_sql = "SELECT category, COUNT(*) AS count FROM tickets GROUP BY category";
$category_res = $conn->query($category_sql);
$category_data = [];
while($row = $category_res->fetch_assoc()) {
    $category_data[$row['category']] = intval($row['count']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard / Reports</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2>Admin Dashboard / Reports</h2>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Tickets</h5>
                    <p class="card-text fs-3"><?= $total ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <canvas id="statusChart"></canvas>
        </div>
        <div class="col-md-4">
            <canvas id="priorityChart"></canvas>
        </div>
        <div class="col-md-4">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <a href="dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
</div>

<script>
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_keys($status_data)) ?>,
        datasets: [{
            label: 'Tickets by Status',
            data: <?= json_encode(array_values($status_data)) ?>,
            backgroundColor: ['#007bff','#ffc107','#28a745','#17a2b8','#6c757d']
        }]
    }
});

const priorityCtx = document.getElementById('priorityChart').getContext('2d');
new Chart(priorityCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_keys($priority_data)) ?>,
        datasets: [{
            label: 'Tickets by Priority',
            data: <?= json_encode(array_values($priority_data)) ?>,
            backgroundColor: ['#28a745','#ffc107','#dc3545']
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});


const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_keys($category_data)) ?>,
        datasets: [{
            label: 'Tickets by Category',
            data: <?= json_encode(array_values($category_data)) ?>,
            backgroundColor: ['#007bff','#ffc107','#28a745','#17a2b8']
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
</body>
</html>
