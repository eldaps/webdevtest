PHP 8.0.9 was used for development & testing (mysqli enabled in php.ini)

To run the project locally, edit MySQL database credentials in db.php, create a table using the query in _SQL.txt,
then run __SERVER.bat (or open terminal and run command "php -S localhost:80" in this directory)
and visit localhost/index.php, localhost/mobile.php, localhost/admin.php in any browser.


Below is a brief description of each file

__SERVER.bat - Starts a PHP development server on port 80

index.php - Webpage (PC version, mobile devices redirected to mobile.php)
mobile.php - Webpage (Mobile version)
admin.php - Task 3 admin page, for viewing/exporting/deleting saved data

db.php - MySQL connection credentials and DB/table name
export.php - Handles export to CSV and delete requests
subscribe.php - Contains server-side validation, handles AJAX requests and is included in index.php and mobile.php
styles.css - CSS file with styles for PC and mobile versions
validation.js - Contains client-side validation and makes the page work without reloading it from server

Mobile_Detect.php - External library to detect mobile devices (redirect from index.php to mobile.php)
jquery.js - Used to send AJAX requests to server

_NOTES.txt - Additional notes about the given tasks and how I implemented them.
_SQL.txt - SQL query for creating a table to store entered data.

images - all images are stored here.