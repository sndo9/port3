<?php
/**
 * Created by PhpStorm.
 * User: sndo9
 * Date: 5/2/17
 * Time: 8:18 PM
 */


session_start();
unset($_SESSION["user"]);
session_destroy();