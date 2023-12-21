<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
</head>
<body>

<?php
// Inclure les fichiers nécessaires
require_once 'Utilisateur.php';
require_once 'UtilisateurDAO.php';
require_once 'config.php';

// Vérifier si un ID d'utilisateur est fourni dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'ID d'utilisateur depuis l'URL
    $id_utilisateur = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Créer un objet UtilisateurDAO avec la connexion à la base de données
    $utilisateurDAO = new UtilisateurDAO($connexion);

    // Récupérer les informations de l'utilisateur par son ID
    $utilisateur = $utilisateurDAO->listerUtilisateursParID($id_utilisateur);

    // Vérifier si l'utilisateur existe
    if ($utilisateur) {
        // Afficher le formulaire de modification avec les informations de l'utilisateur
        ?>
        <h2>Modifier un utilisateur</h2>

        <form action="traitement_modifier_utilisateur.php" method="post">
            <input type="hidden" name="id_utilisateur" value="<?= $utilisateur['id'] ?>">

            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo" value="<?= $utilisateur['pseudo'] ?>" required><br>

            <label for="mail">Mail :</label>
            <input type="email" id="mail" name="mail" value="<?= $utilisateur['mail'] ?>" required><br>

            <?php
            // Afficher le champ de mot de passe uniquement si vous avez l'intention de le modifier
            // Dans cet exemple, j'utilise une variable $modifierMdp pour déterminer si le mot de passe doit être modifié
            $modifierMdp = true; // Remplacez ceci par votre propre logique
            if ($modifierMdp) {
                ?>
                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" required><br>
                <?php
            }
            ?>

            <label for="role">Role :</label>
            <select id="role" name="role" required>
                <option value="administrateur" <?= ($utilisateur['role'] == 'administrateur') ? 'selected' : '' ?>>Administrateur</option>
                <option value="membre" <?= ($utilisateur['role'] == 'membre') ? 'selected' : '' ?>>Membre</option>
            </select><br>

            <input type="submit" value="Modifier l'utilisateur">
        </form>
        <?php
    } else {
        echo "L'utilisateur n'existe pas.";
    }
} else {
    echo "ID d'utilisateur non fourni.";
}
?>

</body>
</html>