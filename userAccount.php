<?php
session_start();

// Initialize connection
$conn = new mysqli('localhost', 'root', '', 'malasakit');

// Create user_agents table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS user_agents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    agency VARCHAR(50) NOT NULL,
    role VARCHAR(20) DEFAULT 'user_agent',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($createTable);

// Add role column to existing table if it doesn't exist
$alterTable = "ALTER TABLE agent_account 
               ADD COLUMN IF NOT EXISTS role VARCHAR(20) NOT NULL DEFAULT 'user_agent'";
$conn->query($alterTable);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $agency = $_POST['agency'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'user_agent';

    // Check if username exists
    $check_sql = "SELECT username FROM agent_account WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param('s', $username);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Username already exists. Please choose a different username.';
    } else {
        // Insert new user
        $sql = "INSERT INTO agent_account (username, password, select_agency, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $username, $password, $agency, $role);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Account created successfully for: $username";
        } else {
            $_SESSION['error'] = "Error creating account: " . $stmt->error;
        }
        $stmt->close();
    }
    $check_stmt->close();

    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Display messages if they exist
if (isset($_SESSION['success'])) {
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="css/Dboard.css">
    <link rel="stylesheet" href="css/slidepanel.css">
    <title>Document</title>
</head>

<body>
    <div class="fixed flex flex-row justify-start items-center bg-violet-300 p-3 head-malasakit fr w-full" style="z-index: 5000;">
        <a href="dashboard.php"><img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px"></a>
    </div>

    <div class="openSideBar fixed left-0 z-[100] h-screen bg-violet-200 p-6 shadow-2xl flex flex-col gap-6 transition-transform duration-300 ease-in-out" id="openSideBar" style=" top: 100px; width: 20%; z-index: 1;">

        <ul class="flex flex-col gap-4">
            <li class=" flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
                <img src="assets/dashboard.png" alt="Dashboard" class="w-5 h-5" />
                <a href="Dashboard.php" class="text-sm font-medium text-gray-800">Dashboard</a>
            </li>
            <li class="flex items-center gap-4 p-3 rounded-lg bg-violet-300 transition">
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

            <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition mt-auto">
                <img src="assets/logout.png" alt="Logout" class="w-5 h-5" />
                <a href="logout.php" onclick="return confirm('Are you sure you want to logout?');" class="text-sm font-medium text-gray-800">Logout</a>
            </li>
        </ul>
    </div>

    <form id="createUserForm" method="POST" class="container px-4 py-10 absolute top-40 left-1/3 w-1/2">
        <div class="bg-white rounded-lg shadow-lg flex flex-col items-center p-6">
            <h1 class="text-2xl font-bold text-violet-800 mb-6">Create User Agent Account</h1>

            <!-- Agency Selection -->
            <div class="w-full max-w-md mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Agency
                </label>
                <select
                    name="agency"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-violet-500">
                    <option value="" disabled selected>Select an agency</option>
                    <option value="DSWD">DSWD</option>
                    <option value="Philhealth">Philhealth</option>
                    <option value="PCSO">PCSO</option>
                </select>
            </div>

            <!-- Username -->
            <div class="w-full max-w-md mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Username
                </label>
                <input
                    type="text"
                    name="username"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-violet-500" />
            </div>

            <!-- Password -->
            <div class="w-full max-w-md mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-violet-500" />
            </div>

            <!-- Role Selection -->
            <div class="w-full max-w-md mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Role
                </label>
                <select
                    name="role"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-violet-500">
                    <option value="disable">Select role</option>
                    <option value="user_agent">User Agent</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-violet-600 text-white px-6 py-2 rounded-lg hover:bg-violet-700">
                Create Account
            </button>
        </div>
    </form>

    <!-- Add a table to show existing users -->
    <div class="container px-4 py-10 absolute top-[600px] left-1/3 w-1/2 mt-40">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-violet-800 mb-4">Existing User Accounts</h2>
            <table class="min-w-full">
                <thead class="bg-violet-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Username</th>
                        <th class="py-2 px-4 text-left">Agency</th>
                        <th class="py-2 px-4 text-left">Role</th>
                        <th class="py-2 px-4 text-left">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $list_sql = "SELECT username, select_agency, role, created_at FROM agent_account ORDER BY created_at DESC";
                    $list_result = $conn->query($list_sql);

                    while ($row = $list_result->fetch_assoc()) {
                        echo "<tr class='hover:bg-gray-50'>";
                        echo "<td class='py-2 px-4'>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td class='py-2 px-4'>" . htmlspecialchars($row['select_agency']) . "</td>";
                        echo "<td class='py-2 px-4'>" . htmlspecialchars($row['role']) . "</td>";
                        echo "<td class='py-2 px-4'>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>

</html>