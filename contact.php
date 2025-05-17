<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section d-flex align-items-center text-center text-white">
    <div class="container">
        <h1 class="display-4 animate__animated animate__fadeInDown">Contactez-moi</h1>
        <p class="lead animate__animated animate__fadeInUp">Envoyez-moi un message pour discuter de vos projets ou opportunités</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm animate__animated animate__fadeIn">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Formulaire de contact</h2>
                        <form action="process_contact.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Sujet</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>