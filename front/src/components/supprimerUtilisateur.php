<?php

include_once "Utilisateur.php";
include_once "UtilisateurDAO.php";

$messageSuppression = ""; // Initialisation du message

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["pseudo"]) && !empty($_POST["mail"]) && !empty($_POST["mdp"]) && !empty($_POST["role"])) {
    $pseudo = trim($_POST["pseudo"]);
    $mail = trim($_POST["mail"]);
    $mdp = trim($_POST["mdp"]);
    $role = ($_POST["role"] == "admin") ? 2 : 1;

    //Création d'un nouvel objet Utilisateur
    $utilisateur = new Utilisateur(0, $pseudo, $mail, $mdp, $role);

    //Création de l'objet UtilisateurDAO avec la connexion
    $utilisateurDAO = new UtilisateurDAO($connexion);

    //Tentative de suppression de l'utilisateur
    if ($utilisateurDAO->supprimerUtilisateur($utilisateur)) {
        $messageSuppression = "L'utilisateur a été supprimé avec succès";
    } else {
        $messageSuppression = "Échec de la suppression de l'utilisateur";
    }
} else {
    $messageSuppression = "Tous les champs sont obligatoires";
}

?>