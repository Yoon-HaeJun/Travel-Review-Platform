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
    <title>Update profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Update profile</h2>
    <form method="post" action="Profile_Function.php">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="text" name="username" placeholder="Username" value="<?php $user['username']; ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php $user['email']; ?>" required>
        <button type="submit">Submit</button>
    </form>
    <p><a href="Profile.php">Return to Profile</a></p>
</body>
</html>