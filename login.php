<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dog Care | Login</title>

    <!-- Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Styling Sheets -->
    <link rel="stylesheet" href="src/styles/style.css">

</head>
<body>

<header>
    <!-- Navigation Bar -->
    <?php include 'navbar.php'; ?>
</header>

<section>
<div class="viewport-center">
        <div class="login-container">
            <div class="login-image"></div>
            <div class="login-content">
                <div class="login-header">
                    <h1>Welcome!</h1>
                </div>
                
                <div class="login-type-selector">
                    <button class="login-type-btn active" data-type="visitor" id="visitorBtn">Visitor Login</button>
                    <button class="login-type-btn" data-type="admin" id="adminBtn">Admin Login</button>
                </div>

                <div id="visitorPanel" class="login-panel active">
                    <form class="login-form" id="visitorLoginForm" action="src/scripts/user-login.php" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" id="visitorUsername" name="username" placeholder="Visitor Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="visitorPassword" name="password" placeholder="Visitor Password" required>
                        </div>
                        <button type="submit" class="submit-btn">Visitor Login</button>
                    </form>
                </div>

                <div id="adminPanel" class="login-panel">
                    <form class="login-form" id="adminLoginForm" action="src/scripts/admin-login.php" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" id="adminUsername" name="username" placeholder="Admin Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="adminPassword" name="password" placeholder="Admin Password" required>
                        </div>
                        <button type="submit" class="submit-btn">Admin Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Javascript Functions -->
<script src="src/javascript/login-screen.js"></script>

</body>
</html>