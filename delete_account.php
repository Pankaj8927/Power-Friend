<?php
session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['unique_id'])) {
    $uniqueId = mysqli_real_escape_string($conn, $_SESSION['unique_id']);

    $delSql = "DELETE FROM users WHERE uniqueId = '$uniqueId'";
    $delresult = mysqli_query($conn, $delSql);

    if ($delresult) {
        // Destroy the session
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('Location: ./register.php');
        exit();
    } else {
        echo "
            <script>alert('Error deleting record: " . mysqli_error($conn) . "');window.location.href = './register.php';</script>
        ";
    }
} else {
    echo "
        <script> alert('No uniqueId found in the session.'); window.location.href = './register.php';</script>
    ";
}

mysqli_close($conn);
?>