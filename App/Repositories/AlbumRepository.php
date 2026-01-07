<?php
require_once __DIR__ . "/../Entities/poste.php";
require_once __DIR__ . "/../Entities/album.php";
require_once __DIR__ . "/../Repositories/UserRepository.php";
require_once __DIR__ . "/../../config/Core/Database.php";




class AlbumRepository{


public function __construct(){}
public function getAllAlbums(): array {
    try{
    $pdo = Database::getConnection();
    $sql = "SELECT * FROM album";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
      echo "error data not found" . $e->getMessage();
    }
}


public function Title_is_Unique($title):bool{
     $tab=$this->getAllAlbums();
     $tr=0;
     foreach($tab as $album){
        if($album['title']==$title){
            $tr=1;
        }
     }
    return  $tr==1 ? false : true ;
}


public function getAllUser(){
    try{
     $pdo = Database::getConnection();
            $sql = "SELECT * FROM users";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
      echo "error field to manipulate data!" . $e->getMessage();
    }
}

 public function isA_ProUser(int $userId): bool {
        $pdo = Database::getConnection();
        $sql = "SELECT role FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($user && $user['role'] === 'ProUser');
    }


 public function  createAlbum(int $userId, string $title, string $description, string $visibility): int{
    try{
       $pdo = Database::getConnection();
       if (!$this->isA_ProUser($userId)) {
            $visibility = 'public';
        }

      if ($this->Title_is_Unique($title)) {
           $album=new Album ( $userId,  $title,  $description,  $visibility);
    }
}catch(PDOException $e){
    echo "error field manipuling data!" . $e->getMessage();
    }
    
     }

function findPost($id){
       $pdo = Database::getConnection();
       $sql="SELECT * FROM postes where id=:id";
       $stmt=$pdo->prepare($sql);
       $stmt->execute([':id'=>$id]);
      return  $stmt->fetch(PDO::FETCH_ASSOC);
}
  
 

}


$obj = new AlbumRepository();
$obj->createAlbum(2, "ALBUM3", "no desc", "privee");