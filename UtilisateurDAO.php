<?php
include("config.php");
include("Utilisateur.php");
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
        try {
            //Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, `role`) VALUES (?, ?, ? , ?)");
            
            //Exécution de la requête avec les valeurs de l'objet Utilisateur
            $requete->execute([$utilisateur->getNom(), $utilisateur->getPrenom()]);
            
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
        try {
            //Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("DELETE FROM utilisateurs WHERE pseudo = ?");
            
            //Exécution de la requête avec les valeurs de l'objet Utilisateur
            $requete->execute([$utilisateur->getPseudo()]);
            
            //Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout d'utilisateur: " . $e->getMessage();
            
            // Retourne faux en cas d'échec
            return false;
        }
    }

    public function modificationUtilisateur(Utilisateur $utilisateur) {
        try {
            //Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("UPDATE FROM utilisateurs SET pseudo = '?' where id='?';");
            $pseudo = $utilisateur->getPseudo();
            //Exécution de la requête avec les valeurs de l'objet Utilisateur
            $requete->execute([,$utilisateur->setPseudo($pseudo), $utilisateur->getId()]);
            
            //Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur de modification de l'utilisateur : " . $e->getMessage();
            
            //Retourne faux en cas d'échec
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
}
?>