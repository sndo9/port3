<?php

/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 5/1/17
 * Time: 12:25 AM
 */
class seller
{
    protected $userName = null;
    protected $firstName = null;
    protected $sellerId = null;
    protected $auth = null;
    public $store = null;
    protected $connect = null;
    protected $profit;

    public function __construct($connect)
    {
        $this->connect = $connect;
        //$this->userName = $_SESSION["first"];
        $this->userName = $_SESSION["user"];
        $this->auth = $_SESSION["auth"];
        $this->sellerId = $_SESSION["sellerId"];

        $query = "SELECT profit FROM seller WHERE sellerId = \"$this->sellerId\"";
        $ret = mysqli_query($connect, $query);

        $return = mysqli_fetch_assoc($ret);

        $this->profit = $return["profit"];

        $this->store = new store($connect);
    }

    public function addProduct($product){
        $name = $product["name"];
        $price = $product["price"];
        $des = $product["des"];
        $sellerId = $this->sellerId;
        $discount = 0;
        $score = 0;
        $stock = $product["stock"];
        $totalSold = 0;

        $query = "SELECT * FROM product WHERE sellerId = $this->sellerId AND name = \"$name\"";
        $ret = mysqli_query($this->connect, $query);
        echo mysqli_error($this->connect);

        if($ret->num_rows == 0) {
            $query = "INSERT INTO product (`name`, `price`, `score`, `discount`, `stock`, `totalSold`, `sellerId`, `description`) 
                    VALUES (\"$name\", $price, $score, $discount, $stock, $totalSold, $sellerId, \"$des\")";
            mysqli_query($this->connect, $query);
            echo "Product added";
            return;
        }
        echo "You already have a product with that name.";
    }

    public function addStock($productId, $newStock){
        $query = "UPDATE product SET stock = stock + $newStock WHERE productId = $productId";
        mysqli_query($this->connect, $query);
    }

    public function removeStock($productId, $lessStock){
        $query = "UPDATE product SET stock = stock - $lessStock WHERE productId = $productId";
        mysqli_query($this->connect, $query);
    }

    public function removeProduct($productId){
        $query = "DELETE FROM product WHERE productId = $productId";
        mysqli_query($this->connect, $query);
    }

    public function getSellerId(){
        return $this->sellerId;
    }

    public function getAuth(){
        return $this->auth;
    }

    public function getProfit(){
        return $this->profit;
    }
}