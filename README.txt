Project: booking_resort
PHP Version: 8.1 compatible (uses PDO)
How to use:
1. Copy the folder 'booking_resort' to your XAMPP htdocs (e.g. C:\xampp\htdocs\booking_resort).
2. Import the SQL file 'resort_db.sql' into MySQL (phpMyAdmin) or run:
   mysql -u root -p < resort_db.sql
   (default XAMPP: user=root no password)
3. Edit includes/db.php if your DB credentials differ.
4. Start Apache & MySQL in XAMPP, then open: http://localhost/booking_resort/
Default admin account (created by SQL):
   email: admin@resort.com
   password: admin123
Notes:
 - This package is a starting full-stack template. You can extend features as needed.
 - Files use PDO and prepared statements (safe for PHP 8.1).
