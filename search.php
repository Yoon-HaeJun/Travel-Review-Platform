<?php
include 'config.php';

$search_query = $_GET['query'];
$query = "SELECT * FROM reviews WHERE title LIKE '%$search_query%' OR content LIKE '%$search_query%'";
$result = mysqli_query($conn, $query);
$results = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Search Results</h1>
    </header>
    <main class="main">
        <form action="search.php" method="get">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
        <div>
            <?php foreach ($results as $result): ?>
                <div class="review">
                    <h2><?php echo $result['title']; ?></h2>
                    <p><?php echo $result['content']; ?></p>
                    <p>Rating: <?php echo $result['rating']; ?>/5</p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Yun-haejun</p>
    </footer>
</body>
</html>