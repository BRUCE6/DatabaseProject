select s.sname
from friend f join student s
where f.sid2 = s.sid and f.sid1 = 1;

delete from notify_friend_request
where answer is null and timestampdiff(month, `time`, NOW()) >= 1;

select s.*
from follow f, student s, company c
where f.sid = s.sid and f.cid = c.cid and c.cname = 'Microsoft'
 and s.university = 'NYU';

select *
from job
where background like '%MS in CS%' and timestampdiff(week, `time`, NOW()) = 1;

insert into notify_job (jid, sid, `time`, status) 
	(select 1, sid, NOW(), 'unview'
    from student
    where GPA > 3.5 and `resume` like '%database systems%');