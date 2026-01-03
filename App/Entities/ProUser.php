<?php
require_once("User.php");
 class ProUser Extends  User{
    protected $subscription_start_date;
    protected $subscription_end_date ;

    public function __construct(){
       parent::  __construct($username,$email,$password_hash,$role,$created_at,$last_login_at=null,$bio=null,$profile_picture_path=null,$monthly_upload_count=0,$subscription_start_date,$subscription_end_date=null);
       $this->subscription_start_date=$subscription_start_date;
       $this->subscription_end_date=$subscription_end_date;

    }
}

?>