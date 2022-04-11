/* main database is tutorme*/

create database tutorme;
use tutorme;

/* setting sql mode, transaction mode*/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` ( `id` int NOT NULL,
`fullname` varchar(20) NOT NULL,
email varchar(20) NOT NULL,
password varchar(20) NOT NULL,
primary key(id))ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `admin` values 
(1,'Ravi Kumar','ravikumnar@gmail.com', 'aqwtja@11dethlang'),
(2, 'Suresh Kamble','Suresh@gmail.com','3456@e45623433te6'),
(3, 'Radha Patel', 'radha@gmail.com','2345562rre9$$495730');

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(150) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL DEFAULT '',
  `pass` varchar(50) NOT NULL,
  `confirmcode` varchar(7) NOT NULL,
  `activation` varchar(3) NOT NULL DEFAULT '',
  `type` varchar(10) NOT NULL,
  `user_pic` text,
  `last_logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `online` varchar(5) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `user` (`id`, `fullname`, `gender`, `email`, `phone`, `address`, `pass`, `confirmcode`, `activation`, `type`, `user_pic`, `last_logout`, `online`) VALUES
(1, 'Marco Polo', 'male', 'marco@gmail.com', '015976432566', 'India', 'e10adc3949ba59abbe56e057f20f883e', '205575', '', 'student', '1543554432.png', '2021-11-30 06:11:19', 'no'),
(2, 'Percy Jackson', 'male', 'percy@gmail.com', '014976432566', 'India', '8d788385431273d11e8b43bb78f3aa41', '901358', '', 'teacher', '1515505450.jpg', '2022-01-30 05:35:16', 'yes'),
(5, 'Alyssa Mckara', 'female', 'alyssa@gmail.com', '014976432566', 'India', '8d788385431273d11e8b43bb78f3aa41', '495196', '', 'teacher', '','2022-02-03 08:45:02', 'no'),
(6, 'Harry Carter', 'male', 'harry@gmail.com', '014976432566', 'India', '8d788385431273d11e8b43bb78f3aa41', '292470', '', 'teacher', '1515558340.jpeg', '2022-03-04 02:39:17', 'no'),
(9, 'Cassandra Collin', 'female', 'cassy@gmail.com', '01899761551', 'India', 'e10adc3949ba59abbe56e057f20f883e', '214114', '', 'teacher', '1543568429.jpg', '2021-12-30 09:00:29', 'yes'),
(10, 'Robin Hood', 'male', 'robins@gmail.com', '01788651991', 'India', 'e10adc3949ba59abbe56e057f20f883e', '946363', '', 'student', '1543568644.png', '2022-03-21 09:13:40', 'no');

