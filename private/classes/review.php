<?php

/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 5/1/17
 * Time: 12:04 AM
 */
class review
{
    private $review = null;
    private $score = null;
    private $reviewId = null;
    private $reviewTitle = null;
    private $connect = null;

    public function __construct($review, $connect)
    {
        $this->connect = $connect;

        $this->review = $review["review"];
        $this->reviewId = $review["reviewId"];
        $this->reviewTitle = $review["reviewTitle"];
        $this->score = $review["score"];
    }

    public function getReview(){
        return $this->review;
    }

    public function getScoreR(){
        return $this->score;
    }

    public function getTitle(){
        return $this->reviewTitle;
    }
}