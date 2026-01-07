<?php

interface PostInterface{
    public function AddPost(Post $post):void;
    public function  deletePostById(int $id): void;
}