<?php

//Includes configuration and main index file
include 'config.php';
include 'index.php';

// Fetch user details from the database


$user = [];
//Initialize user array and retrieve session username
$user_id = $_SESSION['username'];
$stmt = $conn->prepare("SELECT user_id, name, email, contact_no, grade_class FROM members WHERE user_id = ?");
// ensures the query is securely parameterized.
$stmt->bind_param("i", $user_id);

//runs the SQL query.
$stmt->execute();
//fetches the query result.
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        ul {
            list-style: none;
        }
 
        @media screen and (max-width: 480px) {
    .content-container {
        padding: 15px;
    }
}
        .content-container {
            background-color: #E5DAD8;
            border-radius: 15px;
            height: fit-content;
            width: 600px;
            padding: 50px;
            margin: 40px;
            text-align: center;
            flex-direction: column;
            display: flex;
        }
        #form-container {
            background-color: #D09594;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10%;
            margin-bottom: 40px;
            height: 70%;
            width: fit-content;
            flex-direction: column;
            display: flex;
        }
        label {
            font-weight: bold;
        }
        input {
            width: 300px; 
            height: 15px; 
            border-radius: 5px;
            border-color: #D09594;
            padding: 5px;
        }
        .error {
            color: #FF0000;
            font-size: 1.0em;
        }
        .submit-btn {
            width: 120px;
            height: 40px;
            font-size: large;
            font-weight: bold;
            padding: 8px;
            border-radius: 0.8em;
            margin-bottom: 8px;
            cursor: pointer;
        }


        footer {
            position: relative;
        }


      
    </style>
</head>
<body>
    <!-------------------------------Header Design------------------------------->
    <nav>
        <img src="./Assets/logo.jpg" alt="logo" style="width: 200px; padding: 10px;">
       
    </nav>


    
    <?php 
        include "backbtn.php"
    ?>
    
    <section style="display: flex; justify-content: center;">
        <div class="content-container" style="display: flex; justify-content: center; align-items: center;">
            <img src="./Assets/logo.jpg" alt="logo" id="logo">
            <div id="form-container">
                <!-- Profile Edit Form -->
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <table align="center" cellpadding="3px" style="text-align: left; width: 400px; height: 300px; ">
                        <tr>
                            <td colspan="2" style="text-align: center;">
                            <i class="fa fa-user" aria-hidden="true" style="font-size:40px;"> </i>
                            <h1 style="display: inline-block; margin-left:30px;">Profile Details</h1>
                            </td>
                        </tr>
                        <tr>
                            <td><label>User ID:</label></td>
                            <!---Uses htmlspecialchars() for security-->
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        </tr>
                        <tr>
                            <td><label>Name:</label></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                        </tr>
                        <tr>
                            <td><label>Email:</label></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                        <tr>
                            <td><label>Contact No:</label></td>
                            <td><?php echo htmlspecialchars($user['contact_no']); ?></td>
                        </tr>
                        <tr>
                            <td><label>Grade/Class:</label></td>
                            <td><?php echo htmlspecialchars($user['grade_class']); ?></td>
                        </tr>
                    </table>
                    <br>
                    <a href="editprofile.php" id="add" name="add" class="submit-btn" style="background-color: #AA9595; color: black; text-decoration: none; display: inline-block; text-align: center; padding: 10px 20px; line-height: 1.9; border-radius: 20px; border: 1px solid black;">Edit Profile</a>
                </form>
            </div>
        </div>
    </section>

        <!--Footer-->
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
</body>
</html>