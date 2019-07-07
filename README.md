# Laravel + VueJS Job Application Task (Studydrive GmbH)



1. Create MySQL database tables:

`
create schema studydrive collate utf8mb4_general_ci;

create table photos
(
	id INT(10) auto_increment
		primary key,
	title VARCHAR(100) not null,
	url VARCHAR(255) null,
	created_at DATETIME(19) not null
);

create table photos_likes
(
	id INT(10) auto_increment
		primary key,
	photo_id INT(10) not null,
	user_id INT(10) not null,
	created_at DATETIME(19) not null
);

create table users
(
	id INT(10) auto_increment
		primary key,
	name VARCHAR(255) not null,
	password VARCHAR(255) null,
	email VARCHAR(255) null,
	created_at DATETIME(19) not null,
	updated_at DATETIME(19) null,
	remember_token VARCHAR(255) null
);
`

2. Compile:
`npm run dev`
