SET default_storage_engine=INNODB;
drop schema if exists Jobster;
create schema Jobster;
use Jobster;
drop table if exists student;
create table student(
	sid int not null auto_increment,
    sname varchar(100) not null,
    login_name varchar(100) not null unique,
    `password` varchar(100) not null,
    university varchar(100),
    major varchar(20),
    GPA float,
    `resume` varchar(1000),
    keywords varchar(500),
    primary key (sid)
);

drop table if exists company;
create table company(
	cid int not null auto_increment,
    cname varchar(100) not null unique,
    `password` varchar(100) not null,
    location varchar(500),
    industry varchar(50),
    primary key (cid)
);

drop table if exists job;
create table job(
	jid int not null auto_increment,
    cid int not null,
    `time` datetime,
    location varchar(500),
    title varchar(100),
    salary varchar(100),
    background varchar(100),
    description varchar(1000),
    primary key (jid),
    foreign key (cid) references company (cid)
);

drop table if exists follow;
create table follow(
	sid int not null,
    cid int not null,
    `time` datetime,
    primary key (sid, cid),
    foreign key (sid) references student (sid),
    foreign key (cid) references company (cid)
);

drop table if exists friend;
create table friend(
	sid1 int not null, 
    sid2 int not null,
    `time` datetime,
    primary key (sid1, sid2),
    foreign key (sid1) references student (sid),
    foreign key (sid2) references student (sid)
);

drop table if exists message;
create table message(
	from_sid int not null,
    to_sid int not null,
	`time` datetime not null,
    content varchar(500),
    primary key (from_sid, to_sid, `time`),
    foreign key (from_sid) references student (sid),
    foreign key (to_sid) references student (sid)
);

drop table if exists apply;
create table apply(
	sid int not null,
    jid int not null,
    `time` datetime,
    result enum('Under view', 'Interviewing', 'Failure', 'Success'),
    primary key (sid, jid),
    foreign key (sid) references student (sid),
    foreign key (jid) references job (jid)
);

drop table if exists notify_friend_request;
create table notify_friend_request(
	from_sid int not null,
    to_sid int not null,
	`time` datetime not null,
    answer enum('yes', 'no'),
    `receive_status` enum('view', 'unview'),
    `answer_status` enum('view', 'unview'),
    primary key (from_sid, to_sid, `time`),
    foreign key (from_sid) references student (sid),
    foreign key (to_sid) references student (sid)
);


drop table if exists notify_apply;
create table notify_apply(
	sid int not null,
    jid int not null,
	`time` datetime,
    cid int not null,
    `status` enum('view', 'unview'),
    primary key (sid, jid, `time`),
    foreign key (sid, jid) references apply (sid, jid),
    foreign key (cid) references company (cid)
);

drop table if exists notify_job;
create table notify_job(
	jid int not null,
    sid int not null,
	`time` datetime,
    status enum('view', 'unview'),
    primary key (jid, sid, `time`),
    foreign key (jid) references job (jid),
    foreign key (sid) references student (sid)
);

drop procedure if exists add_friend;
create procedure add_friend (sid1 int, sid2 int)
insert into friend (sid1, sid2, `time`) values (sid1, sid2, NOW()), (sid2, sid1, NOW());

drop procedure if exists delete_friend;
create procedure delete_friend (s1 int, s2 int)
delete from friend where (sid1 = s1 and sid2 = s2) or (sid1 = s2 and sid2 = s1);

drop procedure if exists request_friend;
create procedure request_friend (from_id int, to_id int)
insert into notify_friend_request (from_sid, to_sid, `time`, receive_status, answer_status) values (from_id, to_id, NOW(),'unview', 'view');

drop procedure if exists answer_friend;
delimiter //
create procedure answer_friend (from_id int, to_id int, t datetime, answer enum('yes', 'no'))
begin
	update notify_friend_request
	set receive_status = 'view', answer_status = 'unview', answer = answer
	where from_sid = from_id and to_sid = to_id and `time` = t;
	if answer = 'yes' then
		call add_friend (from_id, to_id);
	end if;
end//
delimiter ;

drop procedure if exists follow_company;
create procedure follow_company(sid int, cid int)
insert into follow (sid, cid, `time`) values (sid, cid, NOW());

drop procedure if exists unfollow_company;
create procedure unfollow_company(s int, c int)
delete from follow where sid = s and cid = c;

drop procedure if exists post_job;
delimiter //
create procedure post_job(cid int, location varchar(500), title varchar(500), salary varchar(100), background varchar(100), description varchar(1000))
begin
	insert into job (cid, `time`, location, title, salary, background, description) values (cid, NOW(), location, title, salary, background, description);
	insert into notify_job (jid, `time`, `status`, sid) select * from ((select LAST_INSERT_ID(), NOW(), 'unview') t1 JOIN (select sid from follow where follow.cid = cid) t2);
end//
delimiter ;

drop procedure if exists apply_job;
delimiter //
create procedure apply_job(s int, j int, c int)
begin
	insert into apply values (s, j, NOW(), 'Under view');
	insert into notify_apply values (s, j, NOW(), c, 'unview');
end//
delimiter ;