<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>
<!-- Projects Section -->
<section class="projects-section py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title fw-bold animate__animated animate__fadeInUp">Mes Projets</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle animate__animated animate__fadeInUp animate__delay-1s">Découvrez mon portfolio de réalisations professionnelles</p>
            </div>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Extraire les technologies et les transformer en tableau
                $technologies = explode(',', $row['technologies']);
                ?>
                <div class="col">
                    <div class="card project-card h-100 border-0 animate__animated animate__fadeIn">
                        <?php if ($row['image']) { ?>
                            <div class="card-img-wrapper">
                                <img src="assets/images/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                <div class="card-img-overlay d-flex align-items-end">
                                    <div class="project-overlay-content">
                                        <?php if ($row['project_link']) { ?>
                                            <a href="<?php echo htmlspecialchars($row['project_link']); ?>" class="btn btn-primary-outline" target="_blank">
                                                <i class="fas fa-external-link-alt me-2"></i>Voir le projet
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p class="card-text text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                            
                            <?php if (!empty($row['technologies'])) { ?>
                                <div class="tech-stack mt-3">
                                    <?php foreach ($technologies as $tech) { ?>
                                        <span class="badge tech-badge"><?php echo htmlspecialchars(trim($tech)); ?></span>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="far fa-calendar-alt me-1"></i>
                                <?php echo date('M Y', strtotime($row['created_at'])); ?>
                            </small>
                            <?php if ($row['project_link']) { ?>
                                <a href="<?php echo htmlspecialchars($row['project_link']); ?>" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt me-1"></i>Voir le projet
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- Add this CSS to your header or styles file -->
<style>
    :root {
        --primary-color: #3d5af1;
        --primary-light: #e6eaff;
        --secondary-color: #ff6b6b;
        --dark-color: #2d3748;
        --light-color: #f8f9fa;
        --accent-color: #00c9a7;
        --gray-light: #f0f2f5;
        --gray-medium: #a0aec0;
    }
    
    /* Projects Section Styles */
    .projects-section {
        background-color: var(--light-color);
        padding: 80px 0;
    }
    
    .section-title {
        color: var(--dark-color);
        position: relative;
        margin-bottom: 20px;
        font-size: 2.5rem;
    }
    
    .section-divider {
        width: 80px;
        height: 4px;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        margin: 0 auto 20px;
        border-radius: 2px;
    }
    
    .section-subtitle {
        color: var(--gray-medium);
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .project-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        background-color: #ffffff;
    }
    
    .project-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(61, 90, 241, 0.2);
    }
    
    .card-img-wrapper {
        position: relative;
        overflow: hidden;
    }
    
    .card-img-wrapper img {
        height: 220px;
        object-fit: cover;
        transition: transform 0.8s ease;
    }
    
    .project-card:hover .card-img-wrapper img {
        transform: scale(1.05);
    }
    
    .card-img-overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .project-card:hover .card-img-overlay {
        opacity: 1;
    }
    
    .project-overlay-content {
        width: 100%;
        padding: 20px;
    }
    
    .card-title {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 12px;
    }
    
    .card-text {
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    
    .tech-stack {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    
    .tech-badge {
        background-color: var(--primary-light);
        color: var(--primary-color);
        font-size: 0.8rem;
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 500;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 8px 18px;
        font-weight: 500;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #2c48d1;
        border-color: #2c48d1;
        box-shadow: 0 5px 15px rgba(61, 90, 241, 0.4);
    }
    
    .btn-primary-outline {
        color: #ffffff;
        background-color: rgba(61, 90, 241, 0.8);
        border: 2px solid rgba(255, 255, 255, 0.8);
        padding: 8px 18px;
        font-weight: 500;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .btn-primary-outline:hover {
        background-color: var(--primary-color);
        color: white;
        border-color: white;
    }
    
    .card-footer {
        padding: 15px 20px;
    }
    
    /* Add some animations */
    @keyframes cardPulse {
        0% { box-shadow: 0 0 0 0 rgba(61, 90, 241, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(61, 90, 241, 0); }
        100% { box-shadow: 0 0 0 0 rgba(61, 90, 241, 0); }
    }
    
    /* Empty state styling */
    .empty-projects {
        text-align: center;
        padding: 80px 20px;
        background-color: var(--gray-light);
        border-radius: 12px;
        margin-top: 30px;
    }
    
    .empty-projects i {
        font-size: 5rem;
        color: var(--gray-medium);
        margin-bottom: 20px;
    }
    
    .empty-projects h3 {
        color: var(--dark-color);
        margin-bottom: 15px;
    }
    
    .empty-projects p {
        color: var(--gray-medium);
        max-width: 600px;
        margin: 0 auto;
    }
</style>

<?php include 'includes/footer.php'; ?>