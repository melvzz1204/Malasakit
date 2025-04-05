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

// Handle form submission for updating patient data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_patient'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $civil_status = $_POST['civil_status'];
    $educational_attainment = $_POST['educational_attainment'];
    $daily_income = str_replace(',', '', $_POST['daily_income']); // Remove commas
    $monthly_income = str_replace(',', '', $_POST['monthly_income']); // Remove commas
    $occupation = $_POST['occupation']; // Ensure occupation is captured

    $update_sql = "UPDATE patients SET first_name = ?, last_name = ?, middle_name = ?, contact_number = ?, address = ?, date_of_birth = ?, age = ?, sex = ?, civil_status = ?, educational_attainment = ?, daily_income = ?, monthly_income = ?, occupation = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);

    if ($update_stmt->execute([$first_name, $last_name, $middle_name, $contact_number, $address, $date_of_birth, $age, $sex, $civil_status, $educational_attainment, $daily_income, $monthly_income, $occupation, $id])) {
        echo "<p class='text-green-500 text-center'>Patient data updated successfully.</p>";
        // Refresh the page to show updated data
        header("Location: viewPatient.php?id=$id");
        exit;
    } else {
        echo "<p class='text-red-500 text-center'>Failed to update patient data.</p>";
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
    <style>
        /* Ensure the modal is scrollable */
        #edit-modal {
            overflow-y: auto;
            max-height: 90vh;
            /* Limit modal height to 90% of the viewport */
        }

        #edit-modal .modal-content {
            max-height: 80vh;
            /* Limit content height */
            overflow-y: auto;
            /* Enable scrolling for the content */
        }
    </style>
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

    function formatNumber(input) {
        // Remove existing commas
        let value = input.value.replace(/,/g, '');

        // Allow only numbers and one decimal point
        value = value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');

        // Split the value into integer and decimal parts
        let parts = value.split('.');
        let integerPart = parts[0];
        let decimalPart = parts.length > 1 ? '.' + parts[1] : '';

        // Format the integer part with commas
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Combine the integer and decimal parts
        input.value = integerPart + decimalPart;
    }
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
    <div class="patientInfo bg-white p-6 rounded-lg shadow-lg">
        <!-- Navigation Buttons -->
        <div class="mb-10 text-center flex flex-col items-center gap-6">
            <ul class="ul-head flex justify-between items-center">
                <div class="flex gap-4">
                    <li>
                        <button class="border border-violet-500 text-center px-4 py-2 rounded-lg hover:bg-violet-100 focus:ring-2 focus:ring-violet-500 active">
                            <span class="text-m text-violet-700 font-semibold">Patient Profile</span>
                        </button>
                    </li>
                    <li>
                        <button class="border border-violet-500 text-center px-4 py-2 rounded-lg hover:bg-violet-100 focus:ring-2 focus:ring-violet-500">
                            <span class="text-m text-violet-700 font-semibold">Medical Assistant Record</span>
                        </button>
                    </li>
                    <li>
                        <button class="border border-violet-500 text-center px-4 py-2 rounded-lg hover:bg-violet-100 focus:ring-2 focus:ring-violet-500">
                            <span class="text-m text-violet-700 font-semibold">Patient Requirements</span>
                        </button>
                    </li>
                </div
                    </ul>
        </div>

        <!-- Image Upload Section -->
        <div class="mb-10 text-center flex flex-col items-center gap-6">
            <?php if (!empty($patient['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($patient['image_path']); ?>" alt="Patient Image" class="w-60 h-60 object-cover rounded-full shadow-md">
            <?php else: ?>
                <p class="text-gray-500 italic">No image uploaded.</p>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data" class="flex flex-col items-center gap-4">
                <input type="file" name="patient_image" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                <button type="submit" class="bg-violet-500 text-white px-6 py-2 rounded-lg hover:bg-violet-600 transition shadow-md">
                    Upload Image
                </button>
            </form>
        </div>

        <!-- Status Section -->
        <div class="pt-5 mb-10 status-container flex flex-col gap-4">
            <div class="flex items-center gap-4">
                <label for="status" class="text-sm font-medium text-gray-700">Status:</label>
                <select name="status" id="status" class="bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 w-60 focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    <option disabled selected value>--Select Option--</option>
                    <option value="Released" class="status-option released">Released</option>
                    <option value="Pending" class="status-option">Pending</option>
                    <option value="For Approval" class="status-option">For referral</option>
                </select>
            </div>
            <div class="flex flex-col gap-4">
                <div style="display: none;" class="amount-container">
                    <label for="amount" class="text-sm font-medium text-gray-700">Amount:</label>
                    <input type="number" id="amount" class="amount-inpt bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-violet-500 focus:outline-none" placeholder="Enter Amount">
                </div>
                <div style="display: none;" class="reason-container">
                    <label for="reason" class="text-sm font-medium text-gray-700">Reason:</label>
                    <textarea id="reason" class="bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-violet-500 focus:outline-none" placeholder="Reason for pending"></textarea>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="text-center">
            <button class="px-6 py-2 bg-violet-700 text-white rounded-lg hover:bg-violet-600 text-sm transition shadow-md">
                Save
            </button>
        </div>
    </div>

    <!-- Error Message -->
    <?php if (isset($error_message)): ?>
        <p id="error-message" class="text-red-500 text-center bg-red-100 border p-2"><?php echo htmlspecialchars($error_message); ?></p>
        <script></script>
        hideErrorMessage();
        </script>
    <?php endif; ?>

    <!-- Patient Details -->
    <div id="patient-details" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm bg-white p-6 rounded-lg shadow-md">
        <?php
        foreach ($patient as $key => $value) {
            if ($key !== 'image_path' && $key !== 'id' && $key !== 'created_at') { // Exclude image_path, id, and created_at from details
                echo "<div class='flex flex-col bg-gray-50 p-4 rounded-sm shadow-sm'>";
                echo "<p class='text-xs font-semibold text-gray-500 uppercase tracking-wide'>" . ucfirst(str_replace('_', ' ', $key)) . "</p>";
                // Format daily_income and monthly_income with commas
                if ($key == 'daily_income' || $key == 'monthly_income') {
                    echo "<p class='text-sm font-medium text-gray-800'>" . number_format((float)$value, 2) . "</p>";
                } else {
                    echo "<p class='text-sm font-medium text-gray-800'>" . htmlspecialchars($value) . "</p>";
                }
                echo "</div>";
            }
        }
        ?>
        <div class="mt-10">
            <button id="edit-profile-btn" class="bg-gradient-to-r from-violet-500 to-indigo-500 text-white px-6 py-3 rounded-lg shadow-lg hover:from-violet-600 hover:to-indigo-600 transition-all duration-300 transform focus:outline-none focus:ring-2 focus:ring-violet-400 focus:ring-offset-2">
                Edit Profile
            </button>
        </div>
    </div>


    <!-- Modal -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-3/4 max-w-3xl modal-content">
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-xl font-bold text-violet-800">Edit Patient Details</h2>
                <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($patient['first_name']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($patient['last_name']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name" value="<?php echo htmlspecialchars($patient['middle_name']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($patient['contact_number']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($patient['address']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Occupation</label>
                        <?php $Occupation = $patient['occupation'] ?? 'Not specified'; ?>
                        <input type="text" name="occupation" id="occupation" value="<?php echo htmlspecialchars($Occupation); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo htmlspecialchars($patient['date_of_birth']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                        <input type="text" name="age" id="age" value="<?php echo htmlspecialchars($patient['age']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none" readonly>
                    </div>
                    <div>
                        <label for="sex" class="block text-sm font-medium text-gray-700 mb-2">Sex</label>
                        <select name="sex" id="sex" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                            <option value="Male" <?php echo $patient['sex'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $patient['sex'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="civil_status" class="block text-sm font-medium text-gray-700 mb-2">Civil Status</label>
                        <select name="civil_status" id="civil_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                            <option value="Single" <?php echo $patient['civil_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                            <option value="Married" <?php echo $patient['civil_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                            <option value="Widow" <?php echo $patient['civil_status'] == 'Widow' ? 'selected' : ''; ?>>Widow</option>
                        </select>
                    </div>
                    <div>
                        <label for="educational_attainment" class="block text-sm font-medium text-gray-700 mb-2">Educational Attainment</label>
                        <select name="educational_attainment" id="educational_attainment" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                            <option disabled value>--Select Option--</option>
                            <option value="Elementary Under Graduate" <?php echo $patient['educational_attainment'] == 'Elementary Under Graduate' ? 'selected' : ''; ?>>Elementary Under Graduate</option>
                            <option value="Elementary Graduate" <?php echo $patient['educational_attainment'] == 'Elementary Graduate' ? 'selected' : ''; ?>>Elementary Graduate</option>
                            <option value="High School Under graduate" <?php echo $patient['educational_attainment'] == 'High School Under graduate' ? 'selected' : ''; ?>>High School Under graduate</option>
                            <option value="High School Graduate" <?php echo $patient['educational_attainment'] == 'High School Graduate' ? 'selected' : ''; ?>>High School Graduate</option>
                            <option value="College under Graduate" <?php echo $patient['educational_attainment'] == 'College under Graduate' ? 'selected' : ''; ?>>College under Graduate</option>
                            <option value="College Graduate" <?php echo $patient['educational_attainment'] == 'College Graduate' ? 'selected' : ''; ?>>College Graduate</option>
                        </select>
                    </div>
                    <div>
                        <label for="daily_income" class="block text-sm font-medium text-gray-700 mb-2">Daily Income</label>
                        <input type="text" name="daily_income" id="daily_income" value="<?php echo number_format((float)$patient['daily_income'], 2); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none" onkeyup="formatNumber(this)">
                    </div>
                    <div>
                        <label for="monthly_income" class="block text-sm font-medium text-gray-700 mb-2">Monthly Income</label>
                        <input type="text" name="monthly_income" id="monthly_income" value="<?php echo number_format((float)$patient['monthly_income'], 2); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none" onkeyup="formatNumber(this)">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <button type="submit" name="update_patient" class="bg-violet-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-500">Update</button>
                    <button type="button" id="cancel-modal-btn" class="text-gray-500 hover:text-gray-700 px-6 py-2 rounded-lg border border-gray-300 shadow-md">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const editProfileBtn = document.getElementById('edit-profile-btn');
        const editModal = document.getElementById('edit-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelModalBtn = document.getElementById('cancel-modal-btn');

        editProfileBtn.addEventListener('click', () => {
            editModal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            editModal.classList.add('hidden');
        });

        cancelModalBtn.addEventListener('click', () => {
            editModal.classList.add('hidden');
        });
    </script>

</body>

</html>