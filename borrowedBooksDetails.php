<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Display borrowed books details
    if ($action == "fetch") {
        $query = isset($_POST['query']) ? mysqli_real_escape_string($conn, $_POST['query']) : "";

        $sql = "SELECT * FROM borrowed_book_details";
        if (!empty($query)) {
            $sql .= " WHERE book_id LIKE '%$query%' OR borrowed_date LIKE '%$query%' OR borrow_id LIKE '%$query%' 
            OR status LIKE '%$query%' OR user_id LIKE '%$query%' OR return_date LIKE '%$query%'";
        } 

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr style='background-color: white;'>";
            echo "<th>Borrowed ID</th>";
            echo "<th>Book ID</th>";
            echo "<th>User ID</th>";
            echo "<th>Borrowed Date</th>";
            echo "<th>Return Date</th>";
            echo "<th>Status</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
    
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['borrow_id']}</td>";
                echo "<td>{$row['book_id']}</td>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td>{$row['borrowed_date']}</td>";
                echo "<td>{$row['return_date']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td>";
                if($row['status'] == "Pending") {
                    echo "<button class='return-book-btn'
                        data-borrow-id='{$row['borrow_id']}' 
                        data-book-id='{$row['book_id']}'>Return</button>";

                    echo "<button class='lost-book-btn'
                        data-borrow-id='{$row['borrow_id']}' 
                        data-book-id='{$row['book_id']}'
                        data-user-id='{$row['user_id']}'>Lost</button>";
                } else {
                    echo "<button class='return-book-btn' disabled style='background-color:rgb(125, 204, 125); color: #666;'>Return</button>";
                    echo "<button class='lost-book-btn' disabled style='background-color:rgb(204, 167, 99); color: #666;'>Lost</button>";
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='no-results'>No records found for the search.</div>";
        }
    } 

    //When Book is return, 
    if ($action === "return_book") {
        $borrowId = intval($_POST['borrow_id']);
        $bookId = intval($_POST['book_id']);

        // Update the borrowed book status to 'returned'
        $updateBorrowed = "UPDATE borrowed_book_details SET status = 'Returned' WHERE borrow_id = $borrowId";

        // Increment the book copies in the 'books' table
        $updateBook = "UPDATE books SET copies = copies + 1 WHERE acc_no = $bookId";
        
        if (mysqli_query($conn, $updateBorrowed) && mysqli_query($conn, $updateBook)) {
            echo json_encode(["message" => "Book returned successfully and removed from cart."]);
        } else {
            echo json_encode(["message" => "Error updating book status: " . mysqli_error($conn)]);
        }
    }

    // When Book is lost, add it into the lost books details table.
    if ($action === "mark_as_lost") {
        $borrowId = intval($_POST['borrow_id']);
        $bookId = intval($_POST['book_id']);
        $userId = $_POST['user_id'];
        $lostDate = date('Y-m-d');

        mysqli_begin_transaction($conn);

        try {
            // Insert into lost_book_details
            $insertLost = "INSERT INTO lost_book_details (book_id, user_id, lost_date)
                           VALUES ($bookId, '$userId', '$lostDate')";
            mysqli_query($conn, $insertLost);

            // Remove from borrowed_book_details
            $deleteBorrowed = "DELETE FROM borrowed_book_details WHERE borrow_id = $borrowId";
            mysqli_query($conn, $deleteBorrowed);

            mysqli_commit($conn);
            echo json_encode(["message" => "Book marked as lost successfully."]);
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo json_encode(["message" => "Error processing request: " . $e->getMessage()]);
        }
    }
}
?>