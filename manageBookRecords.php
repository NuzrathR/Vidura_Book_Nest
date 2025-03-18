<?php 
    // Setting up the connection
    include "config.php";

    // Add Book
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert"])) {
        $acc_no = $_POST["acc_no"] ?? "";
        $title = $_POST["title"];

        $book_image = $_FILES["book_image"]["name"];
        $image_size = $_FILES['book_image']['size'];
        $image_tmp_name = $_FILES['book_image']['tmp_name'];
        $image_folder = "Assets/uploaded_images/".$book_image;
        
        $book_link = $_POST["book_link"];
        $category = $_POST["category"];
        $author = $_POST["author"];
        $copies = $_POST["book_copies"];
        $publisher = $_POST["publisher"];
        $isbn = $_POST["isbn"];
        $copyright_year = $_POST["copyright_year"];
        $class_no = $_POST["class_no"];
        $price = $_POST["book_price"];
        $status = $_POST["status"];
        $comment = $_POST["comment"] ?? "";
    
        // Check if the book already exists based on ISBN
        $check_query = "SELECT * FROM books WHERE isbn = '$isbn' LIMIT 1";
        $result = mysqli_query($conn, $check_query);
    
        if(mysqli_num_rows($result) > 0) {
            echo "<script type='text/javascript'> 
                    if (confirm('This book already exists! Do you want to update the existing record?')) {
                        window.location.href = 'updateBook.php?isbn=$isbn';
                    } else {
                        window.location.href = 'addBook.php';
                    }
                  </script>";
        } else {
            // To check if the image size exceeds 5MB
            if ($image_size > 5000000) {
                echo 
                "<script type=\"text/javascript\"> 
                    window.alert('Image size is too large');
                    window.location.href = 'addBook.html';
                </script>";
            } elseif (!move_uploaded_file($image_tmp_name, $image_folder)) {
                echo 
                "<script type=\"text/javascript\"> 
                    window.alert('Failed to upload image. Please try again.');
                    window.location.href = 'addBook.html';
                </script>";
            } else {
                // Inserting a Book
                $add_query = "INSERT INTO books (acc_no, title, image, category, author, copies, publisher, isbn, copyright_year, class_no, price, status, comment, file_path) VALUES (
                    '$acc_no',
                    '$title',
                    '$book_image',
                    '$category',
                    '$author',
                    $copies,
                    '$publisher',
                    '$isbn',
                    '$copyright_year',
                    '$class_no',
                    $price,
                    '$status',
                    '$comment',
                    '$book_link')";
                
                if (mysqli_query($conn, $add_query)) {
                    echo 
                    "<script type=\"text/javascript\"> 
                        window.alert('Book added successfully');
                        window.location.href = 'addBook.php';
                    </script>";
                } else {
                    echo 
                    "<script type=\"text/javascript\"> 
                        window.alert('Sorry! Failed to add book'); 
                        window.location.href = 'addBook.php';
                    </script>";
                }
            }
        }
    }

    // Update Book
    if (isset($_GET['isbn'])) {
        $isbn = $_GET['isbn'];
        
        // Getting existing book details
        $query = "SELECT * FROM books WHERE isbn = '$isbn'";
        $result = mysqli_query($conn, $query);

        // Displays based on the book availability
        if($result && mysqli_num_rows($result) > 0) {
            $book = mysqli_fetch_assoc($result);
        } else {
            echo 
                "<script type=\"text/javascript\"> 
                    window.alert('Sorry! No Books Available with ISBN: $isbn'); 
                    window.location.href = 'updateBook.php';
                </script>";
        }
        
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
        $acc_no = $_POST["acc_no"] ?? "";
        $title = $_POST["title"];

        $book_image = $_FILES["book_image"]["name"];
        $image_size = $_FILES['book_image']['size'];
        $image_tmp_name = $_FILES['book_image']['tmp_name'];
        $image_folder = "Assets/uploaded_images/" . $book_image;
        
        $book_link = $_POST["book_link"];
        $category = $_POST["category"];
        $author = $_POST["author"];
        $copies = $_POST["book_copies"];
        $publisher = $_POST["publisher"];
        $isbn = $_POST["isbn"];
        $copyright_year = $_POST["copyright_year"];
        $class_no = $_POST["class_no"];
        $price = $_POST["book_price"];
        $status = $_POST["status"];
        $comment = $_POST["comment"];

        if (!empty($book_image)) {
            // Check if the image size exceeds 5MB
            if ($image_size > 5000000) {
                echo "<script type='text/javascript'> 
                        window.alert('Image size is too large.');
                        window.location.href = 'updateBook.php?isbn=$isbn';
                      </script>";
            } elseif (!move_uploaded_file($image_tmp_name, $image_folder)) {
                echo "<script type='text/javascript'> 
                        window.alert('Failed to upload image. Please try again.');
                        window.location.href = 'updateBook.php?isbn=$isbn';
                      </script>";
            } else {
                $book_image = $book['image'];
            }
        }
        
        $update_query = "UPDATE books SET 
                            acc_no = '$acc_no',
                            title = '$title', 
                            image = '$book_image',
                            category = '$category', 
                            author = '$author', 
                            copies = $copies, 
                            publisher = '$publisher', 
                            copyright_year = '$copyright_year', 
                            class_no = '$class_no', 
                            price = $price, 
                            status = '$status', 
                            comment = '$comment', 
                            file_path = '$book_link'
                        WHERE isbn = '$isbn'";

        if (mysqli_query($conn, $update_query)) {
            echo "<script>
                    alert('Book updated successfully'); 
                    window.location.href = 'bookDetails.html';
                </script>";
        } else {
            echo "<script>
                    alert('Failed to update book'); 
                    window.location.href = 'updateBook.php?isbn=$isbn';
                </script>";
        }
    }

    // Closing the connection
    mysqli_close($conn);
?>
