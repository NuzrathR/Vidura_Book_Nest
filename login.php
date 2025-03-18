<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vidura College BookNest</title>
    <link rel="stylesheet" href="index.css">
    <script src="index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-size: large;
            display: flex;
            justify-content: center;
            align-items: center;
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
            margin-top: 20px;
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
            width: 120px;
            height: 40px;
            font-size: large;
            font-weight: bold;
            padding: 8px;
            border-radius: 0.8em;
            margin-bottom: 8px;
            cursor: pointer;
        }
        .error {
            color: #FF0000;
            font-size: 1.0em;
            padding-top: 5px;
        }
        a {
            text-decoration: none;
            font-size: 15px;
            display: flex;
            justify-content: flex-end;
            padding: 8px;
        }
        .fa {
            position: absolute; 
            right: 10px; 
            top: 50%;
            cursor: pointer;
        }
        /* Mobile Responsive Styles */
        @media screen and (max-width: 768px) {
            body {
                font-size: medium;
            }
            .content-container {
                width: 500px;
                padding: 30px;
            }
            input {
                width: 250px;
            }
        }
    </style>
</head>
<body>
    <?php
        // Starting the session
        session_start();

        // Setting up the connection
        include "config.php";

        // Checking if the connection was successful
        if (!$conn) {
            die("Connection Unsuccessful: " . mysqli_connect_error());
        }


        // Initializing variables
        $usernameErr = $passwordErr = "";
        $username = $password = "";

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            if(!(empty($username) || empty($password))) {
                // check if the user already exists
                $search_id = "SELECT * FROM members WHERE user_id = '$_POST[username]'";
                $result = mysqli_query($conn,$search_id);

                if ($result->num_rows == 1) {
                    // Get user data
                    $row = mysqli_fetch_assoc($result);
                    $stored_password = $row['password'];

                    if($password == $stored_password) {
                        // Storing user details to get in home.php
                        $_SESSION['username'] = $row['user_id'];
                        $_SESSION['name'] = $row['name'];
                        
                        // Redirecting based on user role
                        if ($row['user_id'] == "AAAA") {
                            header('Location: admin.php');
                        } else {
                            header('Location: home.php');
                        }
                        exit();
                    } else {
                        $passwordErr = "Incorrect Password";
                    }
                } else {
                    $usernameErr = "Invalid Username";
                }
            } else {
                $usernameErr = "Username is required";
                $passwordErr = "Password is required";
            }
            
        }
    ?>

    <div class="content-container">
        <img src="./Assets/logo.jpg" alt="logo" id="logo">
        <div id="form-container" style="display: flex; align-items: center; justify-content: center;">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="user-input-container">
                    <label for="username">Username</label>
                    <br>
                    <input type="text" id="username" name="username" value="<?php echo $username; ?>" placeholder="Admission Number">
                    <br>
                    <span class="error"><?php echo $usernameErr; ?></span>
                </div>
                <div class="user-input-container">
                    <label for="password">Password</label>
                    <br>
                    <div style="position: relative; height: 20px;">
                        <input type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder="Password">
                        <i id="icon-eye" class="fa fa-eye-slash" aria-hidden="true" onclick="togglePassword()"></i>
                    </div>
                    <div style="display: flex; justify-content:space-between; margin-top: 10px">
                        <span class="error"><?php echo $passwordErr; ?></span>
                        <a href="forgotPassword.php">Forgot?</a>
                    </div>
                </div>
                <input type="submit" id="login" name="login" value="LOGIN" class="submit-btn" style="background-color: #AA9595;">
            </form>
        </div>
    </div>
</body>
</html>