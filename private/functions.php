<?php
/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 3/30/17
 * Time: 8:47 PM
 */

function print_r2($val){
    echo '<pre>';
    print_r($val);
    echo  '</pre>';
}

function redirect_to($new_location){
    header("Location: " . $new_location);
    exit;
}

