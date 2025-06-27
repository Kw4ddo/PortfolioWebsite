<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'classes/Project.php';
require_once 'classes/FreelanceProject.php';
require_once 'classes/SchoolProject.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], 'assets/img/' . $filename);
        $image = $filename;
    }

    $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description, category, date, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['id'], $title, $description, $category, $date, $image]);
    echo "<div class='alert alert-success'>Project toegevoegd!</div>";
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['delete'], $_SESSION['id']]);
    echo "<div class='alert alert-danger'>Project verwijderd!</div>";
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?");
$stmt->execute([$_SESSION['id']]);
$projectRows = $stmt->fetchAll();

$projects = [];
foreach ($projectRows as $row) {
    if ($row['category'] === 'freelance') {
        $projects[] = new FreelanceProject($row['title'], $row['description'], $row['date'], $row['category'], $row['image'], isset($row['clientName']) ? $row['clientName'] : '', isset($row['budget']) ? $row['budget'] : ''
        );
    } elseif ($row['category'] === 'school') {
        $projects[] = new SchoolProject($row['title'], $row['description'], $row['date'], $row['category'], $row['image'], isset($row['subject']) ? $row['subject'] : '', isset($row['teacherName']) ? $row['teacherName'] : ''
        );
    } else {
        $projects[] = new Project($row['title'], $row['description'], $row['date'], $row['category'], $row['image']
        );
    }
}
?>

<h2>Dashboard</h2>

<h3>Project Toevoegen</h3>
<form method="POST" class="mb-4" enctype="multipart/form-data">
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
    <div class="mb-2">
        <label for="image">Afbeelding:</label>
        <input type="file" name="image" class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Toevoegen</button>
</form>

<h3>Mijn Projecten</h3>
<table class="table">
    <tr>
        <th>Afbeelding</th>
        <th>Titel</th>
        <th>Categorie</th>
        <th>Datum</th>
        <th>Acties</th>
    </tr>
    <?php foreach ($projects as $index => $project): ?>
        <tr>
            <td>
                <?php if (!empty($project->getImage())): ?>
                    <img src="assets/img/<?= htmlspecialchars($project->getImage()); ?>" width="80">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($project->getTitle()); ?></td>
            <td><?= htmlspecialchars($project->getCategory()); ?></td>
            <td><?= htmlspecialchars($project->getDate()); ?></td>
            <td>
                <a href="project.php?id=<?= $projectRows[$index]['id']; ?>" class="btn btn-info btn-sm">Bekijken</a>
                <a href="?delete=<?= $projectRows[$index]['id']; ?>" onclick="return confirm('Weet je zeker dat je dit project wilt verwijderen?')" class="btn btn-danger btn-sm">Verwijderen</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once 'includes/footer.php'; ?>
