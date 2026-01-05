<?php
require_once("User.php");

class Administrateur extends User {
    protected $is_super_administrateur;
    
    public function __construct(
        $username,  $email,  $password_hash,   $role,   $created_at,   $last_login_at,   $bio = null,  $profile_picture_path = null,  $is_super_administrateur = false 
    ) {
        parent::__construct($username, $email, $password_hash, $role, $created_at, $last_login_at, $bio, $profile_picture_path);
        
        $this->is_super_administrateur = $is_super_administrateur;
    }

    public function is_super_admin() {
        return (bool)$this->is_super_administrateur;
    }

    public function getIsSuperAdmin() {
        return $this->is_super_administrateur;
    }
}