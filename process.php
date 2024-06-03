<?php
session_start();
include 'config.php';

$action = $_GET['action'];

switch ($action) {
    case 'login':
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
        } else {
            echo "Invalid username or password.";
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php');
        break;

    case 'register':
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $email = $_POST['email'];
        $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        if (mysqli_query($conn, $query)) {
            header('Location: index.php');
        } else {
            echo "Registration failed.";
        }
        break;

    case 'write_review':
        $title = $_POST['title'];
        $content = $_POST['content'];
        $rating = $_POST['rating'];
        $user_id = $_SESSION['user_id'];
        $query = "INSERT INTO reviews (title, content, rating, user_id) VALUES ('$title', '$content', '$rating', '$user_id')";
        if (mysqli_query($conn, $query)) {
            header('Location: index.php');
        } else {
            echo "Failed to submit review.";
        }
        break;

    case 'like':
        $review_id = $_POST['review_id'];
        $user_id = $_SESSION['user_id'];
        $query = "INSERT INTO likes (user_id, review_id) VALUES ('$user_id', '$review_id')";
        if (mysqli_query($conn, $query)) {
            header('Location: index.php');
        } else {
            echo "Failed to like review.";
        }
        break;

    default:
        echo "Invalid action.";
}
?>