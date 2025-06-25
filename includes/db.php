// Connect aan de database
<?php
$host = 'localhost';      
$dbname = 'portfolio_website';     
$username = 'root';        
$password = '';            

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}
?>
