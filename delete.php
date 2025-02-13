<?php
// delete.php

// Include database connection
include_once('conn/conn.php');

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete query
    $sql = "DELETE FROM patients WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Redirect back to the client list with a success message
        header("Location: clientList.php?message=Record deleted successfully");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: clientList.php?message=Error deleting record");
        exit();
    }
} else {
    // If no ID is provided, redirect back
    header("Location: clientList.php?message=Invalid request");
    exit();
}
?>