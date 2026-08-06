# Campus Events Hub

A simple university project built with HTML5, CSS3, procedural PHP, MySQL, and MySQLi prepared statements.

## 1. Place the project in XAMPP

### Windows
1. Install and open XAMPP.
2. Copy the `campus-events-hub` folder into `C:\xampp\htdocs\`.
3. Start **Apache** and **MySQL** from the XAMPP Control Panel.

### macOS
1. Install XAMPP.
2. Copy the folder into `/Applications/XAMPP/xamppfiles/htdocs/`.
3. Start Apache and MySQL from XAMPP Manager.

## 2. Import the database

1. Open `http://localhost/phpmyadmin/`.
2. Select the **Import** tab.
3. Choose `database/campus_events_hub.sql`.
4. Click **Import** or **Go**.
5. Confirm that the `campus_events_hub` database contains `events`, `registrations`, and `contact_messages`.

The default connection in `http://localhost/campus-events-hub/` is:

```php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'campus_events_hub';
```

Change these values only when your MySQL installation uses different credentials.

## 3. Open the website

Visit:

`http://localhost/campus-events-hub/`

