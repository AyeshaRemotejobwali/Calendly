<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $date = $_POST['date'];
    $time_slot = $_POST['time_slot'];
    $booker_email = $_POST['booker_email'];

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, date, time_slot, booker_email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $date, $time_slot, $booker_email);
    if ($stmt->execute()) {
        // Simulate email confirmation
        echo "<script>alert('Booking confirmed! Email sent to $booker_email.');</script>";
    } else {
        echo "<script>alert('Error booking appointment.');</script>";
    }
    $stmt->close();
}

$users = $conn->query("SELECT id, username FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Meeting - SchedulePro</title>
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
            max-width: 800px;
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
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group select, .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 20px;
        }
        .calendar div {
            padding: 10px;
            text-align: center;
            background: #f0f0f0;
            border-radius: 5px;
            cursor: pointer;
        }
        .calendar div:hover {
            background: #1a73e8;
            color: white;
        }
        .calendar div.selected {
            background: #1a73e8;
            color: white;
        }
        .time-slots {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .time-slots button {
            padding: 10px 20px;
            border: none;
            background: #1a73e8;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .time-slots button:hover {
            background: #1557b0;
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
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #1557b0;
        }
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 15px;
            }
            .calendar {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book a Meeting</h2>
        <form method="POST">
            <div class="form-group">
                <label for="user_id">Select User</label>
                <select id="user_id" name="user_id" required>
                    <option value="">Select a user</option>
                    <?php while ($user = $users->fetch_assoc()): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Select Date</label>
                <div class="calendar" id="calendar"></div>
                <input type="hidden" id="date" name="date">
            </div>
            <div class="form-group">
                <label for="time_slot">Select Time Slot</label>
                <div class="time-slots" id="time-slots"></div>
                <input type="hidden" id="time_slot" name="time_slot">
            </div>
            <div class="form-group">
                <label for="booker_email">Your Email</label>
                <input type="email" id="booker_email" name="booker_email" required>
            </div>
            <button type="submit" class="btn">Book Appointment</button>
        </form>
        <div class="link">
            <p><a href="#" onclick="redirectTo('index.php')">Back to Home</a></p>
        </div>
    </div>
    <script>
        const calendar = document.getElementById('calendar');
        const dateInput = document.getElementById('date');
        const timeSlots = document.getElementById('time-slots');
        const timeSlotInput = document.getElementById('time_slot');

        function generateCalendar() {
            const today = new Date();
            calendar.innerHTML = '';
            for (let i = 0; i < 30; i++) {
                const date = new Date(today);
                date.setDate(today.getDate() + i);
                const div = document.createElement('div');
                div.textContent = date.toISOString().split('T')[0];
                div.onclick = () => {
                    document.querySelectorAll('.calendar div').forEach(d => d.classList.remove('selected'));
                    div.classList.add('selected');
                    dateInput.value = div.textContent;
                    generateTimeSlots();
                };
                calendar.appendChild(div);
            }
        }

        function generateTimeSlots() {
            timeSlots.innerHTML = '';
            const slots = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];
            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.textContent = slot;
                btn.onclick = () => {
                    timeSlotInput.value = slot;
                    timeSlots.querySelectorAll('button').forEach(b => b.style.background = '#1a73e8');
                    btn.style.background = '#1557b0';
                };
                timeSlots.appendChild(btn);
            });
        }

        generateCalendar();

        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
