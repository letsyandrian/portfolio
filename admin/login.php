<?php
require_once '../includes/config.php';
session_start();
// Activation de l'affichage des erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}
$error = '';
$debug_info = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Ne pas filtrer le mot de passe ici pour éviter d'altérer les caractères
   
    $debug_info .= "Email saisi: " . $email . "<br>";
   
    if ($email && $password) {
        try {
            // Vérifier si la connexion à la DB fonctionne
            $debug_info .= "Connexion PDO établie: " . (($pdo) ? "Oui" : "Non") . "<br>";
           
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
           
            $debug_info .= "Requête exécutée<br>";
            $debug_info .= "Admin trouvé: " . (($admin) ? "Oui" : "Non") . "<br>";
           
            if ($admin) {
                $debug_info .= "ID: " . $admin['id'] . "<br>";
                $debug_info .= "Email dans DB: " . $admin['email'] . "<br>";
                $debug_info .= "Hash dans DB: " . $admin['password'] . "<br>";
               
                $verify_result = password_verify($password, $admin['password']);
                $debug_info .= "Résultat password_verify: " . ($verify_result ? "TRUE" : "FALSE") . "<br>";
               
                if ($verify_result) {
                    $_SESSION['admin_id'] = $admin['id'];
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Email ou mot de passe incorrect (vérification échouée).";
                }
            } else {
                $error = "Email ou mot de passe incorrect (admin non trouvé).";
            }
        } catch (PDOException $e) {
            $debug_info .= "ERREUR PDO: " . $e->getMessage() . "<br>";
            $error = "Erreur de connexion à la base de données.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Connexion</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 15px;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .debug-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid var(--secondary-color);
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            border-left: 4px solid var(--accent-color);
            color: #721c24;
        }
        
        .input-group-text {
            background-color: var(--secondary-color);
            color: white;
            border: 1px solid var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h1><i class="fas fa-lock me-2"></i>Connexion Admin</h1>
                <p class="text-muted">Veuillez vous identifier pour accéder à l'espace administration</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-4">
                    <label for="email" class="form-label">Adresse email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" 
                               required placeholder="Votre email" autocomplete="username">
                        <div class="invalid-feedback">
                            Veuillez fournir une adresse email valide.
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" class="form-control" id="password" name="password" 
                               required placeholder="Votre mot de passe" autocomplete="current-password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" 
                                title="Afficher/Masquer le mot de passe">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="invalid-feedback">
                            Veuillez entrer votre mot de passe.
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                    </button>
                </div>
            </form>
            
            <!-- Affichage des informations de débogage -->
            <?php if (!empty($debug_info)): ?>
            <div class="debug-info mt-4">
                <h5><i class="fas fa-bug me-2"></i>Informations de débogage:</h5>
                <hr>
                <?php echo $debug_info; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script pour afficher/masquer le mot de passe
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Validation des formulaires Bootstrap
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?>