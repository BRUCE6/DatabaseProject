use jobster;

insert into student (sname, login_name, `password`, university, GPA, `resume`) values ('Bruce', 'Bruce01', 'abc135', 'NYU', 4.0, 'database systems');
insert into student (sname, login_name, `password`, university, GPA, `resume`) values ('Nancy', 'Nancy01', '12345', 'NYU', 3.7, 'database systems');
insert into student (sname, login_name, `password`, university, GPA, `resume`) values ('Bruce', 'Bruce02', '123', 'Cornell', 3.7, 'database systems');
insert into student (sname, login_name, `password`, university, GPA, `resume`) values ('Rogan', 'Rogan01', '345', 'NYU', 3.3, 'database systems');
insert into student (sname, login_name, `password`, university, GPA) values ('Amy', 'Amy01', 'abc', 'NYU', 3.7);

delete from company;
insert into company (cname, `password`, location, industry) values ('Microsoft', 'mmm', 'New York', 'IT');
insert into company (cname, `password`, location, industry) values ('Uber', 'uuu', 'New York', 'Transportation');
insert into company (cname, `password`, location, industry) values ('Facebook', 'fff', 'Seattle', 'IT');
insert into company (cname, `password`, location, industry) values ('TwoSigma', 'ttt', 'New York', 'Finance');
insert into company (cname, `password`, location, industry) values ('Citibank', 'ccc', 'USA', 'Banking');

insert into job (cid, title, background, `time`) values (1, 'Software Engineer', 'MS in CS', NOW());
insert into job (cid, title, background, `time`) values (1, 'Machine Learning Engineer', 'MS in CS', date_add(NOW(), interval -1 week));
insert into job (cid, title, background, `time`) values (4, 'Data analyst', 'MS in Math', date_add(NOW(), interval -1 week));
insert into job (cid, title, background, `time`) values (3, 'Software Engineer', 'MS in CS', date_add(NOW(), interval -1 week));

call request_friend (1, 2);
call request_friend (1, 3);
call request_friend (1, 4);
call request_friend (2, 3);
call request_friend (2, 4);

call answer_friend (1, 2, (select `time` from notify_friend_request where from_sid = 1 and to_sid = 2), 'yes');
call answer_friend (1, 3, (select `time` from notify_friend_request where from_sid = 1 and to_sid = 3), 'yes');
call answer_friend (1, 4, (select `time` from notify_friend_request where from_sid = 1 and to_sid = 4), 'yes');
call answer_friend (2, 4, (select `time` from notify_friend_request where from_sid = 2 and to_sid = 4), 'no');

call follow_company (1, 1);
call follow_company (1, 2);
call follow_company (2, 1);
call follow_company (3, 1);