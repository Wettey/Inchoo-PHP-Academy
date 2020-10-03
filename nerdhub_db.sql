DROP DATABASE IF EXISTS nerdhub_db;
CREATE DATABASE nerdhub_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nerdhub_db;

#creating tables
CREATE TABLE `user` (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password CHAR(60) NOT NULL,
    role TINYINT DEFAULT 0,
    date_joined DATETIME DEFAULT NOW()
);

CREATE TABLE `theme`
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(100),
    description TEXT,
    image_path VARCHAR(255)
);

CREATE TABLE `user_theme`
(
    user_id INT,
    theme_id INT,
    FOREIGN KEY (user_id) REFERENCES user (id),
    FOREIGN KEY (theme_id) REFERENCES theme (id)
);

CREATE TABLE `character`
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    description TEXT,
    theme_id INT,
    FOREIGN KEY (theme_id) REFERENCES theme (id)
);

CREATE TABLE `story`
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL ,
    description TEXT,
    theme_id INT,
    FOREIGN KEY (theme_id) REFERENCES theme (id)
);


INSERT INTO user
(user_name, email, password, role)
VALUES
('admin', 'admin@gmail.com', 'admin', 1);

#inserting into tables
INSERT INTO theme
(name, category, description, image_path)
VALUES
('Skyrim', 'Video Game', 'Lorem ipsum dolor sit amet etc.', '/img/skyrim.jpg'),
('The Hobbit', 'Book', 'Lorem ipsum dolor sit amet etc.', '/img/thehobbit.jpg'),
('Gwent', 'Card Game', 'Lorem ipsum dolor sit amet etc.', '/img/gwent.png'),
('Pictionary', 'Board Game', 'Lorem ipsum dolor sit amet etc.', '/img/pictionary.jpeg');

INSERT INTO story
(name, description, theme_id)
VALUES
('The Great War', 'The Great War as it is now knows begun in 4E 171
                   when the Aldmeri Dominion attacked the Empire
                   lorem ipsum dolor sit amet bla bla...', 1),
('Something something', 'The Great War as it is now knows begun in 4E 171
                   when the Aldmeri Dominion attacked the Empire
                   lorem ipsum dolor sit amet bla bla...', 2),
('This dude', 'The Great War as it is now knows begun in 4E 171
                   when the Aldmeri Dominion attacked the Empire
                   lorem ipsum dolor sit amet bla bla...', 3),
('Reeee', 'The Great War as it is now knows begun in 4E 171
                   when the Aldmeri Dominion attacked the Empire
                   lorem ipsum dolor sit amet bla bla...', 4);