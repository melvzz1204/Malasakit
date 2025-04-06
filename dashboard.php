<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="css/Dboard.css">
    <link rel="stylesheet" href="css/slidepanel.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<?php

include_once('conn/conn.php');

// Fetch data for the dashboard
function fetch_dashboard_data($conn)
{
    $data = [];

    // Count transactions by status
    $statuses = ['for_approval', 'for_processing', 'pending', 'released'];
    foreach ($statuses as $status) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM transactions WHERE status = :status");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $result = $stmt->fetch();
        $data[$status] = $result['count'];
    }

    // Calculate total budget
    $stmt = $conn->prepare("SELECT SUM(amount) AS total_budget FROM transactions");
    $stmt->execute();
    $result = $stmt->fetch();
    $data['total_budget'] = $result['total_budget'] ?? 0;

    return $data;
}

// Fetch dashboard data
$dashboard_data = fetch_dashboard_data($conn);

?>

<body class="bg-gray-100">

    <div>
        <div class="flex flex-row justify-start items-center bg-violet-300 p-3 scroll">
            <img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px">
        </div>
    </div>
    <ul id="hideSlide"
        class="fixed left-0 z-[100] h-screen bg-violet-200 p-6 shadow-2xl flex flex-col gap-6 transition-transform duration-300 ease-in-out" style=" top: 100px; width: 20%; z-index: -1;">

        <li class=" flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition active">
            <img src="assets/dashboard.png" alt="Dashboard" class="w-5 h-5" />
            <a href="Dashboard.php" class="text-sm font-medium text-gray-800 ">Dashboard</a>
        </li>
        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300">
            <img src="assets/add.png" alt="Add Client" class="w-5 h-5" />
            <a href="addPatient.php" class="text-sm font-medium text-gray-800">Add Client</a>
        </li>

        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
            <img src="assets/onlineforms.png" alt="Online Forms" class="w-5 h-5" />
            <a href="onlineforms.php" class="text-sm font-medium text-gray-800">Online Forms</a>
        </li>

        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
            <img src="assets/useraccount.png" alt="User Account" class="w-5 h-5" />
            <a href="#" class="text-sm font-medium text-gray-800">User Account</a>
        </li>

        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
            <img src="assets/reports.png" alt="Reports" class="w-5 h-5" />
            <a href="#" class="text-sm font-medium text-gray-800">Reports</a>
        </li>

        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
            <img src="assets/med.png" alt="Upload Med Inventory" class="w-5 h-5" />
            <a href="uploadMed.php" class="text-sm font-medium text-gray-800">Upload Med Inventory</a>
        </li>

        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
            <img src="assets/settings.png" alt="Settings" class="w-5 h-5" />
            <a href="#" class="text-sm font-medium text-gray-800">Settings</a>
        </li>

        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-red-300 transition mt-auto">
            <img src="assets/logout.png" alt="Logout" class="w-5 h-5" />
            <a href="#" class="text-sm font-medium text-gray-800">Logout</a>
        </li>

    </ul>
    <div class="dashboard">
        <div class="card pending">
            <h2>Pending</h2>
            <p><?php echo $dashboard_data['pending']; ?></p>
        </div>
        <div class="card released">
            <h2>Released</h2>
            <p><?php echo $dashboard_data['released']; ?></p>
        </div>
        <div class="card Tbudget">
            <h2>Total Budget</h2>
            <p><?php echo '₱' . number_format($dashboard_data['total_budget'], 2); ?></p>
        </div>
    </div>
    <!--   chart -->
    <div class="chart-container" style="width: 50%; margin: auto;">
        <canvas id="statusChart"></canvas>
    </div>
</body>
<script src="js/sidepanel.js"></script>
<style>
    .chart-container {
        position: absolute;
        top: 30%;
        left: 35%;
    }
</style>
<!-- chart script -->
<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['For Approval', 'For Processing', 'Pending', 'Released'],
            datasets: [{
                label: 'Transaction Status',
                data: [
                    <?php echo $dashboard_data['for_approval']; ?>,
                    <?php echo $dashboard_data['for_processing']; ?>,
                    <?php echo $dashboard_data['pending']; ?>,
                    <?php echo $dashboard_data['released']; ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</html>