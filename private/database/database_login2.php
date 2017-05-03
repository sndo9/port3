<?php
/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 3/30/17
 * Time: 1:22 PM
 */

$host_name  = "db680204869.db.1and1.com";
$database   = "db680204869";
$user_name  = "dbo680204869";
$password   = "Stjps3skwQfGlZO5";

$connect = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
