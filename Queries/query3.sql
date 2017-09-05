-- use courseSuggest;

-- #query returns all the core classes needed to satisfy for BS.Applied Math
-- select majorID, corNumb
-- from degree, reqCourses 
-- where maID = majorID
-- and majorID = "bsam";

-- # same query as above, but without join
-- select *
-- from reqCourses
-- where maID = "bsam";


-- # assume, student has taken CS 170, MATH 112, and MATH 111. Find how many required classes he/she needs to take 
-- # and she wants to do BS Applied Math

-- create view taken as (select corNumb as cN, maID
-- 	from reqCourses
-- 	where maID = "bsam" 
-- 	limit 3);
    
-- select *
-- from reqCourses
-- where maID = "bsam" and corNumb not in 
-- 	(select cN
-- 	 from taken
-- 	);
    

--  ####   
-- select *
-- from degree
-- where majorID = "bam";

-- select *
-- from reqCourses
-- where corNumb = "CS 170";



-- #### Electives 


-- # the query will return how many (# - number) electives have to taken and the the type of elective
-- # for example, in BS. Applied math, there are 2 types of electives (nID) that need to be satisfied
-- select nID, numOfElectivesMaj
-- from numOfElectivesMajor
-- where maID = "bsam";

-- # the query will return all the courses needed to take and the type of the elective (nID)
-- select nID, courseRangeMaj
-- from majRange
-- where majID = "bsam";


-- #### parameter passing for limit
-- Set @skip = 7;
-- prepare stmt from 'select * from course limit ?';
-- execute stmt using @skip;

drop table if exists electedCourses;
create table electedCourses as select nID
from majRange
where majID = "bsam"; 

DROP procedure IF EXISTS elecPick;

Delimiter $$
create procedure elecPick()
begin

declare n int default 0;
declare i int default 0;

select count(*) from numOfElectivesMajor into n;
	
    while i < n DO
		insert into electedCourses(nID) values (i);
		
		set i = i +1;
    end while;
end; $$
delimiter $


select *
from electedCourses;

