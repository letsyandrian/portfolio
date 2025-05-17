<?php
require_once '../includes/config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $technologies = filter_input(INPUT_POST, 'technologies', FILTER_SANITIZE_STRING);
    $project_link = filter_input(INPUT_POST, 'project_link', FILTER_SANITIZE_URL);
    
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }
    
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, technologies, project_link) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $image, $technologies, $project_link]);
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un projet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-brand { font-weight: bold; }
        .content { margin-top: 2rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="add_project.php">Ajouter un projet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacts.php">Voir les messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit_about.php">Éditer À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit_index.php">Éditer Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container content">
        <h1 class="my-4">Ajouter un projet</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Titre du projet</label>
                <input type="text" class="form-control" id="title" name="title" required placeholder="Titre du projet">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required placeholder="Description" rows="5"></textarea>
            </div>
            <div class="mb-3">
                <label for="technologies" class="form-label">Technologies utilisées</label>
                <input type="text" class="form-control" id="technologies" name="technologies" placeholder="Technologies utilisées">
            </div>
            <div class="mb-3">
                <label for="project_link" class="form-label">Lien du projet</label>
                <input type="url" class="form-control" id="project_link" name="project_link" placeholder="Lien du projet">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image du projet</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le projet</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>