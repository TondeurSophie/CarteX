<?php
// Inclusion des fichiers nécessaires
include_once("Utilisateur.php");
include_once("UtilisateurDAO.php");
include_once("config.php");

$messageAjout = ""; // Initialisation du message

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["pseudo"]) && !empty($_POST["mail"]) && !empty($_POST["mdp"]) && !empty($_POST["role"])) {
    $pseudo = trim($_POST["pseudo"]);
    $mail = trim($_POST["mail"]);
    $mdp = trim($_POST["mdp"]);
    $role = ($_POST["role"] == "admin") ? 2 : 1;

    //Création d'un nouvel objet Utilisateur
    $utilisateur = new Utilisateur($pseudo, $mail, $mdp, $role);

    //Création de l'objet UtilisateurDAO avec la connexion
    $utilisateurDAO = new UtilisateurDAO($connexion);

    //Tentative d'ajout de l'utilisateur
    if ($utilisateurDAO->ajouterUtilisateur($utilisateur)) {
        $messageAjout = "L'utilisateur a été ajouté avec succès";
    } else {
        $messageAjout = "Échec de l'ajout de l'utilisateur";
    }
} else {
    $messageAjout = "Tous les champs sont obligatoires";
}


// var_dump($role);
// var_dump($pseudo);
// var_dump($_POST["pseudo"]);
// var_dump($_POST["mail"]);
// var_dump($_POST["mdp"]);
// var_dump($_POST["role"]);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'utilisateur</title>
    <style type="text/css">
        /* Ajoutez votre CSS ici */
    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter un nouvel utilisateur</h1>
        <p><?php echo $messageAjout; ?></p> <!-- Affichage du message de résultat -->

        <!-- Formulaire pour ajouter un utilisateur -->
        <form action="ajoutUtilisateur.php" method="POST">
            <label for="pseudo">Pseudo:</label>
            <input type="text" id="pseudo" name="pseudo" required><br><br>

            <label for="mail">Mail:</label>
            <input type="text" id="mail" name="mail" required><br><br>

            <label for="mdp">Mot de passe:</label>
            <input type="text" id="mdp" name="mdp" required><br><br>

            <label for="role">Role:</label>
            <input type="text" id="role" name="role" required><br><br>

            <input type="submit" value="Ajouter">
        </form>
    </div>
</body>
</html>