<?php
$showAlert = false;
$loginSuccess = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $host = "localhost";
    $dbname = "saqib";
    $db_username = "root";
    $db_password = "";
    $conn = mysqli_connect($host, $db_username, $db_password, $dbname);

    if (mysqli_connect_errno()) {
        die("Connection error: " . mysqli_connect_error());
    }

    // Retrieve the user's password in plain text from the database
    $sql = "SELECT * FROM `signup` WHERE `username` = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die(mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        // User exists, retrieve the plain text password
        $row = mysqli_fetch_assoc($result);
        $plainTextPassword = $row['password'];
        if ($password === $plainTextPassword) {
            $loginSuccess = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
        } else {
            $showAlert = true;
            $alertMessage = "Error: Invalid username or password.";
        }
    } else {
        $showAlert = true;
        $alertMessage = "Error: Invalid username or password.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Result</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Login Result</h2>
    <?php
    if ($loginSuccess) {
        echo '<div class="alert alert-success" role="alert">Login successful! Redirecting to the next page...</div>';
        // Redirect to the next page after a short delay
        echo '<meta http-equiv="refresh" content="2;url=signup.html">';
    }
    if ($showAlert) {
        echo '<div class="alert alert-danger" role="alert">' . $alertMessage . '</div>';
        echo '<a href="signup.html">Go back to login form</a>';
    }
    ?>
</div>
</body>
</html>
