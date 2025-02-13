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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="css/slidepanel.css">
    <link rel="stylesheet" href="css/Dboard.css">
</head>

<body>
    <div>
        <div class="flex flex-row justify-start items-center bg-pink-300 p-3 scroll">
            <img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px">
        </div>
    </div>
    <ul class="flex flex-col gap-7 w-1/5 h-svh bg-gray-200 p-5 shadow-xl">
        <li class="hover:bg-pink-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel active">
            <img src="assets/dashboard.png" alt="add"><a href="dashboard.php">Dashboard</a>
        </li>
        <li class="hover:bg-pink-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/add.png" alt="add"><a href="addPatient.php">Add client</a>
        </li>
        <li class="hover:bg-pink-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/onlineforms.png" alt="add">
            <a href="#">Online forms</a>
        </li>
        <li class="hover:bg-pink-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/useraccount.png" alt="add">
            <a href="#">User account</a>
        </li>
        <li class="hover:bg-pink-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/reports.png" alt="add">
            <a href="#">Reports</a>
        </li>
        <li class="hover:bg-pink-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/med.png" alt="add">
            <a href="#">Upload med inventory</a>
        </li>
        <li class="hover:bg-pink-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/settings.png" alt="add">
            <a href="#">Settings</a>
        </li>
        <li class="hover:bg-pink-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/logout.png" alt="add">
            <a href="#">Logout</a>
        </li>
    </ul>
    <div class="dashboard">
        <div class="card approval">
            <h2>For Approval</h2>
            <p><?php echo $dashboard_data['for_approval']; ?></p>
        </div>
        <div class="card processing">
            <h2>For Processing</h2>
            <p><?php echo $dashboard_data['for_processing']; ?></p>
        </div>
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
    <!-- dashaboard end -->
</body>

</html>