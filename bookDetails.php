<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Display books
    if ($action == "fetch") {
        $query = isset($_POST['query']) ? mysqli_real_escape_string($conn, $_POST['query']) : "";

        $sql = "SELECT * FROM books";
        if (!empty($query)) {
            $sql .= " WHERE title LIKE '%$query%' OR acc_no LIKE '%$query%' OR author LIKE '%$query%' 
            OR category LIKE '%$query%' OR isbn LIKE '%$query%' OR class_no LIKE '%$query%' 
            OR publisher LIKE '%$query%' OR status LIKE '%$query%' OR copyright_year LIKE '%$query%' OR price LIKE '%$query%'";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr style='background-color: white;'>";
            echo "<th>Book ID</th>";
            echo "<th>Book Title</th>";
            echo "<th>Cover Page</th>";
            echo "<th>Author</th>";
            echo "<th>ISBN Number</th>";
            echo "<th>Category</th>";
            echo "<th>Number Of Copies</th>";
            echo "<th>Publisher Name</th>";
            echo "<th>Copyright Year</th>";
            echo "<th>Class No</th>";
            echo "<th>Book Price</th>";
            echo "<th>Status</th>";
            echo "<th>Comment</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['acc_no']}</td>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['image']}</td>";
                echo "<td>{$row['author']}</td>";
                echo "<td>{$row['isbn']}</td>";
                echo "<td>{$row['category']}</td>";
                echo "<td>{$row['copies']}</td>";
                echo "<td>{$row['publisher']}</td>";
                echo "<td>{$row['copyright_year']}</td>";
                echo "<td>{$row['class_no']}</td>";
                echo "<td>{$row['price']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td>{$row['comment']}</td>";
                echo "<td>";
                echo "<button class='update-btn' 
                    data-id='{$row['acc_no']}' 
                    data-title='{$row['title']}' 
                    data-bookCover='{$row['image']}'
                    data-author='{$row['author']}' 
                    data-isbn='{$row['isbn']}' 
                    data-category='{$row['category']}' 
                    data-copies='{$row['copies']}'  
                    data-publisher='{$row['publisher']}'  
                    data-copyright_year='{$row['copyright_year']}'  
                    data-class_no='{$row['class_no']}'
                    data-price='{$row['price']}' 
                    data-status='{$row['status']}' 
                    data-comment='{$row['comment']}' >Update</button>";
                echo "<button class='delete-btn' data-id='{$row['acc_no']}'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='no-results'>No records found for the search.</div>";
        }
    }

    // Delete Books
    if ($action == "delete" && isset($_POST['acc_no'])) {
        $bookId = intval($_POST['acc_no']);
        $sql = "DELETE FROM books WHERE acc_no = $bookId";
        mysqli_query($conn, $sql);
    }

    // Update Books
    if ($action == "update") {
        $bookId = intval($_POST['acc_no']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $coverPage = mysqli_real_escape_string($conn, $_POST['book_image']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $copies = intval($_POST['copies']);
        $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);
        $copyright_year = mysqli_real_escape_string($conn, $_POST['copyrightYear']);
        $classNo = mysqli_real_escape_string($conn, $_POST['class_no']);
        $price = floatval($_POST['price']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    
        $sql = "UPDATE books SET 
                copies = $copies, 
                publisher = '$publisher', 
                copyright_year = '$copyright_year', 
                class_no = '$classNo',
                price = $price, 
                status = '$status', 
                comment = '$comment' 
                WHERE acc_no = $bookId";
    
        if (mysqli_query($conn, $sql)) {
            echo "Book details updated successfully.";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }    
}
?>