-- Create Database MajorProject;

CREATE TABLE SecurityQuestions 
(
    QuestionId int AUTO_INCREMENT,
    Question varchar(250),
    PRIMARY KEY (QuestionId)
);


CREATE TABLE ContactUsLog
(
	ContactId int AUTO_INCREMENT,
	FullName varchar (150),
	EmailAddress varchar (100),
	EmailSubject varchar (100),
	EmailBody varchar (500),
	SendDate datetime, 
	PRIMARY KEY (ContactId)
);

ALTER TABLE SecurityQuestions
AUTO_INCREMENT   101;

CREATE TABLE Parishes 
(
    ParishId int AUTO_INCREMENT,
    Parish varchar(25),
    PRIMARY KEY (Parishid),
    UNIQUE (Parish)
);

CREATE TABLE Admins 
(
    AdminId varchar(13),
    UserName varchar(15),
    hashedpassword varchar(256),
    QuestionId int,
    hashedSecurityAns varchar(256),
    Email varchar(50),
    PRIMARY KEY (AdminId),
    Unique (UserName , Email),
    FOREIGN KEY (QuestionId) REFERENCES SecurityQuestions (QuestionId)
);


CREATE TABLE AdminLogs 
(
    AdminId varchar(13),
    Email varchar(25),
    hashpassword varchar(256),
    Used varchar(3),
    DateCreated datetime,
    PRIMARY KEY (Email),
    FOREIGN KEY (AdminId)
        REFERENCES Admins (AdminId)
);

CREATE TABLE Administrators 
(
    AdminId varchar(13),
    FirstName varchar(25),
    LastName varchar(25),
    Gender varchar(6),
    DOB datetime,
    PRIMARY KEY (AdminId),
    FOREIGN KEY (AdminId)
        REFERENCES Admins (AdminId)
);

CREATE TABLE AdminContacts 
(
    AdminId varchar(13),
    AddressLine1 varchar(50),
    AddressLine2 varchar(50),
    Town varchar(50),
    ParishId int,
    ContactNumber varchar(11),
    PRIMARY KEY (AdminId),
    FOREIGN KEY (AdminId)
        REFERENCES Admins (AdminId),
    FOREIGN KEY (ParishId)
        REFERENCES Parishes (ParishId)
);

CREATE TABLE PoliticalParties 
(
    PartyId int AUTO_INCREMENT,
    PartyName varchar(10),
    PRIMARY KEY (PartyId)
);

CREATE TABLE Titles
(
	TitleId int AUTO_INCREMENT,
	Title varchar (10),
	PRIMARY KEY (TitleId)
);

CREATE TABLE Roles
(
	RoleId int AUTO_INCREMENT,
	Role varchar(30),
	PRIMARY KEY (RoleId)
);




CREATE TABLE Politicians 
(
    PoliticianId varchar(13),
    TitleId int,
    FirstName varchar(25),
    LastName varchar(25),
    Gender varchar(6),
    DOB datetime,
    RoleId int,
    Minister varchar(3),
    PartyId int,
    ImageLocation varchar(150),
    PRIMARY KEY (PoliticianId),
    FOREIGN KEY (PartyId) REFERENCES PoliticalParties (PartyId),
    FOREIGN KEY (TitleId) REFERENCES Titles (TitleId),
	FOREIGN KEY (RoleId) REFERENCES Roles (RoleId)
);

CREATE TABLE PoliticianCDF
(
	PoliticianId varchar (13),
	OpenSpendingLink varchar (1000),
	SpendingDate datetime,
	PRIMARY KEY (PoliticianId,SpendingDate),
	FOREIGN KEY (PoliticianId) REFERENCES Politicians (PoliticianId)
);
 
CREATE TABLE Portfolios 
(
    PortfolioId int AUTO_INCREMENT,
    Portfolio varchar(100),
    PRIMARY KEY (PortfolioId)
);

ALTER TABLE Portfolios
AUTO_INCREMENT   1001;

CREATE TABLE Ministers 
(
    MinisterId varchar(13),
    PortfolioId int,
    PrimeMinister varchar(3),
    PRIMARY KEY (MinisterId),
    FOREIGN KEY (PortfolioId) REFERENCES Portfolios (PortfolioId),
	FOREIGN KEY (MinisterId) REFERENCES Politicians (PoliticianId)
);


CREATE TABLE Regions 
(
    RegionId int AUTO_INCREMENT,
    Region varchar(25),
    PRIMARY KEY (RegionId)
);



CREATE TABLE Constituencies 
(
    ConstituencyId varchar(13),
    RegionId int,
    ParishId int,
    ConstituencyDescription varchar(250),
    PRIMARY KEY (ConstituencyId),
    UNIQUE (RegionId , ParishId),
    FOREIGN KEY (RegionId) REFERENCES Regions (RegionId),
    FOREIGN KEY (ParishId) REFERENCES Parishes (ParishId)
);
/*

select BillCycle from billmeetings where billid = '1' order by meetingdate desc limit 1;

SELECT Politicians.FirstName, Politicians.LastName, BillVotes.PoliticianId FROM BillVotes INNER JOIN Politicians ON BillVotes.PoliticianId = Politicians.PoliticianId
			LEFT JOIN BillMeetings ON BillVotes.BillCycle = BillMeetings.BillCycle 
			WHERE BillMeetings.BillCycle = (select BillCycle from billmeetings where billid = '1' order by meetingdate desc limit 1)
ORDER BY Politicians.FirstName ASC

SELECT * FROM BillMeetings WHERE BillId = '1'
*/

/*


select * from Politicians;
select * from ministers;

SELECT *
FROM Politicians
LEFT JOIN ministers
ON Politicians.PoliticianId=ministers.ministerid;


SELECT ConstituencyMPs.DateElected, ConstituencyMPs.DateRemoved, Politicians.PoliticianId, Politicians.Title, Politicians.FirstName,Politicians.LastName
FROM Constituencies 
INNER JOIN ConstituencyMps ON Constituencies.ConstituencyId=ConstituencyMPs.ConstituencyId
LEFT JOIN Politicians ON ConstituencyMps.MpId=Politicians.PoliticianId
WHERE Constituencies.ConstituencyId = '10B40IEAE35B';

SELECT Constituencies.ConstituencyId, ConstituencyCouncillors.CouncillorId, ConstituencyCouncillors.DateElected, ConstituencyCouncillors.DateRemoved, Politicians.PoliticianId, Politicians.Title, Politicians.FirstName,Politicians.LastName
FROM Constituencies 
INNER JOIN ConstituencyCouncillors ON Constituencies.ConstituencyId=ConstituencyCouncillors.ConstituencyId
LEFT JOIN Politicians ON ConstituencyCouncillors.COuncillorId=Politicians.PoliticianId;
*/

CREATE TABLE ConstituencyMPs 
(
    ConstituencyId varchar(13),
    MPId varchar(13),
    DateElected datetime,
    DateRemoved datetime,
    PRIMARY KEY (ConstituencyId , DateElected , MPId),
    FOREIGN KEY (MPId) REFERENCES Politicians (PoliticianId),
    FOREIGN KEY (ConstituencyId) REFERENCES Constituencies (ConstituencyId)
);


-- SHOW INDEXES FROM ConstituencyMPs;

CREATE TABLE ConstituencyCouncillors 
(
    ConstituencyId varchar(13),
    CouncillorId varchar(13),
    DateElected datetime,
    DateRemoved datetime,
    PRIMARY KEY (CouncillorId , ConstituencyId , DateElected),
    FOREIGN KEY (ConstituencyId)REFERENCES Constituencies (ConstituencyId),
    FOREIGN KEY (CouncillorId) REFERENCES Politicians (PoliticianId)
);


CREATE TABLE ConstituencyContacts 
(
    ConstituencyId varchar(13),
    AddressLine1 varchar(50),
    AddressLine2 varchar(50),
    Town varchar(50),
    ParishId int,
    ContactNumber varchar(11),
    Email varchar(50),
    PRIMARY KEY (ConstituencyId),
    FOREIGN KEY (ConstituencyId) REFERENCES Constituencies (ConstituencyId),
    FOREIGN KEY (ParishId) REFERENCES Parishes (ParishId)
);


-- -----------

CREATE TABLE Bills
(
	BillId int AUTO_INCREMENT,
	BillName varchar (50),
	IntroducedBy varchar (200),
	FirstIntroduced datetime,
	Details varchar (500),
	PRIMARY KEY (BillId)
);




CREATE TABLE Acts
(
	ActId int,
	DateofAssent datetime,	
	DateofAct datetime,	
	ComeintoOperation varchar (2),
	ActLocation varchar (250),
	PRIMARY KEY (ActId),
	FOREIGN KEY (ActId) REFERENCES Bills (BillId)
);



CREATE TABLE BillMeetings
(
	BillCycle varchar (13),
	BillId int,
	BillCount int,
	MeetingDate datetime,
	PRIMARY KEY (BillCycle),
	FOREIGN KEY (BillId) REFERENCES Bills (BillId)
);


CREATE TABLE BillVotes
(
	BillCycle varchar (13),
	PoliticianId varchar (13),
	PoliticianVoted varchar (20),
	PRIMARY KEY (BillCycle,PoliticianId),
	FOREIGN KEY (PoliticianId) REFERENCES Politicians (PoliticianId),
	FOREIGN KEY (BillCycle) REFERENCES BillMeetings (BillCycle)
);


INSERT INTO Regions (Region) 
VALUES

('Northern'),
('North-Eastern'),
('East'),
('East-Rural'),
('South-Eastern'),
('Southern'),
('South-Western'),
('West'),
('West-Rural'),
('North-Western'),
('Central'),
('North-Central'),
('South-Central'),
('East-Central'),
('West-Central');




INSERT INTO Parishes (Parish) 
VALUES

('St. Catherine'),
('Kingston'),
('St. Mary'),
('Westmoreland'),
('Portland'),
('St. Thomas'),
('St. Elizabeth'),
('St. Andrew'),
('Hanover'),
('St. James'),
('Trelawny'),
('St. Ann'),
('Manchester'),
('Clarendon');



INSERT INTO SecurityQuestions (Question) 
VALUES
('What is your pets name?'),
('Who was your first crush?'),
('Who would win in the fight Superman vs Hulk?'),
('Who would win in the fight Superman vs Goku?'),
('What is your grandmothers maiden name?');



