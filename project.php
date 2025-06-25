<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    echo "<p>Geen project geselecteerd.</p>";
    require_once 'includes/footer.php';
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$_GET['id']]);
$project = $stmt->fetch();

if (!$project) {
    echo "<p>Project niet gevonden.</p>";
    require_once 'includes/footer.php';
    exit;
}
?>

<h2><?= htmlspecialchars($project['title']); ?></h2>
<p><strong>Categorie:</strong> <?= htmlspecialchars($project['category']); ?></p>
<p><strong>Datum:</strong> <?= htmlspecialchars($project['date']); ?></p>
<p><?= nl2br(htmlspecialchars($project['description'])); ?></p>

<a href="index.php" class="btn btn-secondary">Terug naar overzicht</a>

<?php require_once 'includes/footer.php'; ?>
