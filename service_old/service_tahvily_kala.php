<?php
include ("../config.php");

if(!isset($_REQUEST['sell_ostan']) || !isset($_REQUEST['sell_anbar']) || !isset($_REQUEST['sell_year']) || !isset($_REQUEST['sell_kala']) || !isset($_REQUEST['sell_shomare_havale']))
{
	$Result = '
   {
	"status" : false,
	"error_message" : "Invalid input Args. define sell_ostan,sell_anbar,sell_year,sell_kala,sell_shomare_havale ",
	"error_code" : -1,
	"data" : null
   }
  ';
  echo ($Result);
  exit();
}

$sell_ostan = $_REQUEST['sell_ostan'];
$sell_anbar = $_REQUEST['sell_anbar'];
$sell_year = $_REQUEST['sell_year'];
$sell_kala = $_REQUEST['sell_kala'];
$sell_shomare_havale = $_REQUEST['sell_shomare_havale'];


$Data = 0;
$q="SELECT SUM(tedad_karton_h_d) AS tedad_karton_tahvily,SUM(vazn_nakhales_h_d) AS vazn_nakheles_tahvily,SUM(vazn_khales_h_d) AS vazn_khales_tahvily,SUM(tedad_shane_h_d) AS tedad_shane_tahvily , 
    name_ostan,name_anbar,name_kala,kala.code_bastebandy
	FROM meat.havale_detail 
    INNER JOIN meat.ostan ON havale_detail.code_ostan=ostan.code_ostan	
	INNER JOIN meat.list_sardkhane l_s ON havale_detail.code_ostan=l_s.code_ostan AND havale_detail.code_anbar=l_s.code_anbar        
	INNER JOIN meat.kala ON havale_detail.code_kala=kala.code_kala	
	INNER JOIN meat.bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy	
	WHERE  
    havale_detail.code_ostan='".$sell_ostan."'
    AND havale_detail.code_anbar='".$sell_anbar."'
    AND havale_detail.year='".$sell_year."'
    AND havale_detail.h_code='".$sell_shomare_havale."'
    AND status=0
	AND havale_deleted=0";
//echo $q;
$res=mysql_query($q);
	
	 $row = mysql_fetch_array($res);
	 if(($row['code_bastebandy']==2)OR($row['code_bastebandy']==5)OR($row['code_bastebandy']==6))$meghdar_tahvily=$row['tedad_karton_tahvily'];
     else if(($sell_kala==50)OR($sell_kala==54)) $meghdar_tahvily=$row['tedad_shane_tahvily'];
     else $meghdar_tahvily=round($row['vazn_khales_tahvily'],3); 
 
	 
	 $RowData = array(
	 "name_ostan" => $row['name_ostan'],
	 "name_anbar" => $row['name_anbar'],
	 "code_kala" => $sell_kala,
	 "name_kala" => $row['name_kala'],
	 "sell_shomare_havale" => $sell_shomare_havale,
	 "meghdar_tahvily" => $meghdar_tahvily
     );
     $Data=	$RowData; 
     $Result = array(
	 "status" => true,
	 "error_message" => "",
	 "error_code" => 0,
	 "data" => $Data
	 );
echo preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($Result));
?>