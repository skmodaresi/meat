<?php
require_once __DIR__ . '/../mysql_compat.php';
include ("../config.php");
if(!isset($_REQUEST['code_keshvar']))
{
	$Result = '
   {
	"status" : false,
	"error_message" : "Invalid input Args. define code_keshvar ",
	"error_code" : -1,
	"data" : null
   }
  ';
  echo ($Result);
  exit();
}
$code_keshvar = $_REQUEST['code_keshvar'];

$Data = array();
$q="SELECT * FROM meat.keshvar WHERE  code_keshvar='".$code_keshvar."' ORDER BY id asc";
$res=mysql_query($q);
while($row=mysql_fetch_assoc($res))
{  
	 $Data = array(
	 "id" => $row['id'],
	 "code_keshvar" => $row['code_keshvar'],
	 "name_keshvar" => $row['name_keshvar']
     ); 
     //array_push($Data, $RowData);
	
}	
$Result = 
	array(
	"status" => true,
	"error_message" => "",
	"error_code" => 0,
	"data" => $Data
	)
;
echo preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($Result));
?>