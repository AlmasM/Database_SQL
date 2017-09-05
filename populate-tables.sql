use courseSuggest;

LOAD DATA LOCAL INFILE 'courses.csv' 
INTO TABLE course FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r';

select *
from course;

LOAD DATA LOCAL INFILE 'preQ.csv' 
INTO TABLE preQ FIELDS TERMINATED BY ',';

select *
from preQ;

LOAD DATA LOCAL INFILE 'offered.csv' 
INTO TABLE offered FIELDS TERMINATED BY ',';

select *
from offered;

LOAD DATA LOCAL INFILE 'degree.csv' 
INTO TABLE degree FIELDS TERMINATED BY ',';

select *
from degree;


LOAD DATA LOCAL INFILE 'rqCourses.csv' 
INTO TABLE reqCourses FIELDS TERMINATED BY ',';


select *
from reqCourses;


LOAD DATA LOCAL INFILE 'majRange.csv' 
INTO TABLE majRange FIELDS TERMINATED BY ',';

select *
from majRange;


LOAD DATA LOCAL INFILE 'numOfElectivesMajor.csv' 
INTO TABLE numOfElectivesMajor FIELDS TERMINATED BY ',';

select *
from numOfElectivesMajor;


LOAD DATA LOCAL INFILE 'minor.csv' 
INTO TABLE minor FIELDS TERMINATED BY ',';

select *
from minor;

LOAD DATA LOCAL INFILE 'minorReq.csv' 
INTO TABLE minorReq FIELDS TERMINATED BY ',';

select * 
from minorReq;

LOAD DATA LOCAL INFILE 'minRange.csv' 
INTO TABLE minRange FIELDS TERMINATED BY ',';

select * 
from minRange;

LOAD DATA LOCAL INFILE 'numofElectivesMinor.csv' 
INTO TABLE numofElectivesMinor FIELDS TERMINATED BY ',';

select *
from numofElectivesMinor;