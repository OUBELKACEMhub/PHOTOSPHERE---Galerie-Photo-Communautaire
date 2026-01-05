<?php
require_once __DIR__ . "/../App/Services/UserFactory.php";
require_once __DIR__ . "/../App/Repositories/UserRepository.php";



//test 
$datauser = [
    'username'             => "mounya",
    'email'                => "mounya@gmail.com",
    'password_hash'        => "1223pass",
    'bio'                  => "Hi, I am an admin",
    'profile_picture_path' => "pec/mounya",
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
       echo "User found in array!";
   } else {
       echo "User not found.";
   }
}

function FindUserid(RepositoryInterface $repo) {
   if($repo->findById(2)) {
       echo "User id=1 is found";
   } else {
       echo " \n User id=1 is  Not found.";
   }
}




$repo = new UserRepository();
FindUser($repo);
FindUserid($repo);
echo "\n Avant \n";
$repo->afficherAllUsers();

print_r($userObj);
$userObj = UserFactory::create($datauser);
$repo->add($userObj);

echo " \nApret\n";

$repo->afficherAllUsers();

// //  $repo->login("ahmed", "12345678"); //connected
//  $repo->delete(2); //delete sara
//  echo "\n";
//  $repo->afficherAllUsers();








