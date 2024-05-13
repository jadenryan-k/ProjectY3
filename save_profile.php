<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $genre = $_POST['genre'];
    $availability = $_POST['availability'];
    $charges = $_POST['charges'];

    $rating = $_POST['rating'];

    $stmt = $db->prepare("INSERT INTO artists (genre, availability, charges, rating) VALUES (:genre, :availability, :charges, :rating)");

    $stmt->bindParam(':genre', $genre);
    $stmt->bindParam(':availability', $availability);
    $stmt->bindParam(':charges', $charges);
    $stmt->bindParam(':rating', $rating);

    if ($stmt->execute()) {
        echo '<script>
        setTimeout(function(){
            window.location.href = "artist.html";
        }, 2000); // 2000 milliseconds delay
        </script>';
    } else {
        echo "Error updating profile details.";
    }
}
?>
