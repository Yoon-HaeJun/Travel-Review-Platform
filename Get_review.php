<?php
include 'db.php';

function getReviews($db) {
    $query = "SELECT reviews.id, reviews.content, reviews.country, reviews.rating, reviews.likes, reviews.dislikes, users.username, reviews.user_id 
              FROM reviews 
              JOIN users ON reviews.user_id = users.id 
              ORDER BY reviews.id DESC";
    return mysqli_query($db, $query);
}
?>