<?php
    include "config.php";
    include "index.php";

    $user_id = $_SESSION['username']; // Define user_id from session

    if (isset($_POST['book_id'])) {
        $book_id = $_POST['book_id'];

        // Checking if the book is already available in the cart 
        $check_query = "SELECT * FROM borrowed_book_details WHERE user_id = '$user_id' AND book_id = $book_id";
        $check_query_result = mysqli_query($conn, $check_query);

        // Checking if there are book copies
        $check_book_availability = "SELECT * FROM books WHERE acc_no = $book_id AND copies > 0";
        $books_available = mysqli_query($conn, $check_book_availability);

        // Checking the activated membership plan
        $check_membership_plan = "SELECT payment_type, status FROM payment_details WHERE user_id = $user_id";
        $membership_result = mysqli_query($conn, $check_membership_plan);

        $borrowed_date = date('Y-m-d'); // Current date

        // Calculating the number of days given when borrowing the book
        if ($membership_row = mysqli_fetch_assoc($membership_result)) {
            $payment_type = $membership_row['payment_type'];
            $payment_status = $membership_row['status'];

            if($payment_type == 'One Year' && $payment_status == 'Approved') {
                $return_date = date('Y-m-d', strtotime('+14 days')); // Current date + 14 days
            } else if($payment_type == 'Two Year' && $payment_status == 'Approved'){
                $return_date = date('Y-m-d', strtotime('+30 days')); // Current date + 30 days
            } else {
                $return_date = date('Y-m-d', strtotime('+7 days')); // Current date + 7 days
            }
        } else {
            $return_date = date('Y-m-d', strtotime('+7 days')); // Current date + 7 days
        }

        if (mysqli_num_rows($books_available) > 0) {
            if (mysqli_num_rows($check_query_result) > 0) {
                // Getting the row associated with the book already available in the cart
                $row = mysqli_fetch_assoc($check_query_result);

                if($row['status'] == 'Returned') {
                    // Instead of inserting a new row, update the old record
                    $update_query = "UPDATE borrowed_book_details 
                                        SET borrowed_date = '$borrowed_date', 
                                            return_date = '$return_date', 
                                            status = 'Pending' 
                                        WHERE user_id = '$user_id' 
                                        AND book_id = $book_id";
                    
                    if (mysqli_query($conn, $update_query)) {
                        echo "<script>alert('Book re-added to cart successfully')</script>";
            
                        // Deduct one copy from books
                        $update_copies_query = "UPDATE books SET copies = copies - 1 WHERE acc_no = $book_id";
                        mysqli_query($conn, $update_copies_query);
                    } else {
                        echo "<script>alert('Error updating book record')</script>";
                    }
                } else {
                    echo "<script>
                        alert('This Book is already available in your cart')
                    </script>";
                }
            } else {
                // Inserting the book to the cart with status pending
                $insert_query = "INSERT INTO borrowed_book_details(user_id, book_id, borrowed_date, return_date, status) VALUES
                ('$user_id', $book_id, '$borrowed_date', '$return_date', 'Pending')";

                if (mysqli_query($conn, $insert_query)) {
                    echo "<script>
                            alert('Book added to cart successfully')
                        </script>";

                    // Number of copies is deducted by 1
                    $update_query = "UPDATE books SET copies = copies - 1 WHERE acc_no = $book_id";
                    mysqli_query($conn, $update_query);
                } else {
                    echo "<script>
                            alert('Sorry! Something went wrong')
                        </script>";
                }
            }
        } else {
            echo "<script>
                    alert('Sorry! All copies have been borrowed')
                </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vidura College BookNest</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="index.js"></script>
    <style>
        ul {
            list-style: none;
        }
        #page-container {
            background-color: rgba(204, 195, 195, 0.3);
        }
        #cart_card {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 55%;
            height: fit-content;
            background-color: rgba(226, 117, 117, 0.7);
            border-radius: 20px;
            margin: 20px;
        }
        #borrow_details_container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 75%;
            height: 260px;
        }
        #book_img {
            height: 200px;
            width: 130px;
        }
        #book_title, #borrow_details {
            background-color: #FFEEEE;
            width: 80%;
            padding: 8px;
            border-radius: 10px;
        }
        #book_title {
            text-align: center;
            padding-left: 15px;
            padding-right: 15px;
        }
        #borrow_details {
            padding-left: 20px;
        }
        .no-books-message {
            background-color: #D9D9D9;
            width: 100%;
            justify-content: center;
            text-align: center;
            font-size: 20px;
            padding: 5px;
        }
        .read-now-btn {
            border-radius: 0.9em;
            border-color: #D9D9D9;
            padding: 5px;
            width: 100px;
            height: 30px;
            font-size: 15px;
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        @media screen and (max-width: 768px) {
            #cart_card {
                flex-wrap: wrap;
                width: fit-content;
            }
            #book_img {
                margin-top: 10px;
            }
            footer {
                position: relative;
            }
        }
    </style>
