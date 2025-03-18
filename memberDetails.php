<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Display members
    if ($action == "fetch") {
        $query = isset($_POST['query']) ? mysqli_real_escape_string($conn, $_POST['query']) : "";

        $sql = "SELECT * FROM members";
        if (!empty($query)) {
            $sql .= " WHERE name LIKE '%$query%' OR user_id LIKE '%$query%' OR email LIKE '%$query%' OR grade_class LIKE '%$query%'";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr style='background-color: white;'>";
            echo "<th>User ID</th>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Contact Number</th>";
            echo "<th>Class</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['contact_no']}</td>";
                echo "<td>{$row['grade_class']}</td>";
                echo "<td>";
                echo "<button class='update-btn' 
                    data-id='{$row['user_id']}' 
                    data-name='{$row['name']}' 
                    data-email='{$row['email']}' 
                    data-contact='{$row['contact_no']}' 
                    data-class='{$row['grade_class']}'>Update</button>";
                echo "<button class='delete-btn' data-id='{$row['user_id']}'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<div class='no-results'>No records found for the search.</div>";
        }
    }

    // Delete member
    if ($action == "delete" && isset($_POST['user_id'])) {
        $userId = intval($_POST['user_id']);
        $sql = "DELETE FROM members WHERE user_id = $userId";
        mysqli_query($conn, $sql);
    }

    // Update member
    if ($action == "update") {
        $userId = intval($_POST['user_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact_no']);
        $gradeClass = mysqli_real_escape_string($conn, $_POST['grade_class']);

        $sql = "UPDATE members 
                SET name = '$name', email = '$email', contact_no = '$contact', grade_class = '$gradeClass' 
                WHERE user_id = $userId";
        mysqli_query($conn, $sql);
    }
}
?>