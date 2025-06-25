<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date = $_POST['date'];

    $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description, category, date, image) VALUES (?, ?, ?, ?, ?, '')");
    $stmt->execute([$_SESSION['user_id'], $title, $description, $category, $date]);
    echo "<div class='alert alert-success'>Project toegevoegd!</div>";
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    echo "<div class='alert alert-danger'>Project verwijderd!</div>";
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$projects = $stmt->fetchAll();
?>

<h2>Dashboard</h2>

<h3>Project Toevoegen</h3>
<form method="POST" class="mb-4">
    <div class="mb-2">
        <input type="text" name="title" class="form-control" placeholder="Titel" required>
    </div>
    <div class="mb-2">
        <textarea name="description" class="form-control" placeholder="Beschrijving" required></textarea>
    </div>
    <div class="mb-2">
        <select name="category" class="form-select" required>
            <option value="school">School</option>
            <option value="freelance">Freelance</option>
        </select>
    </div>
    <div class="mb-2">
        <input type="date" name="date" class="form-control" required>
    </div>
    <button class="btn btn-primary" type="submit">Toevoegen</button>
</form>

<h3>Mijn Projecten</h3>
<table class="table">
    <tr>
        <th>Titel</th>
        <th>Categorie</th>
        <th>Datum</th>
        <th>Acties</th>
    </tr>
    <?php foreach ($projects as $project): ?>
        <tr>
            <td><?= htmlspecialchars($project['title']); ?></td>
            <td><?= htmlspecialchars($project['category']); ?></td>
            <td><?= htmlspecialchars($project['date']); ?></td>
            <td>
                <a href="project.php?id=<?= $project['id']; ?>" class="btn btn-info btn-sm">Bekijken</a>
                <a href="?delete=<?= $project['id']; ?>" onclick="return confirm('Weet je zeker dat je dit project wilt verwijderen?')" class="btn btn-danger btn-sm">Verwijderen</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once 'includes/footer.php'; ?>
