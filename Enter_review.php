<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $content = $_POST["content"];
    $country = $_POST["country"];
    $rating = $_POST["rating"];

    $sql = "INSERT INTO reviews (user_id, content, country, rating, likes, dislikes) VALUES ('$user_id', '$content', '$country', '$rating', 0, 0)";

    if (mysqli_query($db, $sql)) {
        echo "<script>
                alert('Your review was successfully written.');
                window.location.href = 'Main.php';
              </script>";
    }
}

mysqli_close($db);
?>