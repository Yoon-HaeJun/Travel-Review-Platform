<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if (mysqli_query($db, $sql)) {
        echo "<script>
                alert('Signup completed successfully.');
                window.location.href = 'Main.php';
              </script>";
    }
}

mysqli_close($db);
?>