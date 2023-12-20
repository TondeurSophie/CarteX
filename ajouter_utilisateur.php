<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
</head>
<body>

<h2>Ajouter un utilisateur</h2>

<form action="traitement_utilisateur.php" method="post">
    <label for="pseudo">Pseudo :</label>
    <input type="text" id="pseudo" name="pseudo" required><br>

    <label for="mail">Mail :</label>
    <input type="email" id="mail" name="mail" required><br>

    <label for="mdp">Mot de passe :</label>
    <input type="password" id="mdp" name="mdp" required><br>

    <label for="role">Role :</label>
    <select id="role" name="role" required>
        <option value="user">Utilisateur</option>
        <option value="admin">Administrateur</option>
    </select><br>

    <input type="submit" value="Ajouter l'utilisateur">
</form>

</body>
</html>
