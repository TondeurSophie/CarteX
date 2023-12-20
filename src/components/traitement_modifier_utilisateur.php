<?php
require_once 'Utilisateur.php';
require_once 'UtilisateurDAO.php';
require_once 'config.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $idU = filter_input(INPUT_POST, 'id_utilisateur', FILTER_SANITIZE_NUMBER_INT);
    $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
    $mdp = password_hash(filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    // Créer un objet Utilisateur
    $utilisateur = new Utilisateur($pseudo, $mail, $mdp, $role);

    // Créer un objet UtilisateurDAO avec la connexion à la base de données
    $utilisateurDAO = new UtilisateurDAO($connexion);

    // Modifier l'utilisateur dans la base de données
    if ($utilisateurDAO->modificationUtilisateur($utilisateur)) {
        echo "Utilisateur modifié avec succès.";
    } else {
        echo "Erreur lors de la modification de l'utilisateur.";
    }
} else {
    // Redirection vers la page d'administration si le formulaire n'a pas été soumis
    header('Location: admin.php');
    exit();
}
?>