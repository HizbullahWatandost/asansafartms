CREATE TABLE IF NOT EXISTS client(
  clientId int(10) not null PRIMARY KEY AUTO_INCREMENT,
  clientFullName VARCHAR(50) NOT NULL,
  clientEmail VARCHAR(50) NOT NULL UNIQUE,
  clientMobile VARCHAR(20) NOT NULL,
  clientPermenantAddress VARCHAR(30) NOT NULL,
  clientCurrentAddress VARCHAR(30) NOT NULL,
  clientPassword VARCHAR(50) NOT NULL,
  clientRegisterDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  clientUserModificationDate DATETIME ON UPDATE CURRENT_TIMESTAMP,
  clientStatus INT NOT NULL DEFAULT '1')



CREATE TABLE IF NOT EXISTS websiteAbout(about VARCHAR(3000) NOT NULL)

CREATE TABLE IF NOT EXISTS clientFeedback(id int(2) NOT NULL PRIMARY KEY AUTO_INCREMENT, question VARCHAR(300) NOT NULL, optionA VARCHAR(100) NOT NULL, optionB VARCHAR(100) NOT NULL, optionC VARCHAR(100) NOT NULL, optionD VARCHAR(100) NOT NULL);

CREATE TABLE IF NOT EXISTS contactUs(address VARCHAR(150) NOT NULL, email VARCHAR(100) NOT NULL, contactNoOne VARCHAR(25) NOT NULL, contactNoTwo VARCHAR(25) NOT NULL, webShortDesc VARCHAR(500) NOT NULL, domainName VARCHAR(50) NOT NULL)

CREATE TABLE IF NOT EXISTS logging (logId int(10) PRIMARY KEY AUTO_INCREMENT,userName varchar(50), userType VARCHAR(50), activityType VARCHAR(100), logMsg varchar(300), logDatetime DATETIME DEFAULT CURRENT_TIMESTAMP)

CREATE TABLE IF NOT EXISTS vehicleowner(
  ownerId int(10) not null PRIMARY KEY AUTO_INCREMENT,
  ownerFullName VARCHAR(50) NOT NULL,
  ownerEmail VARCHAR(50) NOT NULL UNIQUE,
  ownertMobile VARCHAR(20) NOT NULL,
  ownerRegisterDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  onwerTazkira VARCHAR(200),
  gurantorDetails VARCHAR(300),
  gurantorTazkira VARCHAR(200))

  CREATE TABLE IF  NOT EXISTS route(routeId int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                  placeName VARCHAR(50) NOT NULL UNIQUE);


  CREATE TABLE IF NOT EXISTS vehicle(
      vehicleId int(10) not null PRIMARY KEY AUTO_INCREMENT,
      vehiclePlanteNo VARCHAR(20) NOT NULL UNIQUE,
      vehicleType VARCHAR(20) NOT NULL,
      numberOfSets int(2) NOT NULL,
      comnSrcPlace VARCHAR(50) NOT NULL,
      comnDestPlace VARCHAR(50) NOT NULL,
      vehicleImg VARCHAR(150),
      travelAgencyDetails VARCHAR(250),
      driverDetails VARCHAR(200),
      cleanerDetails VARCHAR(200),
      ownerId int(50) NOT NULL,
      FOREIGN KEY(ownerId) REFERENCES vehicleowner(ownerId));


    CREATE TABLE IF NOT EXISTS ticket(ticketId int(10) not  null primary key AUTO_INCREMENT,
        srcPlacce varchar(50) not null,
        destPlace varchar(50) not null,
        distance INT(3),
        departureDate VARCHAR(20) NOT NULL,
        arrivalDate VARCHAR(20) NOT NULL,
        departureTime VARCHAR(20) NOT NULL,
        arrivalTime VARCHAR(20) NOT NULL,
        vehicleId int(50) not null,
        setNo int(2) not null,
        price varchar(10) not null,
        discount int(2) not null,
        status int(1) default 0,
        bookingDate DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(vehicleId) REFERENCES vehicle(vehicleId));

CREATE TABLE IF NOT EXISTS membership(vehicleId int(5), memberShipFee varchar(5) NOT NULL, status int(1) default 0);

CREATE TABLE IF NOT EXISTS dailyIncome(ticketId int(15) not null,
       ticketPrice VARCHAR(5) NOT NULL,
       ourShare int(3) not null,
       clientId int(10) not null,
       bookingDate DATETIME DEFAULT CURRENT_TIMESTAMP,
       status int(1) default 1,
       FOREIGN KEY(ticketId) REFERENCES ticket(ticketId),
       FOREIGN KEY(clientId) REFERENCES client(clientId));

create table if not exists membership(membershipId int(10) primary key AUTO_INCREMENT,
  agencyId int(10),
  agentFullName varchar(100) not null,
  membershipDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  agencyAddress varchar(200) not null,
  totalNoOfVehicles int(20) not null,
  vehiclesDescription varchar(300) not null,
  membershipFee int(10) not null,
  paidAmount int(10) not null,
  remainingAmount int(10),
  contractFileName varchar(200) not null,
  FOREIGN key(agencyId) REFERENCES vehicleowner(ownerId));

  create table if not EXISTS feedbackcollections (feedbackId int(5) PRIMARY KEY AUTO_INCREMENT,
                                                clientId int(10),
                                                question1 varchar(150),
                                                answer1 varchar(100),
                                                question2 varchar(150),
                                                answer2 varchar(100),
                                                question3 varchar(150),
                                                answer3 varchar(100),
                                                question4 varchar(150),
                                                answer4 varchar(100),
                                                suggestion varchar(300),
                                                customerFullName varchar(100),
                                                customerAddress varchar(100),
                                                customerMobileNumber varchar(100),
                                                customerEmail varchar(100),
                                                FOREIGN KEY(clientID) REFERENCES client(clienId));

CREATE TABLE IF NOT EXISTS operator(operatorId int(10) PRIMARY key AUTO_INCREMENT,
 operatorFullName varchar(100) not null, operatorEmail varchar(50) not null unique,
 operatorMobile varchar(20) not null UNIQUE,
 operatorPassword varchar(30) not null,
 operatorRegisterDate DATETIME DEFAULT CURRENT_TIMESTAMP,
 operatorUserModificationDate DATETIME ON UPDATE CURRENT_TIMESTAMP,
 operatorStatus INT NOT NULL DEFAULT '1');
