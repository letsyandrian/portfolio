<?php
require_once '../includes/config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages de Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-brand { font-weight: bold; }
        .content { margin-top: 2rem; }
        .contact-message { margin-bottom: 1.5rem; padding: 1rem; border: 1px solid #ddd; border-radius: 5px; }
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
                        <a class="nav-link" href="add_project.php">Ajouter un projet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contacts.php">Voir les messages</a>
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
        <h1 class="my-4">Messages de Contact</h1>
        <?php
        $stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="contact-message card">
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                    <p class="card-text"><strong>Message:</strong> <?php echo htmlspecialchars($row['message']); ?></p>
                    <p class="card-text"><strong>Reçu le:</strong> <?php echo $row['created_at']; ?></p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>