INSERT INTO Portfolios (Portfolio)
VALUES
('Without Portfolio'),
('Defence, Development, Information and Sports'),
('Transports, Works and Housing'),
('Finance and Planning'),
('Water, Land, Environment and Climate Change'),
('National Security'),
('Foreign Affairs and Foreign Trade'),
('Science, Technology, Energy and Mining'),
('Labour and Social Security'),
('Agriculture and Fisheries'),
('Industry, Investment and Commerce'),
('Health'),
('Local Government and Community Development'),
('Education'),
('Tourism and Entertainment'),
('Youth and Culture'),
('Justice');

INSERT INTO PoliticalParties (PartyName)
VALUES
('JLP'),
('PNP'),
('NDM');

INSERT INTO Titles (Title) 
VALUES
('Mr.'),
('Ms.'),
('Mrs.'),
('Rev.'),
('Dr.'),
('Sen.');

INSERT INTO Roles (Role)
VALUES
('Member of Parliament'),
('Councillor'),
('Politician'),
('Senator');

-- select * from politicalparties

DELIMITER //
CREATE PROCEDURE INSERTConstituency
     ( 
        -- IN p_constituencyid int,
		IN p_regionid int, 
        IN p_parishid int, 
        IN p_description varchar(250)           
     )
BEGIN 

	DECLARE p_constituencyid varchar(13);
	SET p_constituencyid = UPPER (SUBSTRING(MD5(RAND()) FROM 1 FOR 12));
	
    INSERT INTO Constituencies (ConstituencyId,RegionId,ParishId,ConstituencyDescription)
    VALUES (p_constituencyid,p_regionid,p_parishid,p_description); 

END;  
//
DELIMITER ;

-- Clarendon
CALL INSERTConstituency('11', '14','Central Clarendon');  
CALL INSERTConstituency('1', '14','Northern Clarendon');  
CALL INSERTConstituency('12', '14','North-Central Clarendon');  
CALL INSERTConstituency('10', '14','North-Western Clarendon');  
CALL INSERTConstituency('5', '14','South-Eastern Clarendon');  
CALL INSERTConstituency('7', '14','South-Western Clarendon');  

-- Hanover

CALL INSERTConstituency('3', '9','Eastern Hanover');  
CALL INSERTConstituency('8', '9','Western Hanover');  	


-- Kingston	 
CALL INSERTConstituency('11', '2','Central Kingston');  
CALL INSERTConstituency('3', '2','Eastern Kingston');  
CALL INSERTConstituency('8', '2','Western Kingston');  


-- Manchester	 
CALL INSERTConstituency('11', '13','Central Manchester');  	
CALL INSERTConstituency('2', '13','North-Eastern Manchester');  
CALL INSERTConstituency('10', '13','North-Western Manchester');  
CALL INSERTConstituency('6', '13','Southern Manchester');  
	
-- Portland 
CALL INSERTConstituency('3', '5','Eastern Portland');  
CALL INSERTConstituency('8', '5','Western Portland');  

	 
-- St. Andrew
CALL INSERTConstituency('14', '8','East-Central St. Andrew');  
CALL INSERTConstituency('4', '8','East-Rural St. Andrew');  
CALL INSERTConstituency('3', '8','Eastern St. Andrew');  
CALL INSERTConstituency('12', '8','North-Central St. Andrew');  
CALL INSERTConstituency('2', '8','North-Eastern St. Andrew');  
CALL INSERTConstituency('10', '8','North-Western St. Andrew');  
CALL INSERTConstituency('5', '8','South-Eastern St. Andrew');  
CALL INSERTConstituency('7', '8','South-Western St. Andrew');  
CALL INSERTConstituency('6', '8','Southern St. Andrew');  
CALL INSERTConstituency('15', '8','West-Central St. Andrew');  
CALL INSERTConstituency('9', '8','West-Rural St. Andrew');  
CALL INSERTConstituency('8', '8','Western St. Andrew');  

-- St. Ann
CALL INSERTConstituency('2', '12','North-Eastern St. Ann');  
CALL INSERTConstituency('10', '12','North-Western St. Ann');  
CALL INSERTConstituency('5', '12','South-Eastern St. Ann');  
CALL INSERTConstituency('7', '12','South-Western St. Ann');  
 
-- St. Catherine
CALL INSERTConstituency('11', '1','Central St. Catherine');  
CALL INSERTConstituency('14', '1','East-Central St. Catherine');  
CALL INSERTConstituency('3', '1','Eastern St. Catherine');  
CALL INSERTConstituency('12', '1','North-Central St. Catherine');  
CALL INSERTConstituency('2', '1','North-Eastern St. Catherine');  
CALL INSERTConstituency('10', '1','North-Western St. Catherine');  
CALL INSERTConstituency('13', '1','South-Central St. Catherine');  
CALL INSERTConstituency('5', '1','South-Eastern St. Catherine');  
CALL INSERTConstituency('7', '1','South-Western St. Catherine');  
CALL INSERTConstituency('6', '1','Southern St. Catherine');  
CALL INSERTConstituency('15', '1','West-Central St. Catherine');  


-- St. Elizabeth
CALL INSERTConstituency('2', '7','North-Eastern St. Elizabeth');  
CALL INSERTConstituency('10', '7','North-Western St. Elizabeth');  
CALL INSERTConstituency('5', '7','South-Eastern St. Elizabeth');  
CALL INSERTConstituency('7', '7','South-Western St. Elizabeth');  	

-- St. James 
CALL INSERTConstituency('11', '10','Central St. James');  
CALL INSERTConstituency('14', '10','East-Central St. James');  
CALL INSERTConstituency('10', '10','North-Western St. James');  
CALL INSERTConstituency('6', '10','Southern St. James');  
CALL INSERTConstituency('15', '10','West-Central St. James');  

-- St. Mary
CALL INSERTConstituency('11', '3','Central St. Mary');  
CALL INSERTConstituency('5', '3','South-Eastern St. Mary');  
CALL INSERTConstituency('8', '3','Western St. Mary');  
	 
-- St. Thomas
CALL INSERTConstituency('3', '6','Eastern St. Thomas');  
CALL INSERTConstituency('8', '6','Western St. Thomas');  
 
-- Trelawny 
CALL INSERTConstituency('1', '11','Nothern Trelawny');  
CALL INSERTConstituency('6', '11','Southern Trelawny');  

-- Westmoreland
CALL INSERTConstituency('11', '4','Central Westmoreland');  
CALL INSERTConstituency('3', '4','Eastern Westmoreland');  
CALL INSERTConstituency('8', '4','Western Westmoreland');  



DELIMITER //
CREATE PROCEDURE INSERTPolitician
     ( 
		IN p_title varchar (5), 
        IN p_firstname varchar (25), 
        IN p_lastname varchar(25),
		IN p_gender varchar (6),
		IN p_dob datetime,
		IN p_role varchar (30),
		IN p_minister varchar (3),
		IN p_partyaffiliation int,
		IN p_imagelocation varchar (150),
		IN p_portfolioid int,
		IN p_primeminister varchar (3)
     )
BEGIN 

	DECLARE p_politicianid varchar(13);
	SET p_politicianid = UPPER (SUBSTRING(MD5(RAND()) FROM 1 FOR 12));
	
    INSERT INTO Politicians
    VALUES (p_politicianid,p_title,p_firstname,p_lastname,p_gender,p_dob,p_role,p_minister,p_partyaffiliation,p_imagelocation);
	
	INSERT INTO PoliticianCDF
	VALUES (p_politicianid,"<iframe width='825' height='400' src='http://openspending.org/mayor_s_proposed_policy_budget_fy2013-15/embed?widget=treemap&state=%7B%22drilldowns%22%3A%5B%22fund%22%2C%22department%22%2C%22unit%22%5D%2C%22year%22%3A2013%2C%22cuts%22%3A%7B%7D%7D&width=825&height=400' frameborder='0'></iframe>",'2010-10-10');

	IF p_minister = 'Yes' THEN
		INSERT INTO Ministers
		VALUES (p_politicianid,p_portfolioid,p_primeminister);
	END IF;

END;  
//
Delimiter ;

-- Ministers as of December 2011
CALL INSERTPolitician ('3','Portia','Simpson-Miller','Female','1945-12-12','1','Yes','2','images/PoliticianWarehouse/PortiaMiller.jpg','1002','Yes'); 
CALL INSERTPolitician ('5','Omar','Davies','Male','1947-05-28','1','Yes','2','images/PoliticianWarehouse/OmarDavies.jpg','1003','No'); 
CALL INSERTPolitician ('5','Peter','Phillips','Male','1949-12-28','1','Yes','2','images/PoliticianWarehouse/PeterPhillips.jpg','1004','No'); 
CALL INSERTPolitician ('1','Robert','Pickersgill','Male','1943-02-26','1','Yes','2','images/PoliticianWarehouse/RobertPickersgill.jpg','1005','No'); 
CALL INSERTPolitician ('1','Peter','Bunting','Male','1960-09-07','1','Yes','2','images/PoliticianWarehouse/PeterBunting.jpg','1006','No'); 
CALL INSERTPolitician ('6','Arnold','Nicholson','Male','1942-02-28','4','Yes','2','images/PoliticianWarehouse/ArnoldNicholson.jpg','1007','No'); 
CALL INSERTPolitician ('1','Phillip','Paulwell','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/PhillipPaulwell.jpg','1008','No'); 
CALL INSERTPolitician ('1','Derrick','Kellier','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/DerrickKellier.jpg','1009','No'); 
CALL INSERTPolitician ('1','Roger','Clarke','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/RogerClarke.jpg','1010','No'); 
CALL INSERTPolitician ('1','Anthony','Hylton','Male','1957-04-27','1','Yes','2','images/PoliticianWarehouse/AnthonyHylton.jpg','1011','No'); 
CALL INSERTPolitician ('1','Fenton','Ferguson','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/FentonFerguson.jpg','1012','No'); 
CALL INSERTPolitician ('1','Noel','Arscott','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/NoelArscott.jpg','1013','No'); 
CALL INSERTPolitician ('4','Ronald','Thwaites','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/RonaldThwaites.jpg','1014','No'); 
CALL INSERTPolitician ('5','Kenneth','McNeil','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/KennethMcNeil.jpg','1015','No'); 
CALL INSERTPolitician ('3','Lisa','Hanna','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/LisaHanna.jpg','1016','No'); 
CALL INSERTPolitician ('6','Mark','Golding','Male',NULL,'4','Yes','2','images/PoliticianWarehouse/MarkGolding.jpg','1017','No'); 
CALL INSERTPolitician ('1','Horace','Dalley','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/HoraceDalley.jpg','1001','No'); 
CALL INSERTPolitician ('5','Morais','Guy','Male',NULL,'1','Yes','2','images/PoliticianWarehouse/MoraisGuy.jpg','1001','No'); 
CALL INSERTPolitician ('6','Sandrea','Falconer','Female',NULL,'4','Yes','2','images/PoliticianWarehouse/SandreaFalconer.jpg','1001','No'); 
CALL INSERTPolitician ('3','Natalie','Neita-Headley','Female',NULL,'1','Yes','2','images/PoliticianWarehouse/NatalieNeitaHeadley.jpg','1001','No'); 


