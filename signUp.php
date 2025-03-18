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
            height: 75%;
            width: 600px;
            padding: 50px;
            margin: 40px;
            text-align: center;
        }
        #form-container {
            background-color: #D09594;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10%;
            margin-bottom: 40px;
            height: 70%;
            width: fit-content;
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
        .fa {
            position: absolute;
            right: 10px; 
            top: 5px;
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

        // Setting up the connection
        //Includes the database configuration file (config.php) to establish a connection.
        include "config.php";

        //Declares variables to store form input values and error messages.
        $nameErr = $emailErr = $contactNoErr = $gradeClassErr = $admissionNoErr = $passwordErr = "";
        $name = $email = $contact_no = $grade_class = $admission_no = $password = "";

        // Validation of Input 
        $valid = true;


        function test_input($data) {
            $data = trim($data);      // Remove spaces from beginning and end
            $data = stripslashes($data);  // Remove backslashes
            $data = htmlspecialchars($data); // Convert special characters to HTML entities
            return $data;
        }
    
        // Importing PHPMailer for Email Notifications
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';

        //Checks if the form is submitted using the POST method.
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
        //Retrieves user input values.
            $name = $_POST["student_name"];
            $email = $_POST["email"];
            $contact_no = $_POST["contact_no"];
            $grade_class = $_POST["grade_class"];
            $admission_no = $_POST["admission_no"];
            $password = $_POST["password"];

            //Input Validation
            // Validate student name
            if(empty($name)) {
                $nameErr = "Name is required";
                $valid = false;
            } else {
                $name = test_input($_POST["student_name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    $nameErr = "Only letters and white space allowed";
                }
            }

            // Validate email
            if(empty($email)) {
                $emailErr = "Email is required";
                $valid = false;
            } else {
                $email = test_input($_POST["email"]);
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $emailErr = "Invalid email format";
                  $valid = false;
                }
            }

            // Validate contact number
            if(empty($contact_no)) {
                $contactNoErr = "Contact Number is required";
                $valid = false;
            } else {
                $contact_no = test_input($_POST["contact_no"]);
                // check if phone number has 10 digits
                if(!preg_match("/^[0-9]{10}+$/",$contact_no)) {
                    $contactNoErr = "Invalid contact number";
                    $valid = false;
                }
            }

            // Validate grade/class
            if(empty($grade_class)) {
                $gradeClassErr = "Grade and Class are required";
                $valid = false;
            }

            // Validate admission number
            if(empty($admission_no)) {
                $admissionNoErr = "Admission Number is required";
                $valid = false;
            } else {
                $admission_no = test_input($_POST["admission_no"]);
            // check if admission number has 4 digits
                if(!preg_match("/^[0-9]{4}+$/",$admission_no)) {
                    $admissionNoErr = "Invalid number format";
                    $valid = false;
                }

            // check if the admission number already exists
                $search_id = "SELECT * FROM members WHERE user_id = '$_POST[admission_no]'";
                $result = mysqli_query($conn,$search_id);

                if ($result->num_rows > 0) {
                    $admissionNoErr = "Admission number already exists";
                    $valid = false;
                }
            }

            // Validate password
            if(empty($password)) {
                $passwordErr = "Password is required";
                $valid = false;
            } 

            // To ensure that the password is strong enough
            if (!preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$#", $password)) {
                $passwordErr = "Password must contain at least 1 uppercase <br> letter, 1 lowercase letter, 1 digit, and be at <br> least 8 characters long";
                $valid = false;
            }

            // Inserting data to the database if all details are valid
            if($valid) {
                $sql = "INSERT INTO members (name, email, contact_no, grade_class, user_id, password) VALUES (
                    '$name',
                    '$email',
                    '$contact_no',
                    '$grade_class',
                    '$admission_no',
                    '$password' )";
              
            //Configures PHPMailer to send emails using Gmail SMTP.
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com"; 
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->Username = "vidurabooknest@gmail.com"; 
            // App Password via GMAIL
                $mail->Password = "uxym ftzh zhtp isxz"; 
                $mail->setFrom("vidurabooknest@gmail.com"); 
                $mail->addAddress($email); 
                $mail->isHTML(true);
                // Email content for Admin
                $mail->Subject = 'Welcome to ViduraBookNest';
                $mail->Body = "Dear  $name<br><br>" 
                    . "Thank you for registering at Vidura BookNest. You can now log in and access our book collection.<br><br>"
                    . "Best Regards,<br>"
                    . "Vidura BookNest Team";

                $mail->send();
                
                //Redirects user to the login page after successful registration.
                if(mysqli_query($conn,$sql)) {
                    echo 
                    "<script type=\"text/javascript\"> 
                        window.alert('Registration Successful')
                        window.location.href = 'login.php';
                    </script>";
                } else {
                    echo 
                    "<script type=\"text/javascript\"> 
                        window.alert('Sorry! Something went wrong'); 
                    </script>";
                }
            }
        }
    ?>

    <div class="content-container" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <img src="./Assets/logo.jpg" alt="logo" id="logo">
        <div id="form-container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <table align="center" cellpadding="3px" style="text-align: left;">
                    <tr>
                        <td><label for="student_name">Name</label></td>
                        <td>
                            <input type="text" id="student_name" name="student_name" value="<?php echo $name; ?>">
                            <br>
                            <span class="error"><?php echo $nameErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td>
                            <input type="email" id="email" name="email" value="<?php echo $email;?>" autocomplete="email">
                            <br>
                            <span class="error"><?php echo $emailErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="contactNo">Contact No</label></td>
                        <td>
                            <input type="tel" id="contact_no" name="contact_no" value="<?php echo $contact_no; ?>">
                            <br>
                            <span class="error"><?php echo $contactNoErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="gradeClass">Grade/Class</label></td>
                        <td>
                            <input type="text" id="grade_class" name="grade_class" value="<?php echo $grade_class; ?>">
                            <br>
                            <span class="error"><?php echo $gradeClassErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="admissionNo">Admission Number</label></td>
                        <td>
                            <input type="number" id="admission_no" name="admission_no" value="<?php echo $admission_no; ?>" autocomplete="off">
                            <br>
                            <span class="error"><?php echo $admissionNoErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;"><label for="password">Password</label></td>
                        <td>
                            <div style="position: relative; height: 15px;">
                                <input type="password" id="password" name="password" value="<?php echo $password; ?>" autocomplete="new-password">
                                <i id="icon-eye" class="fa fa-eye-slash" aria-hidden="true" onclick="togglePassword()"></i>
                            </div>
                            <br>
                            <span class="error"><?php echo $passwordErr; ?></span>
                        </td>
                    </tr>
                </table>
                <br>
                <input type="submit" id="add" name="add" value="SIGN UP" class="submit-btn" style="background-color: #AA9595;">
            </form>
        </div>
    </div>
</body>
</html>