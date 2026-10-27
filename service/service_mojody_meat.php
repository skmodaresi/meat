<?php
include ("../config.php");
if(!isset($_REQUEST['sal']))
{
  $Result = '
  {
	"status" : false,
	"error_message" : "Invalid input Args. define sal",
	"error_code" : -1,
	"data" : null
  }';
  echo ($Result);
  exit();
}

$Data = array();
$sal = $_REQUEST['sal'];

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


$Condition_tarikh_m = strtotime ( '-1 day' , strtotime ( $today_milady ) ) ;//1 day ago
$Condition_tarikh_m = date ( 'Y-m-j' , $Condition_tarikh_m );
$d3=substr($Condition_tarikh_m,8,2);$m3=substr($Condition_tarikh_m,5,2);$y3=substr($Condition_tarikh_m,0,4);
$DateF3=gregorian_to_jalali($y3,$m3,$d3);
$yy3=$DateF3[0];
$mm3=$DateF3[1];
$dd3=$DateF3[2];
$Condition_tarikh_sh=$yy3.'/'.$mm3.'/'.$dd3;

  
//تعداد کل رکوردها
$q1="SELECT count(*) FROM meat.ostan ORDER BY id asc ";
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
//حلقه استان
 $q_ostan="SELECT * FROM  meat.ostan ORDER BY name_ostan asc $Limit";
 $res_ostan=mysql_query($q_ostan);
 while($row_ostan=mysql_fetch_assoc($res_ostan))
 {  
	$q_group_kala="SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2 AND (code_group_kala_top=4 OR code_group_kala_top=5) ORDER BY code_group_kala_top asc";
    $res_group_kala=mysql_query($q_group_kala);
	$DataGr = array();
    while($row_group_kala=mysql_fetch_assoc($res_group_kala))
	{
	  //توابع در فایل فانکشن
	  //شرط تاریخ در توابع نیست
	  $tedad_karton=mojodyGroupKarton($row_ostan['code_ostan'],'',$sal,$row_group_kala['code_group_kala_top']);
	  $mojody_nakhales=mojodyGroupNakhales($row_ostan['code_ostan'],'',$sal,$row_group_kala['code_group_kala_top']);
	  $mojody_khales=mojodyGroupKhales($row_ostan['code_ostan'],'',$sal,$row_group_kala['code_group_kala_top']);
	
	
	  //خرید قطعی 
      //سه مقدار کارتن ناخالص و خالص	  
	  $q_kharidghatee ="SELECT SUM(tedad_karton_r_d_sub),SUM(vazn_nakhales_r_d_sub),SUM(vazn_khales_r_d_sub) FROM meat.resid_kala_detail AS r_k_d 
	              	    INNER JOIN meat.resid AS r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year 
				        INNER JOIN meat.kala ON r_k_d.code_kala=kala.code_kala
                        INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=kala.code_group_kala_top 
	  			        WHERE r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6
				        AND r.code_ostan='".$row_ostan['code_ostan']."' AND r.year='$sal' AND kala.code_group_kala_top='".$row_group_kala['code_group_kala_top']."' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND tarikh_resid<='$today' ";
      $res_kharidghatee = mysql_query($q_kharidghatee);
      $row_kharidghatee = mysql_fetch_array($res_kharidghatee);
	  $kharidghatee_karton = $row_kharidghatee[0];		
	  $kharidghatee_nakhales = round($row_kharidghatee[1],3);		
	  $kharidghatee_khales = round($row_kharidghatee[2],3);		
	  //تحویل قطعی
      //سه مقدار کارتن ناخالص و خالص	  
	  $q_tahvilghatee ="SELECT SUM(tedad_karton_h_d),SUM(vazn_nakhales_h_d),SUM(vazn_khales_h_d) FROM meat.havale_detail AS h_d 
		                INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year 
				        INNER JOIN meat.kala ON h_d.code_kala=kala.code_kala
                        INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=kala.code_group_kala_top 
	  			        WHERE (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3)
				        AND h.code_ostan='".$row_ostan['code_ostan']."' AND h.year='$sal' AND kala.code_group_kala_top='".$row_group_kala['code_group_kala_top']."' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND tarikh_havale_anbar<='$today' ";
      $res_tahvilghatee = mysql_query($q_tahvilghatee);
      $row_tahvilghatee = mysql_fetch_array($res_tahvilghatee);
	  $tahvilghatee_karton = $row_tahvilghatee[0];		
	  $tahvilghatee_nakhales = round($row_tahvilghatee[1],3);		
	  $tahvilghatee_khales = round($row_tahvilghatee[2],3);		  
		  

	 
	 $RowGrData = array(
	 "code_group_kala_top" => $row_group_kala['code_group_kala_top'],
	 "name_group_kala_top" => $row_group_kala['name_group_kala_top'],
	 "tedad_karton" => $tedad_karton,
	 "mojody_nakhales" => $mojody_nakhales,
	 "mojody_khales" => $mojody_khales,
	 "kharidghatee_karton" => $kharidghatee_karton,
	 "kharidghatee_nakhales" => $kharidghatee_nakhales,
	 "kharidghatee_khales" => $kharidghatee_khales,
	 "tahvilghatee_karton" => $tahvilghatee_karton,
	 "tahvilghatee_nakhales" => $tahvilghatee_nakhales,
	 "tahvilghatee_khales" => $tahvilghatee_khales
     ); 
     array_push($DataGr, $RowGrData);
	
	
	}//END WHILE group_kala_top

	 $RowData = array(
	 "id" => $row_ostan['id'],
	 "code_ostan" => $row_ostan['code_ostan'],
	 "name_ostan" => $row_ostan['name_ostan'],
	 "dataGr" => $DataGr
     ); 
     array_push($Data, $RowData);
  	
 }//END WHILE ostan	
//$Result = $Data;
$Result =
	array(
	"status" => true,
    "error_code" => 0,
	"message" => "شماره صفحه جاری :PageNo(optional) , تعداد رکورد در صفحه : RowPerPage (optional)(default:10),در صورت عدم ارسال این دو تمامی رکوردها لیست میشود",
	"PageNo" => $_REQUEST['PageNo'],
	"RowPerPage" => $RowPerPage,
	"total_page" => $MaxPage,
	"total_count" => $cnt,
	"data" => $Data
	);
echo preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($Result));
?>