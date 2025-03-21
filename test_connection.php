 
<?php
include 'db_connect.php';

if ($conn) {
    echo "Connected to MySQL successfully!";
} else {
    echo "Connection failed!";
}
?>
