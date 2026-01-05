<?php
require_once __DIR__ . "/../App/Services/UserFactory.php";


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


