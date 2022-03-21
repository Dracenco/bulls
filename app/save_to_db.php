<?php
$servername = "localhost";
$username = "root";
$password = "";
$table = "user_logs";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if database exists. if not, create one
if(!$conn->select_db('bulls_logs')){
    $createDbSql = 'CREATE Database bulls_logs';
    if (!$conn->query($createDbSql)) {
        die("Error message: \n". $conn->error);
    }
    $conn->select_db('bulls_logs');
}

// Check if table exists. if not, create one
$tableExists = $conn->query("SHOW TABLES LIKE '$table'");

if (!$tableExists || !$tableExists->num_rows) {
    $createTableSql = "CREATE TABLE $table (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        time DATETIME NOT NULL,
                        button_id INT NOT NULL,
                        user_ip VARCHAR(46)
                        )";
    if (!$conn->query($createTableSql)) {
        die("Error message: \n". $conn->error);
    }
}

//insert logs data into table.
$userIpFiltered = $conn->real_escape_string($userIp);
$insertLogsSql = "INSERT INTO $table (time, button_id, user_ip) VALUES ('$date $time', $buttonId, '$userIpFiltered')";

if(!$conn->query($insertLogsSql)){
    die("Error message: \n Data Not Saved \n". $conn->error);
}




