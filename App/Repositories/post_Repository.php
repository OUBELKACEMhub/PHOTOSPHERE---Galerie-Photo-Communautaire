<?php
require_once __DIR__ . "/../Entities/poste.php";
require_once __DIR__ . "/../Interfaces/postInterface.php";
require_once __DIR__ . "/../../config/Core/Database.php";
require_once __DIR__ . "/../Traits/CommentableTrait.php";
require_once __DIR__ . "/../Traits/Taggabletrait.php";





class PostRepository  implements PostInterface{
    private array $postes= [];
    // use CommentableTrait;
    private array $comments=[];
    private array $tags=[];
    use TaggableTrait;

    // session_start();
     public function __construct(){
               try {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM postes";
            $stmt = $pdo->query($sql);
            $postes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($postes as $poste) {
                $this->postes[] = $postes;  
            }


            $sql = "SELECT * FROM tags";
            $stmt = $pdo->query($sql);
            $Mytags = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($Mytags as $tag) {
                $this->tags[] = $tag;  
            }


           }catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        } 
    }

    public function getTags(){
          try {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM tags";
            $stmt = $pdo->query($sql);
            $Mytags = $stmt->fetchAll(PDO::FETCH_ASSOC);

           

           }catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        } 
     return $Mytags;
    }


    public function commentsPost(){
               try {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM comments
            where id:=id";
            $stmt = $pdo->exucute(['id'=>'photo_id']);
            $postes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($postes as $poste) {
                $this->postes[] = $postes;  
            }

           }catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        } 
    }



    public function getAllPostes(){
        return $this->postes;
    }


    public function  FindPosteById($id){
        foreach($this->postes as $post){
          if($post->getId()==$id){
            return $post;
          }
        }
    }


    public function  deletePostById(int $id):void{
            try {
                $pdo = Database::getConnection();
                $sql = "DELETE FROM postes WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $id]);

            }
            catch (PDOException $e) {
                die("Erreur SQL : " . $e->getMessage());
            }  
    }


public function creatTag($id,$contenu){
    try{
      $pdo = Database::getConnection();
     $tag=new Tag(); 
      
        
            $sql="INSERT INTO tags(slug,id_post )  VALUES (:slug,:id_post) ";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([
            ':slug' => $tag->getSlug(),
            ':id_post' => $tag->getIdPost()]);
        
      
      
    }catch(PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
       $pdo -> rollback(); 
    }

}


public function addTagToPhoto_tags( Tag $tag,Post $post11){
    try{
      $pdo = Database::getConnection();
     $tag=new Tag(); 
      foreach($photo_tags as $phT){
        if($post->getId()==$post11->getId()){
            $sql="INSERT INTO photo_tags(id_tag,id_post )  VALUES (:id_tag,:id_post) ";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([
            ':id_tag' => $tag->getIdTag(),
            ':id_post' => $tag->getIdPost()]);
        }
      }
      
    }catch(PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
       $pdo -> rollback(); 
    }
}





//   public function  AddPost( $post, $TagsPost){
//           try {
//          $pdo = Database::getConnection();
//          $pdo -> autocommit(FALSE);
//          if(count($TagPost==0)){
//           creatTag($id,$contenu);
//          }
//          if(count($TagsPost)<10){
//             foreach( $tags as $tag){
//             foreach($TagsPost as $tagPost){
//                 if($tag!=$tagPost){

//                  addTagToPhoto_tags(  $tag,Post $post11)
//                 }
//             }
//          }
//          }
          
//         $sql = "INSERT INTO postes (title, file_path, user_id,description, view_count) VALUES (:title, :file_path, :user_id,:description, 1)";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([
//             ':title' => $post->getTitle(),
//             ':file_path' => $post->getImageLink(),
//             ':user_id' => $post->getUserId(),
//             ':description' => $post->getDescription(),
//             ':view_count' => $post->getViewCount()
//         ]);
//         if (!$pdo -> commit()) {
//         echo "Commit transaction failed";
//         exit();
//         }
//         $pdo -> rollback();
//     } catch (PDOException $e) {
//         $error = "Erreur : " . $e->getMessage();
        
//     }
//   } 
   
}

$obj=new PostRepository();
$tags=$obj->getTagsFromDB();
print_r($tags);



?>