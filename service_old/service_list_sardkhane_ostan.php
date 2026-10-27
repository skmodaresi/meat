<?php
require_once __DIR__ . '/../mysql_compat.php';
include ("../config.php");
$Data = array();

IF($_REQUEST['code_ostan']) $Condition_ostan=" AND list_sardkhane.code_ostan='".$_REQUEST['code_ostan']."' ";
  
//تعداد کل رکوردها
$q1="SELECT count(*) FROM meat.list_sardkhane WHERE 1=1 $Condition_ostan ORDER BY id asc ";
$res1= mysql_query($q1);
$row1= mysql_fetch_array($res1);
$cnt = $row1[0];

$q="SELECT list_sardkhane.*,name_ostan FROM meat.list_sardkhane INNER JOIN ostan USING(code_ostan) WHERE 1=1 $Condition_ostan ORDER BY list_sardkhane.id asc";
$res=mysql_query($q);
while($row=mysql_fetch_assoc($res))
{  
	 $RowData = array(
	 "id" => $row['id'],
	 "code_ostan" => $row['code_ostan'],
	 "name_ostan" => $row['name_ostan'],
	 "code_anbar" => $row['code_anbar'],
	 "name_anbar" => $row['name_anbar'],
	 "shenase_meli_anbar" => $row['shenase_meli_anbar'],
	 "shenase_yekta" => $row['shenase_yekta'],
	 "code_acc" => $row['code_acc'],
	 "noe_malekiyat" => $row['noe_malekiyat'],
	 "situation_type" => $row['situation_type'],
	 "activate" => $row['activate'],
	 "postal_code" => $row['postal_code']
     ); 
     array_push($Data, $RowData);
	
}	
//$Result = $Data;
$Result =
	array(
	"status" => true,
    "error_code" => 0,
	"error_message" => "code_ostan (optional)",
	"total_count" => $cnt,
	"data" => $Data
	);
echo preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($Result));
?>