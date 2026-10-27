<?php
require_once __DIR__ . '/../mysql_compat.php';
include ("../config.php");

if(!isset($_REQUEST['sell_ostan']) || !isset($_REQUEST['sell_anbar']) || !isset($_REQUEST['sell_year']) || !isset($_REQUEST['sell_kala']))
{
	$Result = '
   {
	"status" : false,
	"error_message" : "Invalid input Args. define sell_ostan,sell_anbar,sell_year,sell_kala ",
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

$Data = array();
$q="SELECT	mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton,sharh_mandegari
    From meat.mojody_kala
    INNER JOIN meat.kala ON mojody_kala.code_kala=kala.code_kala
    INNER JOIN meat.keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
    LEFT JOIN meat.karton ON mojody_kala.code_karton=karton.code_karton 
    INNER JOIN meat.tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
    INNER JOIN meat.list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar        
    INNER JOIN meat.tarikh_mandegari ON mojody_kala.code_mandegari=tarikh_mandegari.code_mandegari
    WHERE  
    mojody_kala.code_ostan='".$sell_ostan."'
    AND mojody_kala.code_anbar='".$sell_anbar."'
    AND mojody_kala.year='".$sell_year."'
    AND mojody_kala.code_kala='".$sell_kala."'
    AND mojody_kala.deleted=0
  	
	ORDER BY sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc";
//echo $q;

$res=mysql_query($q);
while($row=mysql_fetch_assoc($res))
{  
	$tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	$mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	$mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	IF($tedad_karton>0 AND $mojody_nakhales>0 AND $mojody_khales>0)
	{
	 $RowData = array(
	 "id" => $row['id'],
	 "name_ziranbar" => $row['name_ziranbar'],
	 "code_kala" => $row['code_kala'],
	 "name_kala" => $row['name_kala'],
	 "name_keshvar" => $row['name_keshvar'],
	 "name_tolidkonande" => $row['name_tolidkonande'],
	 "sal_tolid_shamsi" => $row['sal_tolid_shamsi'],
	 "mah_tolid_shamsi" => $row['mah_tolid_shamsi'],
	 "rouz_tolid_shamsi" => $row['rouz_tolid_shamsi'],
	 "rouz_tolid_shamsi" => $row['rouz_tolid_shamsi'],
	 "sharh_mandegari" => $row['sharh_mandegari'],
	 "vazn_karton" => $row['vazn_karton'],
	 "tedad_karton" => $tedad_karton,
	 "mojody_nakhales" => $mojody_nakhales,
	 "mojody_khales" => $mojody_khales
     ); 
     array_push($Data, $RowData);
	}
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