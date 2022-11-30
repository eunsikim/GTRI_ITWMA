#Red Pepper IT
## Installation
### Pre-requisites
- PHP 8.1.10
- MySQL 5.7.36
- Composer
- APACHE 2.4.51

### Setting up the environment
1. After cloning the repo, set up a virtual host to its root directory.
2. Open the terminal on the root directory and run the command "composer install".
3. After composer has done installing the packages, create a environmental variables files called ".env".
4. Copy and paste the contents from .env.example into the newly create .env file.
5. Modify the required values in the .env file.
6. Create a MySQL database and add the name of the database in the .env file (DB_NAME=...)
7. Migrate the initial tables with the following command:
```
vendor/bin/phinx migrate
```
8. After these steps are done, the user should be able to start the server.

### Developing a module
1. Create a new folder under the "modules" folder. The name of the folder shoul not have spaces.
2. Inside the newly create folder, create four new folders inside called:
- controllers
- dashboard
- migrations
- views
3. Create a app.json file. Inside it should provide the name of the module, the name of the module's folder, its directory path, its dashboard path (both view and controller), path of the module's view, and path to its migration folder. For refernece check either License_Tracking or sampleApp.
4. Naming scheme is important. The controller file and view file should have the same name, example License_Tracking.php inside the controllers folder and License_Tracking.html inside the views folder. Furthermore, the name of these files should match with the module's folder name.
5. For the dasboard, the name for both the controller and view should start with the name of the module's folder name follower by 'Dash'. For example: License_TrackingDash.html and License_TrackingDash.php.
6. After these folders and files are setup, the user should be able to start developing the module. If the module that it is being developed requires to store data into the database follow the next steps to create a migration file

### Create a new migration
1. To create a new migration file, run the command "vendor/bin/phinx create 'NameOfNewMigrationFile'" (The name of the file has to be in CamelCase format)
2. Select the path you are creating the migration for.

### Useful migration commands
- To run a migration, run the command "./vendor/bin/phinx migrate"
- To reverse a migration, run the command "./vendor/bin/phinx rollback"

```
