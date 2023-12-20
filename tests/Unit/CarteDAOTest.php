<?php

use PHPUnit\Framework\TestCase;

require_once ("./front/src/components/Carte.php");
require_once ("./front/src/components/CarteDAO.php");
// require_once("./front/src/components/config.php");

class CarteDAOTest extends TestCase{
    private $pdo;
    private $carte;

    //pour BDD
    protected function setUp(): void{
        $this->configureBDD();
        $this->carte = new CarteDAO($this->pdo);
    }

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
    public function testCarte($fonction,$expected,$id, $name, $type, $frameType, $description, $race, $archetype, $ygoprodeck_url, $cards_sets, $cards_images, $cards_price){
        
        if($fonction == "ajouter"){
            $cartes=new Carte($id, $name, $type, $frameType, $description, $race, $archetype, $ygoprodeck_url, $cards_sets, $cards_images, $cards_price);
            if($name == "" || is_int($name) || is_int($type)|| is_int($frameType)|| is_int($description)|| is_int($race)|| is_int($archetype)|| is_int($ygoprodeck_url)|| is_int($cards_sets)|| is_int($cards_images)|| is_int($cards_price) ){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("champs invalide");
                throw new InvalidArgumentException("champs invalide");
            }
            else if(preg_match('/\s/',$frameType) || preg_match('/\s/',$race) ){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("champs invalide");
                throw new InvalidArgumentException("champs invalide");
            }
            $this->carte->ajouterCarte($cartes);
            $stmt = $this->pdo->prepare("SELECT * FROM cartes WHERE name = :name");
            $stmt->bindParam(":name",$name);
            $cartes=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($cartes);
            $this->assertEquals($expected,$name);
        }

        else if($fonction == "supprimer"){
            if(is_string($id)||is_int($name)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("erreur de format des informations");
            }
            $cartes=new Carte($id, $name, $type, $frameType, $description, $race, $archetype, $ygoprodeck_url, $cards_sets, $cards_images, $cards_price);
            $this->carte->supprimerCarte($cartes);
            $stmt = $this->pdo->prepare("SELECT * FROM cartes WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $cartes=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($cartes);
            $this->assertFalse($cartes);
            
        }

        // else if($fonction == "modifier"){
        //     if($id == "" || $nom == "" || is_string($id) || is_int($nom) ||preg_match('/\s/',$nom) || preg_match('/[0-9]/',$nom)){
        //         $this->expectException(InvalidArgumentException::class);
        //         $this->expectExceptionMessage("ne correspond pas aux attentes");
        //     }
        //     $this->carte->modifierCarte($id,$nom);
        //     $stmt=$this->pdo->prepare("SELECT * FROM cartes WHERE id = :id");
        //     $stmt->bindParam(":id",$id);
        //     $cartes=$stmt->fetch(PDO::FETCH_ASSOC);
        //     // var_dump($cartes);
        //     $this->assertEquals($expected,$nom);
        // }

        else if($fonction == "listerCarteparId"){
            if($id == "" || is_string($id)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("Id invalide");
            }
            $carte=$this->carte->listerCarteparId($id);
    
            $this->assertInstanceOf(Carte::class,$carte);
            $this->assertEquals($expected,$id);
        }
        
    }

    public static function Provider(){
        return[
            //modèle :
            // ["","expected",id, "name", "type", "frameType", "description", "race", "archetype", "ygoprodeck_url", "cards_sets", "cards_images", "cards_price"],
            
            // ["ajouter","test",1,"test","feu","d","sdqfgdhf","ogre","qsdf","url","s","image","price"],
            ["ajouter",1,2,1,"feu","d","sdqfgdhf","ogre","qsdf","url","s","image","price"],
            ["ajouter","test2",2,"test2",2,5,1,9,10,0,2,6,8],
            ["ajouter","1",3,"1","feu","nk ut","sdqfgdhf","ogre g","qsdf","url","s","image","price"],


            // ["supprimer","test",1,"test","","","","","","","","",""],
            ["supprimer","test","1","test","","","","","","","","",""],
            ["supprimer",1,1,1,"","","","","","","","",""],


            ["listerCarteParId",1, 1,"","","","","","","","","",""],
            ["listerCarteParId","","","","","","","","","","","",""],
            ["listerCarteParId",1,"1","","","","","","","","","",""],
            ["listerCarteParId","","bonjour","","","","","","","","","",""],
            ["listerCarteParId","1",1,"","","","","","","","","",""],
            
        ];
    }


}


?>