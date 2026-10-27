<?php
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

//تعداد کل رکوردها
$q1="SELECT count(*) FROM meat.kala ORDER BY id asc ";
$res1=mysql_query($q1);
$row1 = mysql_fetch_array($res1);
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
$q="SELECT kala.*,sharh_vahedkala,sharh_bastebandy,name_group_kala_top,name_group_kala_top_det,name_group_kala FROM meat.kala 
    INNER JOIN meat.vahed_kala USING(code_vahedkala)
    INNER JOIN meat.bastebandy USING(code_bastebandy)
    INNER JOIN meat.group_kala_top USING(code_group_kala_top)
    LEFT JOIN meat.group_kala_top_det USING(code_group_kala_top_det)
    LEFT JOIN meat.group_kala USING(code_group_kala)
    ORDER BY id asc $Limit";
$res=mysql_query($q);
while($row=mysql_fetch_assoc($res))
{  
	 $RowData = array(
	 "id" => $row['id'],
	 "code_kala" => $row['code_kala'],
	 "name_kala" => $row['name_kala'],
	 "code_vahedkala" => $row['code_vahedkala'],
	 "sharh_vahedkala" => $row['sharh_vahedkala'],
	 "code_bastebandy" => $row['code_bastebandy'],
	 "sharh_bastebandy" => $row['sharh_bastebandy'],
	 "code_group_kala_top" => $row['code_group_kala_top'],
	 "name_group_kala_top" => $row['name_group_kala_top'],
	 "code_group_kala_top_det" => $row['code_group_kala_top_det'],
	 "name_group_kala_top_det" => $row['name_group_kala_top_det'],
	 "code_group_kala" => $row['code_group_kala'],
	 "name_group_kala" => $row['name_group_kala'],
	 "gosht_type" => $row['gosht_type'],
	 "sharh_gosht_type" => $goshttypeArr[$row['gosht_type']],
	 "kala_type" => $row['kala_type'],
	 "sharh_kala_type" => $kalatypeArr[$row['kala_type']],
	 "mahmule_type" => $row['mahmule_type'],
	 "sharh_mahmule_type" => $mahmuletypeArr[$row['mahmule_type']]
     ); 
     array_push($Data, $RowData);
	
}	
//$Result = $Data;
$Result =
	array(
	"status" => true,
    "error_code" => 0,
	"error_message" => "شماره صفحه جاری :PageNo(optional) , تعداد رکورد در صفحه : RowPerPage (optional)(default:10),در صورت عدم ارسال این دو تمامی رکوردها لیست میشود",
	"PageNo" => $_REQUEST['PageNo'],
	"RowPerPage" => $RowPerPage,
	"total_page" => $MaxPage,
	"total_count" => $cnt,
	"data" => $Data
	);
echo preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($Result));
?>