<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="css/slidepanel.css">
    <link rel="stylesheet" href="css/addpatient.css">
    <link rel="stylesheet" href="css/slidepanel.css">
</head>
<script>
    function validateContactNumber() {
        var contactNumber = document.getElementById('contact_number').value;
        if (contactNumber.length < 11) {
            alert('Contact number must be 11 digits');
            contactNumberInput.style.border = '2px solid red';
            return false;
        }
        contactNumberInput.style.border = '3px solid red';
        return true;
    }

    function showSuccessMessage() {
        var successMessage = document.getElementById('success-message');
        successMessage.style.display = 'block';
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 2000);
    }

    function showMessageErr() {
        var successMessageErr = document.getElementById('error-message');
        successMessageErr.style.display = 'block';
        setTimeout(function() {
            successMessageErr.style.display = 'none';
        }, 2000);
    }

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
        integerPart = integerPart.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Combine the integer and decimal parts
        value = integerPart + decimalPart;

        // Update the input value
        input.value = value;
    }
</script>

<style>
    #success-message {
        display: none;
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
        position: absolute;
        width: 100%;
        text-align: center;
        top: 0;
        left: 0;
        z-index: 1000;

    }

    #error-message {
        display: none;
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        position: absolute;
        width: 100%;
        top: 0;
        left: 0;
        text-align: center;
        z-index: 1000;

    }

    .head {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }
</style>


