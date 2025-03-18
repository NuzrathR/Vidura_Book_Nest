<?php
    // To connect to the database
    include "config.php";

    // To display student name
    include "index.php";

    // To display chatbot
    include "chatbot.php";

    if(isset($_GET['id'])) {
        $book_id = $_GET['id'];
        $search_query = "SELECT * FROM books WHERE acc_no = $book_id";
        $result_query = mysqli_query($conn,$search_query);

        if(mysqli_num_rows($result_query) > 0) {
            $book = mysqli_fetch_assoc($result_query);
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
    <script src="home.js"></script>
    <script src="books.js"></script>
    <style>
        ul {
            list-style: none;
        }
        #page-container {
            background-color: rgba(204, 195, 195, 0.3);
        }
        #book_details_container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding-top: 20px;
        }
        #book_img {
            height: 300px;
            width: 220px;
            margin-top: 10px;
        }
        #book_title {
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
        .add-cart-btn {
            width: 120px;
            height: 40px;
            font-size: large;
            padding: 8px;
            border-color: #D9D9D9;
            border-radius: 0.8em;
            margin-top: 20px;
            cursor: pointer;
        }
        .read-now-btn {
            border-radius: 0.8em;
            border-color: #D9D9D9;
            padding: 8px;
            width: 120px;
            font-size: 20px;
            color: black;
            text-decoration: none;
            margin-top: 20px;
            margin-bottom: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
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
            <!--User Profile-->
            <div id="user-profile-container" onmouseover="showViewProfile()" onmouseleave="hideViewProfile()">
                <div id="view-profile-option">
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <p><?php echo htmlspecialchars($student_name); ?></p>
                        <a href="viewProfile.php" style="text-decoration: none;">View Profile</a>
                    </div>
                </div>
                <button type="button" id="user-profile-icon">
                    <i class="fa fa-user" aria-hidden="true" style="font-size: xx-large;" onclick="showMore()"></i>
                </button>
            </div>

            <div id="more-options">
                <a href="editProfile.php" class="more-options-links">Edit Profile</a>
                <a href="help.html" class="more-options-links">Help and Support</a>
                <a href="settings.html" class="more-options-links">Settings</a>
                <br>
                <br>
                <button type="button" class="btn" style="margin-left: 13px;">
                    <i class="fa fa-external-link" aria-hidden="true" style="color: blue; text-align: center;"></i>
                    <a href="logout.php" style="color: blue; text-decoration: none;font-weight: normal;font-family: 'Times New Roman', Times, serif;">Log Out</a>
                </button>
            </div>

            <!-------------------------------Book Details------------------------------->
            <div id="book_details_container">
                <h2 id="book_title"><?php echo htmlspecialchars($book['title']); ?></h2>
                <img id="book_img" src="Assets/uploaded_images/<?php echo htmlspecialchars($book['image']); ?>">
                <form action="cart.php" method="post">
                    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['acc_no']); ?>">
                    <input class="add-cart-btn" type="submit" name="addCart" value="Add to Cart">
                </form>
                <?php if (!empty($book['file_path'])): ?>
                    <button type="button" class="read-now-btn">
                        <a href="<?php echo htmlspecialchars($book['file_path']); ?>" style="color: black; text-decoration: none;font-weight: normal;font-family: 'Times New Roman', Times, serif;">
                            Read Now
                        </a>
                    </button>
                <?php endif; ?>
            </div>
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