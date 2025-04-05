<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload Excel File</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-8 relative">
        <h2 class="text-2xl font-semibold text-violet-600 mb-6 text-center">📄 Upload Excel File</h2>

        <?php
        require_once __DIR__ . '/src/Database.php';
        require_once __DIR__ . '/src/Models/MedInventory.php';

        use Admin\Malasakit\Models\MedInventory;
        use PhpOffice\PhpSpreadsheet\IOFactory;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excelFile"])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); // Create uploads directory
            }

            $target_file = $target_dir . basename($_FILES["excelFile"]["name"]);
            $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "<p class='text-red-700 bg-red-100 border border-red-300 text-sm text-center p-3 rounded mb-4' id='existMessage'>🚫 The file already exists. Please upload a different file.</p>";
            } elseif ($fileType != "xls" && $fileType != "xlsx") {
                // Allow only Excel files
                echo "<p class='text-red-600 text-sm mb-4'>Only Excel files (.xls, .xlsx) are allowed.</p>";
            } else {
                if (move_uploaded_file($_FILES["excelFile"]["tmp_name"], $target_file)) {
                    echo "<p id='success-message' class='text-green-700 bg-green-100 border border-green-300 text-sm text-center p-3 rounded mb-4'>✅ The file " . htmlspecialchars(basename($_FILES["excelFile"]["name"])) . " has been uploaded successfully.</p>";
                    echo "<script>
                        setTimeout(() => {
                            const message = document.getElementById('success-message');
                            if (message) {
                                message.style.display = 'none';
                            }
                            setTimeout(() => {
                                window.location.href = 'clientList.php'; 
                            }, 500); 
                        }, 2000); 
                    </script>";

                    // Read the Excel file
                    require_once __DIR__ . '/vendor/autoload.php';
                    $spreadsheet = IOFactory::load($target_file);
                    $sheet = $spreadsheet->getActiveSheet();
                    $rows = $sheet->toArray();

                    // Skip the header row and save data to the database
                    foreach (array_slice($rows, 1) as $row) {
                        // Check if the record already exists in the database
                        $existingRecord = MedInventory::where('Drug_Code', $row[0])->first();
                        if (!$existingRecord) {
                            MedInventory::create([
                                'Drug_Code' => $row[0],
                                'Drug_Name' => $row[1],
                                'Specification_Model' => $row[2],
                                'Production_Batch' => $row[3],
                                'Period_Validity' => $row[4],
                                'Manufacturer' => $row[5],
                                'Quantity' => $row[6],
                                'Unit_Price' => $row[7],
                                'Amount' => $row[8],
                                'Remarks' => $row[9],
                            ]);
                        }
                    }
                } else {
                    echo "<p class='text-red-600 text-sm mb-4'>Sorry, there was an error uploading your file.</p>";
                }
            }
        }
        ?>

        <script>
            setTimeout(() => {
                const message = document.getElementById('existMessage');
                if (message) {
                    message.style.display = 'none';
                }
            }, 2000);
        </script>

        <!-- Upload Form -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-5">
                <label for="excelFile" class="block text-gray-700 font-medium mb-2">
                    Choose Excel File
                </label>
                <input
                    class="w-full border border-gray-300 rounded-lg py-2 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition"
                    id="excelFile"
                    type="file"
                    name="excelFile"
                    required />
            </div>
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-violet-500 hover:bg-violet-600 text-white font-medium py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-200 ease-in-out">
                    Upload
                </button>
            </div>
        </form>
    </div>
</body>

</html>