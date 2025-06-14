<?php
if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}
$dataFile = 'profile_data.php';
if (file_exists($dataFile)) 
{
    $user = include $dataFile;
} 
else 
{
    $user = [
        'first_name' => '',
        'last_name' => '',
        'birth_date' => '',
        'about' => '',
        'photo' => ''
    ];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_profile'])) 
{
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $birthDate = $_POST['birth_date'];
    $about = trim($_POST['about']);
    $errors = [];
    if (empty($firstName) || empty($lastName) || empty($birthDate) || empty($about)) 
    {
        $errors[] = 'All fields must be filled.';
    }
    if (strlen($firstName) < 2 || strlen($lastName) < 2) 
    {
        $errors[] = 'First Name and Last Name must be at least 2 characters.';
    }
    $birthTimestamp = strtotime($birthDate);
    $age = (int)floor((time() - $birthTimestamp) / (365.25 * 24 * 60 * 60));
    if ($age < 16) 
    {
        $errors[] = 'You must be at least 16 years old.';
    }
    if (strlen($about) < 50) 
    {
        $errors[] = 'The "About" section must be at least 50 characters.';
    }
    if (empty($errors)) 
    {
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) 
        {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $filename = 'uploads/' . uniqid() . "." . $ext;
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }
            move_uploaded_file($_FILES['photo']['tmp_name'], $filename);
            $user['photo'] = $filename;
        }
        $user['first_name'] = $firstName;
        $user['last_name'] = $lastName;
        $user['birth_date'] = $birthDate;
        $user['about'] = $about;
        file_put_contents($dataFile, "<?php\nreturn " . var_export($user, true) . ";\n");
        header("Location: main.php?page=profile");
        exit;
    }
}
?>
<h2>Edit Profile</h2>
<?php if (!empty($errors)): ?>
    <div class="error-messages">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" enctype="multipart/form-data">
    <label>First Name:</label>
    <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
    <label>Last Name:</label>
    <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
    <label>Date of Birth:</label>
    <input type="date" name="birth_date" value="<?= htmlspecialchars($user['birth_date']) ?>" required>
    <label>About:</label>
    <textarea name="about" rows="4" required><?= htmlspecialchars($user['about']) ?></textarea>
    <label>Photo:</label>
    <?php if (!empty($user['photo'])): ?>
        <img src="<?= htmlspecialchars($user['photo']) ?>" alt="Profile Photo" style="max-width:200px; display:block; margin:10px 0;">
    <?php else: ?>
        <p>No photo uploaded</p>
    <?php endif; ?>
    <input type="file" name="photo">
    <button class="btn" type="submit" name="save_profile">Save</button>
</form>