-- Other Member of Parliaments (Including State Ministers)
CALL INSERTPolitician ('1','Luther','Buchanan','Male',NULL,'1','No','2','images/PoliticianWarehouse/LutherBuchanan.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Colin','Fagan','Male',NULL,'1','No','2','images/PoliticianWarehouse/ColinFagan.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Patrick','Atkinson','Male',NULL,'1','No','2','images/PoliticianWarehouse/PatrickAtkinson.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Ian','Hayles','Male',NULL,'1','No','2','images/PoliticianWarehouse/IanHayles.jpg',NULL,NULL);  
CALL INSERTPolitician ('2','Denise','Daley','Female',NULL,'1','No','2','images/PoliticianWarehouse/DeniseDaley.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Julian','Robinson','Male',NULL,'1','No','2','images/PoliticianWarehouse/JulianRobinson.jpg',NULL,NULL);  
-- CALL INSERTPolitician ('1','George','Hylton','Male',NULL,'1','No','2','images/PoliticianWarehouse/GeorgeHylton.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Fitz','Jackson','Male',NULL,'1','No','2','images/PoliticianWarehouse/FitzJackson.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Mikael','Phillips','Male',NULL,'1','No','2','images/PoliticianWarehouse/MikaelPhillips.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Michael','Peart','Male',NULL,'1','No','2','images/PoliticianWarehouse/MichaelPeart.jpg',NULL,NULL);  
CALL INSERTPolitician ('5','Lynvale','Bloomfield','Male',NULL,'1','No','2','images/PoliticianWarehouse/LynvaleBloomfield.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Raymond','Pryce','Male',NULL,'1','No','2','images/PoliticianWarehouse/RaymondPryce.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Donald','Duncan','Male',NULL,'1','No','2','images/PoliticianWarehouse/DonaldDuncan.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Arnaldo','Brown','Male',NULL,'1','No','2','images/PoliticianWarehouse/ArnaldoBrown.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Lloyd','Smith','Male',NULL,'1','No','2','images/PoliticianWarehouse/LloydSmith.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Paul','Buchanan','Male',NULL,'1','No','2','images/PoliticianWarehouse/PaulBuchanan.jpg',NULL,NULL);  
CALL INSERTPolitician ('3','Sharon','Ffolkes-Abraham','Female',NULL,'1','No','2','images/PoliticianWarehouse/SharonFfolkesAbraham.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Hugh','Buchanan','Male',NULL,'1','No','2','images/PoliticianWarehouse/HughBuchanan.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Richard','Azan','Male',NULL,'1','No','2','images/PoliticianWarehouse/RichardAzan.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Joylan','Silvera','Male',NULL,'1','No','2','images/PoliticianWarehouse/JoylanSilvera.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Damion','Crawford','Male',NULL,'1','No','2','images/PoliticianWarehouse/DamionCrawford.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Andre','Hylton','Male',NULL,'1','No','2','images/PoliticianWarehouse/AndreHylton.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Dayton','Campbell','Male',NULL,'1','No','2','images/PoliticianWarehouse/DaytonCampbell.jpg',NULL,NULL);  
CALL INSERTPolitician ('5','Winston','Green','Male',NULL,'1','No','2','images/PoliticianWarehouse/WinstonGreen.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Kevin','Walford','Male',NULL,'1','No','2','images/PoliticianWarehouse/KevinWalford.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Richard','Parchment','Male',NULL,'1','No','2','images/PoliticianWarehouse/RichardParchment.jpg',NULL,NULL);  

-- JLP
CALL INSERTPolitician ('1','Andrew','Holness','Male','1972-07-22','1','No','1','images/PoliticianWarehouse/AndrewHolness.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Delroy','Chuck','Male',NULL,'1','No','1','images/PoliticianWarehouse/DelroyChuck.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Desmond','Mckenzie','Male',NULL,'1','No','1','images/PoliticianWarehouse/DesmondMcKenzie.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Derrick','Smith','Male',NULL,'1','No','1','images/PoliticianWarehouse/DerrickSmith.jpg',NULL,NULL);  
CALL INSERTPolitician ('5','Kenneth','Baugh','Male',NULL,'1','No','1','images/PoliticianWarehouse/KennethBaugh.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Audley','Shaw','Male',NULL,'1','No','1','images/PoliticianWarehouse/AudleyShaw.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Karl','Samuda','Male',NULL,'1','No','1','images/PoliticianWarehouse/KarlSamuda.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Pearnel','Charles','Male',NULL,'1','No','1','images/PoliticianWarehouse/PearnelCharles.jpg',NULL,NULL);  
CALL INSERTPolitician ('5','Horace','Chang','Male',NULL,'1','No','1','images/PoliticianWarehouse/HoraceChang.jpg',NULL,NULL);  
CALL INSERTPolitician ('2','Olivia','Grange','Female',NULL,'1','No','1','images/PoliticianWarehouse/OliviaGrange.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','James','Robertson','Male',NULL,'1','No','1','images/PoliticianWarehouse/JamesRobertson.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Rudyard','Spencer','Male',NULL,'1','No','1','images/PoliticianWarehouse/RudyardSpencer.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Lester','Henry','Male',NULL,'1','No','1','images/PoliticianWarehouse/LesterHenry.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Edmund','Bartlett','Male',NULL,'1','No','1','images/PoliticianWarehouse/EdmundBartlett.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Clifford','Warmington','Male',NULL,'1','No','1','images/PoliticianWarehouse/CliffordWarmington.jpg',NULL,NULL);  
CALL INSERTPolitician ('3','Shahine','Robinson','Female',NULL,'1','No','1','images/PoliticianWarehouse/ShahineRobinson.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','William','Hutchinson','Male',NULL,'1','No','1','images/PoliticianWarehouse/WilliamHutchinson.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Daryl','Vaz','Male',NULL,'1','No','1','images/PoliticianWarehouse/DarylVaz.jpg',NULL,NULL);  
CALL INSERTPolitician ('3','Marisa','Dalrymple-Philbert','Female',NULL,'1','No','1','images/PoliticianWarehouse/MarisaDalrymplePhilbert.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Desmond','Mair','Male',NULL,'1','No','1','images/PoliticianWarehouse/DesmondMair.jpg',NULL,NULL);  
CALL INSERTPolitician ('1','Andrew','Wheatley','Male',NULL,'1','No','1','images/PoliticianWarehouse/AndrewWheatley.jpg',NULL,NULL);  


-- Older Politicians
CALL INSERTPolitician ('1','Bruce','Golding','Male','1947-12-05','3','No','1','images/PoliticianWarehouse/BruceGolding.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Clive','Mullings','Male','1957-07-03','3','No','1','images/PoliticianWarehouse/CliveMullings.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Laurence','Broderick','Male',NULL,'3','No','1','images/PoliticianWarehouse/LaurenceBroderick.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Robert','Montague','Male',NULL,'3','No','1','images/PoliticianWarehouse/RobertMontague.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Sharon','Hay-Webster','Female','1961-09-29','3','No','1','images/PoliticianWarehouse/SharonHayWebster.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Andrew','Gallimore','Male',NULL,'3','No','1','images/PoliticianWarehouse/AndrewGallimore.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Maxine','Henry-Wilson','Female',NULL,'3','No','2','images/PoliticianWarehouse/MaxineWilson.jpg',NULL,NULL); 
CALL INSERTPolitician ('5','St. Aubyn','Bartlett','Male',NULL,'3','No','1','images/PoliticianWarehouse/AubynBartlett.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Joseph','Hibbert','Male',NULL,'3','No','1','images/PoliticianWarehouse/JosephHibbert.jpg',NULL,NULL); 
-- CALL INSERTPolitician ('1','Everald','Warmington','Male',NULL,'3','No','1','images/PoliticianWarehouse/EveraldWarmington.jpg',NULL,NULL); 
-- CALL INSERTPolitician ('1','Gregory','Mair','Male',NULL,'3','No','1','images/PoliticianWarehouse/GregoryMair.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Donald','Rhodd','Male',NULL,'3','No','2','images/PoliticianWarehouse/DonaldRhodd.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Tarn','Peralto','Male',NULL,'3','No','1','images/PoliticianWarehouse/TarnPeralto.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Othneil','Lawrence','Male',NULL,'3','No','1','images/PoliticianWarehouse/OthneilLawrence.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Ernest','Smith','Male',NULL,'3','No','1','images/PoliticianWarehouse/ErnestSmith.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Patrick','Harris','Male',NULL,'3','No','2','images/PoliticianWarehouse/PatrickHarris.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Michael','Stern','Male',NULL,'3','No','1','images/PoliticianWarehouse/MichaelStern.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Dean','Peart','Male',NULL,'3','No','2','images/PoliticianWarehouse/DeanPeart.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Kert','Spencer','Male',NULL,'3','No','2','images/PoliticianWarehouse/KertSpencer.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Christopher','Tufton','Male',NULL,'3','No','1','images/PoliticianWarehouse/ChristopherTufton.jpg',NULL,NULL); 
CALL INSERTPolitician ('1','Franklyn','Witter','Male',NULL,'3','No','1','images/PoliticianWarehouse/FranklynWitter.jpg',NULL,NULL); 


DELIMITER //
-- DROP PROCEDURE IF EXISTS INSERTConstituencyMp
CREATE PROCEDURE INSERTConstituencyMp
 ( 
	-- IN p_constituencyid int,
	-- IN p_mpid int,
	IN p_constituencydescription varchar (250),
	IN p_dateelected datetime, 
	IN p_dateremoved datetime,
	IN p_firstname varchar (25),
	IN p_lastname varchar (25)
 )
