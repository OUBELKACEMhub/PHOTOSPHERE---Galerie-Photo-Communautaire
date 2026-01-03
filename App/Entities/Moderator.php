<?php
require_once("User.php");
 class Moderator Extends  User{
    protected $moderator_level;
    protected $date_intervention;
    protected $raison_intervention;
    protected $isUserActive;
    protected $isSuperAdmin;

    public function __construct($username,  $email,  $password_hash,  $bio = null,  $profile_picture_path = null,  $role = 'Moderator', $moderator_level = "junior",  $isSuperAdmin = false){
       parent::__construct($username,$email,$password_hash,$bio,$profile_picture_path,$role);
       $this->moderator_level=$moderator_level;
       $this->isSuperAdmin=$isSuperAdmin;
    }
}

?>