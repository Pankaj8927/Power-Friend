<?php
// Start the session
session_start();

// Destroy the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Optionally, you can redirect to a specific page after logout
// header("Location: index.php"); // Redirect to the home page or login page

// If using AJAX, return a response (optional)
header('./register.php');
echo json_encode(["status" => "success"]);
?>