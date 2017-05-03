<?php

/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 4/30/17
 * Time: 11:26 PM
 */
class product
{

    public $name = null;
    public $price = null;
    public $discount = null;
    public $reviews = null;
    public $score = null;
    public $stock = null;
    public $totalSold = null;
    public $productId = null;
    public $connect = null;
    public $descript = null;

    public function __construct($entry, $connect)
    {

        $this->name = $entry["name"];
        $this->price = $entry["price"];
        $this->discount = $entry["discount"];
        $this->score = $entry["score"];
        $this->productId = $entry["productId"];
        $this->stock = $entry["stock"];
        $this->totalsold = $entry["totalSold"];
        $this->reviews = Array();
        $this->descript = $entry["description"];
        $this->connect = $connect;

        $query = "SELECT * FROM reviews WHERE productId = $this->productId ORDER BY reviewId DESC";
        $ret = mysqli_query($this->connect, $query);

        $int = 0;

        while($entry = mysqli_fetch_assoc($ret)){
            $this->reviews[$int] = new review($entry, $this->connect);

            $int++;
        }

    }

    public function getId(){
        return $this->productId;
    }

    public function getStock(){
        return $this->stock;
    }

    public function getReviews(){
        return $this->reviews;
    }

    public function getReviewsNewest(){
        $query = "SELECT * FROM reviews WHERE productId = $productId";
        $return = mysqli_query($this->connect, $query);

        while($review = mysqli_fetch_assoc($return)){
            $id = $review["reviewId"];

            $newReview = new review($review, $this->connect);
            $this->reviews[$id] = $newReview;
        }
    }

    public function compileScore(){
        $total = 0;
        $numReviews = 0;

        foreach($this->reviews as $review){
            //print_r2($review);
            //print_r2($this->reviews);
            $total += $review->getScoreR();
            $numReviews++;
        }

        if($numReviews != 0) {
            $total = $total / $numReviews;

            $this->score = $total;

            $query = "UPDATE product SET score = $this->score WHERE productId = $this->productId";
            mysqli_query($this->connect, $query);
            echo mysqli_error($this->connect);
        }


    }

    public function getName(){
        return $this->name;
    }

    public function getPrice(){
        //return number_format($this->score, 2, '.', '');
        return $this->price;
    }

    public function getScore(){
        return $this->score;
    }

    public function getDescription(){
        return $this->descript;
    }

}