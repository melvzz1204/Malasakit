<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once 'src/Database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the ID is numeric to prevent SQL injection
    if (!is_numeric($id)) {
        die("Invalid ID.");
    }

    // Delete the patient record
    $deleted = Capsule::table('patients')->where('id', $id)->delete();

    if ($deleted) {
        header("Location: clientList.php?message=Patient record deleted successfully.");
        exit;
    } else {
        echo "Error deleting record.";
    }
} else {
    echo "No ID provided.";
}
