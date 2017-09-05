
#required courses for particular major
select mD, reqNumber+numElec as totalClassNum
from
		(select maID as mD, count(corNumb) as reqNumber
		from reqCourses
		where maID = "bsam"
		group by maID) reqClass, 
		# number of electives required to take
		(select maID, sum(numOfElectivesMaj) as numElec
		from numOfElectivesMajor
		where maID = "bsam") elecClass
where mD = maID;

#logic will handle operation such as : (reqNumber + numElec)/4 = x


#Using logic, I will get user input of graduation year
# using current year, I will calculate how many semesters are there between graduation year and 
# current year (i.e. 3 semesters or 4, etc). Then, using x, I will calculate if person can graduate on time.


#Suppsing 5 required classes have been taken already
create view takenReq as (select corNumb as cN, maID
	from reqCourses
	where maID = "bsam" 
	limit 5);
    

select *
from reqCourses
where maID = "bsam" and corNumb not in 
	(select cN
	 from takenReq
	);



