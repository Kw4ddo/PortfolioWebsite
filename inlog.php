<?php
session_start();
require_once 'includes/db.php';
require_once 'classes/User.php';

$user = new User($pdo);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($user->login($email, $password)) {
        if ($_SESSION['role'] === 'admin') {
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        $error = "Ongeldige inloggegevens.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Inloggen</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <form method="post" action="">
    <div>
      <label for="email">E-mailadres</label>
      <input type="email" name="email" id="email" required>
    </div>

    <div>
      <label for="password">Wachtwoord</label>
      <input type="password" name="password" id="password" required>
    </div>

    <?php if (!empty($error)): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <button type="submit" name="login">Inloggen</button>
  </form>
</body>
</html>
