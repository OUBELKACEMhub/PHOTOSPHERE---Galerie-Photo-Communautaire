<?php
require_once __DIR__ . "/../App/Services/UserFactory.php";
require_once __DIR__ . "/../App/Repositories/UserRepository.php";



//test 
$datauser = [
    'username'             => "ahmed",
    'email'                => "ahmed@gmail.com",
    'password_hash'        => "1223pass",
    'bio'                  => "Hi, I am an admin",
    'profile_picture_path' => "pec/ahmed",
    'role'                 => "Administrator", 
    'last_upload_reset_date' => null,
    'is_super_administrateur' => true
];

try {
    $userObj = UserFactory::create($datauser);
    echo "Utilisateur créé : " . $userObj->getUsername() . " avec le rôle " . $userObj->getRole();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
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

//  $repo->login("ahmed", "12345678"); //connected
 $repo->delete(2); //delete sara
 echo "\n";
 $repo->afficherAllUsers();








