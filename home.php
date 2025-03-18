<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vidura College BookNest</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="home.js"></script>
    <script src="index.js"></script>
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
        #about-section {
            display: flex;
            margin-top: 40px;
            margin-left: 30px;
            margin-right: 30px;
            padding: 10px;
            width: fit-content;
            background-color: rgba(229, 194, 187, 0.9);
            border-radius: 25px;
        }
        #gallerybox {
            display: flex;
            justify-content: center;
            margin: 20px;
        }
        .imagegallery, .mySlides{
            width: 44.375em;
            height: 35em;
        }
        .mySlides {
            border: 2px solid rgb(160, 81, 81);
        }
        .btn-left{
            font-size: xx-large;
            top: 380px;
            margin-left: 20px;
            position: absolute;
        }
        .btn-right{
            font-size: xx-large;
            position: absolute;
            top: 380px;
            margin-left: 670px;
        }
        .about-content {
            display: flex;
            justify-content: center;
            flex-direction: column;
            padding: 20px;
        }
        footer {
            position: relative;
        }
        @media screen and (max-width: 768px) {
            .search-bar {
                margin-top: 40px;
            }
            .search-bar input {
                padding: 5px 35px;
                height: 25px;
                width: 300px;
            }
            #about-section {
                flex-wrap: wrap;
                margin-left: 10px;
                margin-right: 10px;
            }
            .imagegallery, .mySlides{
                width: 25em;
                height: 20em;
            }
            .btn-left{
                top: 300px;
                margin-left: 20px;
            }
            .btn-right{
                top: 300px;
                margin-left: 370px;
            }
        }
    </style>
</head>
<body>
    <!--To display student name-->
    <?php 
        include "index.php";
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
                    <form action="books.php" method="GET">
                        <input id="author-filter" type="text" placeholder="Type" name="author" style="width: 350px; height: 20px; padding: 5px;">
                    </form>
                </div>
            </div>    

            <!-------------------------------About Section------------------------------->
            <section id="about-section">
                <!-------------------------------Picture Gallery------------------------------->
                <div id="gallerybox">  
                    <div class="imagegallery"> 
                        <div class="slide">
                            <img class="mySlides" src="Assets/library1.jpg">
                            <img class="mySlides" src="Assets/library2.jpg">
                            <img class="mySlides" src="Assets/lib3.png">
                            <img class="mySlides" src="Assets/lib4.jpeg">
                            <img class="mySlides" src="Assets/lib5.jpeg">
                            <img class="mySlides" src="Assets/lib6.jpeg">
                            
                            <i class="fa fa-angle-right btn-right" aria-hidden="true" onclick="plusDivs(-1)"></i>
                            <i class="fa fa-angle-left btn-left" aria-hidden="true" onclick="plusDivs(1)"></i>
                        </div>
                    </div>
            
                    <script>
                        var slideIndex = 1;
                        showDivs(slideIndex);

                        function plusDivs(n) {
                        showDivs(slideIndex += n);
                        }

                        function showDivs(n) {
                            var i;
                            var x = document.getElementsByClassName("mySlides");
                            if (n > x.length) {
                                slideIndex = 1
                            }    
                            if (n < 1) {
                                slideIndex = x.length
                            }
                            for (i = 0; i < x.length; i++) {
                                x[i].style.display = "none";  
                            }
                            x[slideIndex-1].style.display = "block";  
                        }

                        var slideIndex = 0;
                        carousel();

                        function carousel() {
                            var i;
                            var x = document.getElementsByClassName("mySlides");
                            for (i = 0; i < x.length; i++) {
                            x[i].style.display = "none"; 
                            }
                            slideIndex++;
                            if (slideIndex > x.length) {
                                slideIndex = 1
                            } 
                            x[slideIndex-1].style.display = "block"; 
                            setTimeout(carousel, 4000); 
                        }
                    </script>
                </div>

                <!-------------------------------Details------------------------------->
                <div class="about-content">
                    <h1 style="font-family: cursive;">About Us</h1>
                    <h3>Our Mission</h3>
                    <p style="font-size: larger; line-height: 1.5em;">
                        At BookNest, our mission is to streamline and enhance the library experience for both patrons and 
                        librarians. We aim to provide a user-friendly platform that simplifies book borrowing, 
                        catalog management, and information accessibility.
                    </p>
                    <h3>Our Vision</h3>
                    <p style="font-size: larger; line-height: 1.5em;">
                        At BookNest, we envision a future where every library is a vibrant hub of knowledge and community engagement.
                        By harnessing the power of technology, we aim to transform the library experience, making it more accessible, 
                        efficient, and enjoyable for everyone.
                    </p>
                </div>
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