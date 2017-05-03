<?php

session_start();
require_once ('../private/includes/requires.php');

if(isset($_SESSION["auth"])) {
    if ($_SESSION["auth"] == 1) {
        $user = new seller($connect);
    } else {
        $user = new user($connect);
    }
}
else redirect_to("index.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Portfolio 3 Store</title>
</head>
<ul>
<li><h1>Portfolio 3 Store</h1></li>
<li id="welcome"><h2>Welcome <?php echo $_SESSION["user"]?></h2></li>
</ul>
<hr>
<ul id="MenuBar">
    <li><a class="#home" href="home.php">Home</a></li>
<!--    <li style="float:right"><a href="#login" id="login">Login/Register</a></li>-->
    <li style="float:right"><a href="user.php" id="Account">Account/Logout</a></li>
</ul>
<hr>
<h2>
    <?php
        if($_SESSION["auth"] == 1) echo "Your Products";
        else echo "All Products";
    ?>
</h2>
<hr>
<div id="tableSpace"></div>

<body>
</body>
<script>
    function loadTables() {
        $.post("ajax/loadProducts.php", {
            action: "all"
        }, function (data) {
                $("#tableSpace").html(data);
            })
    }
    $(document).ready(loadTables());

    function loadOne(id){
        var location = "product.php?productId=" + id;
        window.open(location, '_self');
    }

</script>

</html>