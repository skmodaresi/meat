<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_baskul.php";
$TableName="bsk_data";
$titr='اطلاعات باسکول';
$radif=1;

if(!$inputName) $inputName='bsk_no';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
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
	  { showOn: "button",
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
echo"
<script type='text/javascript'>
function substitute(code_val)
{
 window.opener.document.myform.bsk_no.value=code_val;
 window.opener.document.myform.bsk_no.focus();
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body onload="document.myform.bsk_no.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <tr>
  <td class="title title_search">';
  if($parent_page=="resid_new.php")//صفحه ایجاد رسید
   echo'<div onClick="window.location=\''.$FileName.'?parent_page='.$parent_page.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&pl1_='.$pl1_.'&pl2_='.$pl2_.'&pl3_='.$pl3_.'&pl4_='.$pl4_.'&Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div>';
  else
   echo'<div onClick="window.location=\''.$FileName.'?parent_page='.$parent_page.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&h_id_='.$h_id_.'&idJabejae_='.$idJabejae_.'&Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div>';
  echo'</td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden; ">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
     <tr class="table-title">
	  <td width="3%">رديف</td>
	  <td width="10%">شماره باسکول</td>
	  <td width="15%">نام راننده</td>
	  <td width="10%">کد ملی</td>
	  <td width="13%">پلاک خودرو</td>
	  <td width="13%">وزن کامیون با بار</td>
	  <td width="10%">وزن کامیون</td>';
	  if($parent_page=="havale_new.php")echo'<td width="12%">حواله فروش/مجوز جابه جایی</td>';
	echo' 
    </tr>';
    /*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_baskul']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if ($bsk_no) $temp.=" and $TableName.bsk_no LIKE '%$bsk_no%'";
     if ($ranande_name) $temp.=" and ranande_name LIKE '%$ranande_name%'";
	 if ($plak1) $temp.=" and bsk_kamion.plak1='$plak1'";//پلاک خودرو 
     if ($plak2) $temp.=" and bsk_kamion.plak2='$plak2'";//پلاک خودرو 
     if ($plak3) $temp.=" and bsk_kamion.plak3='$plak3'";//پلاک خودرو 
     if ($plak4) $temp.=" and bsk_kamion.plak4='$plak4'";//پلاک خودرو 
	 if($temp) {$PageNo=1;$_SESSION['mt_search_help_baskul']=$temp;} else $_SESSION['mt_search_help_baskul']="";
    }
	/*************END SEARCH ******/	 
   $Cntr=0;

   //change sal 2raghami be sal 4raghami
   $sal=substr($mtActiveYear,2,2);
   //$sal_ghabl=$mtActiveYear-1;
   
   $query_find = $db->query("set session group_concat_max_len=250000");
   if($parent_page=="resid_new.php")//صفحه ایجاد رسید
   {
	//bsk_type=3,4:رسید
	//اگر نوع تحویل بار حمل با راه آهن تحویل روباری باشد
	IF($noe_tahvil_bar_==7)$noe_form="AND bsk_type=4";
	ELSE $noe_form="AND bsk_type=3";
	/*******************/
	// if(($noe_tahvil_bar_!=4)AND($noe_tahvil_bar_!=5)) $activate_kala="AND activate_resid=1";//جابه جایی نباشد فعال یا غیرفعال بودن کالا
	// //جابه جایی باشد
	// if(($noe_tahvil_bar_==4)OR($noe_tahvil_bar_==5)) 
	// {
	  // IF($code_kala_)$name_kala=$db->get_from_where("name_kala","kala","code_kala=$code_kala_");
	  // $Condition="AND $TableName.code_kala='$code_kala_' AND bsk_kamion.plak1='$pl1_' AND bsk_kamion.plak2='$pl2_' AND bsk_kamion.plak3='$pl3_' AND bsk_kamion.plak4='$pl4_'";
    // }
	// ELSE $Condition='';
	//not in:اگر رسیدی وجود ندارد
	$count_resid=$db->get_from_where("COUNT(*)","resid","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND deleted=0 AND status=0 AND year=$mtActiveYear");
	IF($count_resid>0)//with not find_in_set
	{
	 $q1="SELECT bsk_id,bsk_no,bsk_date_k,ranande_name,ranande_melicode,plak,vazn_por,vazn_khali
	      FROM baskool.$TableName
          INNER JOIN baskool.bsk_kamion ON $TableName.kamion_id=bsk_kamion.kamion_id
          INNER JOIN baskool.bsk_ranande ON $TableName.ranande_id=bsk_ranande.ranande_id
		  WHERE 1=1 ".$_SESSION['mt_search_help_baskul']."  $noe_form $Condition AND SUBSTRING(bsk_date_k,1,4)='$mtActiveYear'  AND vazn_por>0 AND vazn_khali>0 AND anbar_id='$mt_gl_id_anbar' 
		  AND not find_in_set(bsk_data.bsk_no,(SELECT group_concat(bsk_no SEPARATOR ',') FROM meat.resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND status=0 AND deleted=0 AND (year=$mtActiveYear ))) 
		  ORDER BY $TableName.bsk_no DESC";	
	}
	ELSE//with not in
	{
	 $q1="SELECT bsk_id,bsk_no,bsk_date_k,ranande_name,ranande_melicode,plak,vazn_por,vazn_khali
	      FROM baskool.$TableName
          INNER JOIN baskool.bsk_kamion ON $TableName.kamion_id=bsk_kamion.kamion_id
          INNER JOIN baskool.bsk_ranande ON $TableName.ranande_id=bsk_ranande.ranande_id
		  WHERE 1=1 ".$_SESSION['mt_search_help_baskul']."  $Condition AND SUBSTRING(bsk_date_k,1,4)='$mtActiveYear' AND bsk_type=3 AND vazn_por>0 AND vazn_khali>0 AND anbar_id='$mt_gl_id_anbar' 
		  AND (bsk_data.bsk_no NOT IN(SELECT bsk_no FROM meat.resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND status=0 AND deleted=0 AND (year=$mtActiveYear )))
		  ORDER BY $TableName.bsk_no DESC";	
	}
   }//پایان اطلاعات برای صفحه رسید
   else//صفحه ایجاد حواله 
   {
	
	//not in:اگر حواله ایی وجود ندارد
    $count_havale=$db->get_from_where("COUNT(*)","havale","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND deleted=0 AND status=0 AND year=$mtActiveYear");
	//جابه جایی نباشد فعال یا غیرفعال بودن کالا
	IF(($noe_tahvil_bar_==1)OR($noe_tahvil_bar_==2)OR($noe_tahvil_bar_==3))//جابه جایی
	{
	 $noe_form="AND bsk_type=1";
	 $activate_kala="AND activate_havale=1"; 
	 IF($h_id_>0)$Condition="AND lnk_id='$h_id_'";
	 ELSE $Condition='';
     //شرط تاریخ حواله های 20 روز قبل
	 $Condition_Date_m = strtotime ( '-20 day' , strtotime ( $today_milady ) ) ;//20 days ago
     $Condition_Date_m = date ( 'Y-m-j' , $Condition_Date_m );	 
	 IF($count_havale>0)//with not find_in_set
	 {
	  //INNER JOIN $mydatabase.list_sardkhane_detail l_a_d ON $TableName.anbar_mtb=l_a_d.id 	  
	  $q1="SELECT bsk_id,bsk_no,bsk_date_k,bsk_type,ranande_name,ranande_melicode,plak,vazn_por,vazn_khali,name_kala,dm_havale.h_code FROM baskool.$TableName
           INNER JOIN baskool.bsk_kamion ON $TableName.kamion_id=bsk_kamion.kamion_id
           INNER JOIN baskool.bsk_ranande ON $TableName.ranande_id=bsk_ranande.ranande_id
		   INNER JOIN sell.dm_havale ON $TableName.lnk_id=dm_havale.h_id
	       INNER JOIN $mydatabase.kala ON dm_havale.h_p_code=kala.code_kala
		   WHERE 1=1 ".$_SESSION['mt_search_help_baskul']." $Condition $activate_kala $noe_form AND SUBSTRING(bsk_date_k,1,4)='$mtActiveYear' AND vazn_por>0 AND vazn_khali>0 AND anbar_id='$mt_gl_id_anbar' 
	       AND not find_in_set(bsk_data.bsk_no,(SELECT group_concat(bsk_no SEPARATOR ',') FROM meat.havale WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND status=0 AND deleted=0 AND year=$mtActiveYear)) 
		   ORDER BY $TableName.bsk_no DESC";
	 }
	 ELSE //with not in
	 {
	  $q1="SELECT bsk_id,bsk_no,bsk_date_k,bsk_type,ranande_name,ranande_melicode,plak,vazn_por,vazn_khali,name_kala,dm_havale.h_code FROM baskool.$TableName
           INNER JOIN baskool.bsk_kamion ON $TableName.kamion_id=bsk_kamion.kamion_id
           INNER JOIN baskool.bsk_ranande ON $TableName.ranande_id=bsk_ranande.ranande_id
		   INNER JOIN sell.dm_havale ON $TableName.lnk_id=dm_havale.h_id
	       INNER JOIN $mydatabase.kala ON dm_havale.h_p_code=kala.code_kala
		   WHERE 1=1 ".$_SESSION['mt_search_help_baskul']." $Condition $activate_kala $noe_form AND SUBSTRING(bsk_date_k,1,4)='$mtActiveYear' AND vazn_por>0 AND vazn_khali>0 AND anbar_id='$mt_gl_id_anbar'  
	       AND (bsk_data.bsk_no NOT IN(SELECT bsk_no FROM meat.havale WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND status=0 AND deleted=0 AND year=$mtActiveYear))
		   ORDER BY $TableName.bsk_no DESC"; 
	 }	  
	}
	ELSE//جابه جایی
	{   
     $noe_form="AND bsk_type=2";
     IF($idJabejae_>0)$Condition="AND lnk_id='$idJabejae_'";
	 ELSE $Condition='';
	 IF($count_havale>0)//with not find_in_set
	 {
	  $q1="SELECT bsk_id,bsk_no,bsk_date_k,bsk_type,ranande_name,ranande_melicode,plak,vazn_por,vazn_khali,name_kala,mojavez_jabejae.shomare_jabejae FROM baskool.$TableName
           INNER JOIN baskool.bsk_kamion ON $TableName.kamion_id=bsk_kamion.kamion_id
           INNER JOIN baskool.bsk_ranande ON $TableName.ranande_id=bsk_ranande.ranande_id
		   INNER JOIN $mydatabase.mojavez_jabejae ON $TableName.lnk_id=mojavez_jabejae.id
		   INNER JOIN $mydatabase.kala ON mojavez_jabejae.code_kala=kala.code_kala
		   WHERE 1=1 ".$_SESSION['mt_search_help_baskul']." $Condition $activate_kala $noe_form AND SUBSTRING(bsk_date_k,1,4)='$mtActiveYear' AND vazn_por>0 AND vazn_khali>0 AND anbar_id='$mt_gl_id_anbar' 
		   AND not find_in_set(bsk_data.bsk_no,(SELECT group_concat(bsk_no SEPARATOR ',') FROM meat.havale WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND status=0 AND deleted=0 AND year=$mtActiveYear)) 
		   ORDER BY $TableName.bsk_no DESC";  
	 }
	 ELSE //with not in
	 {
	  $q1="SELECT bsk_id,bsk_no,bsk_date_k,bsk_type,ranande_name,ranande_melicode,plak,vazn_por,vazn_khali,name_kala,mojavez_jabejae.shomare_jabejae FROM baskool.$TableName
           INNER JOIN baskool.bsk_kamion ON $TableName.kamion_id=bsk_kamion.kamion_id
           INNER JOIN baskool.bsk_ranande ON $TableName.ranande_id=bsk_ranande.ranande_id
		   INNER JOIN $mydatabase.mojavez_jabejae ON $TableName.lnk_id=mojavez_jabejae.id
		   INNER JOIN $mydatabase.kala ON mojavez_jabejae.code_kala=kala.code_kala
		   WHERE 1=1 ".$_SESSION['mt_search_help_baskul']." $Condition $activate_kala $noe_form AND SUBSTRING(bsk_date_k,1,4)='$mtActiveYear' AND vazn_por>0 AND vazn_khali>0 AND anbar_id='$mt_gl_id_anbar' 
		   AND (bsk_data.bsk_no NOT IN(SELECT bsk_no FROM meat.havale WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND status=0 AND deleted=0 AND year=$mtActiveYear))
		   ORDER BY $TableName.bsk_no DESC";  
	 }
	}//END IF jabejaee
	
   }//پایان اطلاعات صفحه حواله
   if(SuperUser())echo $q1.'<br>';
   //IF(SuperUser())echo $q1;
   $all = $db->query($q1);
   $count =$db->num_rows($all);
   IF($count>0)
   {
	while($row1=$db->fetch_assoc($all))
    {
   	 $editclick="onclick='substitute(\"".$row1['bsk_no']."\")'";   
	 if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even"/>';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['bsk_no'].'</td>
	  <td '.$editclick.'>'.$row1['ranande_name'].'</td>
	  <td '.$editclick.'>'.$row1['ranande_melicode'].'</td>
	  <td '.$editclick.'>'.$row1['plak'].'</td>
	  <td '.$editclick.'>'.$row1['vazn_por'].'</td>
	  <td '.$editclick.'>'.$row1['vazn_khali'].'</td>';
	  if($parent_page=="havale_new.php")
	  { 
        if($row1['bsk_type']==1)echo'<td '.$editclick.'>'.$row1['h_code'].'</td>';
        else echo'<td '.$editclick.'>'.$row1['shomare_jabejae'].'</td>';
      }
	 echo '
	 </tr>';
    }   
   }
   ELSE 
   {
	IF(($parent_page=="resid_new.php") AND ($noe_tahvil_bar_==4 OR $noe_tahvil_bar_==5))
	{
	 IF($code_kala_)echo'<tr class="table-even"><td colspan="10">درسیستم توزین اطلاعاتی برای کالای '.$name_kala.' با شماره پلاک حواله انتخابی شما وجود ندارد</td></tr>';
	 ELSE echo'<tr class="table-even"><td colspan="10">لطفاً ابتدا حواله ی مدنظر خود را از لیست حواله ها انتخاب کنید</td></tr>';
	}	
    ELSE echo'<tr class="table-even"><td colspan="10">اطلاعاتی یافت نشد</td></tr>';
   }

   echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_baskul']){ 
 echo '
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">
    <tr>
	 <td width="70px">';
	 if($parent_page=="resid_new.php")//صفحه ایجاد رسید
	  echo'<input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?parent_page='.$parent_page.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_kala_='.$code_kala_.'&pl1_='.$pl1_.'&pl2_='.$pl2_.'&pl3_='.$pl3_.'&pl4_='.$pl4_.'&open_filter=1\'">';
	 else
	  echo'<input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?parent_page='.$parent_page.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&h_id_='.$h_id_.'&idJabejae_='.$idJabejae_.'&open_filter=1\'">';
	 echo'
	 </td>
    </tr>
   </table>
  </td>
 </tr>';}	  
 if($Mode=="Search")
 {
   echo'
	<tr> 
	 <td> 	 
	  <table border="0" bgcolor="#f3f3f3" align="center" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;top:150px;">
       <tr class="title"><td colspan="4"align="center">جستجو</td></tr>
	   <tr>
	    <td align="left" height="40px">شماره باسکول :&nbsp;</td><td align="right">&nbsp;<input class="textboxme2" type="text" name="bsk_no" value="'.$bsk_no.'" onkeypress="return isNumber(event)"/></td>
	   </tr>
	   <tr>
	   	<td align="left" height="40px">نام راننده :&nbsp;</td><td align="right">&nbsp;<input class="textboxme2" type="text" name="ranande_name" value="'.$ranande_name.'"/></td>
	   	 <td align="left"> پلاک خودرو : </td>
	     <td align="right">&nbsp;
	     	   <sup>ایران</sup>
	  	  	   <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/> |
	  	  	   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" style="width:30px;"/>
	  	  	   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" style="width:20px;"/>
	  	  	   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/>
	     </td>
	   </tr>
	   <tr>
        <td colspan="4" align="center" class="title">
		 <input class="buttonme" type="submit" id="sabt" name="Search_x" value="جستجو" >';
         if($parent_page=="resid_new.php")//صفحه ایجاد رسید
          echo'<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?parent_page='.$parent_page.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_kala_='.$code_kala_.'&pl1_='.$pl1_.'&pl2_='.$pl2_.'&pl3_='.$pl3_.'&pl4_='.$pl4_.'\'">';
         else
		  echo'<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?parent_page='.$parent_page.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&h_id_='.$h_id_.'&idJabejae_='.$idJabejae_.'\'">';
		echo'
		</td>
       </tr>
	  </table>
	 </td>
    </tr>';
  }
echo' 
</table>
</div>
</form>
</body>
</html>';	
?>