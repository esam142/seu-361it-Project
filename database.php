<?php
// Default XAMPP database settings.
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'campus_events_hub_5';
$database = 'campus_events_hub';
$conn = @new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    exit('We could not connect to the website database. Please confirm that MySQL is running and the database has been imported.');
}

if (!$conn->set_charset('utf8mb4')) {
    http_response_code(500);
    exit('The database character set could not be configured.');
}
