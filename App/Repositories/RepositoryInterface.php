<?php

interface RepositoryInterface{

    public function findByUsername($username = null);
    public function findById($id);

    //  public function add($user): bool;
    //  public function Update($user): array;
}

?>