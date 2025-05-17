<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Tous les champs sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } else {
        // Insert into database (example table: contacts)
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $subject, $message]);
            $success = "Message envoyé avec succès !";
        } catch (PDOException $e) {
            $error = "Erreur lors de l'envoi du message : " . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<!-- Contact Response Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm animate__animated animate__fadeIn">
                    <div class="card-body text-center">
                        <?php if (isset($success)) { ?>
                            <h2 class="card-title mb-4">Merci !</h2>
                            <p class="card-text text-success"><?php echo $success; ?></p>
                            <a href="contact.php" class="btn btn-primary mt-3">Retour au formulaire</a>
                        <?php } elseif (isset($error)) { ?>
                            <h2 class="card-title mb-4">Erreur</h2>
                            <p class="card-text text-danger"><?php echo $error; ?></p>
                            <a href="contact.php" class="btn btn-primary mt-3">Retour au formulaire</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>