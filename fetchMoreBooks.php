<?php
    include_once 'config.php';

    // Sanitize input data
    $title = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : '';
    $author = isset($_POST['author']) ? mysqli_real_escape_string($conn, $_POST['author']) : '';
    $category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : '';
    $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 2;
    $offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;

    // Build the SQL query based on filters
    $sql = "SELECT b.*, COUNT(br.book_id) AS borrow_count
            FROM books b
            LEFT JOIN borrowed_book_details br ON b.acc_no = br.book_id
            WHERE 1";

    if ($title) {
        $sql .= " AND title LIKE '%$title%'";
    }
    if ($category) {
        $sql .= " AND category = '$category'";
    }
    if ($author) {
        $sql .= " AND author LIKE '%$author%'";
    }

    $sql .= " GROUP BY b.acc_no
            ORDER BY borrow_count DESC
            LIMIT $limit OFFSET $offset";

    $result_query = mysqli_query($conn, $sql);

    $output = '';
    if (mysqli_num_rows($result_query) > 0) {
        while ($fetch_book = mysqli_fetch_assoc($result_query)) {
            $output .= '<div class="book_container">
                            <img id="book_img" src="Assets/uploaded_images/' . $fetch_book["image"] . '">
                            <a href="book_details.php?id=' . $fetch_book["acc_no"] . '" style="text-decoration:none; color: black;">
                                <h3 id="book_title">' . $fetch_book["title"] . '</h3>
                            </a>
                        </div>';
        }
    }

    echo $output;
?>
