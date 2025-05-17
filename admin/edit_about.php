<?php
require_once '../includes/config.php';
session_start();

// Vérification de la connexion admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Récupération des contenus existants
try {
    $stmt = $pdo->query("SELECT section, content FROM about_content WHERE section IN ('parcours', 'competences')");
    $contents = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    $parcours = $contents['parcours'] ?? '';
    $competences = $contents['competences'] ?? '';
} catch (PDOException $e) {
    $error = "Erreur lors du chargement des données : " . $e->getMessage();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parcours = trim($_POST['parcours'] ?? '');
    $competences = trim($_POST['competences'] ?? '');
    $errors = [];

    if (empty($parcours)) {
        $errors[] = "Le champ 'Mon parcours' est requis.";
    }
    if (empty($competences)) {
        $errors[] = "Le champ 'Compétences' est requis.";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO about_content (section, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = ?");
            $stmt->execute(['parcours', $parcours, $parcours]);
            $stmt->execute(['competences', $competences, $competences]);
            $success = "Contenu mis à jour avec succès !";
        } catch (PDOException $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}

$pageTitle = 'Modifier À propos - Admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
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
                        <a class="nav-link" href="add_project.php">Ajouter un projet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacts.php">Voir les messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="edit_about.php">Éditer À propos</a>
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

    <section class="py-5 content">
        <div class="container">
            <h1 class="display-4 text-center mb-5 animate__animated animate__fadeInDown">Modifier À propos</h1>

            <!-- Messages -->
            <?php if (isset($success)): ?>
                <div class="alert alert-success animate__animated animate__fadeIn"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger animate__animated animate__fadeIn"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger animate__animated animate__fadeIn">
                    <?php foreach ($errors as $err): ?>
                        <p><?php echo htmlspecialchars($err); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4">
                        <form method="POST" action="">
                            <!-- Mon Parcours -->
                            <div class="mb-4">
                                <label for="parcours" class="form-label card-title">Mon parcours</label>
                                <textarea class="form-control" id="parcours" name="parcours" rows="6" required><?php echo htmlspecialchars($parcours); ?></textarea>
                            </div>

                            <!-- Compétences -->
                            <div class="mb-4">
                                <label for="competences" class="form-label card-title">Compétences (une par ligne)</label>
                                <textarea class="form-control" id="competences" name="competences" rows="6" required><?php echo htmlspecialchars($competences); ?></textarea>
                            </div>

                            <!-- Boutons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="index.php" class="btn btn-outline-primary">Annuler</a>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>