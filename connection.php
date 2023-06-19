<?php
// Establish the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registerinfo";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if($conn)
{
    echo "Connection Successful";
}
else
{
    echo "Connection Failed";
}