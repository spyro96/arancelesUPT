<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "test";
$database_name = "star_rating";

// Get connection object and set the charset
$conn = mysqli_connect($host, $username, $password, $database_name);
$conn->set_charset("utf8mb4");

// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

// Generate SQL script for creating the table structure and dumping data into the table
$sqlScript = "";
foreach ($tables as $table) {
    $sqlScript .= "DROP TABLE IF EXISTS `$table`;\n";
    $sqlScript .= "CREATE TABLE `$table` (\n";
    $result = mysqli_query($conn, "SHOW CREATE TABLE `$table`");
    while ($row = mysqli_fetch_assoc($result)) {
        $sqlScript .= $row["Create Table"] . ";\n\n";
    }
    $sqlScript .= "INSERT INTO  $table ( implode(', ', array_keys(mysqli_fetch_assoc(mysqli_query($conn, SELECT * FROM $table LIMIT 1"))).) VALUES\n;
    $result = mysqli_query($conn, "SELECT * FROM `$table`");
    while ($row = mysqli_fetch_assoc($result)) {
        $sqlScript .= "(";
        $sqlScript .= "'" . implode("','", array_values($row)) . "'),\n";
    }
    $sqlScript = rtrim($sqlScript, ",\n") . ";\n\n";
}

// Save the SQL script to a backup file
$backup_file_name = $database_name . '_backup_' . time() . '.sql';
$fileHandler = fopen($backup_file_name, 'w+');
$number_of_lines = fwrite($fileHandler, $sqlScript);
fclose($fileHandler);

// Download the SQL backup file to the browser
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
header('Content-Tran output the script containing only dumping table data:
There may be cases when you need to export the database or table structure without data. To get that done, run the command with the -no-data parameter.');
