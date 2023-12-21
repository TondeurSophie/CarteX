<?php
// Création de la classe utilisateur
class Utilisateur {
    //Variables en privé car utilisées uniquement à l'intérieur des fonctions de la classe
    private $id; //Ne sert a rien car id en auto-increment
    private $pseudo;
    private $mail;
    private $mdp;
    private $role;

    //Fonction en public car elles sont appelées en dehors de la classe
    //Fonction pour créer les objets
    public function __construct($pseudo, $mail, $mdp, $role) {
        $this->pseudo = $pseudo;
        $this->mail = $mail;
        $this->mdp = $mdp;
        $this->role = $role;
    }
    //Fonction pour récupérer une caracteristque de l'objet
    public function getId() {
        return $this->id;
    }

    public function getPseudo() {
        return $this->pseudo;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function getRole(){
        return $this->role;
    }


}
?>