BEGIN 
	
	DECLARE p_politicianid varchar(13);
	DECLARE p_constituencyid varchar (13);

	SET p_politicianid = (SELECT PoliticianId FROM Politicians WHERE FirstName = p_firstname AND LastName = p_lastname);
	SET p_constituencyid = (SELECT ConstituencyId FROM Constituencies WHERE ConstituencyDescription = p_constituencydescription);

    INSERT INTO ConstituencyMps (ConstituencyId,MpId,DateElected,DateRemoved)
    VALUES (p_constituencyid,p_politicianid,p_dateelected,p_dateremoved); 

END;  
//
DELIMITER ;

CALL INSERTConstituencyMp ('West-Central St. Andrew','2012-01-05',null,'Andrew','Holness'); 
CALL INSERTConstituencyMp ('North-Eastern St. Andrew','2012-01-05',null,'Delroy','Chuck'); 
CALL INSERTConstituencyMp ('Western Kingston','2012-01-05',null,'Desmond','McKenzie'); 
CALL INSERTConstituencyMp ('North-Western St. Andrew','2012-01-05',null,'Derrick','Smith'); 
CALL INSERTConstituencyMp ('North-Central St. Andrew','2012-01-05',null,'Karl','Samuda'); 
CALL INSERTConstituencyMp ('West-Central St. Catherine','2012-01-05',null,'Kenneth','Baugh'); 
CALL INSERTConstituencyMp ('Central St. Catherine','2012-01-05',null,'Olivia','Grange'); 
CALL INSERTConstituencyMp ('South-Western St. Catherine','2012-01-05',null,'Clifford','Warmington'); 
CALL INSERTConstituencyMp ('North-Eastern St. Catherine','2012-01-05',null,'Desmond','Mair'); 
CALL INSERTConstituencyMp ('South-Central St. Catherine','2012-01-05',null,'Andrew','Wheatley'); 
CALL INSERTConstituencyMp ('North-Central Clarendon','2012-01-05',null,'Pearnel','Charles'); 
CALL INSERTConstituencyMp ('South-Eastern Clarendon','2012-01-05',null,'Rudyard','Spencer'); 
CALL INSERTConstituencyMp ('Central Clarendon','2012-01-05',null,'Lester','Henry'); 
CALL INSERTConstituencyMp ('North-Eastern Manchester','2012-01-05',null,'Audley','Shaw'); 
CALL INSERTConstituencyMp ('North-Western St. James','2012-01-05',null,'Horace','Chang'); 
CALL INSERTConstituencyMp ('East-Central St. James','2012-01-05',null,'Edmund','Bartlett'); 
CALL INSERTConstituencyMp ('North-Eastern St. Ann','2012-01-05',null,'Shahine','Robinson'); 
CALL INSERTConstituencyMp ('Western St. Thomas','2012-01-05',null,'James','Robertson'); 
CALL INSERTConstituencyMp ('North-Western St. Elizabeth','2012-01-05',null,'William','Hutchinson'); 
CALL INSERTConstituencyMp ('Western Portland','2012-01-05',null,'Daryl','Vaz'); 
CALL INSERTConstituencyMp ('Southern Trelawny','2012-01-05',null,'Marisa','Dalrymple-Philbert'); 

-- PNP
CALL INSERTConstituencyMp ('South-Western St. Andrew','2012-01-05',null,'Portia','Simpson-Miller'); 
CALL INSERTConstituencyMp ('Southern St. Andrew','2012-01-05',null,'Omar','Davies'); 
CALL INSERTConstituencyMp ('South-Eastern St. Andrew','2012-01-05',null,'Julian','Robinson');
CALL INSERTConstituencyMp ('Western St. Andrew','2012-01-05',null,'Anthony','Hylton');
CALL INSERTConstituencyMp ('East-Central St. Andrew','2012-01-05',null,'Peter','Phillips');
CALL INSERTConstituencyMp ('West-Rural St. Andrew','2012-01-05',null,'Paul','Buchanan');
CALL INSERTConstituencyMp ('East-Rural St. Andrew','2012-01-05',null,'Damion','Crawford');
CALL INSERTConstituencyMp ('Eastern St. Andrew','2012-01-05',null,'Andre','Hylton');
CALL INSERTConstituencyMp ('Eastern Kingston','2012-01-05',null,'Phillip','Paulwell');
CALL INSERTConstituencyMp ('Central Kingston','2012-01-05',null,'Ronald','Thwaites');
CALL INSERTConstituencyMp ('South-Eastern St. Catherine','2012-01-05',null,'Colin','Fagan'); 
CALL INSERTConstituencyMp ('Eastern St. Catherine','2012-01-05',null,'Denise','Daley');
CALL INSERTConstituencyMp ('Southern St. Catherine','2012-01-05',null,'Fitz','Jackson');
CALL INSERTConstituencyMp ('North-Central St. Catherine','2012-01-05',null,'Natalie','Neita-Headley');
CALL INSERTConstituencyMp ('North-Western St. Catherine','2012-01-05',null,'Robert','Pickersgill');
CALL INSERTConstituencyMp ('East-Central St. Catherine','2012-01-05',null,'Arnaldo','Brown');
CALL INSERTConstituencyMp ('South-Western Clarendon','2012-01-05',null,'Noel','Arscott'); 
CALL INSERTConstituencyMp ('North-Western Clarendon','2012-01-05',null,'Richard','Azan'); 
CALL INSERTConstituencyMp ('Northern Clarendon','2012-01-05',null,'Horace','Dalley');
CALL INSERTConstituencyMp ('Eastern Westmoreland','2012-01-05',null,'Luther','Buchanan');
CALL INSERTConstituencyMp ('Central Westmoreland','2012-01-05',null,'Roger','Clarke');
CALL INSERTConstituencyMp ('Western Westmoreland','2012-01-05',null,'Kenneth','McNeil');
CALL INSERTConstituencyMp ('North-Western Manchester','2012-01-05',null,'Mikael','Phillips');
CALL INSERTConstituencyMp ('Central Manchester','2012-01-05',null,'Peter','Bunting');
CALL INSERTConstituencyMp ('Southern Manchester','2012-01-05',null,'Michael','Peart');
CALL INSERTConstituencyMp ('Eastern St. Thomas','2012-01-05',null,'Fenton','Ferguson');
CALL INSERTConstituencyMp ('Central St. Mary','2012-01-05',null,'Morais','Guy'); 
CALL INSERTConstituencyMp ('Western St. Mary','2012-01-05',null,'Joylan','Silvera');
CALL INSERTConstituencyMp ('South-Eastern St. Mary','2012-01-05',null,'Winston','Green'); 
CALL INSERTConstituencyMp ('South-Eastern St. Ann','2012-01-05',null,'Lisa','Hanna'); 
CALL INSERTConstituencyMp ('Nothern Trelawny','2012-01-05',null,'Patrick','Atkinson');
CALL INSERTConstituencyMp ('Western Hanover','2012-01-05',null,'Ian','Hayles');
CALL INSERTConstituencyMp ('Eastern Hanover','2012-01-05',null,'Donald','Duncan');
CALL INSERTConstituencyMp ('Southern St. James','2012-01-05',null,'Derrick','Kellier');
CALL INSERTConstituencyMp ('Central St. James','2012-01-05',null,'Lloyd','Smith');
CALL INSERTConstituencyMp ('West-Central St. James','2012-01-05',null,'Sharon','Ffolkes-Abraham');
CALL INSERTConstituencyMp ('North-Western St. Ann','2012-01-05',null,'Dayton','Campbell');
CALL INSERTConstituencyMp ('South-Western St. Ann','2012-01-05',null,'Kevin','Walford');
CALL INSERTConstituencyMp ('Eastern Portland','2012-01-05',null,'Lynvale','Bloomfield'); 
CALL INSERTConstituencyMp ('North-Eastern St. Elizabeth','2012-01-05',null,'Raymond','Pryce');
CALL INSERTConstituencyMp ('South-Western St. Elizabeth','2012-01-05',null,'Hugh','Buchanan'); 
CALL INSERTConstituencyMp ('South-Eastern St. Elizabeth','2012-01-05',null,'Richard','Parchment'); 


