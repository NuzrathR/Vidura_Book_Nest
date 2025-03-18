<?php
    // Start the session if not started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        header("Location: login.php"); // Redirect to login if not logged in
        exit();
    }

    // Retrieve user details from session
    $username = $_SESSION['username'];
    $student_name = $_SESSION['name'];
?>