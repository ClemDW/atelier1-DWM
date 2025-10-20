<?php

// 1. Définition du mot de passe
$motDePasseClair = 'testPassword';

// 2. Hachage du mot de passe
// PASSWORD_DEFAULT utilise l'algorithme de hachage le plus fort supporté par PHP (actuellement BCrypt)
$motDePasseHache = password_hash($motDePasseClair, PASSWORD_BCRYPT);

echo "Mot de passe en clair : " . $motDePasseClair . "\n";
echo "Mot de passe haché (à stocker en BDD) : " . $motDePasseHache . "\n\n";

// --- VÉRIFICATION (Simule la connexion de l'utilisateur) ---

// Le mot de passe entré par l'utilisateur lors de la connexion
$motDePasseEntreParUtilisateur = 'testPassword'; 

// Le hachage récupéré depuis la base de données
$motDePasseDepuisBDD = $motDePasseHache; 

// 3. Vérification du mot de passe
if (password_verify($motDePasseEntreParUtilisateur, $motDePasseDepuisBDD)) {
    echo "Mot de passe VÉRIFIÉ ! L'utilisateur peut se connecter. ✅";
} else {
    echo "Mot de passe INCORRECT. 🚫";
}

?>