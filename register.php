<?php
require_once 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'student'; 

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, bio, profileImage, website) VALUES (?, ?, ?, ?, '', '', '')");
    $stmt->execute([$username, $email, $password, $role]);

    $userId = $pdo->lastInsertId();
    $_SESSION['user_id'] = $userId;

    header('Location: index.php');
    exit;
}
?>

<?php require_once 'includes/header.php'; ?>

<h2>Registreren</h2>

<form method="POST" class="mb-4">
    <div class="mb-2">
        <input type="text" name="username" class="form-control" placeholder="Gebruikersnaam" required>
    </div>
    <div class="mb-2">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="mb-2">
        <input type="password" name="password" class="form-control" placeholder="Wachtwoord" required>
    </div>
    <button class="btn btn-primary" type="submit">Registreer</button>
</form>

<?php require_once 'includes/footer.php'; ?>
