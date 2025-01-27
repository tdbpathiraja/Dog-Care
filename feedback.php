<?php
session_start();

include 'src/database/dbcon.php';

if (!isset($_SESSION['username'])) {
    $isLoggedIn = false;
} else {
    $isLoggedIn = true;
    $userName = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Fetch doctors related to the logged-in user
    $doctorQuery = "SELECT DISTINCT doctor FROM doctor_bookings WHERE username = ?";
    $doctorStmt = $conn->prepare($doctorQuery);
    $doctorStmt->bind_param("s", $userName);
    $doctorStmt->execute();
    $doctorResult = $doctorStmt->get_result();
    $doctors = $doctorResult->fetch_all(MYSQLI_ASSOC);

    // Fetch doctor names based on usernames
    $doctorNames = [];
    foreach ($doctors as $doctor) {
        $doctorUsername = $doctor['doctor'];
        $nameQuery = "SELECT doctor_name FROM doctors WHERE doctor_username = ?";
        $nameStmt = $conn->prepare($nameQuery);
        $nameStmt->bind_param("s", $doctorUsername);
        $nameStmt->execute();
        $nameResult = $nameStmt->get_result();
        $doctorData = $nameResult->fetch_assoc();
        if ($doctorData) {
            $doctorNames[] = [
                'username' => $doctorUsername,
                'name' => $doctorData['doctor_name']
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="src/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--color-primary-1) 0%, #e0f2f1 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="second-feedbackform">
        <h2>Send Us Your Feedback</h2>
        <?php if ($isLoggedIn): ?>
        <form action="src/scripts/user-functions/submit-feedback.php" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required placeholder="Enter your name" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" required placeholder="Write your feedback here"></textarea>
            </div>
            <div class="form-group">
                <label for="doctor">Select Doctor</label>
                <select id="doctor" name="doctor" required>
                    <option value="">Select a doctor</option>
                    <?php foreach ($doctorNames as $doctor): ?>
                        <option value="<?php echo htmlspecialchars($doctor['username']); ?>"><?php echo htmlspecialchars($doctor['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group star-rating">
    <span class="rating-label">Rate Us:</span>
    <div class="stars">
        <input type="radio" id="star1" name="star" value="1">
        <label for="star1" class="star"><i class="fas fa-star"></i></label>
        <input type="radio" id="star2" name="star" value="2">
        <label for="star2" class="star"><i class="fas fa-star"></i></label>
        <input type="radio" id="star3" name="star" value="3">
        <label for="star3" class="star"><i class="fas fa-star"></i></label>
        <input type="radio" id="star4" name="star" value="4">
        <label for="star4" class="star"><i class="fas fa-star"></i></label>
        <input type="radio" id="star5" name="star" value="5">
        <label for="star5" class="star"><i class="fas fa-star"></i></label>
    </div>
</div>
            <button type="submit" class="submit-btn">Submit Feedback</button>
        </form>
        <?php else: ?>
            <p>Please <a href="login.php">log in</a> to your account to Submit a Feedback.</p>
        <?php endif; ?>
    </div>
</body>
</html>