<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Display lost books details
    if ($action == "fetch") {
        $query = isset($_POST['query']) ? mysqli_real_escape_string($conn, $_POST['query']) : "";

        $sql = "SELECT * FROM lost_books_view";
        if (!empty($query)) {
            $sql .= " WHERE lost_id LIKE '%$query%' OR user_id LIKE '%$query%' OR book_id LIKE '%$query%' 
            OR lost_date LIKE '%$query%' OR title LIKE '%$query%' OR price LIKE '%$query%' OR status LIKE '%$query%'";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr style='background-color: white;'>";
            echo "<th>Lost ID</th>";
            echo "<th>Lost Date</th>";
            echo "<th>Book ID</th>";
            echo "<th>Title</th>";
            echo "<th>Price</th>";
            echo "<th>User ID</th>";
            echo "<th>Status</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['lost_id']}</td>";
                echo "<td>{$row['lost_date']}</td>";
                echo "<td>{$row['book_id']}</td>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['price']}</td>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td style='word-wrap: break-word; max-width: 100px'>{$row['status']}</td>";
                echo "<td>";
                if ($row['status'] == "Pending") {
                    echo "<button class='replace-btn' 
                    data-lost-id='{$row['lost_id']}' 
                    data-book-id='{$row['book_id']}'>Replaced</button>";
                    echo "<button class='pay-btn' data-lost-id='{$row['lost_id']}'>Paid</button>";
                } else {
                    echo "<button class='replace-btn' disabled style='background-color:rgb(125, 195, 212); color: #666;'>Replaced</button>";
                    echo "<button class='pay-btn' disabled style='background-color:rgb(207, 120, 188); color: #666;'>Paid</button>";
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='no-results'>No records found for the search.</div>";
        }
    }

    //When Book is replaced, 
    if ($action === "same_book") {
        $lostId = intval($_POST['lost_id']);
        $bookId = intval($_POST['book_id']);

        // Increment the book copies in the 'books' table
        $updateBook = "UPDATE books SET copies = copies + 1 WHERE acc_no = $bookId";

        // Update the status to 'replaced'
        $updateLostStatus = "UPDATE lost_book_details SET status = 'Replaced with Same' WHERE lost_id = $lostId";
            
        if (mysqli_query($conn, $updateLostStatus) && mysqli_query($conn, $updateBook)) {
            echo json_encode(["message" => "Book replaced successfully."]);
        } else {                
            echo json_encode(["message" => "Error updating lost book status: " . mysqli_error($conn)]);
        }
    }
    elseif ($action === "another_book") {
        $lostId = intval($_POST['lost_id']);

        // Update the status to 'Replaced with Another'
        $updateStatus = "UPDATE lost_book_details SET status = 'Replaced with Another' WHERE lost_id = $lostId";

        if (mysqli_query($conn, $updateStatus)) {
            echo json_encode(["message" => "Updated the status successfully."]);
        } else {
            echo json_encode(["message" => "Error updating lost book status: " . mysqli_error($conn)]);
        }
    }
    elseif ($action === "pay_for_book") {
        $lostId = intval($_POST['lost_id']);

        // Update the status to 'Paid For Book'
        $updateStatus = "UPDATE lost_book_details SET status = 'Paid For Book' WHERE lost_id = $lostId";

        if (mysqli_query($conn, $updateStatus)) {
            echo json_encode(["message" => "Updated the status successfully."]);
        } else {
            echo json_encode(["message" => "Error updating lost book status: " . mysqli_error($conn)]);
        }
    }
}
?>