<?php
include_once("config.php");
include_once("Utilisateur.php");
class UtilisateurDAO {
    //Variable en privé car appelé uniquement à l'intérieur de la classe (pour des raisons de sécurité on le met en privé)
    private $bdd;

    //Constructeur prenant une connexion PDO en paramètre
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }
    //Les fonctions sont en publiques car elles sont appelées en dehors de la classe
    //Méthode pour ajouter un utilisateur dans la BDD
    public function ajouterUtilisateur(Utilisateur $utilisateur) {
        if($utilisateur->getPseudo() == "" || is_int($utilisateur->getPseudo()) || $utilisateur->getMail() == "" || is_int($utilisateur->getMail())|| $utilisateur->getMdp() == "" || is_int($utilisateur->getMdp()) || is_string($utilisateur->getRole()) || preg_match('/\s/',$utilisateur->getMail()) ){
            throw new InvalidArgumentException("champs invalide");
        }
        try {
            //Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, `role`) VALUES (?, ?, ? , ?)");
            
            //Exécution de la requête avec les valeurs de l'objet Utilisateur
            $requete->execute([$utilisateur->getPseudo(), $utilisateur->getMail(), $utilisateur->getMdp(), $utilisateur->getRole()]);
            
            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout d'utilisateur: " . $e->getMessage();
            
            //Retourne faux en cas d'échec
            return false;
        }
    }

    public function supprimerUtilisateur(Utilisateur $utilisateur) {
        if(is_string($utilisateur)){
            throw new InvalidArgumentException("erreur de format des informations");
        }
        try {
            //Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("DELETE FROM utilisateurs WHERE id = ?;");
            
            //Exécution de la requête avec les valeurs de l'objet Utilisateur
            $requete->execute([$utilisateur->getId()]);
            
            //Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur de suppression de l'utilisateur : " . $e->getMessage();
            
            //Retourne faux en cas d'échec
            return false;
        }
    }

    public function modificationUtilisateur(Utilisateur $utilisateur) {
        if($utilisateur->getPseudo() == "" || is_int($utilisateur->getPseudo()) || $utilisateur->getMail() == "" || is_int($utilisateur->getMail())|| $utilisateur->getMdp() == "" || is_int($utilisateur->getMdp()) || is_string($utilisateur->getRole()) || preg_match('/\s/',$utilisateur->getMail()) ){
            throw new InvalidArgumentException("champs invalide");
        }
        try {
            $requete = $this->bdd->prepare("UPDATE utilisateurs SET pseudo = ?, mail = ?, mdp = ?, `role` = ? WHERE id = ?;");
            $requete->execute([$utilisateur->getPseudo(), $utilisateur->getMail(), $utilisateur->getMdp(), $utilisateur->getRole(), $utilisateur->getId()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    

    //Méthode pour lister tous les utilisateurs de la BDD
    public function listerUtilisateurs() {
        try {
            //Exécution d'une requête de sélection pour récupérer tous les utilisateurs
            $requete = $this->bdd->query("SELECT * FROM utilisateurs");
            
            //Retourne un tableau associatif avec les utilisateurs
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur de récupération des utilisateurs: " . $e->getMessage();
            
            //Retourne un tableau vide en cas d'échec
            return [];
        }
    }

// Dans UtilisateurDAO
public function getUtilisateurById($id) {
    if($id == "" || is_string($id)){
        throw new InvalidArgumentException("Id invalide");
    }
    try {
        $requete = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?;");
        $requete->execute([$id]);
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        if ($resultat) {
            // Assurez-vous que l'ordre des paramètres correspond au constructeur de la classe Utilisateur
            return new Utilisateur($resultat['id'], $resultat['pseudo'], $resultat['mail'], $resultat['mdp'], $resultat['role']);
        }
        return null;
    } catch (PDOException $e) {
        echo "Erreur de récupération de l'utilisateur : " . $e->getMessage();
        return null;
    }
}

    
}
?>