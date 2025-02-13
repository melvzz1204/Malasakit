<?php
include_once('conn/conn.php');

$id = $_GET['id'] ?? null; // Get patient ID from URL if available
$sql = "SELECT * FROM patients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    echo "<p class='text-red-500 text-center'>Patient not found.</p>";
    exit;
}

// Handle Image Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["patient_image"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["patient_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "jpeg", "png", "gif"];

    if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES["patient_image"]["tmp_name"], $target_file)) {
        // Update database with image path
        $update_sql = "UPDATE patients SET image_path = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->execute([$target_file, $id]);

        // Refresh page to show new image
        header("Location: viewPatient.php?id=$id");
        exit;
    } else {
        $error_message = "Image upload failed. Please choose a file";
    }
}
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="css/slidepanel.css">
    <link rel="stylesheet" href="css/addpatient.css">
</head>
<script>
    // Function to hide the error message after 1 second
    function hideErrorMessage() {
        setTimeout(function() {
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 1000); // 1000 ms = 1 second
    }
</script>

<body>
    <div class="flex flex-row justify-start items-center bg-pink-300 p-3">
        <img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px">
    </div>
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6 relative">
        <h1 class="text-2xl font-bold text-pink-700 mb-4">Client Details</h1>
        <!-- Image Upload Form -->
        <div class="mb-4 text-center mt-0 flex flex-col items-center gap-4">
            <?php if (!empty($patient['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($patient['image_path']); ?>" alt="Patient Image" class="w-32 h-32 object-cover rounded-full mx-auto">
            <?php else: ?>
                <p class="text-gray-500">No image uploaded.</p>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data" class="mt-2 flex flex-col items-center gap-4">
                <input type="file" name="patient_image" class="opacity-50 cursor-pointer ml-20">
                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-md hover:bg-pink-600 transition">Upload Image</button>
            </form>
        </div>
        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <p id="error-message" class="text-red-500 text-center bg-red-100 border border-red-500 rounded-lg p-2 mt-2 absolute top-32 right-0"><?php echo htmlspecialchars($error_message); ?></p>
            <script>
                hideErrorMessage();
            </script>
        <?php endif; ?>
        <a href="clientList.php" class="block text-center bg-pink-500 text-white p-1 mt-4 rounded-md hover:bg-pink-600 transition w-40">Back to List</a>
        <div class="grid grid-cols-2 gap-4">
            <?php
            foreach ($patient as $key => $value) {
                if ($key !== 'image_path') { // Exclude image path from details
                    echo "<div class='border-b py-2'><strong class='text-gray-700'>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong></div>";
                    echo "<div class='border-b py-2 text-gray-900'>" . htmlspecialchars($value) . "</div>";
                }
            }
            ?>
        </div>
    </div>

</body>

</html>