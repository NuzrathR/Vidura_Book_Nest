<?php
    // To display student name
    include "index.php";
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
    <script src="home.js"></script>
    <script src="books.js"></script>
    <style>
        ul {
            list-style: none;
        }
        .search-bar {
            display: flex;
            align-items: center;
            margin-top: 20px;
            width: fit-content;
        }
        .search-bar input {
            border: none;
            background-color: #E5C2BB;
            padding: 10px 40px;
            border-radius: 25px;
            height: 25px;
            width: 400px;
        }
        .fa-filter {
            position: relative;
            font-size: large;
            left: 30px;
        }
        .fa-search {
            position: relative;
            font-size: large;
            right: 30px;
        }
        #filter-options {
            background-color: #E5DAD8;
            width: 420px;
            padding: 10px;
            padding-bottom: 20px;
            position: absolute;
            z-index: 1;
        }
        .btn-genre, .btn-author {
            padding: 5px 20px;
            font-weight: bold;
        }
        .book_category_container {
            margin-left: 40px;
            margin-right: 40px;
            justify-content: center;
        }
        #search_heading {
            display: block;
            background-color: #D9D9D9;
            border-radius: 20px;
            width: fit-content;
            height: fit-content;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 25px;
            padding-right: 25px;
        }
        #book_list_container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            width: 100%;
            height: fit-content;
        }
        #book_display_container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            width: 100%;
            height: fit-content;
        }
        .book_container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: fit-content;
            height: fit-content;
            margin-right: 10px;
            padding: 8px;
            margin: 10px;
        }
        #book_img {
            height: 250px;
            width: 170px;
        }
        #book_title {
            background-color: #D9D9D9;
            padding: 3px;
            border-radius: 20px;
            width: 200px;
            text-align: center;
            height: fit-content;
        }
        .view-more-btn {
            width: 120px;
            height: 40px;
            font-size: large;
            padding: 5px;
            border: 1px solid white;
            border-radius: 0.8em;
            margin: 20px;
            color: #0029FF;
        }
        #page-container {
            background-color: rgba(204, 195, 195, 0.3);
        }
        .no-books-message {
            background-color: #D9D9D9;
            width: 100%;
            justify-content: center;
            text-align: center;
            font-size: 20px;
            padding: 5px;
        }
        footer {
            position: relative;
        }
        @media screen and (max-width: 768px) {
            .search-bar {
                margin-top: 45px;
            }
            .search-bar input {
                padding: 5px 35px;
                height: 25px;
                width: 300px;
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
        include "backbtn.php";
    ?>

    <div id="page-container">
        <div id="content-wrap">
            <!--User Profile-->
            <div id="user-profile-container" onmouseover="showViewProfile()" onmouseleave="hideViewProfile()">
                <div id="view-profile-option">
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <p><?php echo htmlspecialchars($student_name); ?></p>
                        <a href="viewProfile.php" style="text-decoration: none;">View Profile</a>
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

            <!-------------------------------Search Bar------------------------------->
            <form id="searchForm" action="books.php" method="GET" style="display: flex; justify-content: center;">
                <div class="search-bar">
                    <i class="fa fa-filter" aria-hidden="true" onclick="showFilterOptions()"></i>
                    <input id="search-bar" type="text" placeholder="Search" name="search">
                    <button type="submit" style="background: none; border: none; padding: 0;">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>

            <!-------------------------------Filter Options------------------------------->
            <div id="filter-options-container" style="display: none; justify-content: center;">
                <div id="filter-options">
                    <h4>Genre</h4>
                    <div style="padding: 5px;">
                        <button type="button" class="btn-genre" onclick="filterBooks('English Fiction')">Fiction</button>
                        <button type="button" class="btn-genre" onclick="filterBooks('Non Fiction')">Non-Fiction</button>
                        <button type="button" class="btn-genre" onclick="filterBooks('Science')">Science</button>
                        <button type="button" class="btn-genre" onclick="filterBooks('History')">History</button>
                    </div>
                    <div style="padding: 5px;">
                        <button type="button" class="btn-genre" onclick="filterBooks('Language')">Language</button>
                        <button type="button" class="btn-genre" onclick="filterBooks('English Literature')">Literature</button>
                        <button type="button" class="btn-genre" onclick="filterBooks('Technology')">Technology</button>
                    </div>
                    <h4>Author</h4>
                    <input id="author-filter" type="text" placeholder="Type" style="width: 350px; height: 20px; padding: 5px;" oninput="filterBooksByAuthor(this.value)">
                </div>
            </div>

            <!-------------------------------Book Collection------------------------------->
            <section class="book_category_container">
                <h2 id="search_heading">Top Recommendations</h2>
                <div id="book_list_container">
                    <?php 
                        include "config.php";

                        // Retrieve search term from GET request
                        $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                        $title = $_GET["title"] ?? '';
                        $category = $_GET["genre"] ?? '';
                        $author = $_GET["author"] ?? '';

                        $limit = 5; // Consistent limit
                        $offset = 0;

                        // Build the SQL query based on filters
                        $search_books = "SELECT b.*, COUNT(br.book_id) AS borrow_count 
                                FROM books b
                                LEFT JOIN borrowed_book_details br ON b.acc_no = br.book_id
                                WHERE 1";
                    
                        // Add the search term condition
                        if ($searchTerm) {
                            $search_books .= " AND (b.title LIKE '%$searchTerm%' OR b.author LIKE '%$searchTerm%')";
                        }

                        if ($title) {
                            $search_books .= " AND title LIKE '%$title%'";
                        }
                        if ($category) {
                            $search_books .= " AND category = '$category'";
                        }
                        if ($author) {
                            $search_books .= " AND author LIKE '%$author%'";
                        }

                        // Group results by book and order by most borrowed
                        $search_books .= " GROUP BY b.acc_no 
                                ORDER BY borrow_count DESC 
                                LIMIT $limit"; 

                        $result_query = mysqli_query($conn,$search_books);

                        // Build the query to check if there are more books AFTER applying filters
                        $check_more_books = "SELECT COUNT(DISTINCT b.acc_no)
                                            FROM books b
                                            LEFT JOIN borrowed_book_details br ON b.acc_no = br.book_id
                                            WHERE 1";
                        
                        //Add the search term condition to the total count query as well!
                        if ($searchTerm) {
                            $check_more_books .= " AND (b.title LIKE '%$searchTerm%' OR b.author LIKE '%$searchTerm%')";
                        }

                        if ($title) {
                            $check_more_books .= " AND title LIKE '%$title%'";
                        }
                        if ($category) {
                            $check_more_books .= " AND category = '$category'";
                        }
                        if ($author) {
                            $check_more_books .= " AND author LIKE '%$author%'";
                        }

                        $check_more_books_result = mysqli_query($conn, $check_more_books);
                        $check_more_books_row = mysqli_fetch_assoc($check_more_books_result);
                        $totalBooks = $check_more_books_row["COUNT(DISTINCT b.acc_no)"] ?? 0;

                        // Counts the number of displayed books
                        $count = 0;

                        if (mysqli_num_rows($result_query) > 0) {
                            echo '<div id="book_display_container">';
                        
                            while($fetch_book = mysqli_fetch_assoc($result_query)) {
                                echo '<div class="book_container">
                                        <img id="book_img" src="Assets/uploaded_images/' . $fetch_book["image"] .' ">
                                        <a href="book_details.php?id=' . $fetch_book["acc_no"] . '" style="text-decoration:none; color: black;">
                                            <h3 id="book_title">' . $fetch_book["title"] . '</h3>
                                        </a>
                                    </div>'; 
                                
                                $count++;
                            }
                        
                            echo '</div>';

                            // Display "View More" button only if there are more books to show
                            if ($totalBooks > $count) {
                                echo '<input type="button" value="More" name="view-more" id="view-more-btn" class="view-more-btn">';
                            }

                        } else {
                            echo '<p class="no-books-message">Sorry, No books available</p>';
                        }  
                    ?>
                </div>
            </section>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function () {
                    let limit = 2; // Number of books per request

                    $("#view-more-btn").click(function () {
                        // Get the current offset by counting the number of displayed book containers
                        const offset = $("#book_display_container .book_container").length;
                        
                        let title = "<?php echo $title; ?>";
                        let author = "<?php echo $author; ?>";
                        let category = "<?php echo $category; ?>";

                        $.ajax({
                            url: "fetchMoreBooks.php",
                            type: "POST",
                            data: { title, author, category, offset, limit },
                            success: function (response) {
                                if (response.trim() === "") {
                                    $("#view-more-btn").hide(); // Hide button if no more books
                                } else {
                                    $("#book_display_container").append(response);
                                    
                                    // Check if the displayed books are equal to or greater than the totalBooks
                                    const displayedBooks = $("#book_display_container .book_container").length;
                                    const totalBooks = <?php echo $totalBooks; ?>;

                                    if (displayedBooks >= totalBooks) {
                                        $("#view-more-btn").hide();
                                    }
                                }
                            }
                        });
                    });
                });
            </script>
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
