<?php
require_once __DIR__ . "/../Repositories/RepositoryInterface.php";
require_once __DIR__ . "/../Entities/User.php";
require_once __DIR__ . "/../Entities/BasicUser.php";
require_once __DIR__ . "/../Entities/ProUser.php";
require_once __DIR__ . "/../Entities/Moderator.php";
require_once __DIR__ . "/../Entities/Administrator.php";
require_once __DIR__ . "/../../config/Core/Database.php";
require_once __DIR__. "/../Services/UserFactory.php"; 

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
                $this->users[] = UserFactory::create($row);  
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
$sql = "INSERT INTO users (
                    username, email, password_hash, role, bio, 
                    profile_picture_path, created_at, last_login_at, 
                    monthly_upload_count, subscription_start_date, 
                    subscription_end_date, moderator_level, is_super_admin
                ) VALUES (
                    :username, :email, :password_hash, :role, :bio, 
                    :path, :created_at, :last_login_at, 
                    :upload_count, :sub_start, :sub_end, :mod_level, :is_admin
                )";      
                  $stmt = $pdo->prepare($sql);
      $stmt->execute([
            ':username'      => $user->getUsername(),
            ':email'         => $user->getEmail(),
            ':password_hash' => $user->getPasswordHash(),
            ':role'          => $user->getRole(),
            ':bio'           => $user->getBio(),
            ':path'          => $user->getProfilePicturePath(),
            ':created_at'    => $user->getDate_Creation() ,
            ':last_login_at' => $user->getDate_last_login(),
            ////
            ':upload_count'  => method_exists($user, 'getMonthlyUploadCount') ? $user->getMonthlyUploadCount() : 0,
            ':sub_start'     => method_exists($user, 'getSubscriptionStartDate') ? $user->getSubscriptionStartDate() : null,
            ':sub_end'       => method_exists($user, 'getSubscriptionEndDate') ? $user->getSubscriptionEndDate() : null,
            ':mod_level'     => method_exists($user, 'getModeratorLevel') ? $user->getModeratorLevel() : null,
            ':is_admin'      => method_exists($user, 'getIsSuperAdmin') ? ($user->is_super_admin() ? 1 : 0) : 0
        ]);
        echo "user was adding to db!";
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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

    public function UpdateUser($id){
       foreach($this->users as $user){
        if($user->getId()==$id){
                        try {
                $pdo = Database::getConnection();
                $sql="UPDATE users 
                set username=:username,
                    email=:email,
                    password_hash=:password_hash,
                    role=:role,
                    created_at=:created_at,
                    last_login_at=:last_login_at,
                    bio=:bio,
                    profile_picture_path=:profile_picture_path

                WHERE id= :id
                
                ";
                $stmt=$pdo->prepare($sql);
                $stmt->exucute([
                    ':username'             => $user->getUsername(),
                    ':email'                => $user->getEmail(),
                    ':password_hash'        => $user->getPasswordHash(),
                    ':role'                 => $user->getRole(),
                    ':created_at'           => $user->getDate_Creation(),
                    ':last_login_at'        => $user->getDate_last_login(),
                    ':bio'                  => $user->getBio(),
                    ':profile_picture_path' => $user->getProfilePicturePath(),
                    ':id'                   => $user->getId()
                ]);
            return true;
            } catch (PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        }

        echo "user introuvable!!!";
       }

    }



     public function  delete($id){
    $pdo = Database::getConnection();

    $sql="DELETE FROM USERS WHERE id= :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
 }


}

// function FindUser(RepositoryInterface $repo) {
//    if($repo->findByUsername("amine_dev")) {
//        echo "User l'qinah f l'array!";
//    } else {
//        echo "User ma-kaynch.";
//    }
// }

// function FindUserid(RepositoryInterface $repo) {
//    if($repo->findById(2)) {
//        echo "User de id=1 l'qinah f l'array!";
//    } else {
//        echo "User ma-kaynch.";
//    }
// }

// $repo = new UserRepository();
// FindUser($repo);
// FindUserid($repo);
// echo "\n Avant \n";
// $repo->afficherAllUsers();
// $user1=new BasicUser('ahmed', 'oubelkacem.@gmail.com', '$2y$10$abcdefg12345', 'PHP Developer', '/img/amine.jpg', 'BasicUser', 3, '2025-12-15', NULL, 0);
// $repo->add($user1);
// echo " \nApret\n";
// $repo->afficherAllUsers();

// //  $repo->login("ahmed", "12345678"); //connected
//  $repo->delete(2); //delete sara
//  echo "\n";
//  $repo->afficherAllUsers();









