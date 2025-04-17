<?php
session_start();
include_once('conn/conn.php');

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check admin table
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['user_role'] = 'admin';
        $_SESSION['username'] = $username;
        $_SESSION['welcome_message'] = "Welcome Administrator!";
        header("Location: dashboard.php");
        exit();
    }

    // Check agent_account table
    $stmt = $conn->prepare("SELECT * FROM agent_account WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $agent = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($agent && password_verify($password, $agent['password'])) {
        $_SESSION['user_role'] = 'agent';
        $_SESSION['username'] = $username;
        $_SESSION['agency'] = $agent['select_agency'];
        $_SESSION['welcome_message'] = "Welcome " . ucfirst($agent['select_agency']) . " Agent!";
        header("Location: dashboard.php");
        exit();
    }

    // Invalid login
    echo "<script>alert('Invalid username or password');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malasakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex flex-row justify-start items-center bg-violet-300 p-3">
        <a href="dashboard.php"><img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px"></a>
    </div>
    <form method="POST" class="flex flex-column justify-center align-center">
        <div class="w-1/3 mt-20 border-2 border-pink-100 p-10">
            <h2 class="text-2xl font-bold text-violet-800 mb-6 text-center">Login</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Username
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-violet-500"
                    id="username"
                    name="username"
                    type="text"
                    required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-violet-500"
                    id="password"
                    name="password"
                    type="password"
                    required>
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-violet-500 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit">
                    Sign In
                </button>
            </div>
        </div>
    </form>
</body>

</html>