<?php
// session_start();

// Define the session lifetime (e.g., 1800 seconds = 30 minutes)
$lifetime = 120;

// Check if the session has expired
if (isset($_SESSION['login_timestamp']) && (time() - $_SESSION['login_timestamp'] > $lifetime)) {
    // Destroy the session if it has expired
    session_unset();     // Unset all session variables
    session_destroy();   // Destroy the session data on the server
    setcookie("powerfriend", "", time() - 120, "/"); // Remove the session cookie

    // Redirect to the login page or another appropriate page
    echo "
        <script>
            alert('Session has expired. Please log in again.');
            window.location.href = './register.php';
        </script>
    ";
    exit();
} else {
    // If the session is still valid, update the timestamp
    $_SESSION['login_timestamp'] = time();
}
?>