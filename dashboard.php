<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
    $booking_id = $_POST['cancel_id'];
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Booking cancelled.');</script>";
}

$bookings = $conn->query("SELECT * FROM bookings WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SchedulePro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #1a73e8;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        table th {
            background: #1a73e8;
            color: white;
        }
        .btn {
            padding: 8px 15px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #1557b0;
        }
        .btn-cancel {
            background: #dc3545;
        }
        .btn-cancel:hover {
            background: #c82333;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            color: #1a73e8;
            text-decoration: none;
        }
        .logout a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 15px;
            }
            table {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <h3>Your Bookings</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Booker Email</th>
                <th>Action</th>
            </tr>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo $booking['date']; ?></td>
                    <td><?php echo $booking['time_slot']; ?></td>
                    <td><?php echo htmlspecialchars($booking['booker_email']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="cancel_id" value="<?php echo $booking['id']; ?>">
                            <button type="submit" class="btn btn-cancel">Cancel</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <div class="logout">
            <a href="#" onclick="redirectTo('logout.php')">Log Out</a>
        </div>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }

        // Notification for upcoming bookings
        setTimeout(() => {
            alert('Reminder: Check your upcoming bookings!');
        }, 2000);
    </script>
</body>
</html>