</head>
<body>
    <?php 
        include "chatbot.php"
    ?>
    <!-------------------------------Header Design------------------------------->
    <nav>
        <img src="./Assets/logo.jpg" alt="logo" style="width: 200px; padding: 10px;">
        <ul style="display: flex;">
            <li>
                <div class="nav-element-container">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <a href="home.php" class="header-links">Home</a>
                </div>
            </li>
            <li>
                <div class="nav-element-container">
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <a href="books.php" class="header-links">Books</a>
                </div>
            </li>
            <li>
                <div class="nav-element-container">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <a href="cart.php" class="header-links">Cart</a>
                </div>
            </li>
            <li>
                <div class="nav-element-container">
                    <i class="fa fa-credit-card-alt" aria-hidden="true" style="font-size: larger; padding-top: 3px;"></i>
                    <a href="payment.php" class="header-links">Payment</a>
                </div>
            </li>
        </ul>
    </nav>

    <?php 
        include "backbtn.php"
    ?>
    
    <div id="page-container">
        <div id="content-wrap">
            <!-------------------------------User Profile------------------------------->
            <div id="user-profile-container" onmouseover="showViewProfile()" onmouseleave="hideViewProfile()">
                <div id="view-profile-option">
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <p><?php echo htmlspecialchars($student_name); ?></p>
                        <a href="viewprofile.php" style="text-decoration: none;">View Profile</a>
                    </div>
                </div>
                <button type="button" id="user-profile-icon">
                    <i class="fa fa-user" aria-hidden="true" onclick="showMore()"></i>
                </button>
            </div>

            <div id="more-options">
                <a href="editprofile.php" class="more-options-links">Edit Profile</a>
                <a href="help.html" class="more-options-links">Help and Support</a>
                <a href="settings.html" class="more-options-links">Settings</a>
                <br>
                <br>
                <button type="button" class="btn" style="margin-left: 13px;">
                    <i class="fa fa-external-link" aria-hidden="true" style="color: blue; text-align: center;"></i>
                    <a href="logout.php" style="color: blue; text-decoration: none;font-weight: normal;font-family: 'Times New Roman', Times, serif;">Log Out</a>
                </button>
            </div>

            <section style="padding: 40px;">
                <?php
                    // Displaying the requested book
                    $search_books = "SELECT b.title, b.image, bb.borrow_id, bb.borrowed_date, bb.return_date, bb.status, b.file_path 
                                     FROM borrowed_book_details bb
                                     JOIN books b ON bb.book_id = b.acc_no
                                     WHERE bb.user_id = '$user_id' AND bb.status != 'Returned'
                                     ORDER BY bb.borrow_id DESC";

                    $result_query = mysqli_query($conn, $search_books);

                    if(mysqli_num_rows($result_query) > 0) {
                        while($fetch_book = mysqli_fetch_assoc($result_query)) {
                            echo '<div id="cart_card">
                                    <img id="book_img" src="Assets/uploaded_images/' . $fetch_book["image"] .' ">
                                    <div id="borrow_details_container">
                                        <h3 id="book_title">' . $fetch_book["title"] . '</h3>
                                        <div id="borrow_details">
                                            <p>Borrowed Date: ' . $fetch_book["borrowed_date"] . '</p>
                                            <p>Return Date: ' . $fetch_book["return_date"] . '</p>
                                            <p>Status: ' . $fetch_book["status"] . '</p>';
                
                            // Check if the book has a "Read Now" option
                            if (!empty($fetch_book["file_path"])) {
                                echo '<button type="button" class="read-now-btn">
                                        <a href="' . htmlspecialchars($fetch_book["file_path"]) . '" style="color: black; text-decoration: none;">
                                            Read Now
                                        </a>
                                      </button>';
                            }

                            echo '  </div>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo '<p class="no-books-message"> 
                                No books available in the cart 
                            </p>';
                    }
                ?>
            </section>
            
        </div>
        
        <!-------------------------------Footer------------------------------->
        <footer>
            <div id="footer-link-container">
                <ul>
                    <li><a href="home.php" class="footer-links">Home</a></li>
                    <li><a href="books.php" class="footer-links">Books</a></li>
                    <li><a href="cart.php" class="footer-links">Cart</a></li>
                    <li><a href="payment.php" class="footer-links">Payment</a></li>
                </ul>
            </div>
            <div id="contact-container">
                <ul style="line-height: 1.5em;">
                    <li>
                        <div style="display: flex; flex-direction: row;">
                            <i class="fa fa-map-marker" aria-hidden="true" style="margin-right: 42px; font-size: larger;"></i>
                            <a href="https://www.google.com/maps/dir//Vidura+College,+742%2F16+Samagi+Mawatha,+Hokandara+10230/data=!4m6!4m5!1m1!4e2!1m2!1m1!1s0x3ae250eed5064887:0x99747169de18801f?sa=X&ved=1t:57443&ictx=111"
                            class="footer-links">
                                742/16 Samagi Mawatha, Hokandara 10230
                            </a>
                        </div>
                    </li>
                    <li>
                        <div style="display: flex; flex-direction: row;">
                            <i class="fa fa-phone" aria-hidden="true" style="font-size: larger;"></i>
                            <ul style="display: flex; flex-direction: column;">
                                <li>+94 11 286 6238</li>
                                <li>+94 11 287 1861</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="social-media-container">
                <i class="fa fa-facebook-square" aria-hidden="true"></i>
                <i class="fa fa-instagram" aria-hidden="true"></i>
                <i class="fa fa-twitter" aria-hidden="true"></i>
            </div>
        </footer>
    </div>
</body>
</html>