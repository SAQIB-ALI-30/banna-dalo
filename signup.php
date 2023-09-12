<?php
$showalert = false;
$username = $_POST['username'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$exists = false;
$host = "localhost";
$dbname = "saqib";
$db_username = "root";
$db_password = "";
$conn = mysqli_connect($host, $db_username, $db_password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if the passwords match
if ($password !== $cpassword) {
    $showalert = true;
    echo "Error: Passwords do not match.";
    exit;
}

// Check if the username already exists in the database
$sql = "SELECT * FROM `signup` WHERE `username` = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $exists = true;
    echo "Error: Username already exists.";
    exit;
}

// Insert the user data into the database
$sql = "INSERT INTO `signup` (`username`, `password`) VALUES ('$username', '$password')";
if (mysqli_query($conn, $sql)) {
    echo "Record saved";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
