<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malasakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php

include_once('conn/conn.php');

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Ensure the default admin exists
function admin($conn)
{
    $username = 'admin';
    $password = 'admin'; // Default password (should be changed later)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the admin user already exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        // Insert the default admin user
        $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        echo "Default admin user created successfully!";
    }
}

// Ensure the default admin exists
admin($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    // Query for user with the given username
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        session_start();
        $_SESSION['user_role'] = $user['role']; // Assign role from database
        $_SESSION['username'] = $username;
        header("Location: Home.php");
        exit;
    } else {
        // Invalid login
        echo "<script language='javascript'>";
        echo "alert('Invalid username or password');";
        echo "window.location.href = 'index.php';"; // Redirect to login page
        echo "</script>";
        exit;
    }
}
?>

<body>
    <div class="flex flex-row justify-start items-center bg-pink-300 p-3 scroll">
        <img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px">
    </div>
    <form action="dashboard.php" method="POST" class="flex flex-column justify-center align-center ">
        <div class="w-1/3 mt-20 border-2 border-pink-100 p-10 ">
            <h1 class="text-2xl mb-10 ">Welcome, Please Log in</h1>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="******************" required>
                    <p class=" text-xs italic">Please choose a password.</p>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="submit">
                        Sign In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                        Forgot Password?
                    </a>
                </div>
            </form>
        </div>
    </form>
    </div>
</body>

</html>