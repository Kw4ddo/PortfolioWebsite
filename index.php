<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'classes/Project.php';

$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;

if ($categoryFilter) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE category = ?");
    $stmt->execute([$categoryFilter]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM projects");
    $stmt->execute();
}

$projects = [];
while ($row = $stmt->fetch()) {
    $projects[] = new Project($row['title'], $row['description'], $row['date'], $row['category'], $row['image']);
}
?>

<h2>Projectenoverzicht</h2>

<div class="mb-4">
    <a href="index.php" class="btn btn-secondary">Alle Projecten</a>
    <a href="index.php?category=school" class="btn btn-primary">Schoolprojecten</a>
    <a href="index.php?category=freelance" class="btn btn-success">Freelance Projecten</a>
</div>

<?php if ($projects): ?>
    <div class="row">
        <?php foreach ($projects as $project): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <?php if (method_exists($project, 'getImage') && !empty($project->getImage())): ?>
                        <img src="assets/img/<?= htmlspecialchars($project->getImage()); ?>" class="card-img-top" style="max-height:200px;object-fit:cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($project->getTitle()); ?></h5>
                        <p class="card-text"><?= htmlspecialchars(substr($project->getDescription(), 0, 100)); ?>...</p>
                        <p>
                            <strong>Categorie:</strong>
                            <?php if (strtolower($project->getCategory()) == 'school'): ?>
                                <span class="badge bg-primary">School</span>
                            <?php elseif (strtolower($project->getCategory()) == 'freelance'): ?>
                                <span class="badge bg-success">Freelance</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= htmlspecialchars($project->getCategory()); ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Geen projecten gevonden.</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
