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
        try {
            //Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO cartes (id, `name`, `type`, frameType, `description`, race, archetype, ygoprodeck_url, cards_sets, cards_images, cards_price, id_joueur) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            //Exécution de la requête avec les valeurs de l'objet Carte
            $requete->execute([$carte->getId(), $carte->getName(), $carte->getType(), $carte->getFrameType(), $carte->getDescription(), $carte->getRace(), $carte->getArcheType(), $carte->getYgoprodeck_url(), $carte->getCards_sets(), $carte->getCards_images(), $carte->getCards_price(), $carte->getIdJoueur()]);
            
            //Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout de la carte : " . $e->getMessage();
            
            //Retourne faux en cas d'échec
            return false;
        }
    }

    public function supprimerCarte($id_carte) {
        try {
            //Préparation de la requête de suppression
            $requete = $this->bdd->prepare("DELETE FROM cartes WHERE id_carte = ?");
            
            //Exécution de la requête avec l'ID de la carte
            $requete->execute([$id_carte]);
            
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
            $requete = $this->bdd->prepare("UPDATE cartes SET `name` = ?, `type` = ?, frameType = ?, `description` = ?, race = ?, archetype = ?, ygoprodeck_url = ?, cards_sets = ?, cards_images = ?, cards_price = ?, id_joueur WHERE id_carte = ?");
            $requete->execute([$carte->getName(), $carte->getType(), $carte->getFrameType(), $carte->getDescription(), $carte->getRace(), $carte->getArcheType(), $carte->getYgoprodeck_url(), $carte->getCards_sets(), $carte->getCards_images(), $carte->getCards_price(), $carte->getId_carte(), $carte->getIdJoueur()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification de la carte : " . $e->getMessage();
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

    //Méthode pour lister toutes les cartes de la BDD
    // Méthode pour lister une carte par son ID
    public function listerCarteparIdd($id) {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM cartes WHERE id_carte = ?");
            $requete->execute([$id]);
            return $requete->fetch(PDO::FETCH_ASSOC);  // Retourne directement le tableau associatif
        } catch (PDOException $e) {
            echo "Erreur de récupération de la carte par ID : " . $e->getMessage();
            return [];
        }
    }

    public function listerCarteparId($id) {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM cartes WHERE id_carte = ?");
            $requete->execute([$id]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                return new Carte(
                    $resultat["id_carte"],
                    $resultat["name"],
                    $resultat["type"],
                    $resultat["frameType"],
                    $resultat["description"],
                    $resultat["race"],
                    $resultat["archetype"],
                    $resultat["ygoprodeck_url"],
                    $resultat["cards_sets"],
                    $resultat["cards_images"],
                    $resultat["cards_price"],
                    $resultat["id_joueur"]
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur de récupération de la carte par ID : " . $e->getMessage();
            return null;
        }
    }
}

?>