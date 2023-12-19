<?php
class CarteDAO {
    //En privé car la variable ets appelé uniquement à l'interieur de la classe
    private $bdd;

    //Les fonctions sont en public car elles sont appelées en dehors de la classe 
    //Constructeur
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    //Méthode pour ajouter un utilisateur dans la BDD
    public function ajouterCarte(Carte $carte) {

        if($carte->getName() == "" || is_int($carte->getName()) || is_int($carte->getType())|| is_int($carte->getFrameType())|| is_int($carte->getDescription())|| is_int($carte->getRace())|| is_int($carte->getArcheType())|| is_int($carte->getYgoprodeck_url())|| is_int($carte->getCards_sets())|| is_int($carte->getCards_images())|| is_int($carte->getCard_price()) ){
            throw new InvalidArgumentException("champs invalide");
        }else if (preg_match('/\s/',$carte->getFrameType()) || preg_match('/\s/',$carte->getRace())){
            throw new InvalidArgumentException("champs invalide");
        }

        try {
            //Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO cartes (id, `name`, `type`, frameType, `description`, race, archetype, ygoprodeck_url, cards_sets, cards_images, cards_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            //Exécution de la requête avec les valeurs de l'objet Carte
            $requete->execute([$carte->getId(), $carte->getName(), $carte->getType(), $carte->getFrameType(), $carte->getDescription(), $carte->getRace(), $carte->getArcheType(), $carte->getYgoprodeck_url(), $carte->getCards_sets(), $carte->getCards_images(), $carte->getCard_price()]);
            
            //Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout de la carte : " . $e->getMessage();
            
            //Retourne faux en cas d'échec
            return false;
        }
    }

    public function supprimerCarte(Carte $carte) {

        if(is_string($carte->getId())||is_int($carte->getName())){
            throw new InvalidArgumentException("erreur de format des informations");
        }

        try {
            //Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("DELETE FROM cartes WHERE `name` = ?");
            
            //Exécution de la requête avec les valeurs de l'objet Carte
            $requete->execute([$carte->getName()]);
            
            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur de la suppression de la carte : " . $e->getMessage();
            
            //Retourne faux en cas d'échec
            return false;
        }
    }

    public function modificationCarte(Carte $carte) {
        try {
            //Préparation de la requête de mise à jour
            $requete = $this->bdd->prepare("UPDATE cartes SET `name` = ? WHERE id = ?");
            
            //Exécution de la requête avec les valeurs de l'objet Carte
            $requete->execute([$carte->getName(), $carte->getId()]);
            
            //Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur de modification de la carte : " . $e->getMessage();
            
            //Retourne faux en cas d'échec
            return false;
        }
    }

    //Méthode pour lister toutes les cartes de la BDD
    public function listerCartes() {
        try {
            //Exécution d'une requête de sélection pour récupérer toutes les cartes
            $requete = $this->bdd->query("SELECT * FROM cartes");
            
            //Retourne un tableau associatif avec les cartes
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur de récupération des cartes: " . $e->getMessage();
            
            //Retourne un tableau vide en cas d'échec
            return [];
        }
    }
}

?>