DROP TABLE IF EXISTS `tutor`;
CREATE TABLE IF NOT EXISTS `tutor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `t_id` int NOT NULL,
  `inst_name` varchar(150) NOT NULL,
  `prefer_sub` text NOT NULL,
  `class` text NOT NULL,
  `prefer_location` text NOT NULL,
  `salary` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT fk_tutor_user_t_id foreign key(t_id) references `user`(id)
)ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `tutor` (`id`, `t_id`, `inst_name`, `prefer_sub`, `class`, `prefer_location`, `salary`) VALUES
(5, 2, 'Southeast University', 'Math,ICT,Computer Science', 'One-Three,Nine-Ten,Eleven-Twelve,College/University', 'India', '1000-2000'),
(11, 6, 'Southeast University', 'English,ICT,Physics,Sociology,Economics,Civics,Computer Science', 'Six-Seven,Nine-Ten,Eleven-Twelve', 'India', '2000-5000'),
(15, 5, 'Southeast University', 'Math,General Science,ICT,Physics,Higher Math,Computer Science', 'Nine-Ten,Eleven-Twelve,College/University', 'India', '1000-2000'),
(17, 9, 'Southeast University', 'ICT,Physics,Higher Math,Computer Science', 'Nine-Ten,Eleven-Twelve,College/University', 'India', '5000-10000');

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `postby_id` int NOT NULL,
  `subject` text NOT NULL,
  `class` text NOT NULL,
  `medium` varchar(20) NOT NULL,
  `salary` varchar(50) NOT NULL,
  `location` text NOT NULL,
  `p_university` text NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deadline` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT fk_post_user_postby_id foreign key(postby_id) references `user`(id)
)ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `post` (`id`, `postby_id`, `subject`, `class`, `medium`, `salary`, `location`, `p_university`, `post_time`, `deadline`) VALUES
(2, 1, 'ICT,Computer Science', 'College/University', 'English', 'None', 'India', 'Southeast University', '2021-01-09 11:11:44', '01/05/2022'),
(3, 1, 'English,ICT,Physics,Higher Math,Statistics', 'Eleven-Twelve,College/University', 'English', '10000-15000', 'India', 'Southeast University', '2021-01-09 17:36:07', '01/07/2022'),
(4, 1, 'ICT,Computer Science', 'Six-Seven,Eleven-Twelve', 'English', '2000-5000', 'India', 'Southeast University', '2018-01-10 04:28:42', '01/17/2022'),
(5, 1, 'Science', 'One-Three', 'English', '1000-2000', 'India', 'Southeast University', '2018-01-11 05:17:25', '01/19/2022'),
(6, 1, 'EVS', 'One-Three', 'English', '5000','India','Oxford', '2018-01-10 05:24:41', '02/14/2018'),
(7, 1, 'English', 'One-Three', 'English', '10000-15000', 'India', 'Southeast University', '2018-06-28 10:23:31', '06/30/2022'),
(8, 1, 'Statistics', 'Eleven-Twelve,College/University', 'English', '2000-5000', 'India', 'Southeast Univesity', '2021-11-30 05:03:02', '12/19/2022');

DROP TABLE IF EXISTS `applied_post`;
CREATE TABLE IF NOT EXISTS `applied_post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `post_by` int NOT NULL,
  `applied_by` int NOT NULL,
  `applied_to` int NOT NULL,
  `applied_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `student_ck` varchar(3) NOT NULL DEFAULT 'no',
  `tutor_ck` varchar(3) NOT NULL DEFAULT 'no',
  `tutor_cf` tinyint NOT NULL DEFAULT '0',
  `tution_cf` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  CONSTRAINT fk_applied_post_user_post_by foreign key(post_by) references `user`(id),
  CONSTRAINT fk_applied_post_tutor_applied_by foreign key(applied_by) references `tutor`(id),
  CONSTRAINT fk_applied_post_post_post_id foreign key(post_id) references `post`(id)
)ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `applied_post` (`id`, `post_id`, `post_by`, `applied_by`, `applied_to`, `applied_time`, `student_ck`, `tutor_ck`, `tutor_cf`, `tution_cf`) VALUES
(13, 2, 1, 5, 1, '2022-01-30 08:26:35', 'yes', 'yes', 0, 0),
(14, 3, 10, 11, 10, '2022-01-30 09:05:48', 'yes', 'yes', 0, 1);

DROP TABLE IF EXISTS `publicuser`;
CREATE TABLE `publicuser` (`id` int NOT NULL AUTO_INCREMENT,
hits int,
primary key(id))ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO publicuser VALUES
(101,1),
(234,5),
(351,7),
(456,8),
(623,11);

CREATE TABLE schedule (`id` int NOT NULL AUTO_INCREMENT,
scheduled_by int,
attended_by int, 
class varchar(20),
`date_time` datetime,
primary key(id),
CONSTRAINT fk_schedule_tutor_scheduled_by foreign key(scheduled_by) references tutor(id),
CONSTRAINT fk_schedule_user_attended_by foreign key(attended_by) references user(id));

INSERT INTO schedule VALUES 
(1, 5, 1, 'Nine,ten','2022-04-01 10:25:00'),
(5,11,10,'College','2022-04-13 08:55:00'),
(7,15,10,'Eleven,twelve','2022-04-17 14:30:00'),
(8,17,1,'College','2022-04-21 16:30:00');

COMMIT;