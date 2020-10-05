DROP DATABASE IF EXISTS nerdhub_db;
CREATE DATABASE nerdhub_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nerdhub_db;

SET FOREIGN_KEY_CHECKS = 0;

#creating tables
CREATE TABLE `user` (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password CHAR(60) NOT NULL,
    admin TINYINT DEFAULT 0,
    date_joined DATETIME DEFAULT NOW()
);

CREATE TABLE `theme`
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    category varchar(50) NOT NULL,
    description VARCHAR(255),
    image_path VARCHAR(255) NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE TABLE `story`
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL ,
    description TEXT,
    theme_id INT,
    FOREIGN KEY (theme_id) REFERENCES theme (id)
);

CREATE TABLE `character`
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    description TEXT,
    story_id INT,
    FOREIGN KEY (story_id) REFERENCES story (id)
);