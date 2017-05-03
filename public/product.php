<?php

session_start();
require_once ('../private/includes/requires.php');

$id = $_GET["productId"];

if(isset($_SESSION["auth"])) {
    if ($_SESSION["auth"] == 1) {
        $user = new seller($connect);
    } else {
        $user = new user($connect);
    }
}
else redirect_to("index.php");

$product = $user->store->findById($id);
$product->compileScore();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title><?php echo $product->getName()?></title>
</head>
<body></body>
<div id="error"></div>
<h1>Portfolio 3 Store</h1>
<hr>
<ul id="MenuBar">
    <li><a class="#home" href="home.php">Home</a></li>
<!--    <li style="float:right"><a href="#login" id="login">Login/Register</a></li>-->
    <li style="float:right"><a href="user.php" id="Account">Account/Logout</a></li>
</ul>
<hr>
    <div>
        <img src="https://www.axure.com/c/attachments/forum/7-0-general-discussion/3919d1401387174-turn-placeholder-widget-into-image-maintain-interactions-screen-shot-2014-05-29-10.46.57-am.png" id="ProductImage" hspace=50px align="left" style="width:500px;height:500px;">
        <?php
            if($user->getAuth() == 1){
                echo "<button align=\"right\" class=\"buyButton\" onclick=\"hideAdd()\">Add Stock</button><br>";
                echo "<div id='toAdd'>";
                echo "<input id=\"add\" placeholder='Ammount to add'><button onclick='updateStock()'>Add</button>";
                echo "</div>";
            }
            if($user->getAuth() == 0){
                if($product->getStock() == 0){
                    echo "<button align=\"right\" class=\"buyButton\" style='background-color: gray' disabled>Out of stock</button>";
                }
                else {
                    echo "<button align=\"right\" class=\"buyButton\" onclick=\"purchace(" . $product->getId() . ")\">Purchase</button>";
                }
            }
        ?>
        <h2 align="left"  id="ProductName"><?php echo $product->getName() . " " . $product->getScore() . " Stars" ?></h2>
        <h3 align="left" id="ProductPrice"><?php echo "$" . $product->getPrice()?></h3><br><h3><?php if($user->getAuth() == 1) echo "<div id=\"stock\">" .$product->getStock() . "</div>" . " units in stock"?></h3>
</div>
<hr>
<h2 align="left" >Product Description</h2>
<div id="stock"></div>
<h3 align="left"  id="ProductDetails"><?php echo $product->getDescription() ?></h3>
<br>
<hr>
<h2 align="left" >Product Reviews</h2>
    <div id ="Reviews" style="float: right; margin-right: 150px">
        <?php
            $reviews = $product->getReviews();
            //print_r2($reviews);
            if(isset($reviews[0])){
                printReview($reviews[0]);
            }
            if(isset($reviews[1])){
                printReview($reviews[1]);
            }

        ?>
    </div>

<script>
    function updateStock(){
        $.post("ajax/productManagement.php", {
            action: "addStock",
            productId: <?php echo $product->getId()?>,
            stock : $("#add").val()
        })
        hideAdd();
        viewStock();
    }
    function viewStock(){
        $.post("ajax/productManagement.php", {
            action : "getStock",
            productId: <?php echo $product->getId()?>
        }, function (data) {
            $("#stock").html(data);
        })
    }
    function hideAdd(){
        $("#toAdd").toggle();
    }
    $(document).ready(hideAdd());

    function purchace(id){
        $.post("ajax/productManagement.php", {
            action: "purchace",
            id: id
        }, function (data) {
            alert(data);
            $("#error").html(data);
        })
    }
</script>
</html>

<?php
function printReview($review){
    //print_r2($review);
    echo "<ul><li><h2><I>" . $review->getTitle() . "</I></h2></li><li> " . $review->getScoreR() . " Stars<br></li></ul>";
    echo $review->getReview();
    echo "<hr><br><br>";
}
?>