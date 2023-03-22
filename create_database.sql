/* 
Written to create the database and all of the necessary tables
and data that should be added.

This script should be run by the root user of a database.
*/
CREATE DATABASE IF NOT EXISTS G20973951_CO2717;
USE G20973951_CO2717;

/*
Create tables to hold data
*/

CREATE TABLE IF NOT EXISTS Users (
    UserId int NOT NULL AUTO_INCREMENT,
    Email varchar(50) NOT NULL,
    Password varchar(255) NOT NULL, -- The password has an extended maximum length for hashing and security reasons.
    Firstname varchar(20) NOT NULL,
    Lastname varchar(20) NOT NULL,
    Address varchar(255) NOT NULL,
    DateOfBirth date NOT NULL, -- The date of birth will be checked on the web page to make sure users are above a certain age when making an account
    PrivilegeLevel int NOT NULL DEFAULT 1 CHECK (PrivilegeLevel >= 1 AND PrivilegeLevel <= 6),
    PRIMARY KEY ( UserId )
);

/* 
Create new *database* users, which will be used alongside
the multi-level user access. These will ensure that different
users have different permissions (such as not being able to)
drop tables.
*/

-- Base users, this is for very basic database interactions only. This user will not be permitted to delete data.
CREATE USER IF NOT EXISTS 'G20973951_CO2717_user'@'localhost' IDENTIFIED BY 'db_usr_pwd_Pa55word';
GRANT SELECT, INSERT ON G20973951_CO2717.Users TO 'G20973951_CO2717_user'@'localhost' WITH GRANT OPTION;

-- Junior golfers
CREATE USER IF NOT EXISTS 'G20973951_CO2717_junior_member'@'localhost' IDENTIFIED BY 'db_usr_pwd_Pa55word';

-- Social members (non-playing)
CREATE USER IF NOT EXISTS 'G20973951_CO2717_social_member'@'localhost' IDENTIFIED BY 'db_usr_pwd_Pa55word';

-- Full playing members
CREATE USER IF NOT EXISTS 'G20973951_CO2717_full_member'@'localhost' IDENTIFIED BY 'db_usr_pwd_Pa55word';

-- Staff
CREATE USER IF NOT EXISTS 'G20973951_CO2717_staff'@'localhost' IDENTIFIED BY 'db_usr_pwd_Pa55word';

-- Admin
CREATE USER IF NOT EXISTS 'G20973951_CO2717_admin'@'localhost' IDENTIFIED BY 'db_usr_pwd_Pa55word';
GRANT ALL PRIVILEGES ON G20973951_CO2717.* TO 'G20973951_CO2717_admin'@'localhost' WITH GRANT OPTION;