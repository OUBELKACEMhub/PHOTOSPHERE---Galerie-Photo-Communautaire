<?php
require_once("User.php");
 class BasicUser Extends  User{
    protected $monthly_upload_count=0;
    protected $last_upload_reset_date;

    public function __construct($username,$email,$password_hash,$bio,$profile_picture_path,$role="BasicUser",$monthly_upload_count=0,$last_upload_reset_date=null){
       parent::  __construct($username,$email,$password_hash,$bio,$profile_picture_path,$role);
       $this->monthly_upload_count=$monthly_upload_count;
       $this->last_upload_reset_date=$last_upload_reset_date;

    }


    public function getLast_upload_reset_date(){
        return $this->last_upload_reset_date;
    }
   
    public function  getMonthly_upload_count(){
        return $monthly_upload_count;
     }



 }
?>



