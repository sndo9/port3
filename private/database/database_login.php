<?php
/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 3/30/17
 * Time: 1:22 PM
 */

$host_name  = "127.0.0.1";
$database   = "port3";
$user_name  = "319";
$password   = "Stjps3skwQfGlZO5";

$connect = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
