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
        
        return ($user && $user['role'] === 'ProUser')?: null;
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
      return  $stmt->fetch(PDO::FETCH_ASSOC)?: null;
}
  
 
function findAlbum($id){
       $pdo = Database::getConnection();
       $sql="SELECT * FROM album where id=:id";
       $stmt=$pdo->prepare($sql);
       $stmt->execute([':id'=>$id]);
      return  $stmt->fetch(PDO::FETCH_ASSOC)?: null;
} 



 public function addPostToAlbum(int $album_id, int $postId, int $userId): bool{
           $pdo = Database::getConnection();
            $post=$this->findPost($postId);
            $sql = "UPDATE postes set album_id=:album_id,updated_at=NOW() where id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':album_id'     => $album_id,
                ':id'       => $postId
            ]);
            echo "ajouter Post sur avec succees!";  
    }  



public function removePhotoFromAlbum($albumId, $photoId, $userId): bool 
{
    try {
        $pdo = Database::getConnection();
        $sql = "UPDATE postes  SET album_id = NULL  WHERE id = :photo_id 
                AND album_id = :album_id  AND user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        
        $success = $stmt->execute([
            ':photo_id' => $photoId,
            ':album_id' => $albumId,
            ':user_id'  => $userId
        ]);

        return $success && $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Erreur removePhotoFromAlbum : " . $e->getMessage());
        return false;
    }
}

public function getAlbumWithPhotos($userId,$includePrivate=true){
 $pdo = Database::getConnection();
        $sql = "SELECT * FROM album ab JOIN postes p 
          ON ab.id=p.album_id where ab.visibility=:visibility";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['visibility'=>$includePrivate]);
        return $stmt->fetch(PDO::FETCH_ASSOC)?: null;
}

public function updateAlbum(int $albumId, int $userId, array $data): bool{
     if (!$this->isA_ProUser($userId) && $data['visibility'] != 'public') {
            return false;
        }
 $pdo = Database::getConnection();
        $sql = "UPDATE album  SET title=:title ,description=:description,visibility=:visibility
        WHERE id=:id ";
         $stmt = $pdo->prepare($sql);
         $stmt->execute([
            'title'=>$data['title'],
            'description'=>$data['description'],
            'visibility'=>$data['visibility']
            ]);
   return true;
}

public function deleteAlbum($albumId,$userId):bool{
    try{
         $pdo = Database::getConnection();
        $sql="DELETE FROM albums WHERE id=:id";
         $stmt = $pdo->prepare($sql);
         $stmt->execute(['id'=>$albumId]);
    }catch(PDOExecption $e){
        echo "error  deleting field" . $e->getMessage();
    }
}
}











 //test

$obj = new AlbumRepository();
 $obj->createAlbum(2, "ALBUM3", "no desc", "privee"); 
$obj->addPhotoToAlbum(1,1,1);
