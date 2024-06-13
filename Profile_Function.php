<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    $sql = "UPDATE users SET username = '$username', email = '$email' WHERE id = '$user_id'";

    if (mysqli_query($db, $sql)) {
        echo "<script>
                alert('Your profile has been updated successfully.');
                window.location.href = 'Profile.php';
              </script>";
    }
}

mysqli_close($db);
?>