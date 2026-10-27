<?php
session_start();
if(!isset($_SESSION['isLogged'])) $_SESSION['isLogged'] = false;
include_once 'lib/php/db_connect.php';
include_once 'lib/php/gen_def.php';
include_once 'lib/php/general.php';
include_once 'lib/php/general_aj.php';
include_once 'lib/php/body.php';
//include_once 'lib/php/Pfactor_mgmt.php';
include_once 'lib/php/jdf.php';
?>