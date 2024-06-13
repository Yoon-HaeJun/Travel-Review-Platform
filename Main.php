<?php
session_start();
include 'db.php';

function getReviews($db) {
    $query = "SELECT reviews.id, reviews.content, reviews.country, reviews.rating, reviews.likes, reviews.dislikes, users.username, reviews.user_id 
              FROM reviews 
              JOIN users ON reviews.user_id = users.id 
              ORDER BY reviews.id DESC";
    return mysqli_query($db, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'like' || $_POST['action'] == 'dislike') {
            $review_id = $_POST["review_id"];
            $action = $_POST["action"];

            if ($action == 'like') {
                $query = "UPDATE reviews SET likes = likes + 1 WHERE id = $review_id";
            } elseif ($action == 'dislike') {
                $query = "UPDATE reviews SET dislikes = dislikes + 1 WHERE id = $review_id";
            }

            mysqli_query($db, $query);
        } elseif ($_POST['action'] == 'delete') {
            $review_id = $_POST["review_id"];
            $user_id = $_SESSION["userid"];

            $query = "DELETE FROM reviews WHERE id = $review_id AND user_id = $user_id";
            mysqli_query($db, $query);
        } elseif ($_POST['action'] == 'submit_review') {
            $user_id = $_SESSION["userid"];
            $content = $_POST["content"];
            $country = $_POST["country"];
            $rating = $_POST["rating"];

            $query = "INSERT INTO reviews (user_id, content, country, rating, likes, dislikes) 
                      VALUES ('$user_id', '$content', '$country', '$rating', 0, 0)";
            mysqli_query($db, $query);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Review Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Travel Review Platform</h1>
        <nav>
            <ul>
                <li><a href="Main.php">Home</a></li>
                <?php if (isset($_SESSION['userid'])): ?>
                    <li><a href="Profile.php">Profile</a></li>
                    <li><a href="Logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="Login.php">Login</a></li>
                    <li><a href="Signup.php">Signup</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <?php if (isset($_SESSION['userid'])): ?>
            <h2>List of reviews</h2>
            <?php
            $result = getReviews($db);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='review'>";
                    echo "<p><strong>" . $row['username'] . "</strong></p>";
                    echo "<p><em>" . $row['country'] . "</em></p>";
                    echo "<p>Rating: " . $row['rating'] . "</p>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo "<div class='review-buttons'>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='review_id' value='" . $row['id'] . "'>";
                    echo "<input type='hidden' name='action' value='like'>";
                    echo "<button type='submit'>Like (" . $row['likes'] . ")</button>";
                    echo "</form>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='review_id' value='" . $row['id'] . "'>";
                    echo "<input type='hidden' name='action' value='dislike'>";
                    echo "<button type='submit'>Dislike (" . $row['dislikes'] . ")</button>";
                    echo "</form>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='review_id' value='" . $row['id'] . "'>";
                    echo "<input type='hidden' name='action' value='delete'>";
                    echo "<button type='submit'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "There is no review.";
            }
            ?>
            <h2>Writing a Review</h2>
            <form method="POST">
                <input type="hidden" name="action" value="submit_review">
                <input type="text" name="country" placeholder="Country" required>
                <select name="rating" required>
                    <option value="">Select a rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <textarea name="content" placeholder="Please enter your review" required></textarea>
                <button type="submit">Writing a Review</button>
            </form>
        <?php else: ?>
            <p>After you log in, you can write a review.</p>
        <?php endif; ?>
    </main>
</body>
</html>