<?php
    session_start();

    require '../config/config.php';

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

            if ($role != 'Staff') {
                header("location: /thirteaann-pos/index.php");
                exit();
            }
        } else {
            // Handle database error
            die("Error in prepared statement: " . $mysqli->error);
        }
    } else {
        // User is not logged in, redirect to index.php
        header("location: /thirteaann-pos/index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThirTeaAnn</title>
</head>
<body>
    <h1>Staff</h1>
    <a href="/thirteaann-pos/config/logout.php">Logout</a>
</body>
</html>