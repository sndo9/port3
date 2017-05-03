<?php
/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 4/30/17
 * Time: 2:37 AM
 */

require_once('../../private/classes/product.php');
require_once('../../private/classes/review.php');
require_once('../../private/classes/seller.php');
require_once('../../private/classes/store.php');
require_once('../../private/classes/user.php');
require_once('../../private/functions.php');
require_once('../../private/database/database_login.php');

if(isset($_SESSION["auth"])) {
    if ($_SESSION["auth"] == 1) {
        $user = new seller($connect);
    } else {
        $user = new user($connect);
    }
}