<body>
    <div class="flex flex-row justify-start items-center bg-violet-300 p-3 head">
        <div>
            <img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px">
        </div>
        <div class="absolute right-20">
            <a href="clientList.php">
                <button
                    class="bg-violet-500 hover:bg-violet-600 text-white font-semibold py-2 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ease-in-out">
                    View Client List
                </button>
            </a>
        </div>

    </div>
    <div class="btnSlide">
        <img src="assets/rightbtn.png" alt="" class="w-8 h-12 opacity-30 hover:opacity-100 cursor-pointer " id="btnSlide">
    </div>
    <ul id="hideSlide"
        class="fixed left-0 z-[100] h-screen bg-violet-200 p-6 shadow-2xl flex flex-col gap-6 transition-transform duration-300 ease-in-out" style=" top: 100px; width: 20%;">

        <li class=" flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
            <img src="assets/dashboard.png" alt="Dashboard" class="w-5 h-5" />
            <a href="dashboard.php" class="text-sm font-medium text-gray-800">Dashboard</a>
        </li>

        <li class="flex items-center gap-4 p-3 rounded-lg bg-violet-300 ">
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

    <div id="success-message">
        <span>New record created successfully!</span>
    </div>
    <div id="error-message">
        <span>Patient already exist!</span>
    </div>
    <div class="max-w-6xl m-auto p-6 bg-white rounded-xl shadow-md mt-20 z-index -2 ml-80">
        <h2 class="text-3xl font-semibold mb-6 text-violet-600">Client Information Sheet</h2>
        <form method="POST" action="addPatient.php" onsubmit="return validateContactNumber()" class="space-y-8">

            <!-- Name Fields -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block mb-1 font-medium">First Name</label>
                    <input type="text" name="first_name" required class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-violet-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Last Name</label>
                    <input type="text" name="last_name" required class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-violet-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Middle Name</label>
                    <input type="text" name="middle_nam" required class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-violet-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Name Extension</label>
                    <select name="name_extension" class="w-full border rounded-lg p-2 bg-gray-100">
                        <option value="None">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                    </select>
                </div>
            </div>

            <!-- Contact and Address -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="w-full border rounded-lg p-2" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Patient Address</label>
                    <input type="text" name="address" required class="w-full border rounded-lg p-2" />
                </div>
            </div>

            <!-- Birth, Age, Sex -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" onchange="calculateAge()" class="w-full border rounded-lg p-2" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Age</label>
                    <input type="text" name="age" id="age" readonly class="w-full border rounded-lg p-2 bg-gray-100" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Sex</label>
                    <select name="sex" class="w-full border rounded-lg p-2 bg-gray-100">
                        <option disabled selected>--Select Option--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>

            <!-- Civil Status & Birthplace -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Civil Status</label>
                    <select name="civil_status" class="w-full border rounded-lg p-2 bg-gray-100">
                        <option disabled selected>--Select Option--</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widow">Widow</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Place of Birth</label>
                    <input type="text" name="place_of_birth" required class="w-full border rounded-lg p-2" />
                </div>
            </div>

            <!-- Religion & Education -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Religion</label>
                    <input type="text" name="religion" class="w-full border rounded-lg p-2" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Educational Attainment</label>
                    <select name="educational_attainment" class="w-full border rounded-lg p-2 bg-gray-100">
                        <option disabled selected>--Select Option--</option>
                        <option>Elementary Under Graduate</option>
                        <option>Elementary Graduate</option>
                        <option>High School Under Graduate</option>
                        <option>High School Graduate</option>
                        <option>College Under Graduate</option>
                        <option>College Graduate</option>
                    </select>
                </div>
            </div>

            <!-- Occupation and Employment Status -->
            <div class="space-y-4">
                <div>
                    <label class="block mb-1 font-medium">Occupation</label>
                    <input type="text" name="occupation" class="w-full border rounded-lg p-2" />
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Employment Status</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        <label><input type="checkbox" name="employment_status[]" value="Regular" /> Regular</label>
                        <label><input type="checkbox" name="employment_status[]" value="Job order" /> Job order</label>
                        <label><input type="checkbox" name="employment_status[]" value="Contractual" /> Contractual</label>
                        <label><input type="checkbox" name="employment_status[]" value="Part-time" /> Part-time</label>
                        <label><input type="checkbox" name="employment_status[]" value="On call" /> On call</label>
                        <label><input type="checkbox" name="employment_status[]" value="Private employee" /> Private employee</label>
                        <label><input type="checkbox" name="employment_status[]" value="Government employee" /> Government employee</label>
                        <label><input type="checkbox" name="employment_status[]" value="Self employed" /> Self employed</label>
                    </div>
                </div>
            </div>

            <!-- Income -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Daily Income</label>
                    <input type="text" name="daily_income" id="daily_income" required class="w-full border rounded-lg p-2" onkeyup="formatNumber(this)" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Monthly Income</label>
                    <input type="text" name="monthly_income" id="monthly_income" required class="w-full border rounded-lg p-2" onkeyup="formatNumber(this)" />
                </div>
            </div>

            <!-- Sectoral Membership -->
            <div>
                <label class="block mb-2 font-semibold">Other Sectoral Membership</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    <label><input type="checkbox" name="sectoral_membership[]" value="PWD" /> PWD</label>
                    <label><input type="checkbox" name="sectoral_membership[]" value="Gov employee" /> Gov employee</label>
                    <label><input type="checkbox" name="sectoral_membership[]" value="Brgy. official" /> Brgy. official</label>
                    <label><input type="checkbox" name="sectoral_membership[]" value="Solo parent" /> Solo parent</label>
                    <label class="col-span-2 md:col-span-1">
                        <span>Others:</span>
                        <input type="text" name="sectoral_membership[]" class="w-full border rounded-lg p-2 mt-1" />
                    </label>
                </div>
            </div>

            <!-- Companion Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Companion Name</label>
                    <input type="text" name="companion_name" class="w-full border rounded-lg p-2" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Companion Address</label>
                    <input type="text" name="companion_address" class="w-full border rounded-lg p-2" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Companion Contact No.</label>
                    <input type="text" name="companion_contact" class="w-full border rounded-lg p-2" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Date of Admission/Consultation</label>
                    <input type="date" name="admission_date" class="w-full border rounded-lg p-2" />
                </div>
            </div>

            <!-- Diagnosis -->
            <div>
                <label class="block mb-1 font-medium">Patient Diagnosis</label>
                <textarea name="diagnosis" rows="4" class="w-full border rounded-lg p-2"></textarea>
            </div>

            <!-- Submit -->
            <div class="text-right">
                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                    Submit
                </button>
            </div>
        </form>
    </div>


    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $middle_name = $_POST['middle_name'];
        $name_extension = $_POST['name_extension'];
        $contact_number = $_POST['contact_number'];
        $address = $_POST['address'];
        $date_of_birth = $_POST['date_of_birth'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $civil_status = $_POST['civil_status'];
        $place_of_birth = $_POST['place_of_birth'];
        $religion = $_POST['religion'];
        $educational_attainment = $_POST['educational_attainment'];
        $occupation = $_POST['occupation'];
        $employment_status = isset($_POST['employment_status']) ? implode(", ", $_POST['employment_status']) : "";
        $daily_income = str_replace(',', '', $_POST['daily_income']);
        $monthly_income = str_replace(',', '', $_POST['monthly_income']);
        $sectoral_membership = isset($_POST['sectoral_membership']) ? implode(", ", $_POST['sectoral_membership']) : "";
        $companion_name = $_POST['companion_name'];
        $companion_address = $_POST['companion_address'];
        $companion_contact = $_POST['companion_contact'];
        $admission_date = $_POST['admission_date'];
        $diagnosis = $_POST['diagnosis'];
        $date_registered = date("Y-m-d");

        // Calculate age
        $birthDate = new DateTime($date_of_birth);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;

        $conn = new mysqli("localhost", "root", "", "malasakit");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if patient already exists
        $check_sql = "SELECT * FROM patients WHERE first_name='$first_name' AND last_name='$last_name' AND middle_name='$middle_name' AND date_of_birth='$date_of_birth'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo "<script>showMessageErr();</script>";
        } else {
            $sql = "INSERT INTO patients (first_name, last_name, middle_name, name_extension, contact_number, address, date_of_birth, age, sex, civil_status, place_of_birth, religion, educational_attainment, occupation, employment_status, daily_income, monthly_income, sectoral_membership, companion_name, companion_address, companion_contact, admission_date, diagnosis, date_registered) VALUES ('$first_name', '$last_name', '$middle_name', '$name_extension', '$contact_number', '$address', '$date_of_birth', '$age', '$sex', '$civil_status', '$place_of_birth', '$religion', '$educational_attainment', '$occupation', '$employment_status', '$daily_income', '$monthly_income', '$sectoral_membership', '$companion_name', '$companion_address', '$companion_contact', '$admission_date', '$diagnosis', '$date_registered')";

            if ($conn->query($sql) === TRUE) {
                // Get the last inserted patient ID
                $patient_id = $conn->insert_id;

                // Insert initial status as "New"
                $status_sql = "INSERT INTO patient_status (patient_id, status) VALUES (?, 'New')";
                $status_stmt = $conn->prepare($status_sql);

                if ($status_stmt->execute([$patient_id])) {
                    echo "<script>showSuccessMessage();</script>";
                } else {
                    echo "Error setting initial status: " . $conn->error;
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
    }
    $employment_status = isset($_POST['employment_status']) ? implode(", ", $_POST['employment_status']) : "";
    $sectoral_membership = isset($_POST['sectoral_membership']) ? implode(", ", $_POST['sectoral_membership']) : "";

    ?>

</body>
<script src="js/script.js"></script>

</html>