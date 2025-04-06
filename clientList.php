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
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex flex-row justify-start items-center bg-violet-300 p-3 head-malasakit fr">
        <a href="dashboard.php"><img src="assets/malasakit_logo.png" alt="add" style="width: 100px; margin-left:50px"></a>
    </div>
    <div class="container mx-auto px-4 py-10 ">
        <div class="maincontainerHead">
            <h1 class="text-3xl font-bold text-violet-800 mb-8">Client List</h1>
            <div>
                <div class="relative w-full max-w-md">
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
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
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
                    $sql = "SELECT id, first_name, last_name, middle_name, date_of_birth, date_registered, address FROM patients ORDER BY date_registered DESC";
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