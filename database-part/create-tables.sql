CREATE TABLE users
(
id int NOT NULL AUTO_INCREMENT,
email varchar(255) NOT NULL,
password varchar(255) NOT NULL,
first_name varchar(255) NOT NULL,
last_name varchar(255) NOT NULL,
credit int NOT NULL DEFAULT 0,
vote_up int NOT NULL DEFAULT 0,
vote_down int NOT NULL DEFAULT 0,
PRIMARY KEY (id)
);

CREATE TABLE lectures
(
id int NOT NULL AUTO_INCREMENT,
begin_time bigint NOT NULL,
duration bigint NOT NULL,
teacher_id int NOT NULL,
cost int NOT NULL,
max_users int NOT NULL,
description varchar(255),
PRIMARY KEY (id),
FOREIGN KEY (teacher_id) REFERENCES users(id)
);

CREATE TABLE participations
(
id int NOT NULL AUTO_INCREMENT,
lecture_id int NOT NULL,
student_id int NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (lecture_id) REFERENCES lectures(id),
FOREIGN KEY (student_id) REFERENCES users(id)
);


CREATE TABLE problems
(
id int NOT NULL AUTO_INCREMENT,
poster_id int NOT NULL,
cost int NOT NULL,
begin_time bigint NOT NULL,
duration bigint NOT NULL,
description varchar(255),
solver_id int DEFAULT -1,
PRIMARY KEY (id),
FOREIGN KEY (poster_id) REFERENCES users(id),
FOREIGN KEY (solver_id) REFERENCES users(id)
);

CREATE TABLE solvers
(
id int NOT NULL AUTO_INCREMENT,
solver_id int NOT NULL,
problem_id int NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (solver_id) REFERENCES users(id),
FOREIGN KEY (problem_id) REFERENCES problems(id)
);