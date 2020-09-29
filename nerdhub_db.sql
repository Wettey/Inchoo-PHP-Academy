DROP DATABASE IF EXISTS nerdhub_db;
CREATE DATABASE nerdhub_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nerdhub_db;

CREATE TABLE `user`
(
    id int not null primary key auto_increment,
    user_name varchar(255) not null,
    email varchar(255) not null,
    password char(60) not null,
    role tinyint not null,
    date_joined datetime not null
);

CREATE TABLE `theme`
(
    id int not null primary key auto_increment,
    name varchar(255) not null,
    category varchar(255),
    description text,
    image_path varchar(255)
);

CREATE TABLE `user_theme`
(
    user int,
    theme int,
    foreign key (user) references user (id),
    foreign key (theme) references theme (id)
);

CREATE TABLE `character`
(
    id int not null primary key auto_increment,
    name varchar(255) not null,
    type varchar(255) not null,
    description text
);

CREATE TABLE `event`
(
    id int not null primary key auto_increment,
    name varchar(255) not null,
    description text
);


#inserts
INSERT INTO theme
(name, category, description, image_path)
VALUES
('Skyrim', 'Video Game', 'Lorem ipsum dolor sit amet etc.', '/img/skyrim.jpg'),
('The Hobbit', 'Book', 'Lorem ipsum dolor sit amet etc.', '/img/thehobbit.jpg'),
('Gwent', 'Card Game', 'Lorem ipsum dolor sit amet etc.', '/img/gwent.png'),
('Pictionary', 'Board Game', 'Lorem ipsum dolor sit amet etc.', '/img/pictionary.jpg');