<?php
abstract class User {
  protected $id;
    protected $username;
    protected $email;
    protected $password_hash;
    protected $bio;
    protected $profile_picture_path;
    protected $created_at;
    protected $last_login_at;
    protected $role;



    public function __construct($username,$email,$password_hash,$role,$created_at,$last_login_at,$bio=null,$profile_picture_path=null){
        $this->username=$username;
        $this->email=$email;
        $this->password_hash=$password_hash;
        $this->role=$role;
        $this->created_at=$created_at;
        $this->last_login_at=$last_login_at;
        $this->bio=$bio;
        $this->profile_picture_path=$profile_picture_path;
    }
}


   //test
// $user=new User();
//resultat :  Cannot instantiate abstract class User in C:\xampp\htdocs\PHOTOSPHERE - Galerie Photo Communautaire\App\Entities\User.php:27


?>



