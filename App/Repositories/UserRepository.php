<?php
require_once __DIR__ . "/../Repositories/RepositoryInterface.php";
require_once __DIR__ . "/../Entities/User.php";
require_once __DIR__ . "/../Entities/BasicUser.php";
require_once __DIR__ . "/../Entities/ProUser.php";
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
   private $current_user=null; 
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

    public function add($user){
            try {
$pdo = Database::getConnection();
$sql = "INSERT INTO users (username, email, password_hash, bio, profile_picture_path, role) 
                VALUES (:username, :email, :password_hash, :bio, :path, :role)";        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username'      => $user->getUsername(), 
            ':email'         => $user->getEmail(),
            ':password_hash' => $user->getPasswordHash(),
            ':bio'           => $user->getBio(),
            ':path'          => $user->getProfilePicturePath(),
            ':role'          => $user->getRole()
        ]);
         if (session_status() === PHP_SESSION_NONE) {
            session_start();}

    } catch (PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
    }
    }


     public function login($usernameInput, $passwordInput) {
        foreach ($this->users as $user) {
            if ( $user->getUsername() === $usernameInput && $user->getPasswordHash() === $passwordInput ) 
                {
                $this->current_user = $user;
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                
                echo $user->getUsername()." ->connected \n";
                return;
            }
        }
       echo "eshec de connection \n";
    }

    public function logout(){
        $this->current=null;
        session_unset();
    }


    public function afficherAllUsers(){
        foreach($this->users as $user){
            echo $user->getUsername()."->".$user->getRole(). "\n";      
        }
    }

    public function Update($user){
        echo "user is updating";
        return false;
    }



     public function  delete($id){
    $pdo = Database::getConnection();

    $sql="DELETE FROM USERS WHERE id= :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
 }





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
echo "\n Avant \n";
$repo->afficherAllUsers();
$user1=new BasicUser('ahmed', 'oubelkacem.@gmail.com', '$2y$10$abcdefg12345', 'PHP Developer', '/img/amine.jpg', 'BasicUser', 3, '2025-12-15', NULL, 0);
$repo->add($user1);
echo " \nApret\n";
$repo->afficherAllUsers();

 $repo->login("ahmed", "12345678"); //connected
 $repo->delete(2); //delete sara
 echo "\n";
 $repo->afficherAllUsers();






