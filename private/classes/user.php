<?php

/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 4/30/17
 * Time: 11:26 PM
 */
class user
{
    protected $userName = null;
    protected $firstName = null;
    protected $userId = null;
    protected $auth = null;
    public $store = null;
    protected $connect = null;

    public function __construct($connect)
    {
        $this->connect = $connect;
        //$this->firstName = $_SESSION["first"];
        $this->userName = $_SESSION["user"];
        $this->auth = $_SESSION["auth"];
        $this->userId = $_SESSION["userId"];

        $this->store = new store($connect);
    }

    public function purchase($productId, $num){
        //Check stock
        if($this->store->findById($productId)->getStock() == 0){
            return "Sorry, this item is out of stock.";
        }
        //Decrement stock
        $query = "UPDATE product SET stock = stock - $num WHERE productId = $productId";
        mysqli_query($this->connect, $query);
        //echo mysqli_error($this->connect);

        //echo $query;

        //Update sales
        $query = "SELECT * FROM product WHERE productId = $productId";
        $ret = mysqli_query($this->connect, $query);
        $return = mysqli_fetch_assoc($ret);

        $user = $this->userId;
        $sellerId = $return["sellerId"];
        $price = $return["price"] * $num;

        $query = "INSERT INTO sales (`userId`, `sellerId`, `productId`, `cost`) 
                      VALUES ($user, $sellerId, $productId, $price)";
        mysqli_query($this->connect, $query);
        echo mysqli_error($this->connect);
        //update seller
        $query = "UPDATE seller SET profit = profit + $price WHERE sellerId = $sellerId";
        mysqli_query($this->connect, $query);
        echo mysqli_error($this->connect);

        $query = "UPDATE product SET totalSold = totalSold + 1 WHERE productId = $productId";
        mysqli_query($this->connect, $query);
    }

    public function changePassword($newPassword){

    }

    public function getUserId(){
        return $this->userId;
    }

    public function getAuth(){
        return $this->auth;
    }


}