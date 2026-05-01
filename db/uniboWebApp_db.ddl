create database UniboWebApp;
use UniboWebApp;

-- Tables Section
-- _____________ 

create table ACCOUNTS (
     Email varchar(256) not null,
     Password varchar(30) not null,
     PermissionType varchar(30) not null,
     constraint IDACCOUNT primary key (Email),
     constraint PSW_LENGTH check (length(Password) >= 8),
     constraint PERMISSION_CHECK check (PermissionType in ('Admin', 'Studente')));

create table ADMINS (
     Name varchar(256) not null,
     Surname varchar(256) not null,
     AdminID int unsigned not null auto_increment,
     Email varchar(256) not null,
     constraint IDADMIN primary key (AdminID),
     constraint FKaccount_admin_ID unique (Email));

create table BATHROOMS (
     BathroomID varchar(10) not null,
     constraint IDBATHROOM primary key (BathroomID));

create table BIKE_PARKINGS (
     Floor tinyint unsigned not null,
     constraint IDBIKE_PARKING primary key (Floor));

create table CORRIDORS (
     Floor tinyint unsigned not null,
     Block char(1) not null,
     constraint IDCORRIDOR primary key (Floor, Block));

create table COURSES (
     CourseID char(5) not null,
     Name varchar(256) not null,
     CFU tinyint unsigned not null,
     ResourcesURL varchar(500) not null,
     ExamMethod varchar(5000) not null,
     TeachingMaterial varchar(5000) not null,
     Semester tinyint unsigned not null,
     constraint SEMESTER_CHECK check (Semester in (1, 2)),
     constraint IDCOURSE_ID primary key (CourseID));

create table COURSE_MODULES (
     CourseID char(5) not null,
     Module tinyint unsigned not null,
     Professor varchar(256) not null,
     constraint IDCOURSE_MODULE primary key (CourseID, Module));

create table DEGREE_COURSES (
     DegreeCourseID int unsigned not null,
     Name varchar(256) not null,
     Type varchar(256) not null, -- "Laurea triennale", "Laurea magistrale", "Laurea a ciclo unico"...
     constraint IDDEGREE_COURSE primary key (DegreeCourseID));

create table EVENTS (
     EventID int auto_increment not null,
     Category varchar(50) not null, -- value of "Categoria" filter. Its values can be: "Sconti", "Conferenze", "Eventi esterni", ...
     Type varchar(100) not null,
     Title varchar(256) not null,
     Description varchar(500),
     Place varchar(256),
     StartDate date,
     EndDate date,
     StartTime time,
     EndTime time,
     constraint EVENTS_TYPE_CHECK check (Type in ('A scadenza', 'A periodo', 'Programmato')),
     constraint EXPIRING_EVENT_CHECK check (Type <> 'A scadenza' or (Type = 'A scadenza' and (StartDate is null and EndDate is not null and
                                                                                              StartTime is null and EndTime is null))),
     constraint PERIOD_EVENT_CHECK check (Type <> 'A periodo' or (Type = 'A periodo' and (StartDate is not null and EndDate is not null and
																						  StartTime is null and EndTime is null))),
     constraint SCHEDULED_EVENT_CHECK check (Type <> 'Programmato' or (Type = 'Programmato' and (StartDate is not null and EndDate is null and
                                                                                                 StartTime is not null and EndTime is not null))),
     constraint IDEVENT primary key (EventID));

create table JOB_POSTS (
     JobPostID int auto_increment not null,
     Title varchar(256) not null,
     InsertionDate date not null,
     Author varchar(256) not null,
     Description varchar(500) not null,
     WorkingTime varchar(500) not null,
     EnterpriseAddress varchar(256) not null,
     HourlySalary decimal(4,2) not null,
     ContractType varchar(256) not null, -- "Part-time", "Full-time", ...
     AuthorPhoneNumber varchar(20) not null,
     AuthorEmail varchar(256) not null,
     DegreeCourseID int unsigned,
     constraint IDJOB_POST primary key (JobPostID));

create table LESSONS (
     CourseID char(5) not null,
     Date date not null,
     StartTime time not null,
     EndTime time not null,
     TeachingPlaceID varchar(10) not null,
     constraint IDLESSON primary key (CourseID, Date, StartTime));

create table PONIES (
     PonyID int auto_increment not null,
     Name varchar(256) not null,
     Breed varchar(256) not null,
     HourlyFee decimal(4,2) not null,
     Image varchar(256) not null,
     SpecMarks varchar(20),
     Description varchar(100),
     constraint IDPONY primary key (PonyID));

