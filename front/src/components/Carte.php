<?php
// Création de la classe carte
class Carte {
    //Variables en privé car utilisées uniquement à l'intérieur des fonctions de la classe
    private $id_carte;
    private $id; //Ne sert a rien car id en auto-increment
    private $name;
    private $type;
    private $frameType;
    private $description;
    private $race;
    private $archetype;
    private $ygoprodeck_url;
    private $cards_sets;
    private $cards_images;
    private $cards_price;
    private $id_joueur;

    //Fonction en public car elles sont appelées en dehors de la classe
    //Fonction pour créer les objets
    public function __construct($id, $name, $type, $frameType, $description, $race, $archetype, $ygoprodeck_url, $cards_sets, $cards_images, $cards_price, $id_joueur) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->frameType = $frameType;
        $this->description = $description;
        $this->race = $race;
        $this->archetype = $archetype;
        $this->ygoprodeck_url = $ygoprodeck_url;
        $this->cards_sets = $cards_sets;
        $this->cards_images = $cards_images;
        $this->cards_price = $cards_price;
        $this->id_joueur = $id_joueur;
    }
    //Fonction pour récupérer une caracteristique de l'objet
    public function getId() {
        return $this->id;
    }
    public function getIdJoueur() {
        return $this->id_joueur;
    }

    public function getId_carte() {
        return $this->id_carte;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getFrameType(){
        return $this->frameType;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getRace(){
        return $this->race;
    }

    public function getArcheType(){
        return $this->archetype;
    }

    public function getYgoprodeck_url(){
        return $this->ygoprodeck_url;
    }

    public function getCards_sets(){
        return $this->cards_sets;
    }

    public function getCards_images(){
        return $this->cards_images;
    }

    public function getCards_price(){
        return $this->cards_price;
    }

    public function setId_carte($id_carte){
        $this->id_carte= $id_carte;
    }

    public function setName($name){
        $this->name= $name;
    }

    public function setType($type){
        $this->type= $type;
    }

    public function setFrameType($frameType){
        $this->frameType= $frameType;
    }

    public function setDescription($description){
        $this->description= $description;
    }

    public function setRace($race){
        $this->race= $race;
    }

    public function setArcheType($archetype){
        $this->archetype= $archetype;
    }

    public function setYgoprodeck_url($ygoprodeck_url){
        $this->ygoprodeck_url=$ygoprodeck_url;
    }

    public function setCards_sets($cards_sets){
        $this->cards_sets= $cards_sets;
    }

    public function setCards_images($cards_images){
        $this->cards_images= $cards_images;
    }

    public function setCards_price($cards_price){
        $this->cards_price= $cards_price;
    }
    public function setIdJoueur($id_joueur){
        $this->id_joueur= $id_joueur;
    }
}
?>