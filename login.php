<?php
session_start();
include 'db.php'; // Ensure this path is correct and db.php is in the same directory

if (isset($_SESSION['admin_id'])) {
    header("Location: add_trucks.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($mysqli)) {
        // Check if the username and password are correct
        $stmt = $mysqli->prepare("SELECT id, password FROM admins WHERE username = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $db_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            if ($password === $db_password) {
                // Check if there's already an active session
                if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
                    // Password is correct, start a session
                    $_SESSION['admin_id'] = $id;
                    $_SESSION['admin_logged_in'] = true;
                    header("Location: add_trucks.php");
                    exit();
                } else {
                    $error_message = "An admin is already logged in.";
                }
            } else {
                $error_message = "Password is incorrect";
            }
        } else {
            $error_message = "Username not found";
        }

        $stmt->close();
    } else {
        $error_message = "Database connection failed";
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('truck.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #ffffff;
        }
        .login-header {
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="login-header text-center">Admin Login</h2>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
