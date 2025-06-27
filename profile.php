<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'classes/UserProfile.php';

if (!isset($_SESSION['id'])) {
    header('Location: inlog.php');
    exit;
}

$stmt = $pdo->prepare("SELECT username, email, role, bio, profileImage, website FROM users WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$userData = $stmt->fetch();

$userProfile = new UserProfile(
    $userData['bio'] ?? '',
    $userData['profileImage'] ?? '',
    $userData['website'] ?? ''
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'];
    $website = $_POST['website'];
    $profileImage = $userProfile->getProfileImage();

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['profileImage']['tmp_name'], 'assets/img/' . $filename);
        $profileImage = $filename;
    }

    $stmt = $pdo->prepare("UPDATE users SET bio = ?, website = ?, profileImage = ? WHERE id = ?");
    $stmt->execute([$bio, $website, $profileImage, $_SESSION['id']]);

    $userProfile->setBio($bio);
    $userProfile->setWebsite($website);
    $userProfile->setProfileImage($profileImage);

    $userData['bio'] = $bio;
    $userData['website'] = $website;
    $userData['profileImage'] = $profileImage;

    echo "<div class='alert alert-success'>Profiel bijgewerkt!</div>";
}
?>

<h2>Mijn Account</h2>
<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Gebruikersnaam:</strong> <?= htmlspecialchars($userData['username']); ?></li>
    <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($userData['email']); ?></li>
    <li class="list-group-item"><strong>Rol:</strong> <?= htmlspecialchars($userData['role']); ?></li>
</ul>

<h2>Profiel aanpassen</h2>
<form method="POST" enctype="multipart/form-data">
    <div class="mb-2">
        <label for="bio">Bio:</label>
        <textarea name="bio" class="form-control"><?= htmlspecialchars($userProfile->getBio()); ?></textarea>
    </div>
    <div class="mb-2">
        <label for="website">Website:</label>
        <input type="text" name="website" class="form-control" value="<?= htmlspecialchars($userProfile->getWebsite()); ?>">
    </div>
    <div class="mb-2">
        <label for="profileImage">Profielfoto:</label>
        <input type="file" name="profileImage" class="form-control">
        <?php if ($userProfile->getProfileImage()): ?>
            <img src="assets/img/<?= htmlspecialchars($userProfile->getProfileImage()); ?>" width="100" class="mt-2 rounded-circle">
        <?php endif; ?>
    </div>
    <button class="btn btn-primary" type="submit">Opslaan</button>
</form>

<?php require_once 'includes/footer.php'; ?>