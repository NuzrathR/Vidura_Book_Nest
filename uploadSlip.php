<?php
    // Database connection parameters
    include "config.php";
    include "index.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["Upload"])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["paymentSlip"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $validFileTypes = array("jpg", "jpeg", "png", "pdf");

        if (!in_array($fileType, $validFileTypes)) {
            echo 
                "<script>
                    alert('File upload failed. Please try again.');
                    window.location.href = 'uploadSlip.html';
                </script>";
            $uploadOk = 0;
        } else {
            if ($uploadOk == 1 && move_uploaded_file($_FILES["paymentSlip"]["tmp_name"], $targetFile)) {
                // Retrieve payment details
                $user_id = $_SESSION['username'];
                $paymentType = $_POST['plan'];
                $price = $_POST['price'];
                $status = 'Pending';
        
                // Insert into the database
                $stmt = $conn->prepare("INSERT INTO payment_details (user_id, payment_type, payment_slip, price, status) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssis", $user_id, $paymentType, $targetFile, $price, $status);
        
                if ($stmt->execute()) {
                    echo "<script>alert('Payment slip uploaded successfully!'); window.location.href='membershipPay.php';</script>";
                } else {
                    echo "Error: " . $stmt->error . "<br>";
                }
        
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Invalid request.";
    }

    $conn->close();
?>