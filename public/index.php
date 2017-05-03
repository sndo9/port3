<?php
session_start();
require_once ('../private/includes/requires.php');
if(isset($_SESSION["user"])){
    redirect_to('home.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<h1>Portfolio 3 Store</h1>
<hr>
<ul id="MenuBar">
    <li><a class="#home" href="#home">Home</a></li>
<!--    <li style="float:right"><a href="#login" id="login">Login/Register</a></li>-->
<!--    <li style="float:right"><a href="#userAcc" id="Account">Account/Logout</a></li>-->
</ul
<hr>
<h2 id="message">Log In</h2>
<hr>
<div align="center">
    <h2>Username:</h2>
    <input type="text" name="pw1" placeholder="Username" id="userName">
    <h2>Password:</h2>
    <input type="password" name="pw2" placeholder="Password" id="password">
    <br>
    <br>
    <label>Seller:</label>
    <input type="radio" value="Seller" id="seller" name="Seller/Customer" checked>
    <br>
    <label>Customer:</label>
    <input type="radio" value="Customer" id="user" name="Seller/Customer">
    <br>
    <br>
    <button onclick="login('login')" class="login">Login</button>
    <br>
    <button onclick="login('register')" class="login">Register</button>
</div>

<body>
</body>
<script>

    var radios = jQuery("input[type='radio']");


    function login($action){

        //alert("logg");

        var radio = radios.filter(":checked");
        var $stat = $(radio).attr('value');

        $.post("ajax/login_register.php", {
            action: $action,
            userName: $("#userName").val(),
            password: $("#password").val(),
            status: $stat

        }, function (data) {
            var result = $.trim(data);
            //alert(data);
            if(data.includes("logged")){
                window.open("home.php", "_self");
            }
            $("#message").html(data);
        })
    }
</script>
</html>