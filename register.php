<?php
require_once 'includes/db.php';
require_once 'classes/User.php';
session_start();

$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user->register($username, $email, $password);

    header('Location: inlog.php');
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