-- ConstuencyMps
CALL INSERTConstituencyMp ('Western Kingston','2007-09-27','2012-01-17','Bruce','Golding');
CALL INSERTConstituencyMp ('West-Central St. James','2007-09-27','2012-01-17','Clive','Mullings');
CALL INSERTConstituencyMp ('North-Western Clarendon','2007-09-27','2012-01-17','Laurence','Broderick');
CALL INSERTConstituencyMp ('Western St. Mary','2007-09-27','2012-01-17','Robert','Montague');
CALL INSERTConstituencyMp ('South-Central St. Catherine','2007-09-27','2012-01-17','Sharon','Hay-Webster');
CALL INSERTConstituencyMp ('Central Kingston','2007-09-27','2012-01-17','Ronald','Thwaites');
CALL INSERTConstituencyMp ('Eastern Kingston','2007-09-27','2012-01-17','Phillip','Paulwell');
CALL INSERTConstituencyMp ('West-Rural St. Andrew','2007-09-27','2012-01-17','Andrew','Gallimore');
CALL INSERTConstituencyMp ('Western St. Andrew','2007-09-27','2012-01-17','Anthony','Hylton');
CALL INSERTConstituencyMp ('West-Central St. Andrew','2007-09-27','2012-01-17','Andrew','Holness');
CALL INSERTConstituencyMp ('East-Central St. Andrew','2007-09-27','2012-01-17','Peter','Phillips');
CALL INSERTConstituencyMp ('South-Western St. Andrew','2007-09-27','2012-01-17','Portia','Simpson-Miller');
CALL INSERTConstituencyMp ('Southern St. Andrew','2007-09-27','2012-01-17','Omar','Davies');
CALL INSERTConstituencyMp ('South-Eastern St. Andrew','2007-09-27','2012-01-17','Maxine','Henry-Wilson');
CALL INSERTConstituencyMp ('Eastern St. Andrew','2007-09-27','2012-01-17','St. Aubyn','Bartlett');
CALL INSERTConstituencyMp ('North-Eastern St. Andrew','2007-09-27','2012-01-17','Delroy','Chuck');
CALL INSERTConstituencyMp ('North-Central St. Andrew','2007-09-27','2012-01-17','Karl','Samuda');
CALL INSERTConstituencyMp ('North-Western St. Andrew','2007-09-27','2012-01-17','Derrick','Smith');
CALL INSERTConstituencyMp ('East-Rural St. Andrew','2007-09-27','2012-01-17','Joseph','Hibbert');
CALL INSERTConstituencyMp ('North-Western St. Catherine','2007-09-27','2012-01-17','Robert','Pickersgill');
CALL INSERTConstituencyMp ('South-Western St. Catherine','2007-09-27','2012-01-17','Clifford','Warmington');
CALL INSERTConstituencyMp ('Southern St. Catherine','2007-09-27','2012-01-17','Fitz','Jackson');
CALL INSERTConstituencyMp ('Central St. Catherine','2007-09-27','2012-01-17','Olivia','Grange');
CALL INSERTConstituencyMp ('South-Eastern St. Catherine','2007-09-27','2012-01-17','Colin','Fagan');
CALL INSERTConstituencyMp ('East-Central St. Catherine','2007-09-27','2012-01-17','Natalie','Neita-Headley');
CALL INSERTConstituencyMp ('West-Central St. Catherine','2007-09-27','2012-01-17','Kenneth','Baugh');
CALL INSERTConstituencyMp ('North-Eastern St. Catherine','2007-09-27','2012-01-17','Desmond','Mair');
CALL INSERTConstituencyMp ('Western St. Thomas','2007-09-27','2012-01-17','James','Robertson');
CALL INSERTConstituencyMp ('Eastern St. Thomas','2007-09-27','2012-01-17','Fenton','Ferguson');
CALL INSERTConstituencyMp ('Eastern Portland','2007-09-27','2012-01-17','Donald','Rhodd');
CALL INSERTConstituencyMp ('Western Portland','2007-09-27','2012-01-17','Daryl','Vaz');
CALL INSERTConstituencyMp ('South-Eastern St. Mary','2007-09-27','2012-01-17','Tarn','Peralto');
CALL INSERTConstituencyMp ('Central St. Mary','2007-09-27','2012-01-17','Morais','Guy');
CALL INSERTConstituencyMp ('South-Eastern St. Ann','2007-09-27','2012-01-17','Lisa','Hanna');
CALL INSERTConstituencyMp ('North-Eastern St. Ann','2007-09-27','2012-01-17','Shahine','Robinson');
CALL INSERTConstituencyMp ('North-Western St. Ann','2007-09-27','2012-01-17','Othneil','Lawrence');
CALL INSERTConstituencyMp ('South-Western St. Ann','2007-09-27','2012-01-17','Ernest','Smith');
CALL INSERTConstituencyMp ('Nothern Trelawny','2007-09-27','2012-01-17','Patrick','Harris');
CALL INSERTConstituencyMp ('Southern Trelawny','2007-09-27','2012-01-17','Marisa','Dalrymple-Philbert');
CALL INSERTConstituencyMp ('East-Central St. James','2007-09-27','2012-01-17','Edmund','Bartlett');
CALL INSERTConstituencyMp ('North-Western St. James','2007-09-27','2012-01-17','Horace','Chang');
CALL INSERTConstituencyMp ('Eastern Hanover','2007-09-27','2012-01-17','Donald','Duncan');
CALL INSERTConstituencyMp ('Western Hanover','2007-09-27','2012-01-17','Ian','Hayles');
CALL INSERTConstituencyMp ('North-Western Clarendon','2007-09-27','2012-01-17','Michael','Stern');
CALL INSERTConstituencyMp ('North-Central Clarendon','2007-09-27','2012-01-17','Pearnel','Charles');
CALL INSERTConstituencyMp ('Central Clarendon','2007-09-27','2012-01-17','Lester','Henry');
CALL INSERTConstituencyMp ('South-Western Clarendon','2007-09-27','2012-01-17','Noel','Arscott');
CALL INSERTConstituencyMp ('South-Eastern Clarendon','2007-09-27','2012-01-17','Rudyard','Spencer');
CALL INSERTConstituencyMp ('Southern Manchester','2007-09-27','2012-01-17','Michael','Peart');
CALL INSERTConstituencyMp ('Central Manchester','2007-09-27','2012-01-17','Peter','Bunting');
CALL INSERTConstituencyMp ('North-Western Manchester','2007-09-27','2012-01-17','Dean','Peart');
CALL INSERTConstituencyMp ('North-Eastern Manchester','2007-09-27','2012-01-17','Audley','Shaw');
CALL INSERTConstituencyMp ('North-Western St. Elizabeth','2007-09-27','2012-01-17','William','Hutchinson');
CALL INSERTConstituencyMp ('North-Eastern St. Elizabeth','2007-09-27','2012-01-17','Kert','Spencer');
CALL INSERTConstituencyMp ('South-Western St. Elizabeth','2007-09-27','2012-01-17','Christopher','Tufton');
CALL INSERTConstituencyMp ('South-Eastern St. Elizabeth','2007-09-27','2012-01-17','Franklyn','Witter');
CALL INSERTConstituencyMp ('Western Westmoreland','2007-09-27','2012-01-17','Kenneth','McNeil');
CALL INSERTConstituencyMp ('Central Westmoreland','2007-09-27','2012-01-17','Roger','Clarke');
CALL INSERTConstituencyMp ('Eastern Westmoreland','2007-09-27','2012-01-17','Luther','Buchanan');


DELIMITER //
CREATE PROCEDURE INSERTBill
	( 
        -- IN p_constituencyid int,
		IN p_billname varchar(50), 
        IN p_introducedby varchar (200), 
		IN p_firstintroduced datetime,
        IN p_details varchar(500)           
     )
BEGIN 
	
    INSERT INTO Bills (BillName,IntroducedBy,FirstIntroduced,Details)
    VALUES (p_billname,p_introducedby,p_firstintroduced,p_details); 

END;  
//
DELIMITER ;

CALL INSERTBill ('The Conch (Export Levy) Act 2009','Christopher Tufton','2009-03-31','A levy on conch intended for export and to create from the proceeds a dedicated fund called the Fisheries Management and Development Fund.');
CALL INSERTBill ('Sexual Offences Act 2009','Clive Mullings','2009-03-31','To modernise the law relating to sexual offences: to provide for a statutory, gender-neutral definition of rape, to abolish the common law presumption that a boy under fourteen years is incapable of committing rape or other offence of vaginal or anal intercourse, to increase the penalty for incest and widen the categories of prohibited relationships, to provide for the establishment of a Sexual Offender Registry and for connected matters.');
CALL INSERTBill ('Factories (Amendment) Act, 2009','Pearnel Charles','2009-04-28','To amend the Factories Act in order to increase the fines and penalties payable for breaches of several provisions of this Act.');
CALL INSERTBill ('Appropriation Act, 2009','Audley Shaw','2009-04-23','To provide authority for expenditure (other than statutory expenditure) for the financial year 2009/2010 and specifies the manner in which that expenditure is to be allocated to the various services and purposes. To provide for the amounts of receipts in relation to these services and purposes.');
CALL INSERTBill ('Income Tax (Validation & Amendment) Act 2009','Karl Samuda','2009-04-28','To amend Section 79(1) (b) of the Act to allow for the charging of interest on the unpaid taxes owed by persons who file returns under Section 67(5) of the Act; to provide for an incentive for tax payers for prepayments by crediting the same rate of interest applicable to unpaid amounts.');
CALL INSERTBill ('The Trade (Amendment) Act','Karl Samuda','2009-04-23','To provide for increase in fines; and to empower the Minister to increase fines under the Act by order,  subject to affirmative resolution in each House of Parliament.');
CALL INSERTBill ('The Bank of Jamaica (Amendment) Act','Audley Shaw','2009-06-09','Outlines the regulations of the Bank of Jamaica. This would include the capital of the bank, funds, etc., the issuing of notes, and the establishment of the bank. This amendment establishes new limits for the legal tender of coins in any one transaction');
CALL INSERTBill ('Holidays with Pay (Amendment)','Pearnel Charles','2009-06-09','To increase fines payable to more realistic levels and to give RM Courts jurisdiction to hear and determine matters arising out of the operation of the Act.');
CALL INSERTBill ('The Child Pornography (Prevention) Act, 2009','Bruce Golding','2009-07-22','An act to prohibit the production, distribution, imposition, exportation or possession child pornography and the use of children for child pornography and to provide for connected matters.');
CALL INSERTBill ('The Registration (Strata Titles) Amendment','Bruce Golding','2009-09-06','The Registration (Strata Titles) Amendment Act addresses the concerns surrounding the ownership of condominiums or apartment buildings,along with payment of relevant fees.');



DELIMITER //
CREATE PROCEDURE INSERTBillUpdate
     ( 
        IN p_billid int, 
		IN p_billcount int, 
        IN p_meetingdate datetime         
     )
BEGIN 

	DECLARE p_billcycle varchar(13);
	SET p_billcycle = UPPER (SUBSTRING(MD5(RAND()) FROM 1 FOR 12));
	
    INSERT INTO BillMeetings (BillCycle,BillId,BillCount,Meetingdate)
    VALUES (p_billcycle,p_billid,p_billcount,p_meetingdate); 

END;  
//
DELIMITER ;

CALL INSERTBillUpdate ('1','1','2009-03-31');
CALL INSERTBillUpdate ('2','1','2009-09-15');
CALL INSERTBillUpdate ('3','1','2009-06-09');
CALL INSERTBillUpdate ('4','1','2009-05-06');
CALL INSERTBillUpdate ('5','1','2009-06-09');
CALL INSERTBillUpdate ('6','1','2009-06-09');
CALL INSERTBillUpdate ('7','1','2009-10-27');
CALL INSERTBillUpdate ('8','1','2009-10-06');
CALL INSERTBillUpdate ('9','1','2009-09-22');
CALL INSERTBillUpdate ('10','1','2009-10-27');


DELIMITER //
CREATE PROCEDURE INSERTBillVote
     ( 
		IN p_billid int, 
		IN p_firstname varchar(25),
		IN p_lastname varchar(25),
        IN p_polticianvoted varchar(20)         
     )
BEGIN 

	DECLARE p_politicianid varchar(13);
	DECLARE p_billcycle varchar (13);

	SET p_politicianid = (SELECT PoliticianId FROM Politicians WHERE FirstName = p_firstname AND LastName = p_lastname);
	SET p_billcycle = (SELECT BillCycle from BillMeetings WHERE BillId = p_billid ORDER BY MeetingDate DESC limit 1);
	
    INSERT INTO BillVotes (BillCycle,PoliticianId,PoliticianVoted)
    VALUES (p_billcycle,p_politicianid,p_polticianvoted); 

