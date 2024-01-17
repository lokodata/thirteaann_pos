<?php
    session_start();

    include 'config/config.php';

    // Check if the user is already logged in
    if (isset($_SESSION['user_id'])) {
        // Redirect based on the user's role
        $user_id = $_SESSION['user_id'];

        // Use prepared statement to prevent SQL injection
        $stmt = $mysqli->prepare("SELECT role FROM staff_table WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->bind_result($role);
            $stmt->fetch();
            $stmt->close();

            if ($role == 'Admin') {
                header("location: /thirteaann-pos/admin/dashboard.php");
                exit();
            } elseif ($role == 'Staff') {
                header("location: /thirteaann-pos/staff/dashboard.php");
                exit();
            }
        } else {
            // Handle database error
            die("Error in prepared statement: " . $mysqli->error);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThirTeaAnn's POS</title>
</head>
<body>
    <form action="config/checklogin.php" method="POST">
        <img src="./assets/thirteaann-logo.svg" alt="ThirTeaAnn">

        <label for="email">Email: <input id="email" type="text" name="email" required /> </label> 

        <label for="password">Password: <input id="password" type="password" name="password" required /> </label>

        <label for="remember_me">Remember Me: <input id="remember_me" type="checkbox" name="remember_me" /> </label>

        <input id="submit" type="submit" value="login" />
    </form>
</body>
</html>
