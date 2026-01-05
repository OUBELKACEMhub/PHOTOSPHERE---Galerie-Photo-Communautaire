<?php

require_once __DIR__ . "/../Entities/User.php";
require_once __DIR__ . "/../Entities/BasicUser.php";
require_once __DIR__ . "/../Entities/ProUser.php";
require_once __DIR__ . "/../Entities/Moderator.php";
require_once __DIR__ . "/../Entities/Administrator.php";




class UserFactory {
    public static function create(array $data): User {
        switch ($data['role']) {
            case 'BasicUser':
                return new BasicUser(
                    $data['username'], $data['email'], $data['password_hash'], 
                    $data['bio'], $data['profile_picture_path'], $data['role'],
                    $data['monthly_upload_count'], $data['last_upload_reset_date']
                );

            case 'ProUser':
                return new ProUser(
                    $data['username'], $data['email'], $data['password_hash'], 
                    $data['bio'], $data['profile_picture_path'], $data['role'],
                    $data['monthly_upload_count'], $data['last_upload_reset_date'],
                    $data['subscription_start_date'], $data['subscription_end_date']
                );

            case 'Moderator':
                return new Moderator(
                    $data['username'], $data['email'], $data['password_hash'], 
                    $data['bio'], $data['profile_picture_path'], $data['role'],
                    $data['monthly_upload_count'], $data['last_upload_reset_date'],
                    $data['moderator_level'], $data['is_super_admin']
                );

            case 'Administrator':
                return new Administrateur(
                    $data['username'], $data['email'], $data['password_hash'], 
                    $data['bio'], $data['profile_picture_path'], $data['role'],
                    $data['is_super_administrateur']
                );

            default:
                throw new Exception("Rôle inconnu : " . $data['role']);
        }
    }
}

