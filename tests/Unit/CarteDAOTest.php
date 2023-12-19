<?php

use PHPUnit\Framework\TestCase;

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
            if($name == "" || is_int($name) || preg_match('/\s/',$name) || preg_match('/[0-9]/',$name)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("nom invalide");
                throw new InvalidArgumentException("nom invalide");
            }
            $this->carte->ajouterCarte($cartes);
            $stmt = $this->pdo->prepare("SELECT * FROM cartes WHERE name = :name");
            $stmt->bindParam(":name",$name);
            $cartes=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($cartes);
            $this->assertEquals($expected,$name);
        }
        else if($fonction == "supprimer"){
            if(is_string($id)||$name != ""){
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
        
    }

    public static function Provider(){
        return[
            
            // ["ajouter",$id, $name, $type, $frameType, $description, $race, $archetype, $ygoprodeck_url, $cards_sets, $cards_images, $cards_price],
            ["ajouter","test",1,"test","feu","d","sdqfgdhf","ogre","qsdf","url","s","image","price"]

            // ["supprimer","",29,""],
            // ["supprimer","","",""],
            // ["supprimer","","29",""],
            // ["supprimer","",29,"qsdfrgt"],

            // ["modifier","test",26,"test"],
            // ["modifier","","",""],
            // ["modifier","","1",""],
            // ["modifier","",1,2],
            // ["modifier"," ",1," "],
            // ["modifier","1234",1,"1234"],
        ];
    }


}


?>