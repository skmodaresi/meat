<?php
include ("../config.php");

if(!isset($_REQUEST['sell_ostan']) || !isset($_REQUEST['sell_year']) || !isset($_REQUEST['sell_group_kala']))
{
	$Result = '
   {
	"status" : false,
	"error_message" : "Invalid input Args. define sell_ostan,sell_year,sell_group_kala ",
	"error_code" : -1,
	"data" : null
   }
  ';
  echo ($Result);
  exit();
}

$sell_ostan = $_REQUEST['sell_ostan'];
$sell_year = $_REQUEST['sell_year'];
$sell_group_kala = $_REQUEST['sell_group_kala'];

$Data = array();
$q="SELECT	mojody_kala.*,name_anbar,name_group_kala,name_kala
    From meat.mojody_kala
    INNER JOIN meat.kala ON mojody_kala.code_kala=kala.code_kala
    INNER JOIN meat.group_kala ON group_kala.code_group_kala=kala.code_group_kala
    INNER JOIN meat.list_sardkhane l_s ON mojody_kala.code_ostan=l_s.code_ostan AND mojody_kala.code_anbar=l_s.code_anbar        
    WHERE  
    mojody_kala.code_ostan='".$sell_ostan."'
    AND mojody_kala.year='".$sell_year."'
    AND kala.code_group_kala='".$sell_group_kala."'
    AND mojody_kala.deleted=0
	ORDER BY code_ostan,code_anbar,kala.code_kala asc";
echo $q;

$res=mysql_query($q);
while($row=mysql_fetch_assoc($res))
{  
	//$tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	//$mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	//$mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	//IF($tedad_karton>0 AND $mojody_nakhales>0 AND $mojody_khales>0)
	//{
	 $RowData = array(
	 "id" => $row['id'],
	 "name_ostan" => $row['name_ostan'],
	 "name_anbar" => $row['name_anbar'],
	 "name_group_kala" => $row['name_group_kala'],
	 "code_kala" => $row['code_kala'],
	 "name_kala" => $row['name_kala'],
	 "tedad_karton" => $tedad_karton,
	 "mojody_nakhales" => $mojody_nakhales,
	 "mojody_khales" => $mojody_khales
     ); 
     array_push($Data, $RowData);
	//}
}	
$Result = 
	array(
	"status" => true,
	"error_message" => "",
	"error_code" => 0,
	"data" => $Data
	)
;
echo (json_encode( $Result));
?>