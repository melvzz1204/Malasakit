<?php
include_once('conn/conn.php');

$id = $_GET['id'] ?? null; // Get patient ID from URL if available
$sql = "SELECT * FROM patients WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $success = $stmt->execute([$id]);
    if ($success) {
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "<p class='text-red-500 text-center'>Query execution failed.</p>";
        exit;
    }
} else {
    echo "<p class='text-red-500 text-center'>Prepare failed.</p>";
    exit;
}

if (!$patient) {
    echo "<p class='text-red-500 text-center'>Patient not found.</p>";
    exit;
}

// Handle Image Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["patient_image"])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
    }
    $target_file = $target_dir . basename($_FILES["patient_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "jpeg", "png", "gif"];

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["patient_image"]["tmp_name"]);
    if ($check === false) {
        $error_message = "File is not an image.";
    }

    // Check file size
    $max_file_size = 10000000; // 2MB
    if ($_FILES["patient_image"]["size"] > $max_file_size) {
        $error_message = "Sorry, your file is too large. Maximum file size is 2MB.";
    }

    // Allow certain file formats
    if (!in_array($imageFileType, $allowed_types)) {
        $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    if (empty($error_message)) {
        if (move_uploaded_file($_FILES["patient_image"]["tmp_name"], $target_file)) {
            // Update database with image path
            $update_sql = "UPDATE patients SET image_path = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->execute([$target_file, $id]);

            // Refresh page to show new image
            header("Location: viewPatient.php?id=$id");
            exit;
        } else {
            $error_message = "Sorry, there was an error uploading your file.";
        }
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
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
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

    // Function to toggle the visibility of patient details
    function togglePatientDetails() {
        const details = document.getElementById('patient-details');
        const toggleIcon = document.getElementById('toggle-icon');
        if (details.style.display === 'none') {
            details.style.display = 'grid';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            details.style.display = 'none';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        }
    }

    // Function to show/hide amount input based on status selection
    function toggleAmountInput() {
        const statusSelect = document.querySelector('.select-status');
        const amountInput = document.querySelector('.amount-inpt').parentElement;
        const reasonTextarea = document.querySelector('textarea').parentElement;

        statusSelect.addEventListener('change', function() {
            if (statusSelect.value === 'Released') {
                amountInput.style.display = 'block';
                reasonTextarea.style.display = 'none';
            } else if (statusSelect.value === 'Pending') {
                amountInput.style.display = 'none';
                reasonTextarea.style.display = 'block';
            } else {
                amountInput.style.display = 'none';
                reasonTextarea.style.display = 'none';
            }
        });
    }

    // Call the function on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleAmountInput();
    });
</script>

<body>
    <div class="flex flex-row justify-start items-center bg-violet-300 p-3">
        <a href="dashboard.php"><img src=" assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px"></a>
    </div>
    <style>
        .patientInfo {
            width: 100%;
            margin: auto;
            padding: 2rem;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }

        .status-container {
            display: flex;
            gap: 1rem;
            align-items: center;
            padding: 5px;
        }

        .select-status {
            outline: none;
            padding: 6px;
            width: 25%;
            border: 1px solid black;
            font-weight: 600;
            border-radius: 5px;
            color: black;
            cursor: pointer;
        }

        .ul-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .amount-inpt {
            outline: none;
            border: violet 1px solid;
            height: 2.3rem;
            text-align: center;
            padding: 5px
        }

        textarea {
            outline: none;
            border: 1px solid palevioletred;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            height: 100px;
            resize: vertical;
            font-size: 14px;
            font-family: Arial, sans-serif;
            color: #333;
        }

        textarea::placeholder {
            color: #aaa;
        }

        #error-message {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            text-align: center;
        }

        .active {
            background-color: #e5e7eb;
            color: #4b5563;
        }
    </style>
    <div class="patientInfo">
        <!-- Image Upload Form -->
        <div class="mb-10">
            <ul class="ul-head">
                <div class="flex gap-4">
                    <li>
                        <button class="border text-center p-2 mt-2 hover:border-violet-600 focus:border-violet-800 active">
                            <span class="text-1xl text-violet-700 mb-4">Patient Profile</span>
                        </button>
                    </li>
                    <li>
                        <button class="border text-center p-2 mt-2 hover:border-violet-600 focus:border-violet-800">
                            <span class="text-1xl text-violet-700 mb-4">Medical Assitant Record</span>
                        </button>
                    </li>
                    <li>
                        <button class="border text-center p-2 mt-2 hover:border-violet-600 focus:border-violet-800">
                            <span class="text-1xl text-violet-700 mb-4">Patient requirements</span>
                        </button>
                    </li>
                </div>
                <div>
                    <li>
                        <a href="clientList.php" class="p-2 w-30 block text-center bg-violet-700 text-white p-1 rounded-md hover:bg-violet-600 text-sm transition">Back to List</a>
                    </li>
                </div>
            </ul>
        </div>
        <div class="mb-10 text-center mt-0 flex flex-col items-center gap-4">
            <?php if (!empty($patient['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($patient['image_path']); ?>" alt="Patient Image" class="w-60 h-60 object-cover rounded mx-auto">
            <?php else: ?>
                <p class="text-gray-500">No image uploaded.</p>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data" class="flex flex-col items-center gap-4">
                <input type="file" name="patient_image" class="opacity-50 cursor-pointer ml-20 text-sm">
                <button type=" submit" class="bg-violet-500 text-white text-sm p-2 py-2 rounded-md hover:bg-violet-600 transition">Upload Image</button>
            </form>
        </div>
        <div class="pt-5 mb-10 status-container">
            <label for="">Status:</label>
            <select name="" id="" class="select-status">
                <option disabled selected value>--Select Option--</option>
                <option value="Released" class="status-option released">Released</option>
                <option value="Pending" class="status-option">Pending</option>
                <option value="For Approval" class="status-option">For referral</option>
            </select>
            <div style="display: none;">
                <label for="">Amount:</label>
                <input type="number" class="amount-inpt" placeholder="Enter Amount">
            </div>
            <div style="display: none;">
                <textarea name="" id="" placeholder="Reason of pending"></textarea>
            </div>
        </div>
        <div>
            <button class="p-2 w-30 block text-center bg-violet-700 text-white p-1 rounded-md hover:bg-violet-600 text-sm transition mb-10 w-20">Save</button>
        </div>

        <style>
            .amount-inpt {
                outline: none;
                border: violet 1px solid;
                height: 2.3rem;
                text-align: center;
                padding: 5px
            }
        </style>
        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <p id="error-message" class="text-red-500 text-center bg-red-100 border p-2"><?php echo htmlspecialchars($error_message); ?></p>
            <script></script>
            hideErrorMessage();
            </script>
        <?php endif; ?>

        <!-- Patient Details -->
        <div id="patient-details" class="grid grid-cols-2 gap-4 text-sm">
            <?php
            foreach ($patient as $key => $value) {
                if ($key !== 'image_path') { // Exclude image_path from details
                    echo "<div class='border-b py-2'><p class='text-gray-700 opacity-70'>" . ucfirst(str_replace('_', ' ', $key)) . ":</p></div>";
                    // Format daily_income and monthly_income with commas
                    if ($key == 'daily_income' || $key == 'monthly_income') {
                        echo "<div class='border-b py-2 font-medium '>" . number_format($value, 2) . "</div>";
                    } else {
                        echo "<div class='border-b py-2 font-medium '>" . htmlspecialchars($value) . "</div>";
                    }
                }
            }
            ?>
        </div>
    </div>

</body>

</html>