<?php
require_once __DIR__ . '/../mysql_compat.php';
error_reporting(0);
include ("../config.php");
$Data = array();
IF(isset($_REQUEST['PageNo']) && isset($_REQUEST['RowPerPage']))//PageNo and RowPerPage isset
{
  $PageNo = $_REQUEST['PageNo'];
  $RowPerPage = $_REQUEST['RowPerPage'];
}
ELSE IF(isset($_REQUEST['PageNo']) && !isset($_REQUEST['RowPerPage']))//PageNo isset
{
  $PageNo = $_REQUEST['PageNo'];
  $RowPerPage = 10;//ده تا ده تا
}
ELSE IF(!isset($_REQUEST['PageNo']) && !isset($_REQUEST['RowPerPage']))//همه را بیاورد
  $Limit='';


IF($_REQUEST['code_ostan']) $Condition_ostan=" AND list_sardkhane.code_ostan='".$_REQUEST['code_ostan']."' ";

  
//تعداد کل رکوردها
$q1="SELECT count(*) FROM meat.list_sardkhane WHERE 1=1 $Condition_ostan ORDER BY id asc ";
$res1= mysql_query($q1);
$row1= mysql_fetch_array($res1);
$cnt = $row1[0];

if(isset($_REQUEST['PageNo']))//برای صفحه بندی حتما باید وارد شود
{
  //صفحه بندی
  $MaxPage=intval($cnt/$RowPerPage);
  if ($cnt%$RowPerPage) $MaxPage++;
  if (!$MaxPage) $MaxPage=1;
  if (!isset($PageNo)) $PageNo=1;//$PageNo=$MaxPage; 
  $NextPage=$PageNo+1;
  $PrevPage=$PageNo-1;
  if (!$cnt)
   {$En_Prev="Disabled";$En_Next="Disabled";}
  else
   {$En_Prev="";$En_Next="";}
  if ($PageNo==$MaxPage) $En_Next="onclick=\'return false;\'";
  if ($PageNo==1) $En_Prev="onclick=\'return false;\'";
  $FirstRow=$PrevPage*$RowPerPage;
  if ($FirstRow<0) $FirstRow=0;
  $Limit="Limit ".$FirstRow.",".$RowPerPage;
}
$q="SELECT list_sardkhane.*,name_ostan FROM meat.list_sardkhane INNER JOIN ostan USING(code_ostan) WHERE 1=1 $Condition_ostan ORDER BY list_sardkhane.id asc $Limit";
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
	 "postal_code" => $row['postal_code'],
	 "full_address" => $row['full_address']
     ); 
     array_push($Data, $RowData);
	
}	
//$Result = $Data;
$Result =
	array(
	"status" => true,
    "error_code" => 0,
	"error_message" => "شماره صفحه جاری :PageNo(optional) , تعداد رکورد در صفحه : RowPerPage (optional)(default:10),در صورت عدم ارسال این دو تمامی رکوردها لیست میشود , code_ostan (optional)",
	"PageNo" => $_REQUEST['PageNo'],
	"RowPerPage" => $RowPerPage,
	"total_page" => $MaxPage,
	"total_count" => $cnt,
	"data" => $Data
	);
echo preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($Result));
?>