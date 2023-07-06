# blog-php

Require : PHP 8.1 web server and Composer  

Clone Github repository to web server  

Create database with utf8mb4_bin encoding  
Import the bdd.sql file from the /config folder into your database  

Duplicate and rename the database-example.php file from the /config folder to database.php in the same folder  
Open the database.php file in an editor and fill in your database connection information in the file  

Open a command prompt  
Go to the root directory of the repository  
Type "composer install" command to install website dependencies  

Start your webserver  
Go to the website with a web browser  

Go to the register page to create a user  
Open the send by mail link to confirm the user's registration  
Change the role column of the users table in the database to the value "2" to give you the role of administrator  

Role :  
 - 0 = The user did not confirm his registration by email  
 - 1 = The user to confirm his registration by email  
 - 2 = The user is an administrator  

With the administrator role you now have access to the dashboard in the footer menu
