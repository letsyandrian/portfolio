<?php
$pageTitle = 'Accueil - Mon Portfolio';
require_once 'includes/config.php';
include 'includes/header.php';

// Récupération des contenus depuis la base de données
try {
    $stmt = $pdo->query("SELECT section, content FROM index_content WHERE section IN ('name', 'slogan', 'profile_image', 'cv_file')");
    $contents = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    $name = isset($contents['name']) ? htmlspecialchars($contents['name']) : 'Nom non défini';
    $slogan = isset($contents['slogan']) ? htmlspecialchars($contents['slogan']) : 'Slogan non défini';
    $profile_image = isset($contents['profile_image']) && !empty($contents['profile_image']) ? htmlspecialchars($contents['profile_image']) : 'https://via.placeholder.com/300';
    $cv_file = isset($contents['cv_file']) && !empty($contents['cv_file']) ? htmlspecialchars($contents['cv_file']) : '';
} catch (PDOException $e) {
    $name = 'Erreur';
    $slogan = 'Erreur';
    $profile_image = 'https://via.placeholder.com/300';
    $cv_file = '';
    error_log("Erreur PDO : " . $e->getMessage());
}
?>

<!-- Main Section -->
<section id="main" class="py-5 bg-light">
    <div class="container">
        <!-- Section Nom, Photo, Slogan, Boutons en haut -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-4 animate__animated animate__fadeInDown" style="animation-delay: 0.2s; background: linear-gradient(135deg, #ffffff, #e3f0ff); border: 2px solid var(--primary-color); box-shadow: 0 6px 12px rgba(0,0,0,0.15);">
                    <div class="row align-items-center">
                        <!-- Gauche : Photo -->
                        <div class="col-md-4 text-center">
                            <!-- Photo de profil -->
                            <img src="<?php echo $profile_image; ?>" alt="Photo de profil" class="img-fluid rounded-circle shadow animate__animated animate__zoomIn" style="max-width: 150px; height: auto; border: 4px solid var(--primary-color); transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 0 15px rgba(0,123,255,0.5)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)';">
                        </div>
                        <!-- Droite : Nom, Slogan, Boutons -->
                        <div class="col-md-8 text-center text-md-start">
                            <!-- Nom -->
                            <h2 class="card-title mb-2 animate__animated animate__bounceIn" style="animation-delay: 0.3s; font-weight: 900; font-size: 2.2rem; background: linear-gradient(45deg, var(--primary-color), #ff6b6b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 8px rgba(0,123,255,0.5);"><?php echo $name; ?></h2>
                            <!-- Slogan -->
                            <p class="animate__animated animate__bounceIn" style="animation-delay: 0.4s; font-family: 'Dancing Script', cursive; font-size: 1.4rem; color: #e91e63; font-weight: 700; text-shadow: 1px 1px 3px rgba(0,0,0,0.2);"><?php echo $slogan; ?></p>
                            <!-- Boutons CV -->
                            <?php if (!empty($cv_file)): ?>
                                <div class="d-flex flex-column align-items-center align-items-md-start gap-2">
                                    <a href="<?php echo $cv_file; ?>" class="btn btn-primary btn-sm px-4 py-2 animate__animated animate__pulse animate__infinite" style="animation-delay: 0.6s; border-radius: 25px; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 0 15px rgba(0,123,255,0.5)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';" download>
                                        <i class="fas fa-download me-1"></i>Télécharger CV
                                    </a>
                
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section CV (pleine largeur) -->
        <div class="row">
            <div class="col-12">
                <div class="card h-100 p-4 animate__animated animate__fadeInLeft" style="animation-delay: 0.2s;">
                    <h4 class="card-title mb-3 text-center">Mon CV</h4>
                    <?php if (!empty($cv_file)): ?>
                        <div class="mb-3" style="height: 85vh;">
                            <iframe src="<?php echo $cv_file; ?>" title="Aperçu du CV" class="rounded shadow" style="width: 100%; height: 100%;"></iframe>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">Aucun CV disponible.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Google Fonts pour la police du slogan -->
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">