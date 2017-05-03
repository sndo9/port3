<?php
/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 5/2/17
 * Time: 2:51 PM
 */

session_start();
require_once('../../private/includes/ajax_requires.php');

$action = $_REQUEST["action"];
$userName = $_REQUEST["userName"];
$password = $_REQUEST["password"];

if($userName == "" || $password == ""){
    echo "Fields cannot be empty.";
    exit();
}

//print_r2($_REQUEST);

if($action == "login"){

    if($_REQUEST["status"] == "Seller"){
        $query = "SELECT * FROM seller WHERE userName = \"$userName\"";
        $ret = mysqli_query($connect, $query);
        echo mysqli_error($connect);
        $entry = mysqli_fetch_assoc($ret);
        if(password_verify($_REQUEST["password"], $entry["password"])){
            $_SESSION["user"] = $entry["userName"];
            $_SESSION["auth"] = 1;
            $_SESSION["sellerId"] = $entry["sellerId"];
            echo "logged";
            exit();
        }
    }

    if($_REQUEST["status"] == "Customer"){
        $query = "SELECT * FROM users WHERE userName = \"$userName\"";
        $ret = mysqli_query($connect, $query);
        echo mysqli_error($connect);
        $entry = mysqli_fetch_assoc($ret);
        if(password_verify($_REQUEST["password"], $entry["password"])){
            $_SESSION["user"] = $entry["userName"];
            $_SESSION["auth"] = 0;
            $_SESSION["userId"] = $entry["userId"];
            echo "logged";
            exit();
        }
    }

    echo "Incorrect login information.";
    exit();




}

if($action == "register"){

    $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

    $query = "SELECT * FROM users WHERE userName = \"$userName\"";
    $ret = mysqli_query($connect, $query);
    $query = "SELECT * FROM seller WHERE userName = \"$userName\"";
    $ret2 = mysqli_query($connect, $query);
    if($ret->num_rows == 0 && $ret2->num_rows == 0) {

        if($_REQUEST["status"] == "Seller"){
            $query = "INSERT INTO seller (`password`, `profit`, `userName`) VALUES (\"$password\", 0, \"$userName\")";
            mysqli_query($connect, $query);
            echo mysqli_error($connect);
            echo "User Registered.";
            exit();
        }

        if($_REQUEST["status"] == "Customer") {
            $query = "INSERT INTO users (`userName`, `password`) VALUES (\"$userName\", \"$password\")";
            mysqli_query($connect, $query);
            echo mysqli_error($connect);
            echo "User Registered.";
            exit();
        }
    }
    echo "User name already exists;";
    exit();
}

echo "Error EOF";