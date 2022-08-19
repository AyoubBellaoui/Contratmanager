<?php
# Connection to Database
define('DB_SERVER', 'localhost');
define('DB_username','root');
define('DB_PASSWORD','');
define('DB_NAME','cg_db');

$db = mysqli_connect(DB_SERVER,DB_username,DB_PASSWORD,DB_NAME);

if ($db === FALSE) {

    die("Not Connected To DB, Check your connection " . mysqli_connect_error());

}
?>