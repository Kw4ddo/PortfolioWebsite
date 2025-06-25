// inloggen
<?php
session_start();

require_once 'includes/db.php';
require_once 'classes/User.php';   

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($db);

    if ($user->login($email, $password)) {

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Ongeldige inloggegevens.";
    }
}

?>

<form method="post" action="">
  <div>
    <label for="email">E-mailadres</label>
    <input type="email" name="email" id="email" required>
  </div>

  <div>
    <label for="password">Wachtwoord</label>
    <input type="password" name="password" id="password" required>
  </div>

  <button type="submit" name="login">Inloggen</button>
</form>
