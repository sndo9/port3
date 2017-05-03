<?php

/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 5/1/17
 * Time: 12:27 AM
 */
class store
{
    public $products = null;
    private $connect = null;

    public function __construct($connect)
    {
        $this->connect = $connect;

        $query = "SELECT * FROM product";
        $result = mysqli_query($this->connect, $query);

        $this->products = Array();

        while($product = mysqli_fetch_assoc($result)){
            $id = $product["productId"];

            $newProduct = new product($product, $this->connect);

            $this->products[$id] = $newProduct;
        }
    }

    public function getReveiw($productId){
        $this->products[$productId]->getReviews();
    }

    public function findById($id){
        return $this->products[$id];
    }
}