<?php

include_once "Utilisateur.php";
include_once "UtilisateurDAO.php";
include_once "config.php";

$utilisateurDAO = new UtilisateurDAO($connexion);

// Récupération de l'utilisateur
$utilisateur = $utilisateurDAO->getUtilisateurById($_GET["id"]);

// Si l'utilisateur n'existe pas
if (!$utilisateur instanceof Utilisateur) {
    echo "Utilisateur introuvable ou ID invalide";
    exit;
}

// Si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Création de l'objet Utilisateur
    $utilisateur = new Utilisateur(
        $_POST["id"],
        $_POST["pseudo"],
        $_POST["mail"],
        $_POST["mdp"] = $utilisateur->getMdp(),
        $_POST["role"]
    );

    // Modification de l'utilisateur
    $modificationReussie = $utilisateurDAO->modificationUtilisateur($utilisateur);

    // Message pour succès ou echec affiché
    $messageModification = $modificationReussie ? "L'utilisateur a été modifié avec succès." : "Erreur lors de la modification de l'utilisateur.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style type="text/css">
        label {
            display: inline-block;
            width: 150px;
            text-align: right;
        }

        input,
        textarea {
            margin-bottom: 5px;
        }

        button {
            margin-left: 155px;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        .box {
            width: 500px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div class="box">
        <h1>Modifier un utilisateur</h1>

        <?php if (isset($messageModification)) : ?>
            <p><?php echo $messageModification; ?></p>
        <?php endif; ?>

        <form method="post" action="modifier_utilisateur.php?id=<?php echo $utilisateur->getId(); ?>">
            <input type="hidden" name="id" value="<?php echo $utilisateur->getId(); ?>">

            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" value="<?php echo $utilisateur->getPseudo(); ?>">

            <label for="mail">Email</label>
            <input type="text" name="mail" id="mail" value="<?php echo $utilisateur->getMail(); ?>">

            <!-- <label for="mdp">Mot de passe</label>
            <input type="hidden" name="mdp" id="mdp" value="<?php echo $utilisateur->getMdp(); ?>"> -->

            <label for="role">Role</label>
            <input type="text" name="role" id="role" value="<?php echo $utilisateur->getRole(); ?>">

            <button type="submit">Modifier</button>
        </form>
    </div>
</body>

</html>