<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_havale_new_anbar_ebtal.php";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepickerfrom").datepicker({
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { 
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
		}
	  );
 });
</script> 
</head>';
/***************************************** MAIN*****************************************/
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
{
	  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
} 
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
	 $ExcelFileName=str_replace('.php','',$FileName); 
 	 $end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
	 if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
} 
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.sal_mabda.focus();">
<form method="POST" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">انتقال حواله های ابطال شده  '.$mt_gl_name_ostan.' '.$mt_gl_name_anbar.'</td></tr>
    <tr><td colspan="4" class="tr1">از تاریخ : <input id="datepickerfrom" type="text" name="date1" placeholder="'.$date1.'" /></td></tr>
    <tr><td colspan="4" class="tr1">تا تاریخ : <input id="datepickerto" type="text" name="date2" placeholder="'.$date2.'" /></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="انتقال حواله های ابطال شده"></td></tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';
/********************WEB SERVICE NEW***********************/
if(isset($transfer))
{
	$q_havale="SELECT h.* From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar 
	          WHERE h.tarikh_havale_anbar BETWEEN '$date1' AND '$date2' AND h.code_ostan='$mt_gl_code_ostan' AND h.code_anbar='$mt_gl_code_anbar' and year=$mtActiveYear AND h.status=1 AND h.deleted=0 AND h.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND wb_id>0 AND (wb_revoke_error_code!=0 OR wb_revoke_error_code='' OR wb_revoke_error_code IS NULL)";
	echo $q_havale;
	$res_havale = mysql_query($q_havale);	
	while($row_havale=$db->fetch_assoc($res_havale))
    {
      	 $params=array('id'=>$row_havale['wb_id']);
		 $encodedData = json_encode($params);
		 $curl = curl_init();
         curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/DraftRevoke',
          CURLOPT_USERPWD => 'ajix_agridam:3rt67HM',
	      CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$encodedData,
	      // CURLOPT_POSTFIELDS =>'{
          // "id":24878897516399
          // }',
          CURLOPT_HTTPHEADER => array(
           'Authorization: Basic YWppeF9hZ3JpZGFtOjNydDY3SE0=',
           'Content-Type: application/json'
          ),
         ));
		  
          $response = curl_exec($curl);
		  $response = str_replace(array("\"{\"","\"}\""),array("'{\"","\"}'")
		             ,str_replace(array('\"',"\\\\","'"),array('"',"\\")
			 	     ,preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",json_decode($response))));

          $object=json_decode($response);      # آبجکت
	      $wb_revoke_error_code =$object->error_code;
	      $wb_revoke_error_message =$object->error_message;
	  if(curl_exec($ch) === false)
      {
           //echo 'Curl error: ' . curl_error($ch);
		    echo "<script>alert('Curl error: ' . curl_error($ch)')</script>";
      }
	  else
	  {	   
		   if($object->error_code != 0)
           {
	        echo "<script>alert('خطا : \\n $object->error_message \\n کد خطا وزارت صمت :  $object->error_code ')</script>";
	        //exit();
           }
		   else if($object->error_code == 0)
           {
		     //echo "<script>alert('ابطال رسید در وب سرویس به ثبت رسید')</script>";
		     echo $row_havale['id'].'ابطال حواله به ثبت رسید';
			 echo'<br/>';
           }
	       $update_track=("UPDATE havale SET wb_revoke_error_code='$wb_revoke_error_code',wb_revoke_error_message='$wb_revoke_error_message' WHERE id=".$row_havale['id']."");
	       $update_res=mysql_query($update_track);
	   }
	   curl_close($curl);
	 }			  
}
/********************WEB SERVICE NEW EBTAL***********************/
echo'
</form>
</body>
</html>';	
?>