<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Arrow</title>
    <style>
        body{
            height: 100vh;
        }
        .back-arrow {
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
    </style>
</head>
<body>

    <a href="javascript:history.back()" class="back-arrow">
        <span class="arrow">&#8592;</span> Back
    </a>

</body>
</html>