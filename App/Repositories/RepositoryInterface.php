<?php

interface RepositoryInterface{

    public function findByUsername($username = null);
    public function findById($id);
    public function add($user);
    public function login($usernameInput, $passwordInput);
    public function logout();
    // public function Update($user);
    public function  delete($id);
}

?>