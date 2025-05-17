<?php
$password = "admin123"; // Remplacez par votre mot de passe souhaité
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash généré: " . $hash;
?>