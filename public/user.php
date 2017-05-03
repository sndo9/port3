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
    <title>User Details</title>
</head>
<body>
<div id="error"></div>
<h1>Portfolio 3 Store</h1>
<hr>
<ul id="MenuBar">
    <li><a class="#home" href="home.php">Home</a></li>
<!--    <li style="float:right"><a href="" id="login">Login/Register</a></li>-->
    <li style="float:right"><a href="user.php" id="Account">Account/Logout</a></li>
</ul>
<button onclick="logout()" style="float:bottom;">Logout</button>
<hr>
<button onclick="showAddProduct()" id="addProductButton">Add Product</button>
<div id="seller">
<div id="addAProduct">
<h2>Sell A Product:</h2>
    <div id="error"></div>
<hr>

    <input type="text" placeholder="Product Name" id="PName">
    <br>
    <input type="text" placeholder="Product Price" id="PPrice">
    <br>
    <input type="text" placeholder="Stock" id="PStock">
    <br>
    <input  type=text placeholder="Product description" id="PDesc">
    <br>
<!--    <input type="file" value="Upload Product Image" accept="image/*" id="PImage">-->
<!--    <br>-->
    <button onclick="addProductK()">Submit</button>

</div>
<hr>
<h5>Seller Balance:</h5>
<h5 id="SellerBalance">
    <?php
        if($user->getAuth() == 1){
            echo "$" . $user->getProfit();
        }
    ?>
</h5>
<hr>
</div>
<h2>Account History</h2>
<div>
<div id="history" style="float: left;">
    <?php
        echo getPurchaseHistory($user, $connect);
    ?>
</div>
    <div id="review" style="float: right; margin-right: 50px">
        <input id="title" type="text" placeholder="Title..."><br>
        <input id="text" type="text" placeholder="Review..."><br>
        Stars: &nbsp;
        1<input type="radio" value="1" name="stars">
        2<input type="radio" value="2" name="stars">
        3<input type="radio" value="3" name="stars">
        4<input type="radio" value="4" name="stars">
        5<input type="radio" value="5" name="stars">
        <br>
        <button onclick="submitReview()">Submit</button>

    </div>
</div>
<button hidden value="" id="hiddenB"></button>

<!--<hr>-->
<!--<h3 id="username">Username</h3>-->
<!--<form class="shiftleft" border="2px">-->
<!--    <h3>Password Reset</h3>-->
<!--    <h5>Enter New Password:</h5>-->
<!--    <input type="password" name="pw1" id="passwordReset1">-->
<!--    <h5>Enter New Password Again:</h5>-->
<!--    <input type="password" name="pw2" id="passwordReset2">-->
<!--    <input type="button" value="Submit" id="submitReset"">-->
<!--</form>-->
<!--<hr>-->
<!--<form>-->
<!--    <h3>Logout:</h3>-->
<!--    <input type="submit" value="Logout" id="logout">-->
<!--</form>-->
<!--<div id="error"></div>-->
</body>
<script>
    <?php
        echo "var auth = " . $user->getAuth() . ";";
    ?>
    function toggleSeller(){
        $("#addAProduct").toggle();
        $("#review").toggle();

        if(auth == 0){
            $("#seller").toggle();
            $("#addProductButton").toggle();

        }
    }
    function showAddProduct(){
        $("#addAProduct").toggle();
    }
    function addProductK(){
        $.post("ajax/productManagement.php", {
            action : "addProduct",
            name: $("#PName").val(),
            price: $("#PPrice").val(),
            stock: $("#PStock").val(),
            des: $("#PDesc").val()
        }, function (data) {
            alert(data);
            //$("#error").html(data)
        })
    }
    function logout(){
        $.post("ajax/logout.php",
            function (data) {
                window.open("index.php", "_self");
        })
    }

    function review(id){
        $("#review").toggle();
        $("#hiddenB").val(id)
    }

    function submitReview(){
        var radios = jQuery("input[type='radio']");
        var radio = radios.filter(":checked");
        var stat = $(radio).attr('value');
        var id = $("#hiddenB").val();
        //alert(stat);

        $.post("ajax/productManagement.php", {
            action: "addReview",
            id: id,
            title: $("#title").val(),
            text: $("#text").val(),
            score: stat
        }, function (data){
            $("#error").html(data);
        } )
    }



    $(document).ready(toggleSeller());
</script>

</html>

<?php
    function getPurchaseHistory($user, $connect){
        if($user->getAuth() == 1) $person = "sellerId = " . $user->getSellerId();
        else $person = "userId = " . $user->getUserId();



        $query = "SELECT * FROM sales WHERE $person ORDER BY salesId DESC";
        $ret = mysqli_query($connect, $query);
        echo mysqli_error($connect);


        $output = "<table style='border: 20px'><tr>";
        $output .= "<th>ID</th><th>Item</th><th>Price</th>";
        if($user->getAuth() == 1) $output .= "<th>User</th>";
        else $output .= "<th>Seller</th>";

        $output .= "</tr>";

        $int = 0;

        while($entry = mysqli_fetch_assoc($ret)){
            if($user->getAuth() == 1) $name = $entry["userId"];
            else $name = $entry["sellerId"];

            $itemId = $entry["productId"];
            $query = "SELECT * FROM product WHERE productId = $itemId";
            $ret2 = mysqli_query($connect, $query);
            echo mysqli_error($connect);
            $result = mysqli_fetch_assoc($ret2);
            $item = $result["name"];

            $price = $entry["cost"];
            $id = $entry["salesId"];

            echo $int++;

            $output .= "<tr><td>$id</td><td>$item</td><td>$price</td><td>$name</td>";

            if($user->getAuth() == 0) $output .= "<td><button onclick='review($itemId)'>Review</button></td>";

            $output .= "</tr>";



        }

        $output .= "</table>";

        return $output;
    }
?>