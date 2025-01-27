<?php
include 'src/database/dbcon.php';
session_start();

$userName = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$current_page = basename($_SERVER['PHP_SELF']); 
?>

<nav id="navbar">
    <i class="fa-solid fa-dog" id="nav_logo">Dog Care</i>

    <ul id="nav_list">
        <li class="nav-item active">
            <a href="index.php#home">Home</a>
        </li>
        <li class="nav-item">
            <a href="index.php#companyabout">About Us</a>
        </li>
        <li class="nav-item">
            <a href="index.php#testimonials">Testimonials</a>
        </li>
        <li class="nav-item">
            <a href="feedback.php">Feedback</a>
        </li>
    </ul>

    <?php if ($userName): ?>
        <?php if ($current_page === 'user-dashboard.php'): ?>
            <form action="logout.php" method="post">
                <button type="submit" class="btn-default">Logout</button>
            </form>
        <?php else: ?>
            <a href="user-dashboard.php">
                <button class="btn-default">
                    <?php echo htmlspecialchars($userName); ?>
                </button>
            </a>
        <?php endif; ?>
    <?php else: ?>
        <a href="login.php">
            <button class="btn-default">
                Log In
            </button>
        </a>
    <?php endif; ?>
</nav>