END;  
//

DELIMITER ;


-- For Conch Levy Act
CALL INSERTBillVote ('1','Delroy','Chuck',' Undetermined');
CALL INSERTBillVote ('1','Derrick','Smith',' Undetermined');
CALL INSERTBillVote ('1','Bruce','Golding',' Undetermined');
CALL INSERTBillVote ('1','Kenneth','Baugh',' Undetermined');
CALL INSERTBillVote ('1','Pearnel','Charles',' Undetermined');
CALL INSERTBillVote ('1','Lester','Henry',' Undetermined');
CALL INSERTBillVote ('1','Clive','Mullings',' Undetermined');
CALL INSERTBillVote ('1','Christopher','Tufton',' Undetermined');
CALL INSERTBillVote ('1','Shahine','Robinson',' Undetermined');
CALL INSERTBillVote ('1','William','Hutchinson',' Undetermined');
CALL INSERTBillVote ('1','Joseph','Hibbert',' Undetermined');
CALL INSERTBillVote ('1','Andrew','Gallimore',' Undetermined');
CALL INSERTBillVote ('1','Laurence','Broderick',' Undetermined');
CALL INSERTBillVote ('1','Robert','Montague',' Undetermined');
CALL INSERTBillVote ('1','Daryl','Vaz',' Undetermined');
CALL INSERTBillVote ('1','Roger','Clarke',' Undetermined');
CALL INSERTBillVote ('1','Omar','Davies',' Undetermined');
CALL INSERTBillVote ('1','Donald','Duncan',' Undetermined');
CALL INSERTBillVote ('1','Colin','Fagan',' Undetermined');
CALL INSERTBillVote ('1','Ian','Hayles',' Undetermined');
CALL INSERTBillVote ('1','Sharon','Hay-Webster',' Undetermined');
CALL INSERTBillVote ('1','Maxine','Henry-Wilson',' Undetermined');
CALL INSERTBillVote ('1','Anthony','Hylton',' Undetermined');
CALL INSERTBillVote ('1','Desmond','Mair',' Undetermined');
CALL INSERTBillVote ('1','Phillip','Paulwell',' Undetermined');
CALL INSERTBillVote ('1','Michael','Peart',' Undetermined');
CALL INSERTBillVote ('1','Dean','Peart',' Undetermined');
CALL INSERTBillVote ('1','Tarn','Peralto',' Undetermined');
CALL INSERTBillVote ('1','Peter','Phillips',' Undetermined');
CALL INSERTBillVote ('1','Ronald','Thwaites',' Undetermined');
CALL INSERTBillVote ('1','Franklyn','Witter',' Undetermined');


																																		
CALL INSERTBillVote ('2', 'Delroy','Chuck','Undetermined');
CALL INSERTBillVote ('2', 'Marisa', 'Dalrymple-Philbert', 'Undetermined');
CALL INSERTBillVote ('2', 'Andrew', 'Holness', 'Undetermined');
CALL INSERTBillVote ('2', 'Bruce', 'Golding', 'Undetermined');
CALL INSERTBillVote ('2', 'Karl', 'Samuda', 'Undetermined');
CALL INSERTBillVote ('2', 'Pearnel', 'Charles', 'Undetermined');
CALL INSERTBillVote ('2', 'Lester', 'Henry', 'Undetermined');
CALL INSERTBillVote ('2', 'Rudyard', 'Spencer', 'Undetermined');
CALL INSERTBillVote ('2', 'Daryl', 'Vaz', 'Undetermined');
CALL INSERTBillVote ('2', 'William', 'Hutchinson', 'Undetermined');
CALL INSERTBillVote ('2', 'Clifford', 'Warmington', 'Undetermined');
CALL INSERTBillVote ('2', 'Andrew', 'Gallimore', 'Undetermined');
CALL INSERTBillVote ('2', 'Laurence', 'Broderick', 'Undetermined');
CALL INSERTBillVote ('2', 'Robert', 'Montague', 'Undetermined');
CALL INSERTBillVote ('2', 'Noel', 'Arscott', 'Undetermined');
CALL INSERTBillVote ('2', 'St. Aubyn', 'Bartlett', 'Undetermined');
CALL INSERTBillVote ('2', 'Luther', 'Buchanan', 'Undetermined');
CALL INSERTBillVote ('2', 'Peter', 'Bunting', 'Undetermined');
CALL INSERTBillVote ('2', 'Roger', 'Clarke', 'Undetermined');
CALL INSERTBillVote ('2', 'Omar', 'Davies', 'Undetermined');
CALL INSERTBillVote ('2', 'Colin', 'Fagan', 'Undetermined');
CALL INSERTBillVote ('2', 'Fenton', 'Ferguson', 'Undetermined');
CALL INSERTBillVote ('2', 'Morais', 'Guy', 'Undetermined');
CALL INSERTBillVote ('2', 'Lisa', 'Hanna', 'Undetermined');
CALL INSERTBillVote ('2', 'Ian', 'Hayles', 'Undetermined');
CALL INSERTBillVote ('2', 'Sharon', 'Hay-Webster', 'Undetermined');
CALL INSERTBillVote ('2', 'Joseph', 'Hibbert', 'Undetermined');
CALL INSERTBillVote ('2', 'Fitz', 'Jackson', 'Undetermined');
CALL INSERTBillVote ('2', 'Derrick', 'Kellier', 'Undetermined');
CALL INSERTBillVote ('2', 'Desmond', 'Mair', 'Undetermined');
CALL INSERTBillVote ('2', 'Phillip', 'Paulwell', 'Undetermined'); 
CALL INSERTBillVote ('2', 'Michael', 'Peart', 'Undetermined');
CALL INSERTBillVote ('2', 'Tarn', 'Peralto', 'Undetermined');
CALL INSERTBillVote ('2', 'Donald', 'Rhodd', 'Undetermined');
CALL INSERTBillVote ('2', 'Portia', 'Simpson-Miller', 'Undetermined');
CALL INSERTBillVote ('2', 'Ernest', 'Smith', 'Undetermined');
CALL INSERTBillVote ('2', 'Michael', 'Stern', 'Undetermined');
CALL INSERTBillVote ('2', 'Ronald', 'Thwaites', 'Undetermined');
CALL INSERTBillVote ('2', 'Franklyn', 'Witter', 'Undetermined');

CALL INSERTBillVote ('3', 'Delroy','Chuck','Undetermined');
CALL INSERTBillVote ('3', 'Marisa', 'Dalrymple-Philbert', 'Undetermined');
CALL INSERTBillVote ('3', 'Andrew', 'Holness', 'Undetermined');
CALL INSERTBillVote ('3', 'Karl', 'Samuda', 'Undetermined');
CALL INSERTBillVote ('3', 'Pearnel', 'Charles', 'Undetermined');
CALL INSERTBillVote ('3', 'Rudyard', 'Spencer', 'Undetermined');
CALL INSERTBillVote ('3', 'Daryl', 'Vaz', 'Undetermined');
CALL INSERTBillVote ('3', 'Shahine', 'Robinson', 'Undetermined');
CALL INSERTBillVote ('3', 'Joseph', 'Hibbert', 'Undetermined');
CALL INSERTBillVote ('3', 'Andrew', 'Gallimore', 'Undetermined');
CALL INSERTBillVote ('3', 'Omar', 'Davies', 'Undetermined');
CALL INSERTBillVote ('3', 'Morais', 'Guy', 'Undetermined');
CALL INSERTBillVote ('3', 'Lisa', 'Hanna', 'Undetermined');
CALL INSERTBillVote ('3', 'Ian', 'Hayles', 'Undetermined');
CALL INSERTBillVote ('3', 'Sharon', 'Hay-Webster', 'Undetermined');
CALL INSERTBillVote ('3', 'Andre', 'Hylton', 'Undetermined');
CALL INSERTBillVote ('3', 'Derrick', 'Kellier', 'Undetermined');
CALL INSERTBillVote ('3', 'Clive', 'Mullings', 'Undetermined');
CALL INSERTBillVote ('3', 'Phillip', 'Paulwell', 'Undetermined'); 
CALL INSERTBillVote ('3', 'Michael', 'Peart', 'Undetermined');
CALL INSERTBillVote ('3', 'Tarn', 'Peralto', 'Undetermined');
CALL INSERTBillVote ('3', 'Peter', 'Phillips', 'Undetermined');
CALL INSERTBillVote ('3', 'Donald', 'Rhodd', 'Undetermined');
CALL INSERTBillVote ('3', 'Derrick', 'Smith', 'Undetermined');
CALL INSERTBillVote ('3', 'Ronald', 'Thwaites', 'Undetermined');
CALL INSERTBillVote ('3', 'Franklyn', 'Witter', 'Undetermined');


CALL INSERTBillVote ('4','Delroy','Chuck','Undetermined');
CALL INSERTBillVote ('4','Marisa','Dalrymple-Philbert','Undetermined');
CALL INSERTBillVote ('4','Andrew','Holness','Undetermined');
CALL INSERTBillVote ('4','Bruce','Golding','Undetermined');
CALL INSERTBillVote ('4','Audley','Shaw','Undetermined');
CALL INSERTBillVote ('4','Horace', 'Chang' ,'Undetermined');
CALL INSERTBillVote ('4','Pearnel','Charles','Undetermined');
CALL INSERTBillVote ('4','Olivia', 'Grange' ,'Undetermined');
CALL INSERTBillVote ('4','Rudyard', 'Spencer' ,'Undetermined');
CALL INSERTBillVote ('4','Christopher', 'Tufton' ,'Undetermined');
CALL INSERTBillVote ('4','Daryl', 'Vaz' ,'Undetermined');
CALL INSERTBillVote ('4','Shahine', 'Robinson' ,'Undetermined');
CALL INSERTBillVote ('4','William', 'Hutchinson' ,'Undetermined');
CALL INSERTBillVote ('4','Joseph', 'Hibbert' ,'Undetermined');
CALL INSERTBillVote ('4','Clifford', 'Warmington' ,'Undetermined');
CALL INSERTBillVote ('4','Andrew', 'Gallimore' ,'Undetermined');
CALL INSERTBillVote ('4','Michael', 'Stern' ,'Undetermined');
-- CALL INSERTBillVote ('4','Noel', 'Monteith' ,'Undetermined');
CALL INSERTBillVote ('4','Peter', 'Bunting' ,'Undetermined');
CALL INSERTBillVote ('4','Roger', 'Clarke' ,'Undetermined');
CALL INSERTBillVote ('4','Omar', 'Davies' ,'Undetermined');
CALL INSERTBillVote ('4','Colin', 'Fagan' ,'Undetermined');
CALL INSERTBillVote ('4','Fenton', 'Ferguson' ,'Undetermined');
CALL INSERTBillVote ('4','Morais', 'Guy' ,'Undetermined');
CALL INSERTBillVote ('4','Ian', 'Hayles' ,'Undetermined');
CALL INSERTBillVote ('4','Derrick', 'Kellier' ,'Undetermined');
CALL INSERTBillVote ('4','Othneil', 'Lawrence' ,'Undetermined');
CALL INSERTBillVote ('4','Desmond', 'Mair' ,'Undetermined');
CALL INSERTBillVote ('4','Kenneth', 'McNeil' ,'Undetermined');
CALL INSERTBillVote ('4','Natalie', 'Neita-Headley' ,'Undetermined'); 
CALL INSERTBillVote ('4','Phillip', 'Paulwell' ,'Undetermined'); 
CALL INSERTBillVote ('4','Michael', 'Peart' ,'Undetermined');
CALL INSERTBillVote ('4','Tarn', 'Peralto' ,'Undetermined');
CALL INSERTBillVote ('4','Portia', 'Simpson-Miller' ,'Undetermined');
CALL INSERTBillVote ('4','Derrick', 'Smith' ,'Undetermined');
CALL INSERTBillVote ('4','Ronald', 'Thwaites' ,'Undetermined');


