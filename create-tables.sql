create database courseSuggest;

use courseSuggest;

create table course
(
courseNum char(10) not null,
title varchar(255) not null,
creditNum int not null,
constraint coursePK Primary Key(courseNum)
);

create table preQ
(
coursNum char(10) not null,
preReq char(10),
constraint preQ_PK Primary Key (coursNum, preReq),
constraint preQ_FK foreign key (coursNum) references course(courseNum)
);

create table offered
(
courseNum char(10) not null,
offeredCourse char(10) not null,
constraint offeredPK primary key(courseNum, offeredCourse),
constraint offeredFK foreign key (courseNum) references course(courseNum)
);

create table degree
(
majorID char(10) not null,
majorName char(255) not null,
constraint degreePK primary key (majorID)
);

create table reqCourses
(
corNumb char(10) not null,
maID char(10) not null,
constraint reqCoursesPK primary key (corNumb, maID),
#constraint reqCourseIDFK foreign key (maID) references degree(majorID),
constraint reqCoursesNumFK foreign key (corNumb) references course(courseNum)
);

create table majRange
(
majID char(10) not null,
courseRangeMaj char(10) not null,
nID int not null,
constraint elecMajorPK primary key (majID, courseRangeMaj, nID),
constraint elecMajorFKMajor foreign key (majID) references degree(majorID)
);

create table numOfElectivesMajor
(
maID char(10) not null,
numOfElectivesMaj char(15) not null,
nID int not null,
constraint elecNumPK primary key (maID, nID),
constraint elecNumFK foreign key (maID) references degree(majorID)
);

create table minor
(
minorID char(10) not null,
minorName varchar(255),
majorMID char(10) not null,
constraint minorPK primary key (minorID, majorMID)
#constraint midMFK foreign key (majorMID) references degree(majorID)
);

create table minorReq
(
minoID char(10) not null,
corNum char(10) not null,
constraint minorReqPK primary key (minoID, corNum),
constraint minorReqFK foreign key (minoID) references minor(minorID),
constraint minorReqCorFK foreign key (corNum) references course(courseNum)
);

create table minRange
(
minID char(10) not null,
courseRangeMin char(10) not null,
mNID int not null,
constraint minRangePK primary key (minID, mNID, courseRangeMin),
constraint minRangeFK foreign key (minID) references minor(minorID)
);

create table numofElectivesMinor
(
minID char(10) not null,
numOfElectivesMin char(10) not null,
mNID int not null,
constraint minElecNumPK primary key (minID, mNID),
constraint minElecNumFK foreign key (minID) references minor(minorID)
);


