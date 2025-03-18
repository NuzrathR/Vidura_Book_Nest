<?php
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
    <style>
        .content-container {
            background-color: #E5DAD8;
            border-radius: 15px;
            padding: 20px 50px;
            margin: 40px;
            text-align: center;
        }

        #form-container {
            background-color: #D09594;
            padding: 15px;
            border-radius: 10px;
            margin-top: 3%;
            margin-bottom: 5%;
        }

        label {
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 400px;
            height: 5%;
            border-radius: 5px;
            border-color: #D09594;
            padding: 5px;
        }

        .submit-btn {
            width: 120px;
            height: 40px;
            font-size: large;
            font-weight: bold;
            padding: 8px;
            border-radius: 0.8em;
        }
        @media screen and (max-width: 768px) {
            .content-container {
                width: 400px;
                padding: 30px;
                margin-top: 50px;
            }
            input,
            select,
            textarea {
                width: 280px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="admin.php">
            <img src="./Assets/logo.jpg" alt="logo" style="width: 200px; padding: 10px;">
        </a>
    </nav>
    <div id="page-container">
        <?php
            include "backbtn.php";
        ?>
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

        <!-------------------------------Content------------------------------->
        <div style="display: flex; justify-content: center; align-items: center;">
            <div class="content-container">
                <img src="./Assets/logo.jpg" alt="logo" style="height: 100px; padding-top: 10px;">
                <h2>Add New Book</h2>
                <form id="form-container" action="manageBookRecords.php" method="POST" enctype="multipart/form-data">
                    <table align="center" cellpadding="3px" style="text-align: left;">
                        <tr>
                            <td><label for="acc_no">ACC.No</label></td>
                            <td>
                                <input type="text" id="acc_no" name="acc_no">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="title">Book Title</label></td>
                            <td>
                                <input type="text" id="title" name="title" required>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="book_image">Book Cover Page</label></td>
                            <td>
                                <input type="file" id="book_image" name="book_image" accept="image/jpg, image/jpeg, image/png" style="padding-left: 0%;" required>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="book_link">Online Reading Link</label></td>
                            <td>
                                <input type="text" id="book_link" name="book_link">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="category">Category</label></td>
                            <td>
                                <select name="category" style="width: 100%;">
                                    <option value="select">Select</option>
                                    <option value="English Fiction">English Fiction</option>
                                    <option value="Non Fiction">Non Fiction</option>
                                    <option value="Science">Science</option>
                                    <option value="History">History</option>
                                    <option value="Language">Language</option>
                                    <option value="English Literature">English Literature</option>
                                    <option value="Technology">Technology</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="author">Author</label></td>
                            <td>
                                <input type="text" id="author" name="author" required>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="book_copies">Book Copies</label></td>
                            <td>
                                <input type="number" id="book_copies" name="book_copies">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="publisher">Publisher Name</label></td>
                            <td>
                                <input type="text" id="publisher" name="publisher" required>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="isbn">ISBN</label></td>
                            <td>
                                <input type="text" id="isbn" name="isbn" required>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="copyright_year">Copyright Year</label></td>
                            <td>
                                <input type="text" id="copyright_year" name="copyright_year">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="class_no">Class No</label></td>
                            <td>
                                <input type="text" id="class_no" name="class_no">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="book_price">Book Price</label></td>
                            <td>
                                <input type="number" id="book_price" name="book_price">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="status">Status</label></td>
                            <td>
                                <select name="status" style="width: 100%;">
                                    <option value="select">Select</option>
                                    <option value="Old">Old</option>
                                    <option value="New">New</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="comment">Comment</label></td>
                            <td>
                                <textarea id="comment" name="comment" style="height: 70px;"></textarea>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type="submit" id="insert" name="insert" value="INSERT" class="submit-btn" style="background-color: #AA9595;">
                </form>
            </div>
        </div>        
    </div>
</body>
</html>