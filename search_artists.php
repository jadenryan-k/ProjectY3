<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['genre'])) {
    $genre = $_GET['genre'];
    $availability = $_GET['availability'];
    $rating = $_GET['rating'] ?? 1; 
    $charges = $_GET['charges'] ?? PHP_INT_MAX;

    try {
        $stmt = $db->prepare("SELECT * FROM artists WHERE genre LIKE :genre AND availability = 'Available' AND charges <= :charges");
        $stmt->bindValue(':genre', '%' . $genre . '%');
        $stmt->bindValue(':charges', $charges);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            echo "<div class='artist-results'>";
            foreach ($results as $artist) {
                echo "<div class='artist-card'>";
                echo "<h4>{$artist['artist_name']}</h4>";
                echo "<p><strong>Genre:</strong> {$artist['genre']}</p>";
                echo "<p><strong>Availability:</strong> {$artist['availability']}</p>";
                echo "<p><strong>Rating:</strong> {$artist['rating']}</p>";
                echo "<p><strong>Charges:</strong> {$artist['charges']}</p>";
                echo "<button class='btn btn-book'>Book Artist</button>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No available artists found matching the criteria.</p>";
        }
    } catch (PDOException $e) {
        echo "Error searching artists: " . $e->getMessage();
    }
}
?>