CALL INSERTBillVote ('5','Delroy', 'Chuck' ,'Undetermined');
CALL INSERTBillVote ('5','Marisa', 'Dalrymple-Philbert' ,'Undetermined');
CALL INSERTBillVote ('5','Andrew', 'Holness' ,'Undetermined');
CALL INSERTBillVote ('5','Karl', 'Samuda' ,'Undetermined');
CALL INSERTBillVote ('5','Horace', 'Chang' ,'Undetermined');
CALL INSERTBillVote ('5','Pearnel', 'Charles' ,'Undetermined');
CALL INSERTBillVote ('5','Rudyard', 'Spencer' ,'Undetermined');
CALL INSERTBillVote ('5','Daryl', 'Vaz' ,'Undetermined');
CALL INSERTBillVote ('5','Shahine', 'Robinson' ,'Undetermined');
CALL INSERTBillVote ('5','Joseph', 'Hibbert' ,'Undetermined');
CALL INSERTBillVote ('5','Andrew', 'Gallimore' ,'Undetermined');
CALL INSERTBillVote ('5','Omar', 'Davies' ,'Undetermined');
CALL INSERTBillVote ('5','Morais', 'Guy' ,'Undetermined');
CALL INSERTBillVote ('5','Lisa', 'Hanna' ,'Undetermined');
-- CALL INSERTBillVote ('5','E', 'Harris' ,'Undetermined');
CALL INSERTBillVote ('5','Ian', 'Hayles' ,'Undetermined');
CALL INSERTBillVote ('5','Sharon', 'Hay-Webster' ,'Undetermined');
CALL INSERTBillVote ('5','Anthony', 'Hylton' ,'Undetermined');
CALL INSERTBillVote ('5','Derrick', 'Kellier' ,'Undetermined');
CALL INSERTBillVote ('5','Clive', 'Mullings' ,'Undetermined');
CALL INSERTBillVote ('5','Phillip', 'Paulwell' ,'Undetermined');
CALL INSERTBillVote ('5','Michael', 'Peart' ,'Undetermined');
CALL INSERTBillVote ('5','Tarn', 'Peralto' ,'Undetermined');
CALL INSERTBillVote ('5','Peter', 'Phillips' ,'Undetermined');
CALL INSERTBillVote ('5','Donald', 'Rhodd' ,'Undetermined');
CALL INSERTBillVote ('5','Derrick', 'Smith' ,'Undetermined');
CALL INSERTBillVote ('5','Ronald', 'Thwaites' ,'Undetermined');
CALL INSERTBillVote ('5','Franklyn', 'Witter' ,'Undetermined');


CALL INSERTBillVote ('6','Delroy','Chuck','Undetermined');
CALL INSERTBillVote ('6','Andrew','Holness','Undetermined');
CALL INSERTBillVote ('6','Horace','Chang','Undetermined');
CALL INSERTBillVote ('6','Pearnel','Charles','Undetermined');
CALL INSERTBillVote ('6','Rudyard','Spencer','Undetermined');
CALL INSERTBillVote ('6','Daryl','Vaz','Undetermined');
CALL INSERTBillVote ('6','Shahine','Robinson','Undetermined');
CALL INSERTBillVote ('6','Joseph','Hibbert','Undetermined');
CALL INSERTBillVote ('6','Andrew','Gallimore','Undetermined');
CALL INSERTBillVote ('6','Omar','Davies','Undetermined');
CALL INSERTBillVote ('6','Morais','Guy','Undetermined');
CALL INSERTBillVote ('6','Lisa','Hanna','Undetermined');
-- CALL INSERTBillVote ('6','Floyd Emerson','Morris','Undetermined');--First Initial was E, but I found Floyd Emerson for the first name
CALL INSERTBillVote ('6','Ian','Hayles','Undetermined');
CALL INSERTBillVote ('6','Sharon','Hay-Webster','Undetermined');
CALL INSERTBillVote ('6','Anthony','Hylton','Undetermined');
CALL INSERTBillVote ('6','Derrick','Kellier','Undetermined');
CALL INSERTBillVote ('6','Clive','Mullings','Undetermined');
CALL INSERTBillVote ('6','Phillip','Paulwell','Undetermined');
CALL INSERTBillVote ('6','Michael','Peart','Undetermined');
CALL INSERTBillVote ('6','Tarn','Peralto','Undetermined');
CALL INSERTBillVote ('6','Peter','Phillips','Undetermined');
CALL INSERTBillVote ('6','Donald','Rhodd','Undetermined');
CALL INSERTBillVote ('6','Derrick','Smith','Undetermined');
CALL INSERTBillVote ('6','Ronald','Thwaites','Undetermined');
CALL INSERTBillVote ('6','Franklyn','Witter','Undetermined');


CALL INSERTBillVote ('7','Andrew','Holness','Undetermined');
CALL INSERTBillVote ('7','Bruce','Golding','Undetermined');
CALL INSERTBillVote ('7','Karl','Samuda','Undetermined');
CALL INSERTBillVote ('7','Horace','Chang','Undetermined');
CALL INSERTBillVote ('7','Pearnel','Charles','Undetermined');
CALL INSERTBillVote ('7','Olivia','Grange','Undetermined');
CALL INSERTBillVote ('7','Lester','Henry','Undetermined');
CALL INSERTBillVote ('7','Edmund','Bartlett','Undetermined');
CALL INSERTBillVote ('7','Shahine','Robinson','Undetermined');
CALL INSERTBillVote ('7','Andrew','Gallimore','Undetermined');
CALL INSERTBillVote ('7','St. Aubyn','Bartlett','Undetermined');
CALL INSERTBillVote ('7','Luther','Buchanan','Undetermined');
CALL INSERTBillVote ('7','Peter','Bunting','Undetermined');
CALL INSERTBillVote ('7','Fenton','Ferguson','Undetermined');
CALL INSERTBillVote ('7','Morais','Guy','Undetermined');
CALL INSERTBillVote ('7','Lisa','Hanna','Undetermined');
-- CALL INSERTBillVote ('7','Floyd Emerson','Morris','Undetermined');--First Initial was E, but I found Floyd Emerson for the first name
CALL INSERTBillVote ('7','Ian','Hayles','Undetermined');
CALL INSERTBillVote ('7','Maxine','Henry-Wilson','Undetermined');
CALL INSERTBillVote ('7','Joseph','Hibbert','Undetermined');
CALL INSERTBillVote ('7','Fitz','Jackson','Undetermined');
CALL INSERTBillVote ('7','Derrick','Kellier','Undetermined');
CALL INSERTBillVote ('7','Desmond','Mair','Undetermined');
CALL INSERTBillVote ('7','Kenneth','Mcneil','Undetermined');
CALL INSERTBillVote ('7','Phillip','Paulwell','Undetermined');
CALL INSERTBillVote ('7','Michael','Peart','Undetermined');
CALL INSERTBillVote ('7','Tarn','Peralto','Undetermined');
CALL INSERTBillVote ('7','Dean','Peart','Undetermined');
CALL INSERTBillVote ('7','Peter','Phillips','Undetermined');
CALL INSERTBillVote ('7','Robert','Pickersgill','Undetermined');
CALL INSERTBillVote ('7','Ernest','Smith','Undetermined');
CALL INSERTBillVote ('7','Michael','Stern','Undetermined');
CALL INSERTBillVote ('7','Ronald','Thwaites','Undetermined');


CALL INSERTBillVote ('8','Marisa','Dalrymple-Philbert','Undetermined');
CALL INSERTBillVote ('8','Andrew','Holness','Undetermined');
CALL INSERTBillVote ('8','Pearnel','Charles','Undetermined');
CALL INSERTBillVote ('8','Christopher','Tufton','Undetermined');
CALL INSERTBillVote ('8','James','Robertson','Undetermined');
CALL INSERTBillVote ('8','William','Hutchinson','Undetermined');
CALL INSERTBillVote ('8','Clifford','Warmington','Undetermined');
CALL INSERTBillVote ('8','Noel','Arscott','Undetermined');
CALL INSERTBillVote ('8','St. Aubyn','Bartlett','Undetermined');
CALL INSERTBillVote ('8','Peter','Bunting','Undetermined');
CALL INSERTBillVote ('8','Roger','Clarke','Undetermined');
CALL INSERTBillVote ('8','Omar','Davies','Undetermined');
CALL INSERTBillVote ('8','Colin','Fagan','Undetermined');
CALL INSERTBillVote ('8','Morais','Guy','Undetermined');
-- CALL INSERTBillVote ('8','E','Harris','Undetermined');
CALL INSERTBillVote ('8','Ian','Hayles','Undetermined');
CALL INSERTBillVote ('8','Maxine','Henry-Wilson','Undetermined');
CALL INSERTBillVote ('8','Fitz','Jackson','Undetermined');
CALL INSERTBillVote ('8','Derrick','Kellier','Undetermined');
CALL INSERTBillVote ('8','Desmond','Mair','Undetermined');
CALL INSERTBillVote ('8','Natalie','Neita-Headley','Undetermined');
CALL INSERTBillVote ('8','Phillip','Paulwell','Undetermined');
CALL INSERTBillVote ('8','Michael','Peart','Undetermined');
CALL INSERTBillVote ('8','Peter','Phillips','Undetermined');
CALL INSERTBillVote ('8','Robert','Pickersgill','Undetermined');
CALL INSERTBillVote ('8','Donald','Rhodd','Undetermined');
CALL INSERTBillVote ('8','Portia','Simpson-Miller','Undetermined');
CALL INSERTBillVote ('8','Ernest','Smith','Undetermined');
CALL INSERTBillVote ('8','Michael','Stern','Undetermined');
CALL INSERTBillVote ('8','Ronald','Thwaites','Undetermined');


