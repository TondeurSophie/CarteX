<?php
//Classe Utilisateur DAO 
class UtilisateurDAO {
    //Variable en privé car utilisé uniquement à l'interieur de la base de données
    private $bdd;
    //Construceteur
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }
    //Fonction en public car elles sont utilisées en dehors de la classe
    //Ajoute un utilisateur à la base de données
    public function ajouterUtilisateur(Utilisateur $utilisateur) {
        if($utilisateur->getPseudo() == "" || is_int($utilisateur->getPseudo()) || $utilisateur->getMail() == "" || is_int($utilisateur->getMail() )|| $utilisateur->getMdp()  == "" || is_int($utilisateur->getMdp()) || is_string($utilisateur->getRole())|| preg_match('/\s/',$utilisateur->getMail()) ){
            throw new InvalidArgumentException("champs invalide");
        }
        try {
            $requete = $this->bdd->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, `role`) VALUES (?, ?, ?, ?)");
            $requete->execute([$utilisateur->getPseudo(), $utilisateur->getMail(), $utilisateur->getMdp(), $utilisateur->getRole()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout d'utilisateur: " . $e->getMessage();
            return false;
        }
    }
    //Supprime un utilisateur en fonction du pseudo dans la base de données
    // public function supprimerUtilisateur(Utilisateur $utilisateur) {
    //     try {
    //         $requete = $this->bdd->prepare("DELETE FROM utilisateurs WHERE pseudo = ?");
    //         $requete->execute([$utilisateur->getPseudo()]);
    //         return true;
    //     } catch (PDOException $e) {
    //         echo "Erreur de suppression d'utilisateur : " . $e->getMessage();
    //         return false;
    //     }
    // }
    //Modifie un utilisateur dans la base de données
    public function modificationUtilisateur(Utilisateur $utilisateur) {
        if($utilisateur->getPseudo() == "" || is_int($utilisateur->getPseudo()) || $utilisateur->getMail() == "" || is_int($utilisateur->getMail() )|| $utilisateur->getMdp()  == "" || is_int($utilisateur->getMdp()) || is_string($utilisateur->getRole())|| preg_match('/\s/',$utilisateur->getMail()) ){
            throw new InvalidArgumentException("champs invalide");
        }
        try {
            $requete = $this->bdd->prepare("UPDATE utilisateurs SET pseudo = ?, mail = ?, mdp = ?, `role` = ? WHERE id = ?");
            $requete->execute([$utilisateur->getPseudo(), $utilisateur->getMail(), $utilisateur->getMdp(), $utilisateur->getRole(), $utilisateur->getId()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    //Liste tous les utilisateurs
    public function listerUtilisateurs() {
        try {
            $requete = $this->bdd->query("SELECT * FROM utilisateurs");
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des utilisateurs: " . $e->getMessage();
            return [];
        }
    }
    //Liste les utilisateurs par l'id
    public function listerUtilisateursParID($id) {
        if(is_string($id) || is_string($id)){
            throw new InvalidArgumentException("Id invalide");
        }
        try {
            $requete = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
            $requete->execute([$id]);
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération de l'utilisateur par ID : " . $e->getMessage();
            return [];
        }
    }
    //Supprime un utilisateur en fonction de l'ID
    public function supprimerUtilisateurParId($idUtilisateur) {
        if(is_string($idUtilisateur) ){
            throw new InvalidArgumentException("erreur de format des informations");
        }
        try {
            $requete = $this->bdd->prepare("DELETE FROM utilisateurs WHERE id = ?");
            $requete->execute([$idUtilisateur]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de suppression d'utilisateur : " . $e->getMessage();
            return false;
        }
    }
}