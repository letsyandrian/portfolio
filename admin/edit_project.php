<?php
require_once '../includes/config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $technologies = filter_input(INPUT_POST, 'technologies', FILTER_SANITIZE_STRING);
    $project_link = filter_input(INPUT_POST, 'project_link', FILTER_SANITIZE_URL);
    
    $image = $project['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }
    
    $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, image = ?, technologies = ?, project_link = ? WHERE id = ?");
    $stmt->execute([$title, $description, $image, $technologies, $project_link, $id]);
    
    header("Location: index.php");
    exit;
}
?>

<h1>Modifier le projet</h1>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" required value="<?php echo htmlspecialchars($project['title']); ?>">
    <textarea name="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
    <input type="text" name="technologies" value="<?php echo htmlspecialchars($project['technologies']); ?>">
    <input type="url" name="project_link" value="<?php echo htmlspecialchars($project['project_link']); ?>">
    <input type="file" name="image" accept="image/*">
    <?php if ($project['image']) : ?>
        <p>Image actuelle : <img src="../assets/images/<?php echo htmlspecialchars($project['image']); ?>" alt="Current image" style="max-width: 200px;"></p>
    <?php endif; ?>
    <button type="submit">Modifier le projet</button>
</form>
<?php include '../includes/footer.php'; ?>