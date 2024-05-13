<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]); 
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $role = trim($_POST["role"]);

    if (empty($username) || empty($password) || empty($email) || empty($role)) {
        header("Location: signup.html?error=emptyfields");
        exit();
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $hashed_password, $email, $role]);

        header("Location: index.html?signup=success");
        exit();
    } catch (PDOException $e) {
        header("Location: signup.html?error=dberror");
        exit();
    }
} else {
    header("Location: signup.html");
    exit();
}
?>
