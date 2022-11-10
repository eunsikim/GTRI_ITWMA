# GTRI: IT Web Management Application
## Installation
### Pre-requisites
- PHP 8.1.10
- MySQL 5.7.36
- Composer
- APACHE 2.4.51

### Setting up the environment
1. After cloning the repo, set up a virtual host to its root directory.
2. Open the terminal on the root directory and run the command "composer install".
3. After composer has done installing the packages, create a environmental variables files called ".env" (no name, just ".env").
4. Copy and paste the contents from .env.example into the newly create .env file.
5. Modify the required values in the .env file.
6. Create a MySQL database and add the name of the database in the .env file (DB_NAME=...)
7. Add a users table in that database (use query below)

### Setting up the users table
As of 11/10/2022, this is the query for creating the users table:
```
CREATE TABLE users (
    id          CHAR(36) PRIMARY KEY,
    firstName   VARCHAR(50) NOT NULL,
    lastName    VARCHAR(50) NOT NULL,
    userID      VARCHAR(50) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        ENUM('0','1') NOT NULL DEFAULT '0',
    question1   VARCHAR(50) NOT NULL,
    question2   VARCHAR(50) NOT NULL,
    question3   VARCHAR(50) NOT NULL,
)
```
To add the new columns to users, run this query:
```
ALTER TABLE users
    ADD question1   VARCHAR(50) NOT NULL,
    ADD question2   VARCHAR(50) NOT NULL,
    ADD question3   VARCHAR(50) NOT NULL;
```
Change Role Column to Approved
```
UPDATE users
    ALTER TABLE users 
        CHANGE role approved ENUM('0','1') NOT NULL DEFAULT '0';
```


### Setting up the .env file
The .env file should contain an app name, mysql server information and user type (this will be temporary) using this format:
```
APP_NAME='GTRI: IT Web Management Application'

DB_SERVER=mysqlServerName
DB_USERNAME=yourUsername
DB_PASSWORD=yourPassword
DB_NAME=databaseName

# Temporary user type value: 1 = admin, 2 = user 
USER_TYPE=1
```
