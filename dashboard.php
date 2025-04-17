<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include_once('conn/conn.php');
?>

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

<body class="bg-gray-100">
    <?php if (isset($_SESSION['welcome_message'])): ?>
        <div id="welcome-message" class="fixed top-0 left-0 w-full bg-green-100 text-green-700 px-4 py-3 text-center">
            <?php
            echo $_SESSION['welcome_message'];
            unset($_SESSION['welcome_message']); // Clear the message after displaying
            ?>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('welcome-message').style.display = 'none';
            }, 3000); // Hide after 3 seconds
        </script>
    <?php endif; ?>


    <?php
    // Fetch the count of each status
    $status_count_sql = "SELECT status, COUNT(*) as count FROM patient_status GROUP BY status";
    $status_count_stmt = $conn->prepare($status_count_sql);
    $status_count_stmt->execute();
    $status_counts = $status_count_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize counts for each status
    $status_data = [
        'New' => 0,
        'Released' => 0,
        'Pending' => 0,
        'For Referral' => 0
    ];

    // Map the fetched counts to the corresponding statuses
    foreach ($status_counts as $status_count) {
        $status = $status_count['status'];
        $count = $status_count['count'];
        if (array_key_exists($status, $status_data)) {
            $status_data[$status] = $count;
        }
    }
    ?>


    <?php
    // Fetch the count of each agency
    $agency_count_sql = "SELECT select_agency, COUNT(*) as count FROM agent_account GROUP BY select_agency";
    $agency_count_stmt = $conn->prepare($agency_count_sql);
    $agency_count_stmt->execute();
    $agency_counts = $agency_count_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize counts for each agency
    $agency_data = [
        'Philhealth' => 0,
        'DSWD' => 0,
        'PCSO' => 0
    ];

    // Map the fetched counts to the corresponding agencies
    foreach ($agency_counts as $agency_count) {
        $agency = $agency_count['select_agency'];
        $count = $agency_count['count'];
        if (array_key_exists($agency, $agency_data)) {
            $agency_data[$agency] = $count;
        }
    }
    ?>

    <div class="flex flex-row justify-between items-center bg-violet-300 p-3 fixed w-full" style="z-index: 100;">
        <img src="assets/malasakit_logo.png" alt="Logo" style="width: 100px; margin-left:50px">
        <h1 class="text-m text-gray-800 center mr-10">Welcome, <?php echo ucfirst($_SESSION['username']); ?>!</h1>
    </div>
    <div class="container mt-14 absolute top-20 left-1/4 w-3/4">
        <div class="flex flex-row gap-4">
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-md w-60">
                <h2 class="text-l font-bold">New</h2>
                <p class="text-xl font-semibold"><?php echo $status_data['New']; ?></p>
            </div>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md w-60">
                <h2 class="text-l font-bold">Released</h2>
                <p class="text-xl font-semibold"><?php echo $status_data['Released']; ?></p>
            </div>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-md w-60">
                <h2 class="text-l font-bold">Pending</h2>
                <p class="text-xl font-semibold"><?php echo $status_data['Pending']; ?></p>
            </div>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md w-60">
                <h2 class="text-l font-bold">Referral</h2>
                <p class="text-xl font-semibold"><?php echo $status_data['For Referral']; ?></p>
            </div>
        </div>
    </div>
    <div class="container mt-5 absolute top-1/3 left-1/4 w-1/2">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Agency Distribution</h2>
        <div class="w-80">
            <canvas id="agencyPieChart"></canvas>
        </div>
    </div>

    <ul id="hideSlide" class="fixed left-0 z-[100] h-screen bg-violet-200 p-6 shadow-2xl flex flex-col gap-6 transition-transform duration-300 ease-in-out" style=" top: 110px; width: 20%; z-index: -1;">

        <li class=" flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition active">
            <img src="assets/dashboard.png" alt="Dashboard" class="w-5 h-5" />
            <a href="dashboard.php" class="text-sm font-medium text-gray-800 ">Dashboard</a>
        </li>
        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300">
            <img src="assets/add.png" alt="Add Client" class="w-5 h-5" />
            <a href="addPatient.php" class="text-sm font-medium text-gray-800">Add Client</a>
        </li>

        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
            <img src="assets/onlineforms.png" alt="Online Forms" class="w-5 h-5" />
            <a href="#" class="text-sm font-medium text-gray-800">Online Forms</a>
        </li>

        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
                <img src="assets/useraccount.png" alt="User Account" class="w-5 h-5" />
                <a href="userAccount.php" class="text-sm font-medium text-gray-800">User Account</a>
            </li>
        <?php endif; ?>

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
        <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition mt-10">
            <img src="assets/logout.png" alt="Logout" class="w-5 h-5" />
            <a href="logout.php" onclick="return confirm('Are you sure you want to logout?');" class="text-sm font-medium text-gray-800">Logout</a>
        </li>

    </ul>


    <script>
        const ctx = document.getElementById('agencyPieChart').getContext('2d');
        const agencyPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Philhealth', 'DSWD', 'PCSO'],
                datasets: [{
                    label: 'Agency Distribution',
                    data: [
                        <?php echo $agency_data['Philhealth']; ?>,
                        <?php echo $agency_data['DSWD']; ?>,
                        <?php echo $agency_data['PCSO']; ?>
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)', // Blue for Philhealth
                        'rgba(255, 206, 86, 0.6)', // Yellow for DSWD
                        'rgba(75, 192, 192, 0.6)' // Green for PCSO
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
</body>
<script src="js/sidepanel.js"></script>

</html>