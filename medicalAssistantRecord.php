<?php
include_once('conn/conn.php');

$id = $_GET['id'] ?? null;

if (!$id) {
    die("<p class='text-red-500 text-center'>Invalid patient ID.</p>");
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $new_status = $_POST['status'] ?? null;

    if ($new_status) {
        try {
            // Begin transaction
            $conn->beginTransaction();

            // Check if status exists
            $check_sql = "SELECT COUNT(*) FROM patient_status WHERE patient_id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->execute([$id]);
            $exists = $check_stmt->fetchColumn();

            if ($exists) {
                // Update existing status
                $update_sql = "UPDATE patient_status SET status = ? WHERE patient_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $success = $update_stmt->execute([$new_status, $id]);
            } else {
                // Insert new status
                $insert_sql = "INSERT INTO patient_status (patient_id, status) VALUES (?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $success = $insert_stmt->execute([$id, $new_status]);
            }

            if ($success) {
                $conn->commit();
                header("Location: medicalAssistantRecord.php?id=$id&success=1");
                exit;
            } else {
                throw new Exception("Failed to update status");
            }
        } catch (Exception $e) {
            $conn->rollBack();
            echo "<p class='text-red-500 text-center'>Error: " . $e->getMessage() . "</p>";
        }
    }
}

// Fetch current status
$status_sql = "SELECT status FROM patient_status WHERE patient_id = ?";
$status_stmt = $conn->prepare($status_sql);
$status_stmt->execute([$id]);
$current_status = $status_stmt->fetchColumn();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Assistant Record</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="css/slidepanel.css">
</head>

<body class="bg-gray-100">
    <div class="flex flex-row justify-start items-center bg-violet-300 p-3">
        <a href="dashboard.php"><img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px"></a>
    </div>
    <div class="mb-10 text-center flex flex-col items-center gap-6 mt-10">
        <ul class="ul-head flex justify-between items-center">
            <div class="flex gap-4">
                <li>
                    <button class="border border-violet-500 text-center px-4 py-2 rounded-lg hover:bg-violet-100 focus:ring-2 focus:ring-violet-500">
                        <span class="text-m text-violet-700 font-semibold"><a href="patientProfile.php?id=<?php echo htmlspecialchars($id); ?>">Patient Profile</a></span>
                    </button>
                </li>
                <li>
                    <button class="border border-violet-500 text-center px-4 py-2 rounded-lg hover:bg-violet-100 focus:ring-2 focus:ring-violet-500 active">
                        <span class="text-m text-violet-700 font-semibold"><a href="medicalAssistantRecord.php?id=<?php echo htmlspecialchars($id); ?>">Medical Assistant Record</a></span>
                    </button>
                </li>
                <li>
                    <button class="border border-violet-500 text-center px-4 py-2 rounded-lg hover:bg-violet-100 focus:ring-2 focus:ring-violet-500">
                        <span class="text-m text-violet-700 font-semibold">Patient Requirements</span>
                    </button>
                </li>
            </div>
        </ul>
    </div>
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-violet-800 mb-6">Patient Status</h1>
        <div class="bg-white shadow-lg rounded-lg p-6">
            <p><strong>Status:</strong> <span class="text-green-600 font-semibold"><?php echo htmlspecialchars($current_status ?? 'No status available'); ?></span></p>
        </div>
        <div class="mt-6 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-bold text-violet-800 mb-4">Edit Status</h2>
            <form method="POST" action="">
                <div class="flex items-center gap-4">
                    <label for="status" class="text-sm font-medium text-gray-700">New Status:</label>
                    <select name="status" id="status" class="bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 w-60 focus:ring-2 focus:ring-violet-500 focus:outline-none" required>
                        <option disabled selected value="">--Select Option--</option>
                        <option value="New" <?php echo $current_status === 'New' ? 'selected' : ''; ?>>New</option>
                        <option value="Released" <?php echo $current_status === 'Released' ? 'selected' : ''; ?>>Released</option>
                        <option value="Pending" <?php echo $current_status === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="For Referral" <?php echo $current_status === 'For Referral' ? 'selected' : ''; ?>>For Referral</option>
                    </select>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" name="update_status" class="px-6 py-2 bg-violet-700 text-white rounded-lg hover:bg-violet-600 text-sm transition shadow-md">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>