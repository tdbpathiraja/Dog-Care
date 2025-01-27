<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link rel="stylesheet" href="src/styles/style.css">
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--color-primary-1);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

    </style>
</head>
<body>
    <div class="admin-register-container">
        <form class="admin-register-form" action="src/scripts/save-admin.php" method="POST">
            <h2>Admin Register</h2>
            
            <div class="admin-register-form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="admin-register-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="admin-register-form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="admin-register-form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="admin-register-form-group">
                <label for="telephone">Telephone Number</label>
                <input type="tel" id="telephone" name="telephone" required>
            </div>

            <div class="admin-register-form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>

            <button type="submit" class="admin-register-submit">Register</button>
        </form>
    </div>
</body>
</html>