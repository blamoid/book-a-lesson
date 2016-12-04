CREATE
  TABLE lessons
  (
    lessonId   INTEGER NOT NULL AUTO_INCREMENT ,
    date       DATETIME NOT NULL ,
    timeStart  TIME NOT NULL ,
    timeEnd    TIME NOT NULL ,
    note       TEXT ,
    username   VARCHAR (30) ,
    PRIMARY KEY ( lessonId )
  );

CREATE
  TABLE subjects
  (
    code         VARCHAR (3) NOT NULL ,
    description  VARCHAR (1000) ,
    PRIMARY KEY ( code )
  );

CREATE
  TABLE users
  (
    username        VARCHAR (30) NOT NULL ,
    name            VARCHAR (30) NOT NULL ,
    surname         VARCHAR (30) NOT NULL ,
    email           VARCHAR (30) NOT NULL ,
    password        VARCHAR (255) NOT NULL ,
    phoneNumber     VARCHAR (30) ,
    studentName     VARCHAR (30) ,
    studentSurname  VARCHAR (30) ,
    studentAge      INTEGER ,
    PRIMARY KEY ( username )
  );

CREATE
  TABLE subject_lessons
  (
    lessonId  INTEGER NOT NULL ,
    code      VARCHAR (3) NOT NULL ,
    PRIMARY KEY ( lessonId, code )
  );

CREATE
  TABLE student_subjects
  (
    code      VARCHAR (3) NOT NULL ,
    username  VARCHAR (30) NOT NULL ,
    PRIMARY KEY ( username, code )
  );

ALTER TABLE subject_lessons
ADD CONSTRAINT subject_lessons_FK_1 FOREIGN KEY
(
lessonId
)
REFERENCES lessons
(
lessonId
)
ON
DELETE
  NO ACTION ON
UPDATE NO ACTION;

ALTER TABLE subject_lessons
ADD CONSTRAINT subject_lessons_FK_2 FOREIGN KEY
(
code
)
REFERENCES subjects
(
code
)
ON
DELETE
  NO ACTION ON
UPDATE NO ACTION;

ALTER TABLE student_subjects
ADD CONSTRAINT student_subjects_FK_1 FOREIGN KEY
(
code
)
REFERENCES subjects
(
code
)
ON
DELETE
  NO ACTION ON
UPDATE NO ACTION;

ALTER TABLE student_subjects
ADD CONSTRAINT student_subjects_FK_2 FOREIGN KEY
(
username
)
REFERENCES users
(
username
)
ON
DELETE
  NO ACTION ON
UPDATE NO ACTION;

ALTER TABLE lessons
ADD CONSTRAINT lessons_users_FK FOREIGN KEY
(
username
)
REFERENCES users
(
username
)
ON
DELETE CASCADE ON
UPDATE NO ACTION;
