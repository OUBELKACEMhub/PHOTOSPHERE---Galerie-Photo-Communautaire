CREATE DATABASE photospheredb;

use DATABASE photospheredb;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    bio TEXT,
    profile_picture_path VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login_at DATETIME,
    role ENUM(
        'BasicUser',
        'ProUser',
        'Moderator',
        'Administrator'
    ) NOT NULL DEFAULT 'BasicUser',
    monthly_upload_count INT DEFAULT 0,
    last_upload_reset_date DATE,
    subscription_start_date DATETIME,
    subscription_end_date DATETIME,
    moderator_level ENUM('Junior', 'Senior', 'Lead'),
    is_super_admin BOOLEAN DEFAULT FALSE
)

CREATE TABLE postes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    status ENUM(
        'archived',
        'draft',
        'published'
    ) DEFAULT 'draft',
    view_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    published_at DATETIME DEFAULT NULL CHECK (published_at >= created_at),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE album (
    id_alb int AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    title varchar(100),
    descrption text,
    visibility ENUM('privee', 'public') DEFAULT 'public',
    photo_count int DEFAULT 0,
    cover_photo_id INT DEFAULT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT null ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

---Toutes les relations entre entités doivent être protégées par des contraintes d'intégrité référentielle au niveau de la base de

CREATE TABLE comment (
    id_comnt int AUTO_INCREMENT PRIMARY KEY,
    user_id int NOT NULL,
    post_id int NOT NULL,
    Content VARCHAR(500) NOT NULL,
    is_edited BOOLEAN DEFAULT FALSE,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES postes (id) ON DELETE CASCADE
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_post (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES postes (id) ON DELETE CASCADE
);

CREATE TABLE album_post (
    album_id INT NOT NULL,
    post_id INT NOT NULL,
    PRIMARY KEY (album_id, post_id),
    FOREIGN KEY (album_id) REFERENCES album (id_alb) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES postes (id) ON DELETE CASCADE
);

REATE
TABLE tags (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(40) NOT NULL
);

CREATE TABLE posts_tag (
    post_id int NOT NULL,
    tag_id int NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES postes (id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE
);