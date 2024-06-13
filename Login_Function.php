<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT id, password FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row["password"]) {
            $_SESSION["userid"] = $row["id"];
            $_SESSION["username"] = $username;
            echo "<script>
                    window.location.href = 'Main.php';
                  </script>";
            exit;
        }
    }
    echo "<script>
            window.location.href = 'Login.php';
          </script>";
    exit;
}

mysqli_close($db);
?>