create table PROFESSORS (
     Name varchar(256) not null,
     Surname varchar(256) not null,
     Email varchar(256) not null,
     WebsiteAddress varchar(500) not null,
     constraint IDPROFESSOR primary key (Email));

create table RESERVATIONS (
     PonyID int not null,
     Date date not null,
     StartHour time not null,
     EndHour time not null,
     StudentID char(10) not null,
     constraint IDRESERVATION primary key (PonyID, Date, StartHour));

create table SIGNALS (
     SignalID int auto_increment not null,
     CreationDate date not null,
     State varchar(256) not null,
     Description varchar(200) not null,
     Type varchar(50) not null, -- "Servizi igienici", "Pulizia", ... like on mockups
     StudentID char(10) not null,
     TeachingPlaceID varchar(10),
     BathroomID varchar(10),
     CorridorFloor tinyint unsigned,
     CorridorBlock char(1),
     BikeParkingFloor tinyint unsigned,
     constraint STATE_CHECK check (State in ('Non risolto', 'Presa in carico', 'Risolto')),
     constraint IDSIGNAL primary key (SignalID));

create table STUDENTS (
     Name varchar(256) not null,
     Surname varchar(256) not null,
     IdNumber char(10) not null,
     Email varchar(256) not null,
     DegreeCourseID int unsigned not null,
     constraint IDSTUDENT primary key (IdNumber),
     constraint FKaccount_student_ID unique (Email));

create table STUDY_PLANS (
     CourseID char(5) not null,
     DegreeCourseID int unsigned not null,
     Year int unsigned not null, -- the year in which the course is taught in the degree course: for example, its value can be "1", "2" or "3" for degree courses whose type is "Laurea triennale"
     constraint IDstudy_plans primary key (CourseID, DegreeCourseID));

create table TEACHING_PLACES (
     Type varchar(50) not null,
     TeachingPlaceID varchar(10) not null,
     constraint TEACHING_PLACES_TYPE_CHECK check (Type in ('AULA', 'LAB.')),
     constraint IDTEACHING_PLACE primary key (TeachingPlaceID));


-- Constraints Section
-- ___________________ 

alter table ADMINS add constraint FKaccount_admin_FK
     foreign key (Email)
     references ACCOUNTS (Email);

alter table COURSE_MODULES add constraint FKteaches
     foreign key (Professor)
     references PROFESSORS (Email);

alter table COURSE_MODULES add constraint FKdivided_into
     foreign key (CourseID)
     references COURSES (CourseID);

alter table JOB_POSTS add constraint FKrelated_to
     foreign key (DegreeCourseID)
     references DEGREE_COURSES (DegreeCourseID);

alter table LESSONS add constraint FKlesson_course
     foreign key (CourseID)
     references COURSES (CourseID);

alter table LESSONS add constraint FKlesson_teaching_place
     foreign key (TeachingPlaceID)
     references TEACHING_PLACES (TeachingPlaceID);

alter table RESERVATIONS add constraint FKstudent_reservation
     foreign key (StudentID)
     references STUDENTS (IdNumber);

alter table RESERVATIONS add constraint FKpony_reservation
     foreign key (PonyID)
     references PONIES (PonyID);

alter table SIGNALS add constraint FKreports
     foreign key (StudentID)
     references STUDENTS (IdNumber);

alter table SIGNALS add constraint FKsignal_teaching_place
     foreign key (TeachingPlaceID)
     references TEACHING_PLACES (TeachingPlaceID);

alter table SIGNALS add constraint FKsignal_bathroom
     foreign key (BathroomID)
     references BATHROOMS (BathroomID);

alter table SIGNALS add constraint FKsignal_corridor_FK
     foreign key (CorridorFloor, CorridorBlock)
     references CORRIDORS (Floor, Block);

alter table SIGNALS add constraint FKsignal_corridor_CHK
     check ((CorridorFloor is not null and CorridorBlock is not null)
           or (CorridorFloor is null and CorridorBlock is null)); 

alter table SIGNALS add constraint FKsignal_bike_parking
     foreign key (BikeParkingFloor)
     references BIKE_PARKINGS (Floor);

alter table STUDENTS add constraint FKaccount_student_FK
     foreign key (Email)
     references ACCOUNTS (Email);

alter table STUDENTS add constraint FKenrollment
     foreign key (DegreeCourseID)
     references DEGREE_COURSES (DegreeCourseID);

alter table STUDY_PLANS add constraint FKtau_DEG
     foreign key (DegreeCourseID)
     references DEGREE_COURSES (DegreeCourseID);

alter table STUDY_PLANS add constraint FKtau_COU
     foreign key (CourseID)
     references COURSES (CourseID);
