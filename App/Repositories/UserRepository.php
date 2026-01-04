<?php
require_once __DIR__ . "/../Repositories/RepositoryInterface.php";
require_once __DIR__ . "/../Entities/User.php";
require_once __DIR__ . "/../Entities/BasicUser.php";
require_once __DIR__ . "/../../config/Core/Database.php";

try {
    $pdo = Database::getConnection();
         $sql="SELECT * FROM users";
        $stmt = $pdo->query($sql);
       $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de récupération des users : " . $e->getMessage());
}

class UserRepository implements RepositoryInterface {
   private array $users= []; 
    public function __construct(){
        try {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM users";
            $stmt = $pdo->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $this->users[] = new BasicUser(
                    $row['username'],
                    $row['email'],
                    $row['password_hash'],
                    $row['bio'],
                    $row['profile_picture_path'],
                    $row['role'],
                    $row['monthly_upload_count'],
                    $row['last_upload_reset_date']
                );
            }
        } catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }

    public function findByUsername($username = null) { 
        foreach($this->users as $user){
            if($user->getUsername() == $username){
                return true; 
            }
        }
        return false;
    }

    public function findById($id){
         foreach($this->users as $user){
            if($user->getId() == $id){
                return true; 
            }
        }
      return false;
    }

    // public function add($user){
    //     echo "user adding";
    //     return true;
    // }

    // public function Update($user){
    //     echo "user is updating";
    //     return false;
    // }
}

function FindUser(RepositoryInterface $repo) {
   if($repo->findByUsername("amine_dev")) {
       echo "User l'qinah f l'array!";
   } else {
       echo "User ma-kaynch.";
   }
}

function FindUserid(RepositoryInterface $repo) {
   if($repo->findById(2)) {
       echo "User de id=1 l'qinah f l'array!";
   } else {
       echo "User ma-kaynch.";
   }
}

$repo = new UserRepository();
FindUser($repo);
FindUserid($repo);