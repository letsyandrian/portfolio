<?php
$pageTitle = 'À propos - Mon Portfolio';
require_once 'includes/config.php';
include 'includes/header.php';

// Récupération des contenus depuis la base de données
try {
    $stmt = $pdo->query("SELECT section, content FROM about_content WHERE section IN ('parcours', 'competences')");
    $contents = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    // Définition des valeurs par défaut en cas de données manquantes
    $parcours = isset($contents['parcours']) ? htmlspecialchars($contents['parcours']) : 'Contenu non défini.';
    $competences = isset($contents['competences']) ? array_filter(explode("\n", $contents['competences'])) : [];
} catch (PDOException $e) {
    $parcours = 'Erreur lors du chargement du contenu.';
    $competences = [];
    error_log("Erreur PDO : " . $e->getMessage());
}
?>

<!-- About Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Mon Parcours (Gauche) -->
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="card-title mb-4 animate__animated animate__fadeInLeft" style="animation-delay: 0.2s; color: var(--primary-color);">Mon Parcours</h2>
                <div class="card p-4 animate__animated animate__fadeInLeft" style="animation-delay: 0.3s; border-left: 4px solid var(--primary-color); box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <p class="text-muted"><?php echo nl2br($parcours); ?></p>
                </div>
            </div>
            <!-- Compétences (Droite) -->
            <div class="col-md-6">
                <h2 class="card-title mb-4 animate__animated animate__fadeInRight" style="animation-delay: 0.4s; color: var(--primary-color);">Compétences</h2>
                <div class="card p-4 animate__animated animate__fadeInRight" style="animation-delay: 0.5s; border-right: 4px solid var(--primary-color); box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <ul class="list-group list-group-flush">
                        <?php if (!empty($competences)): ?>
                            <?php foreach ($competences as $competence): ?>
                                <li class="list-group-item"><i class="fas fa-check-circle text-primary me-2"></i><?php echo htmlspecialchars(trim($competence)); ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">Aucune compétence définie.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>