CALL INSERTBillVote ('9','Audley','Shaw','Undetermined');
CALL INSERTBillVote ('9','Andrew','Holness','Undetermined');
CALL INSERTBillVote ('9','Pearnel','Charles','Undetermined');
CALL INSERTBillVote ('9','Karl','Samuda','Undetermined');
CALL INSERTBillVote ('9','Horace','Chang','Undetermined');
CALL INSERTBillVote ('9','Daryl','Vaz','Undetermined');
CALL INSERTBillVote ('9','Shahine','Robinson','Undetermined');
CALL INSERTBillVote ('9','William','Hutchinson','Undetermined');
CALL INSERTBillVote ('9','Clifford','Warmington','Undetermined');
CALL INSERTBillVote ('9','Andrew','Gallimore','Undetermined');
CALL INSERTBillVote ('9','Laurence','Broderick','Undetermined');
CALL INSERTBillVote ('9','Robert','Montague','Undetermined');
CALL INSERTBillVote ('9','Noel','Arscott','Undetermined');
CALL INSERTBillVote ('9','St. Aubyn','Bartlett','Undetermined');
CALL INSERTBillVote ('9','Luther','Buchanan','Undetermined');
CALL INSERTBillVote ('9','Omar','Davies','Undetermined');
CALL INSERTBillVote ('9','Colin','Fagan','Undetermined');
CALL INSERTBillVote ('9','Morais','Guy','Undetermined');
CALL INSERTBillVote ('9','Lisa','Hanna','Undetermined');
CALL INSERTBillVote ('9','Ian','Hayles','Undetermined');
CALL INSERTBillVote ('9','Sharon','Hay-Webster','Undetermined');
CALL INSERTBillVote ('9','Fitz','Jackson','Undetermined');
CALL INSERTBillVote ('9','Derrick','Kellier','Undetermined');
CALL INSERTBillVote ('9','Desmond','Mair','Undetermined');
CALL INSERTBillVote ('9','Phillip','Paulwell','Undetermined');
CALL INSERTBillVote ('9','Michael','Peart','Undetermined');
CALL INSERTBillVote ('9','Dean','Peart','Undetermined');
CALL INSERTBillVote ('9','Tarn','Peralto','Undetermined');
CALL INSERTBillVote ('9','Peter','Phillips','Undetermined');
CALL INSERTBillVote ('9','Donald','Rhodd','Undetermined');
CALL INSERTBillVote ('9','Portia','Simpson-Miller','Undetermined');
CALL INSERTBillVote ('9','Michael','Stern','Undetermined');
CALL INSERTBillVote ('9','Ronald','Thwaites','Undetermined');


CALL INSERTBillVote ('10','Andrew', 'Holness' ,'Undetermined');
CALL INSERTBillVote ('10','Bruce', 'Golding' ,'Undetermined');
CALL INSERTBillVote ('10','Horace', 'Chang' ,'Undetermined');
CALL INSERTBillVote ('10','Pearnel', 'Charles' ,'Undetermined');
CALL INSERTBillVote ('10','Olivia', 'Grange' ,'Undetermined');
CALL INSERTBillVote ('10','Lester', 'Henry' ,'Undetermined');
CALL INSERTBillVote ('10','Edmund', 'Bartlett' ,'Undetermined');
CALL INSERTBillVote ('10','Shahine', 'Robinson' ,'Undetermined');
CALL INSERTBillVote ('10','Andrew', 'Gallimore' ,'Undetermined');
CALL INSERTBillVote ('10','St. Aubyn', 'Bartlett' ,'Undetermined');
CALL INSERTBillVote ('10','Peter', 'Bunting' ,'Undetermined');
CALL INSERTBillVote ('10','Fenton', 'Ferguson' ,'Undetermined');
CALL INSERTBillVote ('10','Morais', 'Guy' ,'Undetermined');
CALL INSERTBillVote ('10','Lisa', 'Hanna' ,'Undetermined');
-- CALL INSERTBillVote ('10','E', 'Harris' ,'Undetermined');
CALL INSERTBillVote ('10','Ian', 'Hayles' ,'Undetermined');
CALL INSERTBillVote ('10','Maxine', 'Henry-Wilson' ,'Undetermined');
CALL INSERTBillVote ('10','Joseph', 'Hibbert' ,'Undetermined');
CALL INSERTBillVote ('10','Fitz', 'Jackson' ,'Undetermined');
CALL INSERTBillVote ('10','Derrick', 'Kellier' ,'Undetermined');
CALL INSERTBillVote ('10','Desmond', 'Mair' ,'Undetermined');
CALL INSERTBillVote ('10','Kenneth', 'McNeil' ,'Undetermined');
CALL INSERTBillVote ('10','Phillip', 'Paulwell' ,'Undetermined');
CALL INSERTBillVote ('10','Michael', 'Peart' ,'Undetermined');
CALL INSERTBillVote ('10','Dean', 'Peart' ,'Undetermined');
CALL INSERTBillVote ('10','Tarn', 'Peralto' ,'Undetermined');
CALL INSERTBillVote ('10','Peter', 'Phillips' ,'Undetermined');
CALL INSERTBillVote ('10','Robert', 'Pickersgill' ,'Undetermined');
CALL INSERTBillVote ('10','Ernest', 'Smith' ,'Undetermined');
CALL INSERTBillVote ('10','Michael', 'Stern' ,'Undetermined');
CALL INSERTBillVote ('10','Ronald', 'Thwaites' ,'Undetermined');



DELIMITER //
CREATE PROCEDURE INSERTAct
	( 
		IN p_actId int, 
        IN p_dateofassent datetime,
		IN p_dateofact datetime, 
		IN p_comeintooperation varchar(2),
        IN p_actlocation varchar(250)           
     )
BEGIN 
	
    INSERT INTO Acts (ActId,DateofAssent,DateofAct,ComeintoOperation,ActLocation)
    VALUES (p_actId,p_dateofassent,p_dateofact,p_comeintooperation,p_actlocation); 

END;  
//


DELIMITER ;

CALL INSERTAct ('1','2009-12-12','2009-12-12',NULL,NULL);
CALL INSERTAct ('2','2009-10-20','2009-12-12',NULL,'www.japarliament.gov.jm/attachments/341_The%20Sexual%20Offences%20Act,%202009.pdf');
CALL INSERTAct ('3','2009-08-13','2009-08-14',NULL,'www.japarliament.gov.jm/attachments/341_The%20Factories%20(Amendment)%20Act,%202009.pdf');
CALL INSERTAct ('4','2009-05-29','2009-05-29',NULL,'www.moj.gov.jm/sites/default/files/laws/sunset%20acts/The%20Appropriation%20Act%202009.pdf');
CALL INSERTAct ('5','2009-08-24','2009-08-25',NULL,'www.japarliament.gov.jm/attachments/341_The%20Income%20Tax%20(Validation%20and%20Amendment)%20Act,%202009.pdf');
CALL INSERTAct ('6','2009-10-12','2009-10-12',NULL,'www.japarliament.gov.jm/attachments/341_The%20Trade%20(Amendment)%20Act,%202009.pdf');
CALL INSERTAct ('7','2009-12-10','2009-12-11',NULL,'www.japarliament.gov.jm/attachments/341_The%20Bank%20of%20Jamaica%20(Amendment)%20Act,%202009.pdf');
CALL INSERTAct ('8','2009-10-20','2009-12-12',NULL,'www.japarliament.gov.jm/attachments/341_The%20Holidays%20With%20Pay%20(Amendment)%20Act,%202009.pdf');
CALL INSERTAct ('9','2009-10-20','2009-10-21',NULL,'www.japarliament.gov.jm/attachments/341_The%20Child%20Pornography%20Act.pdf');
CALL INSERTAct ('10','2009-12-29','2009-12-30',NULL,'www.japarliament.gov.jm/attachments/341_The%20Registration%20%28Strata%20Titles%29%20%28Amendment%29%20Act,%202009.pdf');






/*
SELECT * FROM Constituencymps WHERE CONSTITUENCYID = 'FC8DBD3943ED';


SELECT ConstituencyMPs.DateElected, ConstituencyMPs.DateRemoved, Politicians.PoliticianId, Titles.Title, Politicians.FirstName,Politicians.LastName
FROM Constituencies 
INNER JOIN ConstituencyMps ON Constituencies.ConstituencyId=ConstituencyMPs.ConstituencyId
LEFT JOIN Politicians ON ConstituencyMps.MpId=Politicians.PoliticianId
INNER JOIN Titles on Politicians.TitleId=Titles.TitleId;


DELIMITER //
CREATE PROCEDURE CURSORPoliticianImage()
BEGIN
  -- DECLARE done INT DEFAULT FALSE;
  DECLARE a varCHAR(150);
  DECLARE b, c varchar(25);
  DECLARE cursor1 CURSOR FOR SELECT FirstName,LastName FROM Politicians;
	a=;;
  -- DECLARE cur2 CURSOR FOR SELECT i FROM test.t2;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  OPEN cur1;
  -- OPEN cur2;

  read_loop: LOOP
    FETCH cursor1 INTO a, b;
    UPDATE Politicians
	SET ImageLocation = a+b;
    IF done THEN
      LEAVE read_loop;
    END IF;
    
  END LOOP;

  CLOSE cur1;
  -- CLOSE cur2;
END;
//

-- select * from politicians
SELECT * FROM Politicians WHERE RoleId = '1' OR '3' ORDER BY FirstName ASC
update constituencymps
set dateelected = '2012-01-17'
*/