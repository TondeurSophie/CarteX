<?php
include_once("Carte.php");
include_once("CarteDAO.php");
include_once("config.php");

// Récupérer les données du formulaire
$idU = filter_input(INPUT_POST, 'id_utilisateur', FILTER_SANITIZE_NUMBER_INT);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
$mdp = isset($_POST['mdp']) ? password_hash(filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT) : null;
$role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

// Créer un objet Utilisateur
$utilisateur = new Utilisateur($pseudo, $mail, $mdp, $role);