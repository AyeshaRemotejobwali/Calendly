<?php
session_start();
require_once 'db.php';

// Prevent access if already logged in
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='dashboard.php';</script>";
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        // Check user credentials
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        if (!$stmt) {
            $error = 'Database error. Please try again later.';
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo "<script>window.location.href='dashboard.php';</script>";
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - SchedulePro</title>
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
            min-height: 100vh;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1a73e8;
            font-size: 1.8em;
        }
        .error {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
            font-size: 0.9em;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            border-color: #1a73e8;
            outline: none;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn:hover {
            background: #1557b0;
            transform: translateY(-2px);
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #1a73e8;
            text-decoration: none;
            font-size: 0.9em;
        }
        .link a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
            .form-container h2 {
                font-size: 1.5em;
            }
            .btn {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Log In</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Log In</button>
        </form>
        <div class="link">
            <p>Don't have an account? <a href="#" onclick="redirectTo('signup.php')">Sign Up</a></p>
        </div>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
