<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>
            window.location.href = 'Login.php';
          </script>";
    exit;
}

$user_id = $_SESSION['userid'];
$query = "SELECT username, email FROM users WHERE id = '$user_id'";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Profile</h2>
    <p>Username : <?php echo $user['username']; ?></p>
    <p>Email : <?php echo $user['email']; ?></p>
    <p><a href="Update_profile.php">Update profile</a></p>
    <p><a href="Main.php">Return to Home</a></p>
</body>
</html>