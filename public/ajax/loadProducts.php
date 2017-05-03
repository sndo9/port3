<?php
/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 5/2/17
 * Time: 5:14 PM
 */

session_start();
require_once('../../private/includes/ajax_requires.php');

$itemsPerPage = 4;

$action = $_REQUEST["action"];
$auth = $user->getAuth();

if($auth == 1){ //seller
    if($action == "all") {
        $sellerId = $user->getSellerId();
        echo createTable($connect, "SELECT * FROM product WHERE sellerId = $sellerId");
        exit();
    }
}

if($auth == 0){//user
    if($action == "all"){
        echo createTable($connect, "SELECT * FROM product");
        exit();
    }
}

function createTable($connect, $query){
    $ret = mysqli_query($connect, $query);

    $int = 0;

    $output = "<table class=\"ProductTable\"><tr>";

    while ($entry = mysqli_fetch_assoc($ret)) {
        $name = $entry["name"];
        $price = $entry["price"];
        $id = $entry['productId'];
        $output .= "<td align=\"center\"><h4 id = \"p1NamePrice\">$name $$price</h4>
<img onclick='loadOne($id)' id=\"p1Image\" src=\"https://www.axure.com/c/attachments/forum/7-0-general-discussion/3919d1401387174-turn-placeholder-widget-into-image-maintain-interactions-screen-shot-2014-05-29-10.46.57-am.png\" hspace=\"20\" style=\"width:300px;height:300px;\"></td>";

        $int++;
        if (($int / 4) == 0) {
            $output .= "</tr><tr>";
        }
    }

    $output .= "</tr></table>";

    return $output;
}