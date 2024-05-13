<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            if ($user['role'] === "artist") {
                header("Location: artist.html");
                exit();
            } elseif ($user['role'] === "organizer") {
                header("Location: event.html");
                exit();
            }
        } else {
            $error = "Invalid username or password. Please try again.";
        }
    } else {
        $error = "Invalid username or password. Please try again.";
    }
} else {
    header("Location: index.html");
    exit();
}
?>
