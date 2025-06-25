// Registratiepagina voor gebruikers
<?php
require_once 'includes/db.php';
require_once 'classes/User.php';

$message = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User($pdo);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->register($username, $email, $password)) {
        $message = "Registratie gelukt!";
    } else {
        $message = "Registratie mislukt.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h2>Registreren</h2>
    <p><?= $message ?></p>
    <form method="POST" action="">
        <label>Gebruikersnaam:</label><br>
        <input type="text" name="username" required><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" required><br>

        <label>Wachtwoord:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Registreren">
    </form>
</body>
</html>
