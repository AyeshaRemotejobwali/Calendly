<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out - SchedulePro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #1a73e8;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #1a73e8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #1557b0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Logged Out Successfully</h2>
        <p>You have been logged out. Return to the homepage?</p>
        <a href="#" class="btn" onclick="redirectTo('index.php')">Go to Homepage</a>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
