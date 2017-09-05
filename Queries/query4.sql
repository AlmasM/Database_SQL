#Assume: I am not worried fall/spring order 
# I am calculating number of courses needed to get degree.
# the ordering of fall/spring will be taken care of in the logic 

#Note that in piazza 4/5/17 Professor Joyce Ho said that we can ignore Fall/Spring for queries, and should take care in the logic 


# number of required courses for particular major
select maID, count(corNumb) as reqNumber
from reqCourses
where maID = "bsam"
group by maID;

# number of electives required to take
select sum(numOfElectivesMaj)
from numOfElectivesMajor
where maID = "bsam";

#combining both will be done in the logic part 

#in this case, bsam will be 15 classes 

select *
from course;

#calculate credit hours total for required classes 
select maID, sum(creditNum)
from reqCourses, course
where maID = "bsam" and corNumb = courseNum;


#calculate credit hours total for electives 
#from logic (php) I will first gather number of electives required to take and then calcuate their creditNum
# for example, in BS Applied math we have 2 elective requirements: 2 classes from list-1 and 3 classes from list-2
# in total that makes it 5. So, from php I will get first 2 from list-1 and first 3 from list-2, combine them and get intersection 
#of taken and not taken, and only then calculate credit hours
select courseRangeMaj, nID, creditNum
from majRange, course
where courseNum = courseRangeMaj and majID = "bsam";








