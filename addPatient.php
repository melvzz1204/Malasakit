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
<body>
    <div class="flex flex-row justify-start items-center bg-pink-300 p-3 head-malasakit">
        <img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px">
    </div>
    <ul class="flex flex-col gap-7 w-1/5 h-svh bg-gray-200 p-5 shadow-xl left-dashboard">
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel">
            <img src="assets/dashboard.png" alt="add"><a href="Dashboard.php">Dashboard</a>
        </li>
        <li class="hover:bg-pink-200 rounded -sm w-60 p-2  text-start flex align-center gap-3 li-slidepanel active">
            <img src="assets/add.png" alt="add"><a href="addPatient.php">Add patient</a>
        </li>

        <style>

        </style>
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
        <span class="text-2xl mb-6">CLIENT INFORMATION SHEET</span>
        <div class="addpatient-inputs content contentActive">
            <label for="" class="ml-6">First name:</label>
            <input type="text" class="ml-1">
            <label for="" class="ml-6">Last name:</label>
            <input type="text" class="ml-1">
            <label for="" class="ml-6">Middle name:</label>
            <input type="text" class="ml-1">
            <label for="" class="ml-6">Name extension:</label>
            <select name="nameExtension" id="" class="bg-gray-200  p-2 outline-none">
                <option value="Jr.">Jr.</option>
                <option value="Sr.">Sr.</option>
            </select>
            <div class="mt-8">
                <label for="" class="ml-6">Contact number:</label>
                <input type="text" class="ml-1">
                <label for="" class="ml-6">Patient Address:</label>
                <input type="text" class="ml-1 w-1/6">
            </div>
            <div class="mt-8 main-option">
                <div>
                    <label for="" class="ml-6">Date of Birth:</label>
                    <input type="date" class="ml-2 w-40">
                    <label for="" class="ml-6">Age:</label>
                    <input type="text" class="ml-1 w-10">
                </div>
                <div>
                    <label for="" class="ml-6">Sex:</label>
                    <select name="gender" id="" class="bg-gray-200 rounded p-2 outline-none">
                        <option value="">Male</option>
                        <option value="">Female</option>
                    </select>
                </div>
                <div>
                    <label for="" class="ml-6">Civil Status:</label>
                    <select name="gender" id="" class="bg-gray-200 rounded p-2 outline-none">
                        <option value="">Single</option>
                        <option value="">Married</option>
                        <option value="">Widow</option>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="" class="ml-6">Place of Birth:</label>
                    <input type="text" class="ml-2 w-60">
                </div>
            </div>
            <div class="mt-8">
                <label for="" class="ml-6">Religion:</label>
                <input type="text" class="ml-2">
                <label for="" class="ml-6">Educational Atttainment:</label>
                <select name="" id="" class="bg-gray-200 rounded p-2 outline-none">
                    <option value="">Elementary Under Graduate</option>
                    <option value="">Elementary Graduate</option>
                    <option value="">High School Under graduate</option>
                    <option value="">High School Graduate</option>
                    <option value="">High School Graduate</option>
                </select>
            </div>
            <div class="mt-8  p-3 ml-3 flex">
                <div>
                    <label for="">Occupation of Patient:</label>
                    <input type="text" class="ml-2 w-3/2">
                </div>
                <div class="flex gap-10 ml-5 p-2">
                    <div class="flex flex-col gap-3">
                        <div class="flex gap-3 justify-between">
                            <label for="">Regular</label>
                            <input type="checkbox">
                        </div>
                        <div class="flex gap-3 justify-between">
                            <label for="">Job order</label>
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 ">
                        <div class="flex gap-3 items-center align-center justify-between">
                            <label for="">Contractual</label>
                            <input type="checkbox">
                        </div>
                        <div class="flex gap-3 items-center align-center justify-between">
                            <label for="">Part-time</label>
                            <input type="checkbox">
                        </div>
                        <div class="flex gap-3 items-center align-center justify-between">
                            <label for="">On call</label>
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 ">
                        <div class="flex gap-3 items-center align-center justify-between">
                            <label for="">Private employee</label>
                            <input type="checkbox">
                        </div>
                        <div class="flex gap-3 items-center align-center justify-between">
                            <label for="">Government employee</label>
                            <input type="checkbox">
                        </div>
                        <div class="flex gap-3 items-center align-center justify-between">
                            <label for="">Self employed</label>
                            <input type="checkbox">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 ml-3 flex gap-4">
                <div>
                    <label for="">Daily income:</label>
                    <input type="text" class=" w-20">
                    <label for="">Monthly income:</label>
                    <input type="text" class=" w-20">
                </div>
                <div class="flex flex-row">
                    <div class="flex gap-10">
                        <label for="">Other sectoral membership:</label>
                        <div class="flex gap-10">
                            <div class="flex flex-col gap-3">
                                <div class="flex gap-3 justify-between">
                                    <label for="">Senior citizen</label>
                                    <input type="checkbox">
                                </div>
                                <div class="flex gap-3 justify-between">
                                    <label for="">PWD</label>
                                    <input type="checkbox">
                                </div>
                                <div class="flex gap-3 justify-between">
                                    <label for="">Gov employee</label>
                                    <input type="checkbox">
                                </div>
                                <div class="flex gap-3 justify-between">
                                    <label for="">Brgy. official</label>
                                    <input type="checkbox">
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <div class="flex gap-3 justify-between w-3/4">
                                    <label for="">PWD</label>
                                    <input type="checkbox">
                                </div>
                                <div class="flex gap-3 justify-between w-3/4">
                                    <label for="">Gov employee</label>
                                    <input type="checkbox">
                                </div>
                                <div class="flex gap-3 justify-between w-3/4">
                                    <label for="">Brgy. official</label>
                                    <input type="checkbox">
                                </div>
                                <div class="flex gap-3 justify-between w-3/4">
                                    <label for="">Solo parent</label>
                                    <input type="checkbox">
                                </div>
                                <div>
                                    <label for="">Others</label>
                                    <input type="text" class="w-1/2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 ml-3 flex gap-4">
                <label for="">Name of Companion Upon Admission/Consultation:</label>
                <input type="text" class="ml-1">
                <label for="">Address of Companion:</label>
                <input type="text" class="ml-1 w-1/5">
            </div>
            <div class="p-3 ml-3 flex gap-4">
                 <label for="">Campanion Contact No.</label>
                <input type="text" class="ml-1 w-1/8">
                <label for="" class="ml-6">Date of Admission/Consultation:</label>
                <input type="date" class="ml-2 w-40">
            </div>
            <div class="p-3 ml-3 flex gap-4">
                <label for="">Patient Diagnosis:</label>
                <textarea name="" id="" rows="5" cols="40" class="border border-600 mt-2"></textarea></textarea>
            </div>
            <div class="p-5 btn-submit">
                <button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 border border-pink-700 rounded">Submit</button>
            </div>  
            </div>
        <!-- Page 1 end-->

       <!--  Page 2 start-->
       <!--  <div class="content">
            <label for="">Name of Companion Upon Admission/Consultation:</label>
            <input type="text" class="ml-1 mt-6">
            <label for="">Address of Companion:</label>
            <input type="text" class="ml-1 mt-6">
        </div> -->
        <!--  Page 2 end-->
       <!--  <div class="content">
            <h1 class="text-3xl">Next page2</h1>
        </div>
        <div class="content">
            <h1 class="text-3xl">Next page3</h1>
        </div> -->
        <!-- <div class="btn-container">
            <button class="btn-btn Prev" id="prevBtn">
                < Previous</button>
                <button class="btn-btn" id="nextBtn">Next ></button>
        </div> -->
    </div>
    <style>

    </style>


</body>
<script src="js/script.js"></script>
</html>