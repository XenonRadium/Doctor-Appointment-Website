<?php
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DB', 'iwd');

$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
        
die ('Unable to connect. Check your connection parameters.');

mysqli_select_db($db, MYSQL_DB) or die(mysqli_error($db));