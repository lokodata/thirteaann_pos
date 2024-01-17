<?php
// Function to generate a secure token
function generateToken() {
    // Generate a random string using random_bytes
    $randomBytes = random_bytes(32);

    // Convert the random bytes to a hexadecimal string
    $token = bin2hex($randomBytes);

    // Hash the token using password_hash
    $hashedToken = password_hash($token, PASSWORD_BCRYPT);

    return $hashedToken;
}

session_start();

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if "Remember Me" is checked
    $remember_me = isset($_POST['remember_me']);

    $stmt = $mysqli->prepare("SELECT email, password, user_id, role FROM staff_table WHERE (email = ? AND password = ?)");
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $stmt->bind_result($email, $password, $user_id, $role);
    $rs = $stmt->fetch();
    $_SESSION['user_id'] = $user_id;

    if ($rs) {
        // if successful
        if ($role == 'Admin') {
            header("location: /thirteaann-pos/admin/dashboard.php");
        } elseif ($role == 'Staff') {
            header("location: /thirteaann-pos/staff/dashboard.php");
        } else {
            $err = "Invalid user role.";
        }

        // Set a cookie if "Remember Me" is checked
        if ($remember_me) {
            $token = generateToken();
            setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
        }
    } else {
        $err = "Incorrect Authentication Credentials ";
    }

    $stmt->close();
}
?>
