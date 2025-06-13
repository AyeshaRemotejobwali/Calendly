<?php
session_start();
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SchedulePro - Homepage</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background: #1a73e8;
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
            margin-bottom: 40px;
        }
        header h1 {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        .welcome-section {
            text-align: center;
            margin: 40px 0;
        }
        .welcome-section h2 {
            font-size: 1.8em;
            color: #1a73e8;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .welcome-section p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .auth-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: #1a73e8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn:hover {
            background: #1557b0;
            transform: translateY(-2px);
        }
        .btn.secondary {
            background: #28a745;
        }
        .btn.secondary:hover {
            background: #218838;
        }
        .btn.availability {
            background: #ff6f61;
        }
        .btn.availability:hover {
            background: #e55a50;
        }
        @media (max-width: 768px) {
            header {
                padding: 20px;
            }
            header h1 {
                font-size: 1.8em;
            }
            header p {
                font-size: 1em;
            }
            .welcome-section h2 {
                font-size: 1.5em;
            }
            .btn {
                padding: 12px 20px;
                font-size: 1em;
            }
            .auth-buttons {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to SchedulePro</h1>
            <p>Your ultimate solution for seamless meeting scheduling</p>
        </header>
        <div class="welcome-section">
            <h2>Effortless Meeting Scheduling</h2>
            <p>Schedule meetings with ease. Set your availability, share your link, and let others book time with you. Whether for business or personal use, SchedulePro makes it simple and professional.</p>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="#" class="btn" onclick="redirectTo('dashboard.php')">Go to Dashboard</a>
                    <a href="#" class="btn availability" onclick="redirectTo('set_availability.php')">Add Availability</a>
                    <a href="#" class="btn" onclick="redirectTo('booking.php')">Book a Meeting</a>
                    <a href="#" class="btn secondary" onclick="redirectTo('logout.php')">Log Out</a>
                <?php else: ?>
                    <a href="#" class="btn" onclick="redirectTo('signup.php')">Sign Up</a>
                    <a href="#" class="btn" onclick="redirectTo('login.php')">Log In</a>
                    <a href="#" class="btn secondary" onclick="redirectTo('booking.php')">Book a Meeting</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
