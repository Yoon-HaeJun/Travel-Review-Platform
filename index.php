<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Review Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Travel Review Platform</h1>
        <nav>
            <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
                echo '<a href="index.php">Home</a>';
                echo '<a href="profile.php">Profile</a>';
                echo '<a href="process.php?action=logout">Logout</a>';
            } else {
                echo '<a href="index.php">Home</a>';
                echo '<a href="#login">Login</a>';
                echo '<a href="#register">Register</a>';
            }
            ?>
        </nav>
    </header>
    <main class="main">
        <?php
        include 'config.php';

        $query = "SELECT reviews.*, COUNT(likes.id) AS like_count
                  FROM reviews
                  LEFT JOIN likes ON reviews.id = likes.review_id
                  GROUP BY reviews.id
                  ORDER BY reviews.created_at DESC
                  LIMIT 5";
        $result = mysqli_query($conn, $query);

        echo "<h2>Recent Reviews</h2>";
        while ($review = mysqli_fetch_assoc($result)) {
            echo "<div class='review'>";
            echo "<h3>" . $review['title'] . "</h3>";
            echo "<p>" . $review['content'] . "</p>";
            echo "<p>Rating: " . $review['rating'] . "/5</p>";
            echo "<p>Likes: " . $review['like_count'] . "</p>";
            if (isset($_SESSION['user_id'])) {
                echo "<form action='process.php?action=like' method='post'>";
                echo "<input type='hidden' name='review_id' value='" . $review['id'] . "'>";
                echo "<button type='submit'>Like</button>";
                echo "</form>";
            }
            echo "</div>";
        }

        if (!isset($_SESSION['user_id'])) {
            echo '<div id="login">';
            echo '<h2>Login</h2>';
            echo '<form action="process.php?action=login" method="post">';
            echo '<div class="form-group"><label for="username">Username</label><input type="text" id="username" name="username" required></div>';
            echo '<div class="form-group"><label for="password">Password</label><input type="password" id="password" name="password" required></div>';
            echo '<button type="submit">Login</button>';
            echo '</form>';
            echo '</div>';

            echo '<div id="register">';
            echo '<h2>Register</h2>';
            echo '<form action="process.php?action=register" method="post">';
            echo '<div class="form-group"><label for="username">Username</label><input type="text" id="username" name="username" required></div>';
            echo '<div class="form-group"><label for="password">Password</label><input type="password" id="password" name="password" required></div>';
            echo '<div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" required></div>';
            echo '<button type="submit">Register</button>';
            echo '</form>';
            echo '</div>';
        } else {
            echo '<div id="review">';
            echo '<h2>Write a Review</h2>';
            echo '<form action="process.php?action=write_review" method="post">';
            echo '<div class="form-group"><label for="title">Title</label><input type="text" id="title" name="title" required></div>';
            echo '<div class="form-group"><label for="content">Content</label><textarea id="content" name="content" required></textarea></div>';
            echo '<div class="form-group"><label for="rating">Rating</label><input type="number" id="rating" name="rating" min="1" max="5" required></div>';
            echo '<button type="submit">Submit Review</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2024 Yun-haejun</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>