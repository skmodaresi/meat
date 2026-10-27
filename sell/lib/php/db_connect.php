<?php
require_once __DIR__ . '/../../../mysql_compat.php';
//$myconn = mysql_connect( "localhost" , "user" , "");
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
mysql_query("SET NAMES 'utf8'",$myconn);
mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());
//mysql_close() ;
?>