<?php
    include "config.php";
    include "index.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vidura College BookNest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="index.css">
    <script src="index.js"></script>
    <style>
        ul {
           list-style: none; 
        }
        .btn-option {
            background-color: #D09594;
            padding: 10px;
            border-radius: 10px;
            border-color: #D09594;
            width: 200px;
            margin: 20px;
            font-size: large;
            font-weight: bold;
        }
        .content-container {
            background-color:#E5DAD8;
            border-radius: 15px;
            height: max-content;
            width: 500px;
            padding: 50px;
            margin: 40px;
            text-align: center;
        }

        #page-container {
            position: relative;
        }
        /* Mobile Responsive Styles */
        @media screen and (max-width: 768px) {
            .content-container {
                margin-top: 50px;
            }
        }
    </style>
</head>
<body>
    <script type="text/javascript">
        function addBook() {
            window.location.href="addBook.php";
        }
        function updateBook() {
            window.location.href="updateBook.php";
        }
        function deleteBook() {
            window.location.href="bookDetails.html";
        }
        function viewRecords() {
            window.location.href="viewRecords.php";
        }
    </script>
    <nav>
        <a href="admin.php">
            <img src="./Assets/logo.jpg" alt="logo" style="width: 200px; padding: 10px;">
        </a>
        
    </nav>
    
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
                <a href="welcome.html" style="color: blue; text-decoration: none;font-weight: normal;font-family: 'Times New Roman', Times, serif;">Log Out</a>
            </button>
        </div>
    </div>

    <div style="display: flex; justify-content:center; align-items:center;">
        <div class="content-container">
            <img src="./Assets/logo.jpg" alt="logo" style="height: 100px;">

            <div style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <button type="button" class="btn-option" onclick="addBook()">Add a new Book</button>
                <button type="button" class="btn-option" onclick="updateBook()">Update Book</button>
                <button type="button" class="btn-option" onclick="deleteBook()">Delete Book</button>
                <button type="button" class="btn-option" onclick="viewRecords()">View Records</button>
            </div>
        </div>
    </div>
</body>
</html>