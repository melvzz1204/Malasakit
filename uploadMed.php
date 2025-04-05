<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="block text-gray-700 text-xl font-bold mb-2">Upload Excel File</h2>
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

            // Allow only Excel files
            if ($fileType != "xls" && $fileType != "xlsx") {
                echo "<p class='text-red-500'>Only Excel files (.xls, .xlsx) are allowed.</p>";
            } else {
                if (move_uploaded_file($_FILES["excelFile"]["tmp_name"], $target_file)) {
                    echo "<p id='success-message' class='text-green-800 border-2 border-pink-200 absolute top-0 bg-pink-100 w-full text-center left-0 p-3'>The file " . htmlspecialchars(basename($_FILES["excelFile"]["name"])) . " has been uploaded.</p>";
                    echo "<script>
                        setTimeout(() => {
                            const message = document.getElementById('success-message');
                            if (message) {
                                message.style.display = 'none';
                            }
                        }, 2000); 
                    </script>";

                    // Read the Excel file
                    require_once __DIR__ . '/vendor/autoload.php';
                    $spreadsheet = IOFactory::load($target_file);
                    $sheet = $spreadsheet->getActiveSheet();
                    $rows = $sheet->toArray();

                    // Skip the header row and save data to the database
                    foreach (array_slice($rows, 1) as $row) {
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
                } else {
                    echo "<p class='text-red-500'>Sorry, there was an error uploading your file.</p>";
                }
            }
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="excelFile">
                    Choose Excel file:
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="excelFile" type="file" name="excelFile" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-violet-500 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Upload
                </button>
            </div>
        </form>
    </div>
</body>

</html>