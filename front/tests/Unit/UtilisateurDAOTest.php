<?php

use PHPUnit\Framework\TestCase;

//utilise les fichiers
require_once ("./front/src/components/Utilisateur.php");
require_once ("./front/src/components/UtilisateurDAO.php");
// require_once("./front/src/components/config.php");

class UtilisateurDAOTest extends TestCase{
    private $pdo;
    private $utili;

    //pour confugurer la BDD
    protected function setUp(): void{
        $this->configureBDD();
        $this->utili = new UtilisateurDAO($this->pdo);
    }

    //prend les infos de connexion à la BDD
    private function configureBDD(): void{
        $this->pdo = new PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s',
                getenv('DB_HOST'),
                getenv('DB_PORT'),
                getenv('DB_DATABASE')
            ),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    
    /**
     * @dataProvider Provider
     */
    public function testUtilisateur($fonction,$expected,$idUtilisateur,$id,$pseudo, $mail, $mdp, $role){
        
        //test de la méthode d'ajout de carte
        if($fonction == "ajouter"){
            //création de l'objet
            $utilisateurs=new Utilisateur($id,$pseudo, $mail, $mdp, $role);
            //Mise en place des exceptions
            if($pseudo == "" || is_int($pseudo) || $mail == "" || is_int($mail)|| $mdp == "" || is_int($mdp) || is_string($role) || preg_match('/\s/',$mail) ){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("champs invalide");
                throw new InvalidArgumentException("champs invalide");
            }
            
            //appelation de la méthode
            $this->utili->ajouterUtilisateur($utilisateurs);
            $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
            $stmt->bindParam(":pseudo",$pseudo);
            $utilisateurs=$stmt->fetch(PDO::FETCH_ASSOC);
            
            //vérification si $expected est égale à $pseudo
            $this->assertEquals($expected,$pseudo);
        }

        //test de la méthode de suppression de carte
        else if($fonction == "supprimer"){
            //Mise en place des exceptions
            if(is_string($idUtilisateur)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("erreur de format des informations");
                throw new InvalidArgumentException("erreur de format des informations");
            }
            //création de l'objet
            // $utilisateurs=new Utilisateur($pseudo, $mail, $mdp, $role);
            //appelation de la méthode
            $this->utili->supprimerUtilisateur($idUtilisateur);
            $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id");
            $stmt->bindParam(":id",$idUtilisateur);
            $$idUtilisateur=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($utilisateurs);
            //vérification si le resultat est False
            $this->assertEquals($expected,$idUtilisateur);
            
        }
        //test de la méthode de modification de utilisateurs
        else if($fonction == "modifier"){
            $utilisateurs=new Utilisateur($id,$pseudo, $mail, $mdp, $role);
            // Mise en place des exceptions
            if($pseudo == "" || is_int($pseudo) || $mail == "" || is_int($mail)|| $mdp == "" || is_int($mdp) || is_string($role) || preg_match('/\s/',$mail) ){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("champs invalide");
                throw new InvalidArgumentException("champs invalide");
            }
        // appelation de la méthode
            $this->utili->modificationUtilisateur($utilisateurs);
            $stmt=$this->pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
            $stmt->bindParam(":pseudo",$pseudo);
            $utilisateurs=$stmt->fetch(PDO::FETCH_ASSOC);
            
        // vérification si $expected est égale à $pseudo
            $this->assertEquals($expected,$pseudo);
        }
        
        //test de la méthode de trouver la carte par l'id
        else if($fonction == "listerUtilisateursParID"){
            //Mise en place des exceptions
            if($idUtilisateur == "" || is_string($idUtilisateur)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("Id invalide");
                throw new InvalidArgumentException("Id invalide");
            }
            //appelation de la méthode
            $utili=$this->utili->getUtilisateurById($idUtilisateur);
    
            $this->assertInstanceOf(Utilisateur::class,$utili);
            //vérification si $expected est égale à $pseudo
            $this->assertEquals($expected,$idUtilisateur);
        }
        
    }

    //tests des méthodes
    public static function Provider(){
        return[
            //modèle :
            // ["",$expected,$idUtilisateur,$id,$pseudo, $mail, $mdp, $role],
            // ["","","","", "", "","",""],
            
            ["ajouter","","","","", "", "",""],
            // ["ajouter","titi",15,"","titi", "titi@mail.fr", "titititi",1],
            // ["ajouter","a","","","a", "a@aaa.com", "aaaaaa",1],
            ["ajouter","a","","","a", "a@aaa.com", "aaaaaa","1"],
            ["ajouter","a","","","a", "a@aa a.com", "aaaaaa",1],


            ["supprimer","","","","", "", "",""],
            ["supprimer",18,18,"","", "", "",""],
            ["supprimer","17","17","","", "", "",""],


            ["listerUtilisateursParID","", "","","","","","","","","","","",""],
            // ["listerUtilisateursParID",12, 12,"","","","","","","","","","",""],
            
            ["modifier","","","", "", "","",""],
            ["modifier",2,"","",2, "titi@s.fr", "",""],
        ];
    }


}


?>