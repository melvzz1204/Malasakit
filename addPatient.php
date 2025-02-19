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
</script>

<body>
    <div class="flex flex-row justify-start items-center bg-pink-300 p-3 head-malasakit">
        <img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px">
    </div>
    <div class="btn-viewClientList">
        <a href="clientList.php"><button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 border border-pink-700 rounded">View Client List</button></a>
    </div>
    <ul class="flex flex-col gap-7 w-1/5 h-svh bg-gray-200 p-5 shadow-xl left-dashboard">
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/dashboard.png" alt="add"><a href="Dashboard.php">Dashboard</a>
        </li>
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel active">
            <img src="assets/add.png" alt="add"><a href="addPatient.php">Add client</a>
        </li>
        <!--  others -->
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/onlineforms.png" alt="add">
            <a href="onlineforms.php">Online forms</a>
        </li>
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/useraccount.png" alt="add">
            <a href="#">User account</a>
        </li>
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/reports.png" alt="add">
            <a href="#">Reports</a>
        </li>
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/med.png" alt="add">
            <a href="#">Upload med inventory</a>
        </li>
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/settings.png" alt="add">
            <a href="#">Settings</a>
        </li>
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/logout.png" alt="add">
            <a href="#">Logout</a>
        </li>
        <!--  others -->
    </ul>
    <!-- Page 1 start-->
    <div class="addpatient-container">
        <span class="text-2xl text-start ml-6 mb-6">CLIENT INFORMATION SHEET</span>
        <div id="success-message" class="success-message">
            <span>New record created successfully!</span>
        </div>
        <div id="error-message" class="error-message">
            <span>Patient already exist!</span>
        </div>
        <div class="addpatient-inputs content contentActive">
            <form method="POST" action="addPatient.php" onsubmit="return validateContactNumber()">
                <label for="" class="ml-6">First name:</label>
                <input type="text" class="ml-1" name="first_name">
                <label for="" class="ml-6">Last name:</label>
                <input type="text" class="ml-1" name="last_name">
                <label for="" class="ml-6">Middle name:</label>
                <input type="text" class="ml-1" name="middle_name">
                <label for="" class="ml-6">Name extension:</label>
                <select name="name_extension" id="" class="bg-gray-200  p-2 outline-none">
                    <option value="Jr.">None</option>
                    <option value="Jr.">Jr.</option>
                    <option value="Sr.">Sr.</option>
                </select>
                <div class="mt-8">
                    <label for="" class="ml-6">Contact number:</label>
                    <input type="text" class="ml-1" name="contact_number" id="contact_number">
                    <label for="" class="ml-6">Patient Address:</label>
                    <input type="text" class="ml-1 w-1/6" name="address">
                </div>
                <div class="mt-8 main-option">
                    <div>
                        <label for="" class="ml-6">Date of Birth:</label>
                        <input type="date" class="ml-2 w-40" name="date_of_birth" id="date_of_birth" onchange="calculateAge()">
                        <label for="" class="ml-6">Age:</label>
                        <input type="text" class="ml-1 w-10" name="age" id="age" readonly>
                    </div>
                    <div>
                        <label for="" class="ml-6">Sex:</label>
                        <select name="sex" id="" class="bg-gray-200 rounded p-2 outline-none">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="" class="ml-6">Civil Status:</label>
                        <select name="civil_status" id="" class="bg-gray-200 rounded p-2 outline-none">
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widow">Widow</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="" class="ml-6">Place of Birth:</label>
                        <input type="text" class="ml-2 w-60" name="place_of_birth">
                    </div>
                </div>
                <div class="mt-8">
                    <label for="" class="ml-6">Religion:</label>
                    <input type="text" class="ml-2" name="religion">
                    <label for="" class="ml-6">Educational Attainment:</label>
                    <select name="educational_attainment" id="" class="bg-gray-200 rounded p-2 outline-none">
                        <option value="Elementary Under Graduate">Elementary Under Graduate</option>
                        <option value="Elementary Graduate">Elementary Graduate</option>
                        <option value="High School Under graduate">High School Under graduate</option>
                        <option value="High School Graduate">High School Graduate</option>
                        <option value="High School Graduate">College under Graduate</option>
                        <option value="High School Graduate">College Graduate</option>
                    </select>
                </div>
                <div class="mt-8  p-3 ml-3 flex">
                    <div>
                        <label for="">Occupation of Patient:</label>
                        <input type="text" class="ml-2 w-3/2" name="occupation">
                    </div>
                    <div class="flex gap-10 ml-5 p-2">
                        <div class="flex flex-col gap-3">
                            <div class="flex gap-3 justify-between">
                                <label for="">Regular</label>
                                <input type="checkbox" name="employment_status[]" value="Regular">
                            </div>
                            <div class="flex gap-3 justify-between">
                                <label for="">Job order</label>
                                <input type="checkbox" name="employment_status[]" value="Job order">
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 ">
                            <div class="flex gap-3 items-center align-center justify-between">
                                <label for="">Contractual</label>
                                <input type="checkbox" name="employment_status[]" value="Contractual">
                            </div>
                            <div class="flex gap-3 items-center align-center justify-between">
                                <label for="">Part-time</label>
                                <input type="checkbox" name="employment_status[]" value="Part-time">
                            </div>
                            <div class="flex gap-3 items-center align-center justify-between">
                                <label for="">On call</label>
                                <input type="checkbox" name="employment_status[]" value="On call">
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 ">
                            <div class="flex gap-3 items-center align-center justify-between">
                                <label for="">Private employee</label>
                                <input type="checkbox" name="employment_status[]" value="Private employee">
                            </div>
                            <div class="flex gap-3 items-center align-center justify-between">
                                <label for="">Government employee</label>
                                <input type="checkbox" name="employment_status[]" value="Government employee">
                            </div>
                            <div class="flex gap-3 items-center align-center justify-between">
                                <label for="">Self employed</label>
                                <input type="checkbox" name="employment_status[]" value="Self employed">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 ml-3 flex gap-4">
                    <div>
                        <label for="">Daily income:</label>
                        <input type="text" class=" w-20" name="daily_income">
                        <label for="">Monthly income:</label>
                        <input type="text" class=" w-20" name="monthly_income">
                    </div>
                    <div class="flex flex-row">
                        <div class="flex gap-10">
                            <label for="">Other sectoral membership:</label>
                            <div class="flex gap-10">
                                <div class="flex flex-col gap-3">
                                    <div class="flex gap-3 justify-between">
                                        <label for="">Senior citizen</label>
                                        <input type="checkbox" name="sectoral_membership[]" value="Senior citizen">
                                    </div>
                                    <div class="flex gap-3 justify-between">
                                        <label for="">PWD</label>
                                        <input type="checkbox" name="sectoral_membership[]" value="PWD">
                                    </div>
                                    <div class="flex gap-3 justify-between">
                                        <label for="">Gov employee</label>
                                        <input type="checkbox" name="sectoral_membership[]" value="Gov employee">
                                    </div>
                                    <div class="flex gap-3 justify-between">
                                        <label for="">Brgy. official</label>
                                        <input type="checkbox" name="sectoral_membership[]" value="Brgy. official">
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <div class="flex gap-3 justify-between w-3/4">
                                        <label for="">PWD</label>
                                        <input type="checkbox" name="sectoral_membership[]" value="PWD">
                                    </div>
                                    <div class="flex gap-3 justify-between w-3/4">
                                        <label for="">Gov employee</label>
                                        <input type="checkbox" name="sectoral_membership[]" value="Gov employee">
                                    </div>
                                    <div class="flex gap-3 justify-between w-3/4">
                                        <label for="">Brgy. official</label>
                                        <input type="checkbox" name="sectoral_membership[]" value="Brgy. official">
                                    </div>
                                    <div class="flex gap-3 justify-between w-3/4">
                                        <label for="">Solo parent</label>
                                        <input type="checkbox" name="sectoral_membership[]" value="Solo parent">
                                    </div>
                                    <div>
                                        <label for="">Others</label>
                                        <input type="text" class="w-1/2" name="sectoral_membership[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 ml-3 flex gap-4">
                    <label for="">Name of Companion Upon Admission/Consultation:</label>
                    <input type="text" class="ml-1" name="companion_name">
                    <label for="">Address of Companion:</label>
                    <input type="text" class="ml-1 w-1/5" name="companion_address">
                </div>
                <div class="p-3 ml-3 flex gap-4">
                    <label for="">Campanion Contact No.</label>
                    <input type="text" class="ml-1 w-1/8" name="companion_contact" id="contact_number">
                    <label for="" class="ml-6">Date of Admission/Consultation:</label>
                    <input type="date" class="ml-2 w-40" name="admission_date">
                </div>
                <div class="p-3 ml-3 flex gap-4">
                    <label for="">Patient Diagnosis:</label>
                    <textarea name="diagnosis" id="" rows="5" cols="40" class="border border-pink-200 mt-2 p-2 outline-none"></textarea>
                </div>
                <div class="p-5 btn-submit">
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 border border-pink-700 rounded">Submit</button>
                </div>
            </form>
        </div>
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
        $employment_status = implode(", ", $_POST['employment_status']);
        $daily_income = $_POST['daily_income'];
        $monthly_income = $_POST['monthly_income'];
        $sectoral_membership = implode(", ", $_POST['sectoral_membership']);
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
                echo "<script>showSuccessMessage();</script>";
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