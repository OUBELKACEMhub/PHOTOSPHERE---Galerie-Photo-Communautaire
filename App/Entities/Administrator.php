<?php
require_once("User.php");
 class Administrateur Extends  User{
    protected $is_super_administrateur;
    

    public function __construct($is_super_administrateur=false){
       parent::  __construct($username,$email,$password_hash,$bio,$profile_picture_path,$role);
       $this->is_super_administrateur=$is_super_administrateur;
    }
}

?>