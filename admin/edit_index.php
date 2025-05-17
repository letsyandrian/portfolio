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
    $stmt = $pdo->query("SELECT section, content FROM index_content WHERE section IN ('name', 'slogan', 'profile_image', 'cv_file')");
    $contents = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    $name = $contents['name'] ?? '';
    $slogan = $contents['slogan'] ?? '';
    $profile_image = $contents['profile_image'] ?? '';
    $cv_file = $contents['cv_file'] ?? '';
} catch (PDOException $e) {
    $error = "Erreur lors du chargement des données : " . $e->getMessage();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slogan = trim($_POST['slogan'] ?? '');
    $errors = [];

    if (empty($name)) {
        $errors[] = "Le champ 'Nom' est requis.";
    }
    if (empty($slogan)) {
        $errors[] = "Le champ 'Slogan' est requis.";
    }

    // Gestion de l'image de profil
    $profile_image = $contents['profile_image'] ?? '';
    if (!empty($_FILES['profile_image']['name'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        if (in_array($_FILES['profile_image']['type'], $allowed_types) && $_FILES['profile_image']['size'] <= $max_size) {
            $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $filename = 'profile_' . uniqid() . '.' . $ext;
            $destination = '../Uploads/' . $filename;
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination)) {
                $profile_image = 'Uploads/' . $filename;
                // Supprimer l'ancienne image si elle existe et n'est pas l'image par défaut
                if (!empty($contents['profile_image']) && $contents['profile_image'] !== 'https://via.placeholder.com/300' && file_exists('../' . $contents['profile_image'])) {
                    unlink('../' . $contents['profile_image']);
                }
            } else {
                $errors[] = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $errors[] = "L'image doit être au format JPEG, PNG ou GIF et ne pas dépasser 2MB.";
        }
    }

    // Gestion du CV
    $cv_file = $contents['cv_file'] ?? '';
    if (!empty($_FILES['cv_file']['name'])) {
        $allowed_types = ['application/pdf'];
        $max_size = 5 * 1024 * 1024; // 5MB
        if (in_array($_FILES['cv_file']['type'], $allowed_types) && $_FILES['cv_file']['size'] <= $max_size) {
            $ext = pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION);
            $filename = 'cv_' . uniqid() . '.' . $ext;
            $destination = '../Uploads/' . $filename;
            if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $destination)) {
                $cv_file = 'Uploads/' . $filename;
                // Supprimer l'ancien CV si il existe
                if (!empty($contents['cv_file']) && file_exists('../' . $contents['cv_file'])) {
                    unlink('../' . $contents['cv_file']);
                }
            } else {
                $errors[] = "Erreur lors du téléchargement du CV.";
            }
        } else {
            $errors[] = "Le CV doit être au format PDF et ne pas dépasser 5MB.";
        }
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO index_content (section, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = ?");
            $stmt->execute(['name', $name, $name]);
            $stmt->execute(['slogan', $slogan, $slogan]);
            $stmt->execute(['profile_image', $profile_image, $profile_image]);
            $stmt->execute(['cv_file', $cv_file, $cv_file]);
            $success = "Contenu mis à jour avec succès !";
        } catch (PDOException $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}

$pageTitle = 'Modifier Accueil - Admin';
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
                        <a class="nav-link" href="edit_about.php">Éditer À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="edit_index.php">Éditer Accueil</a>
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
            <h1 class="display-4 text-center mb-5 animate__animated animate__fadeInDown">Modifier la page d'accueil</h1>

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
                        <form method="POST" action="" enctype="multipart/form-data">
                            <!-- Nom -->
                            <div class="mb-4">
                                <label for="name" class="form-label card-title">Nom</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                            </div>

                            <!-- Slogan -->
                            <div class="mb-4">
                                <label for="slogan" class="form-label card-title">Slogan (texte court sous la photo)</label>
                                <input type="text" class="form-control" id="slogan" name="slogan" value="<?php echo htmlspecialchars($slogan); ?>" required>
                            </div>

                            <!-- Image de profil -->
                            <div class="mb-4">
                                <label for="profile_image" class="form-label card-title">Photo de profil</label>
                                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/gif">
                                <?php if (!empty($profile_image)): ?>
                                    <div class="mt-2">
                                        <img src="<?php echo $profile_image; ?>" alt="Aperçu" class="img-fluid rounded-circle" style="max-width: 100px;">
                                        <p class="text-muted small">Image actuelle</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- CV -->
                            <div class="mb-4">
                                <label for="cv_file" class="form-label card-title">CV (PDF)</label>
                                <input type="file" class="form-control" id="cv_file" name="cv_file" accept="application/pdf">
                                <?php if (!empty($cv_file)): ?>
                                    <div class="mt-2">
                                        <a href="<?php echo $cv_file; ?>" class="text-primary" target="_blank">Voir le CV actuel</a>
                                    </div>
                                <?php endif; ?>
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