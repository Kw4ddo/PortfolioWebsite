<?php foreach ($projects as $project): ?>
  <div>
    <h3><?= htmlspecialchars($project['title']) ?></h3>
    <p><?= htmlspecialchars($project['description']) ?></p>
    <small><?= htmlspecialchars($project['date']) ?> - <?= htmlspecialchars($project['category']) ?></small>
    <hr>
  </div>
<?php endforeach; ?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Portfolio Projecten</title>
</head>
<body>
  <h1>Projectenoverzicht</h1>
</body>
</html>