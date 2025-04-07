<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="css/slidepanel.css">
    <link rel="stylesheet" href="css/addpatient.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function to hide the message after 1 second
        function hideMessage() {
            const messageDiv = document.getElementById('message');
            if (messageDiv) {
                setTimeout(() => {
                    messageDiv.style.opacity = '0'; // Fade out
                    setTimeout(() => {
                        messageDiv.style.display = 'none'; // Hide after fade
                    }, 500); // Wait for the fade-out to complete
                }, 1000); // Wait 1 second before starting the fade
            }
        }

        // Call the function when the page loads
        window.onload = hideMessage;

        // Hide sidebar after 1 second
        const hideSideBar = document.getElementById('hideSideBar');
        if (hideSideBar) {
            setTimeout(() => {
                hideSideBar.style.display = 'none';
            }, 1000);
        }

        // Wait for the DOM to load
        document.addEventListener('DOMContentLoaded', function() {
            // Live Search Functionality
            const searchBar = document.getElementById('searchBar');
            if (searchBar) {
                searchBar.addEventListener('input', function() {
                    const searchQuery = this.value.toLowerCase(); // Get the search query
                    const rows = document.querySelectorAll('tbody tr'); // Get all table rows

                    rows.forEach(row => {
                        const firstName = row.querySelector('td:nth-child(1)').textContent.toLowerCase(); // First Name column
                        const lastName = row.querySelector('td:nth-child(2)').textContent.toLowerCase(); // Last Name column

                        // Show or hide rows based on the search query
                        if (firstName.includes(searchQuery) || lastName.includes(searchQuery)) {
                            row.style.display = ''; // Show the row
                        } else {
                            row.style.display = 'none'; // Hide the row
                        }
                    });
                });
            } else {
                console.error('Search bar element not found!');
            }

            const openSideBar = document.getElementById('openSideBar');
            if (openSideBar) {
                setTimeout(() => {
                    openSideBar.style.display = 'none';
                }, 500);
            }
            const btn = document.getElementById('btn');
            btn.addEventListener('click', function() {
                openSideBar.style.display = 'flex';
                openSideBar.classList.toggle('openSideBar');
            });
            const hide = document.getElementById('hideSideBar');
            hide.addEventListener('click', function() {
                openSideBar.style.display = 'none';
                openSideBar.classList.toggle('openSideBar');
            });
        });
    </script>
    <style>
        .openSideBar {
            display: flex;
            animation: slideIn 1s linear forwards;

        }

        @keyframes slideIn {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-100%);
            }
        }

        #message {
            transition: opacity 0.5s ease-out;
            position: absolute;
            width: 100%;
            z-index: 500;
            text-align: center;
            left: 0;
            top: 0;
        }

        .fr {
            position: relative;
        }

        .head-malasakit {
            position: relative;
        }

        .maincontainerHead {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            position: fixed;
            top: 50%;
            left: -0.5%;
        }

        #hideSideBar{
            position: absolute;
            top: 40%;
            right: -4%;
            cursor: pointer;
            rotate: 180deg;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="fixed flex flex-row justify-start items-center bg-violet-300 p-3 head-malasakit fr w-full" style="z-index: 5000;">
        <a href="dashboard.php"><img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px"></a>
    </div>
    <div class="btn">
        <button class="hover:opacity-100 opacity-30 w-80" id="btn"> <img src="assets/rightbtn.png" alt=""></button>
    </div>
    <div class="openSideBar fixed left-0 z-[100] h-screen bg-violet-200 p-6 shadow-2xl flex flex-col gap-6 transition-transform duration-300 ease-in-out" id="openSideBar" style=" top: 100px; width: 20%; z-index: 1;">
        <div class="absolute cursor-pointer" id="hideSideBar" style="z-index: 100;">
            <img src="assets/rightbtn.png" alt="" class="w-8 opacity-50 hover:opacity-100 transition">
        </div>
        <ul class="flex flex-col gap-4">
            <li class=" flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
                <img src="assets/dashboard.png" alt="Dashboard" class="w-5 h-5" />
                <a href="Dashboard.php" class="text-sm font-medium text-gray-800">Dashboard</a>
            </li>
            <li class="flex items-center gap-4 p-3 rounded-lg bg-violet-300 active">
                <img src="assets/add.png" alt="Add Client" class="w-5 h-5" />
                <a href="addPatient.php" class="text-sm font-medium text-gray-800">Add Client</a>
            </li>

            <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
                <img src="assets/onlineforms.png" alt="Online Forms" class="w-5 h-5" />
                <a href="onlineforms.php" class="text-sm font-medium text-gray-800">Online Forms</a>
            </li>

            <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-violet-300 transition">
                <img src="assets/useraccount.png" alt="User Account" class="w-5 h-5" />
                <a href="#" class="text-sm font-medium text-gray-800">User Account</a>
            </li>

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

            <li class="flex items-center gap-4 p-3 rounded-lg hover:bg-red-300 transition mt-auto">
                <img src="assets/logout.png" alt="Logout" class="w-5 h-5" />
                <a href="#" class="text-sm font-medium text-gray-800">Logout</a>
            </li>
        </ul>
    </div>

    <div class="container mx-auto px-4 py-10">
        <div class="maincontainerHead">
            <h1 class="text-3xl font-bold text-violet-800 mb-8">Client List</h1>
            <div class="mt-10">
                <div class="relative w-full max-w-md mt-20">
                    <input
                        type="text"
                        placeholder="Search Last name"
                        id="searchBar"
                        class="w-auto px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    <button
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0a8 8 0 1 0-11.3 0 8 8 0 0 0 11.3 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <?php
        if (isset($_GET['message'])) {
            echo "<div id='message' class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4' role='alert'>";
            echo "<span class='block sm:inline'>" . htmlspecialchars($_GET['message']) . "</span>";
            echo "</div>";
        }
        ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden mt-10 ">
            <table class="min-w-full ">
                <thead class="bg-violet-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Middle Name</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Registered</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php
                    include_once('conn/conn.php');
                    $sql = "SELECT id, first_name, last_name, middle_name, date_of_birth, date_registered, address FROM patients ORDER BY created_at DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            echo "<tr class='hover:bg-gray-50 transition-colors'>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['first_name']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['last_name']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['middle_name']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['address']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['date_registered']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900 flex space-x-2'>";
                            echo "<a href='patientProfile.php?id=" . htmlspecialchars($row['id']) . "' class='bg-violet-500 text-white px-4 py-2 rounded-md hover:bg-violet-600 transition-colors'>View</a>";
                            echo "<a href='delete.php?id=" . htmlspecialchars($row['id']) . "' class='bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='py-4 px-6 text-sm text-gray-500 text-center'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>