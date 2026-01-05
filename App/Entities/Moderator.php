<?php
require_once("User.php");
 class Moderator Extends  User{
    protected $moderator_level;
    protected $date_intervention;
    protected $raison_intervention;
    protected $isUserActive;
    protected $isSuperAdmin;

    public function __construct($username,$email,$password_hash,$role,$created_at,$last_login_at,$bio=null,$profile_picture_path=null, $moderator_level = "junior",  $isSuperAdmin = false){
       parent::__construct($username,$email,$password_hash,$role,$created_at,$last_login_at,$bio=null,$profile_picture_path=null);
       $this->moderator_level=$moderator_level;
       $this->isSuperAdmin=$isSuperAdmin;
    }



    public function getModeratorLevel(){
        return $moderator_level;
    }
    public function idsuperadmin(){
        return $isSuperAdmin;
    }


}

?>