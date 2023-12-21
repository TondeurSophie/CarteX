<?php
require_once 'Utilisateur.php';
require_once 'UtilisateurDAO.php';
require_once 'config.php';

//Soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//Récupération des données
    $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
    $mdp = password_hash(filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

//Modification de la valeur du role dans la base de données en fonction de celui qui a été choisi
    $roleValue = ($role === 'administrateur') ? 1 : 2;

    //Création d'un objet Utilisateur
    $nouvelUtilisateur = new Utilisateur($pseudo, $mail, $mdp, $roleValue);

    // Création d'un objet UtilisateurDAO
    $utilisateurDAO = new UtilisateurDAO($connexion);

    //Ajout de l'utilisateur à la base de données
    if ($utilisateurDAO->ajouterUtilisateur($nouvelUtilisateur)) {
        //Redirection vers la page admin
        header('Location: admin.php');
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur.";
    }
} else {
    //Redirection vers le formulaire en cas d'erreur
    header('Location: ajouter_utilisateur.php');
    exit();
}
?>