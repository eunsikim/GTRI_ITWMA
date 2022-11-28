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
To create/update all tables, run the following command at root directory:
```
./vendor/bin/phinx migrate

```

### Create a new migration
- To create a new migration file, run the command "vendor/bin/phinx create 'NameOfNewMigrationFile'" (The name of the file has to be in CamelCase format)
- Select the path you are creating the migration for.

### Useful migration commands
- To run a migration, run the command "./vendor/bin/phinx migrate"
- To reverse a migration, tun the command "./vendor/bin/phinx rollback"

### Setting up the .env file
The .env file should contain an app name, mysql server information and user type (this will be temporary) using this format:
```
APP_NAME='Name of the application'

# Database mode
DB_MODE=development

# Production Database
DB_SERVER=DatabaseAddressWithPort
DB_HOST=DatabaseAddress
DB_PORT=DatabasePort 
DB_USERNAME=Username
DB_PASSWORD=Password
DB_NAME=DabaseName

# Development Database
DB_SERVER_DEV=DatabaseAddressWithPort
DB_HOST_DEV=DatabaseAddress
DB_PORT_DEV=DatabasePort 
DB_USERNAME_DEV=Username
DB_PASSWORD_DEV=Password
DB_NAME_DEV=DabaseName

# Temporary user type value: 1 = admin, 2 = user 
USER_TYPE=1


```
