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
    </script>
    <script>
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
        });
    </script>
    <style>
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

        .hideSlide {
            display: none;
            position: absolute;
            animation-name: hide;
            animation-duration: 1s;
            z-index: 1000;
        }

        @keyframes hide {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateX(-100%);
            }
        }

        .btnSlide {
            position: absolute;
            z-index: 5;
            top: 50%;
            left: -0.5%;
        }

        .btnClose {
            opacity: 50%;
            transition: all 0.3s ease;
        }

        .btnClose:hover {
            opacity: 100%;

        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const hide = document.getElementById("hideSlide");
            const btnSlide = document.getElementById("btnSlide");
            const btnClose = document.getElementById("btnClose");
            if (hide) {
                setTimeout(() => {
                    hide.style.display = "none";
                }, 1000); // Hide after 1 second
            }
            btnSlide.addEventListener("click", () => {
                if (hide.style.display === "none") {
                    hide.style.display = "flex";
                    hide.classList.remove("hideSlide");
                    btnSlide.style.display = "none";
                } else {
                    hide.style.display = "none";
                    hide.classList.add("hideSlide");
                }
            });
            btnClose.addEventListener("click", () => {
                hide.style.display = "none";
                hide.classList.add("hideSlide");
                btnSlide.style.display = "block";
            });
        });
    </script>
</head>

<body class="bg-gray-100">
    <div class="flex flex-row justify-start items-center bg-violet-300 p-3 head-malasakit fr">
        <a href="dashboard.php"><img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px"></a>
    </div>
    <ul class="flex flex-col gap-7 w-1/5 h-svh bg-violet-200 p-5 shadow-xl i hideSlide fixed " id="hideSlide">
        <li class=" hover:bg-violet-300 rounded -sm w-60 p-2 text-start flex align-center gap-3 ">
            <img src="assets/dashboard.png" alt="add"><a href="Dashboard.php">Dashboard</a>
        </li>
        <li class="hover:bg-violet-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 ">
            <img src="assets/add.png" alt="add"><a href="addPatient.php">Add client</a>
        </li>
        <!--  others -->
        <li class="hover:bg-violet-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 ">
            <img src="assets/onlineforms.png" alt="add">
            <a href="onlineforms.php">Online forms</a>
        </li>
        <li class="hover:bg-violet-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 ">
            <img src="assets/useraccount.png" alt="add">
            <a href="#">User account</a>
        </li>
        <li class="hover:bg-violet-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 ">
            <img src="assets/reports.png" alt="add">
            <a href="#">Reports</a>
        </li>
        <li class="hover:bg-violet-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 ">
            <img src="assets/med.png" alt="add">
            <a href="uploadMed.php">Upload med inventory</a>
        </li>
        <li class="hover:bg-violet-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 ">
            <img src="assets/settings.png" alt="add">
            <a href="#">Settings</a>
        </li>
        <li class="hover:bg-violet-300 rounded -sm w-60 p-2  text-start flex align-center gap-3 ">
            <img src="assets/logout.png" alt="add">
            <a href="#">Logout</a>
        </li>
        <div>
            <img src="assets/close.png" alt="" class="absolute top-2 right-5 w-7 h-7 cursor-pointer btnClose" id="btnClose">
        </div>
    </ul>
    <div class="btnSlide">
        <img src="assets/rightbtn.png" alt="" class="w-8 h-12 opacity-30 hover:opacity-100 cursor-pointer" id="btnSlide">
    </div>
    </div>
    <div class="container mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-violet-800">Client List</h1>
            <div class="relative w-full md:w-96">
                <input
                    type="text"
                    placeholder="Search Last name"
                    id="searchBar"
                    class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-full shadow-sm focus:ring-2 focus:ring-violet-500 focus:outline-none" />
                <button
                    class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-violet-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0a8 8 0 1 0-11.3 0 8 8 0 0 0 11.3 0z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <?php
        if (isset($_GET['message'])) {
            echo "<div id='message' class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-all duration-300 ease-in-out'>";
            echo "<span class='block sm:inline'>" . htmlspecialchars($_GET['message']) . "</span>";
            echo "</div>";
        }
        ?>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-violet-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">First Name</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Last Name</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Middle Name</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Date of Birth</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Address</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Date Registered</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    include_once('conn/conn.php');
                    $sql = "SELECT id, first_name, last_name, middle_name, date_of_birth, date_registered, address FROM patients ORDER BY created_at DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            echo "<tr class='hover:bg-violet-50 transition'>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['first_name']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['last_name']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['middle_name']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['address']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900'>" . htmlspecialchars($row['date_registered']) . "</td>";
                            echo "<td class='py-4 px-6 text-sm text-gray-900 flex space-x-2'>";
                            echo "<a href='viewPatient.php?id=" . htmlspecialchars($row['id']) . "' class='bg-violet-500 hover:bg-violet-600 text-white px-4 py-2 rounded-md text-xs font-medium transition'>View</a>";
                            echo "<a href='delete.php?id=" . htmlspecialchars($row['id']) . "' class='bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-xs font-medium transition' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
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

    <script>
        // Optional fade-out for alert
        setTimeout(() => {
            const message = document.getElementById('message');
            if (message) {
                message.classList.add('opacity-0');
                setTimeout(() => message.remove(), 1000);
            }
        }, 3000);
    </script>
</body>

</html>