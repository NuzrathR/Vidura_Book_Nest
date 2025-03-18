<?php
    include "config.php";
    include "index.php";
    include "chatbot.php";
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        ul {
            list-style: none;
        }
        .payment-content-container {
            background-color: #E5DAD8;
            border-radius: 15px;
            height: 350px;
            width: 300px;
            padding: 20px;
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 40px;
            margin-top: 20px;
            text-align: center;
        }
        .btn-start {
            background-color: #E5C2BB;
            padding: 8px 18px;
            font-size: large;
            font-weight: bold;
            border-color: #E5C2BB;
            margin-top: 20px;
        }

        .back-arrow {
            display: inline-block;
            padding: 4px;
            background-color:#D09594; /* Bootstrap primary color */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
            transition: background-color 0.3s;
            z-index: 100;
            margin: 10px;
            position: absolute;
        }

        .back-arrow:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .arrow {
            font-size: 15px; /* Adjust size of the arrow */
        }

        @media screen and (max-width: 768px) {
            footer {
                position: relative;
            }
        }
    </style>
</head>
<body>
    <!--Header Design-->
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

    <a href="javascript:history.back()" class="back-arrow">
        <span class="arrow">&#8592;</span> Back
    </a>

    <div id="page-container" style="min-height: 40vh;">
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

            <!--Content-->
            <section style="padding: 40px;">
                <div style="display: flex; justify-content: center; align-items: center; margin-top: 30px; flex-wrap: wrap;">
                    <div class="payment-content-container" id="membership-plan">
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <h1>1 Year Plan</h1>
                            <h2 style="color: #0E0C52;">
                                LKR 250 <br>
                                for every two years
                            </h2>
                            <p style="color: #2C852B;">
                                Add up to 2 books per month <br>
                                Can read up to 2 weeks time
                            </p>
                            <button type="button" class="btn-start" id="oneyr" data-plan="One Year" data-price=250>GET STARTED</button>
                        </div>
                    </div>
                    <div class="payment-content-container" id="fine-payment">
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <h1 style="font-family: 'Lobster Two';">2 Year Plan</h1>
                            <h2 style="color: #0E0C52;">
                                LKR 650 <br>
                                for every four years 
                            </h2>
                            <p style="color: #2C852B;">
                                Add up to 4 books per month<br>
                                Can read up to a month
                            </p>
                            <button type="button" class="btn-start" id="twoyr" data-plan="Two Years" data-price=650>GET STARTED</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script>
            $(document).on("click", "#oneyr, #twoyr", function() {
                const plan = $(this).data("plan");
                const price = $(this).data("price");

                // Store data in localStorage
                localStorage.setItem("plan", plan);
                localStorage.setItem("price", price);

                window.location.href = "uploadSlip.html";
            });
        </script>
        <!-----------------------------------Footer---------------------------------------------------->
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
</body>
</html>