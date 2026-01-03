<?php

interface Repository{

    public function findById():void;
     public function save(User $user): bool;
    public function getAllUsers(): array;
}

?>