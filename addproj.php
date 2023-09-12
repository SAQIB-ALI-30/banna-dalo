<?php
$showalert = false;

// Check if the form data is submitted and the required fields are set
if (isset($_POST['name'], $_POST['description'], $_POST['budget'], $_POST['phoneno'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $budget = $_POST['budget'];
    $phoneno = $_POST['phoneno'];
    $exists = false;
    $host = "localhost";
    $dbname = "saqib";
    $db_username = "root";
    $db_password = "";
    $conn = mysqli_connect($host, $db_username, $db_password, $dbname);

    if (mysqli_connect_errno()) {
        die("Connection error: " . mysqli_connect_error());
    }

    // Insert the user data into the database
    $sql = "INSERT INTO `projects` (`name`, `description`, `phoneno`, `budget`) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sssi", $name, $description, $phoneno, $budget);
    if (mysqli_stmt_execute($stmt)) {
        echo "Record saved";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Handle the case when the required fields are not set or the form is not submitted
    echo "Error: Required form fields are not set.";
}
?>
