<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'classes/Project.php';
require_once 'classes/FreelanceProject.php';
require_once 'classes/SchoolProject.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$_GET['id']]);
$projectData = $stmt->fetch();

if (!$projectData) {
    echo "Project niet gevonden.";
    exit;
}

if ($projectData['category'] === 'freelance') {
    $project = new FreelanceProject($projectData['title'], $projectData['description'], $projectData['date'], $projectData['category'],  $projectData['image'], '', '');
} elseif ($projectData['category'] === 'school') {
    $project = new SchoolProject($projectData['title'], $projectData['description'], $projectData['date'], $projectData['category'],  $projectData['image'], '', '');
} else {
    $project = new Project($projectData['title'], $projectData['description'], $projectData['date'], $projectData['category'], $projectData['image']);
}
?>

<h2><?= htmlspecialchars($project->getTitle()); ?></h2>
<p><strong>Categorie:</strong> <?= htmlspecialchars($project->getCategory()); ?></p>
<p><strong>Datum:</strong> <?= htmlspecialchars($project->getDate()); ?></p>
<p><?= nl2br(htmlspecialchars($project->getDescription())); ?></p>

<a href="index.php" class="btn btn-secondary">Terug naar overzicht</a>

<?php require_once 'includes/footer.php'; ?>
