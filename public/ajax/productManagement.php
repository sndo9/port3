<?php
/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 5/1/17
 * Time: 1:40 AM
 */

session_start();
require_once('../../private/includes/ajax_requires.php');

$action = $_REQUEST["action"];

if($action == "addProduct"){
    $product = Array();
    $product["name"] = $_REQUEST["name"];
    $product["price"] = $_REQUEST["price"];
    $product["stock"] = $_REQUEST["stock"];
    $product["des"] = $_REQUEST["des"];

    $user->addProduct($product);
}

if($action == "addStock"){
    $productId = $_REQUEST["productId"];
    $newStock = $_REQUEST["stock"];

    $user->addStock($productId, $newStock);
}

if($action == "removeStock"){
    $productId = $_REQUEST["productId"];
    $lessStock = $_REQUEST["stock"];

    $user->removeStock($productId, $lessStock);
}

if($action == "removeProduct"){
    $productId = $_REQUEST["productId"];

    $user->removeProduct($productId);
}

if($action == "getStock"){
    $productId = $_REQUEST["productId"];

    echo $user->store->findById($productId)->getStock();
}

if($action == "purchace"){

    $id = $_REQUEST["id"];

    echo $user->purchase($id, 1);
}

if($action == "addReview"){
    //print_r2($_REQUEST);
    $id = $_REQUEST["id"];
    $title = $_REQUEST["title"];
    $text = $_REQUEST["text"];
    $score = $_REQUEST["score"];
    $user = $user->getUserId();

    $query = "INSERT INTO reviews (`review`, `reviewTitle`, `score`, `userId`, `productId`) VALUES (\"$text\", \"$title\", $score, $user, $id)";

    mysqli_query($connect, $query);

    echo mysqli_error($connect);
}