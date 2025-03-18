<?php
    //Include the database connection file
    include "config.php";


    // Initialize error message variables
    // Initializes error message variables for email, new password, and confirm password
    $emailError = $newPassError = $confirmPassError = "";
    $email = $new_password = $confirm_password = "";
    $valid = true;

    // Check if the form is submitted using the POST method and if the update button was clicked.
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {

        // Retrieve form inputs (email, new password, and confirm password) from the POST request.
        $email = $_POST['email'];
        $new_password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate email input
        // Checks if the email field is empty.
        if (empty($email)) {
            $emailError = "Email is required.";
            // If empty, sets an error message and marks form validation as false.
            $valid = false;
        }

        // To ensure that the password is strong enough
        if (!preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$#", $new_password)) {
            $newPassError = "Password must contain at least 1 uppercase <br> letter, 1 lowercase letter, 1 digit, and be at <br> least 8 characters long";
            $valid = false;
        }

         // Validate password confirmation
        if ($new_password !== $confirm_password) {
            $confirmPassError = "Passwords do not match.";
            $valid = false;
        }

        // If all inputs are valid, update the password in the database
        if ($valid) {
            // Update the password in the database
            $sql = "UPDATE members SET password=? WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $confirm_password, $email);
            $stmt->execute();
            $stmt->close();

            // Display success message and redirect to login page
            echo 
                "<script type=\"text/javascript\"> 
                    window.alert('Password reset successfully');
                    window.location.href = 'login.php';
                </script>";
        }     
    }

     // Close the database connection

    $conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <!---Specifies character encoding as UTF-8-->
    <meta charset="UTF-8">
    <!---Sets viewport for responsiveness-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="index.css">
    <script src="index.js"> </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-size: large;
            display: flex;
            justify-content: center;
            align-items: center;
        }
     
/* Mobile Responsiveness */
@media screen and (max-width: 768px) {
    .content-container {
        width: 90%;
        padding: 30px;
        margin: 20px;
    }
}
        .content-container {
            background-color: #E5DAD8;
            border-radius: 15px;
            height: 70%;
            width: 600px;
            padding: 50px;
            margin: 40px;
            text-align: center;
        }
        #form-container {
            background-color: #D09594;
            padding: 15px;
            border-radius: 10px;
            margin: 30px;
            height: 65%;
        }
        .user-input-container {
            text-align: left; 
            padding: 10px;
            margin-top: 10px;
        }
        label {
            font-weight: bold; 
            font-size: large;
        }
        input {
            width: 350px; 
            height: 20px; 
            border-radius: 5px;
            border-color: #D09594; 
            padding: 5px;
        }
        .submit-btn {
            width: 200px;
            height: 40px;
            font-size: large;
            font-weight: bold;
            padding: 8px;
            border-radius: 0.8em;
            margin-top: 15px;
            cursor: pointer;
        }
        .error {
            color: #FF0000;
            font-size: 1.0em;
        }

        
        .fa {
            position: absolute; 
            right: 10px; 
            top: 50%;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <img src="./Assets/logo.jpg" alt="logo" id="logo">
        <div id="form-container" style="display: flex; align-items: center; justify-content: center;">
            <form id="resetForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="user-input-container">
                    <label for="email">Email</label>
                    <br>
                    <div style="position: relative; height: 20px;">
                        <input type="email" id="email" name="email" value="<?php echo $email;?>" placeholder="Enter email" autocomplete="email">
                    </div>
                    <br>
                    <span class="error" id="emailError"><?php echo $emailError; ?></span>
                </div>
                <div class="user-input-container">
                    <label for="new-password">New Password</label>
                    <br>
                    <div style="position: relative; height: 20px;">
                        <input type="password" id="password" name="password" value="<?php echo $new_password;?>" placeholder="Enter new password" autocomplete="new-password">
                        <i id="icon-eye" class="fa fa-eye-slash" aria-hidden="true" onclick="togglePassword()"></i>
                    </div>
                    <br>
                    <span class="error" id="newPassError"><?php echo $newPassError; ?></span>
                </div>
                <div class="user-input-container">
                    <label for="confirm-password">Confirm Password</label>
                    <br>
                    <div style="position: relative; height: 20px;">
                        <!---Includes an eye icon for toggling visibility-->
                        <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $confirm_password;?>" placeholder="Confirm new password" autocomplete="off">
                        <i id="confirm-icon-eye" class="fa fa-eye-slash" aria-hidden="true" onclick="toggleConfirmPassword()"></i>
                    </div>
                    <br>
                    <span class="error" id="confirmPassError"><?php echo $confirmPassError; ?></span>
                </div>
                <input type="submit" name="update" value="RESET PASSWORD" class="submit-btn" style="background-color: #AA9595;">
            </form>
        </div>
    </div>
</body>
</html>