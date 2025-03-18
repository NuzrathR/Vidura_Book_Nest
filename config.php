<?php 
    $conn = mysqli_connect("localhost:3307", "root", "", "booknest_db");

    if (!$conn) {
        die("Connection Unsuccessful: " . mysqli_connect_error());
    }
?>