<?php
require_once("User.php");
 class BasicUser Extends  User{
    protected $monthly_upload_count;
    protected $last_upload_reset_date;

    public function __construct(){
       parent::  __construct($username,$email,$password_hash,$bio,$profile_picture_path,$role);
       $this->monthly_upload_count=$monthly_upload_count;
       $this->last_upload_reset_date=$last_upload_reset_date;

    }
}




?>



