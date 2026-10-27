<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="chart_manager_col_grkala.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='موجودی گروه کالاهای هر استان';
require_once('head.html');
/****************فیلترها روی گزارش******************/
/******************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val) 
      {
       $Condition_ostan_temp.=" ostan.code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{
 $Condition_ostan=' ostan.code_ostan='.$_SESSION['mt_code_ostan'].'';
}
/******************مالکیت انبارها******************/  
if(is_array($malekiyatchoice))
{
    foreach($malekiyatchoice as $key => $mal_val) 
    {
       $Condition_malekiyat_temp.=" T.noe_malekiyat='$mal_val' OR";
    }
    if($mal_val==-1){$Condition_malekiyat.="1=1 OR";}
    else {$Condition_malekiyat.=" $Condition_malekiyat_temp";}
    $lastSpacePosition = strrpos($Condition_malekiyat," ");
    $Condition_malekiyat =substr($Condition_malekiyat,0,$lastSpacePosition);
}
/******************نمایش یا عدم نمایش انبارهای موقت******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=3;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)
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
if(!$ok)
{
echo'
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت</td>
	 <td align="left"><input type="checkbox" name="chkactivate"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
	<tr class="tr1">
	 <td align="left" style="height:45px">نوع مالکیت : </td>
	 <td align="right">
	 &nbsp;<select name="malekiyatchoice[]" class="easyui-combobox" style="width:150px;" data-options=panelHeight:155 multiple>';
	 $malekiyat_options = "<option value='-1' selected>همه</option>";
	 foreach($noe_malekiyatArr AS $key=>$val)
	 {
	  IF($key==0)continue;
	  $malekiyat_options .= "<option value=".$key.">".$val."</option>";
	 }
	 echo $malekiyat_options;
	 echo'
	   </select>      
	  </td>
	  <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:94").'</td>	
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1"> 
	  <td align="left" style="height:45px">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" size="6" style="width:200px;" multiple >';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>      
	  </td>
	 </tr>';
	}
	echo'
	<tr class="footer"><td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
  </td>
 </tr>
</table> ';
}
else 
{
 /*سطر نمایش فیلترها*/ 
  if(($ostanchoice))
  {
	if($ostan_val==-1)$filter_string='همه استانها';
	else $filter_string=' استان : ';
    foreach($ostanchoice as $ostan_key => $ostan_val) {
	       $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	       $filter_string.=''.$nameOstan.'&nbsp;-';
    }
  }
  if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
  if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
  if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال ';
  if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال ';
  if(is_array($malekiyatchoice))
  {
	$filter_string.=' - نوع مالکیت  : ';
    if($mal_val==-1)$filter_string.=' همه ';
	else{
		 foreach($malekiyatchoice as $mal_key => $mal_val) {
	      $nameMalekiyat=$noe_malekiyatArr[$mal_val];
	      $filter_string.=''.$nameMalekiyat.'&nbsp;';
         }	 
    } 
   }
  if($noe_namayesh==1)  $filter_string.="- نمایش اطلاعات : خالص";
  if($noe_namayesh==2)  $filter_string.="- نمایش اطلاعات : ناخالص";
  if($noe_namayesh==3)  $filter_string.="- نمایش اطلاعات : تعداد";   
   //$sql_ostan2="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane T WHERE $Condition_movaghat $Condition_anbar_activate_ostan AND ($Condition_malekiyat)) AND($Condition_ostan) ORDER BY name_ostan";
	$sql_ostan="SELECT distinct(ostan.code_ostan),name_ostan FROM ostan 
	            INNER JOIN list_sardkhane T ON ostan.code_ostan=T.code_ostan
	            INNER JOIN mojody_kala m_k ON m_k.code_ostan=T.code_ostan AND m_k.code_anbar=T.code_anbar  
	            WHERE  $Condition_movaghat $Condition_anbar_activate_ostan AND ($Condition_malekiyat) AND($Condition_ostan) AND year=$mtActiveYear ORDER BY name_ostan";
	//echo $sql_ostan;
	$result_ostan = mysql_query($sql_ostan);
	IF(mysql_num_rows($result_ostan)>0)//وجود داشتن
	{
	 WHILE($row_ostan = mysql_fetch_assoc($result_ostan)) 
	 {
	  $containerID='container'.$row_ostan['code_ostan'];
	  echo'
      <img src="images/loading.gif" id="loading" class="loading_img"/>
	  <div style="width: 99%; margin: 0 auto; background-color: white;">
	   <button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button>
	   <span>فیلتر شده براساس : '.$filter_string.'</span>
	  </div>
      <div id="'.$containerID.'" style="width: 99%; height: 600px; margin: 0 auto"></div>
	  <br class="pbreak">';
	 }
	}//END IF //وجود داشتن
	ELSE{
	 echo'
	 <div class="msg_error">
	  <span >اطلاعاتی یافت نشد</span><br>
	  <button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button>
	 </div>';
	}
}
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript" src="scripts/highcharts/highcharts.js"></script>
<script type="text/javascript" src="scripts/highcharts/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
  <?php
   //echo $sql_ostan;
   $result_ostan = mysql_query($sql_ostan);
   WHILE($row_ostan = mysql_fetch_assoc($result_ostan)) 
   {
	IF(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $ostanName='(استان : '.$row_ostan['name_ostan'].')';
	ELSE  $ostanName='(استان : '.$mt_gl_name_ostan.')';
	$containerID='container'.$row_ostan['code_ostan'];
	$morghArray = array();
	$gooshtArray=array();
	$conserveArray=array();
	$eggArray=array();
	$eggSArray=array();
	$sausageArray=array();
	$anbarnameArray=array();
	IF(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$sql_anbar = "SELECT  T.code_anbar,T.name_anbar,T.zarfiyat FROM list_sardkhane T WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row_ostan['code_ostan']." ORDER BY name_anbar";
	ELSE $sql_anbar = "SELECT T.code_anbar,T.name_anbar,T.zarfiyat FROM user_ostan_anbar INNER JOIN list_sardkhane T ON T.code_ostan=user_ostan_anbar.code_ostan AND T.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND T.code_ostan=".$row_ostan['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." ORDER BY name_anbar";
	//echo $sql_anbar;
	$result_anbar = mysql_query($sql_anbar);
	WHILE($row = mysql_fetch_assoc($result_anbar)) 
	{
	 IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h';$tadilField='meghdar_khales_tadil';}
	 ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h';$tadilField='meghdar_nakhales_tadil';}
	 ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h';$tadilField='tedad_karton_tadil';}
	 //morgh:code_group_kala_top=4
	 $ConditionKala='';$ConditionKala="AND code_group_kala_top=4";
	 $mojodyAval_morgh=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala  AND year='$mtActiveYear' AND deleted=0");        		 
	 $jameVarede_morgh=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row['code_anbar']." $ConditionKala AND T.year='$mtActiveYear' AND r.deleted=0 AND r.status=0 AND tarikh_resid<='$date2'");
	 $jameSadere_morgh=$db->get_from_where("SUM($havaleField)","havale T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<='$date2'");
	 $meghdarTadil_Ezafe_morgh=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $meghdarTadil_Kasry_morgh=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $mojody_morgh=$mojodyAval_morgh+$jameVarede_morgh-$jameSadere_morgh+$meghdarTadil_Ezafe_morgh-$meghdarTadil_Kasry_morgh;			   
	 //goosht:code_group_kala_top=5
	 $ConditionKala='';$ConditionKala="AND code_group_kala_top=5";
	 $mojodyAval_goosht=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0");        	
	 $jameVarede_goosht=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row['code_anbar']." $ConditionKala AND T.year='$mtActiveYear' AND r.deleted=0 AND r.status=0 AND tarikh_resid<='$date2'");
	 $jameSadere_goosht=$db->get_from_where("SUM($havaleField)","havale T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<='$date2'");
	 $meghdarTadil_Ezafe_goosht=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $meghdarTadil_Kasry_goosht=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $mojody_goosht=$mojodyAval_goosht+$jameVarede_goosht-$jameSadere_goosht+$meghdarTadil_Ezafe_goosht-$meghdarTadil_Kasry_goosht;			   
	 //konserv:code_group_kala_top=6
	 $ConditionKala='';$ConditionKala="AND code_group_kala_top=6";
	 $mojodyAval_conserve=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0");        	
     $jameVarede_conserve=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row['code_anbar']." $ConditionKala AND T.year='$mtActiveYear' AND r.deleted=0 AND r.status=0 AND tarikh_resid<='$date2'");
	 $jameSadere_conserve=$db->get_from_where("SUM($havaleField)","havale T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<='$date2'");
	 $meghdarTadil_Ezafe_conserve=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $meghdarTadil_Kasry_conserve=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $mojody_conserve=$mojodyAval_conserve+$jameVarede_conserve-$jameSadere_conserve+$meghdarTadil_Ezafe_conserve-$meghdarTadil_Kasry_conserve;			   
	 //egg:code_group_kala_top=7
	 $ConditionKala='';$ConditionKala="AND code_group_kala_top=7";
	 $mojodyAval_egg=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0");        	
     $jameVarede_egg=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row['code_anbar']." $ConditionKala AND T.year='$mtActiveYear' AND r.deleted=0 AND r.status=0 AND tarikh_resid<='$date2'");
	 $jameSadere_egg=$db->get_from_where("SUM($havaleField)","havale T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<='$date2'");
	 $meghdarTadil_Ezafe_egg=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $meghdarTadil_Kasry_egg=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $mojody_egg=$mojodyAval_egg+$jameVarede_egg-$jameSadere_egg+$meghdarTadil_Ezafe_egg-$meghdarTadil_Kasry_egg;			   
	 //egg_s:code_group_kala_top=8
	 $ConditionKala='';$ConditionKala="AND code_group_kala_top=8";
	 $mojodyAval_egg_s=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0");        	
     $jameVarede_egg_s=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row['code_anbar']." $ConditionKala AND T.year='$mtActiveYear' AND r.deleted=0 AND r.status=0 AND tarikh_resid<='$date2'");
	 $jameSadere_egg_s=$db->get_from_where("SUM($havaleField)","havale T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<='$date2'");
	 $meghdarTadil_Ezafe_egg_s=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $meghdarTadil_Kasry_egg_s=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $ConditionKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	 $mojody_egg_s=$mojodyAval_egg_s+$jameVarede_egg_s-$jameSadere_egg_s+$meghdarTadil_Ezafe_egg_s-$meghdarTadil_Kasry_egg_s;			   
     
     //sausage:code_group_kala_top=9
	 array_push($morghArray,(float)$mojody_morgh);
	 array_push($gooshtArray,(float)$mojody_goosht);
	 array_push($conserveArray,(float)$mojody_conserve);
	 array_push($eggArray,(float)$mojody_egg);
	 array_push($eggSArray,(float)$mojody_egg_s);
	 //array_push($sausageArray,(float)$mojody_sausage);
	 array_push($anbarnameArray,$row['name_anbar']);	 
    }
    $morghMojody = json_encode($morghArray);
	$gooshtMojody = json_encode($gooshtArray);
    $conserveMojody = json_encode($conserveArray);
    $eggMojody = json_encode($eggArray);
    $eggSMojody = json_encode($eggSArray);
    //$sausageMojody = json_encode($sausageArray);
    $anbarname = json_encode($anbarnameArray);
 ?> 
	$('#<?php echo $containerID ?>').highcharts({
        chart: {
            type: 'column',
			style: {
					fontFamily: 'yekan',	
					direction: "ltr"
                    }
        },
		legend: {
            
            backgroundColor: '#FFFFFF',
            floating: true,
            align: 'left',
			y:-10,
			x:10,
            verticalAlign: 'top',
			padding:5,
			symbolPadding: 0,
            symbolWidth: 30,
			width:300,
			// rtl:true,
			shadow :true,
            borderWidth:1   		
        },
        title: {
            text: '<?php echo $titr.$ostanName ?>',
			style: {
                color: '#000',
                fontSize: '16px'  
             }
        },
        xAxis: {
            categories: <?php echo $anbarname; ?>,
            crosshair: true,
	        labels: {
              style: {
                color: '#000',
                fontSize: '12px'  
             }
			}
        },
        yAxis: {
            min: 0,
            tickInterval: <?php if($noe_namayesh==3) echo 10000; else echo 100000; ?>,
			title: {
                text: 'موجودی گروه کالا',
		    style: {
                color: '#000',
                fontSize: '14px'     
             }
            },
		    labels: {
              style: {
                color: '#000',
                fontSize: '12px',
                fontWeight: 'bold'
             }
			}
        },
        tooltip: {
            headerFormat: '<span style="font-family: "Yekan"; font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.3f} </b>kg</td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
		},

		plotOptions: {
            column: {
				pointPadding: 0.2,
                borderWidth: 0,
				dataLabels:{
					enabled: true,
                    format: '{point.y:,.3f}',
					rotation:0,
                    color:"black",
                    style: {
                        fontSize: "6pt"	
                    }
				}
            },
			series: {
               pointPadding: 0			   
            }
        },
        series: [
		{
            name: 'مرغ',
			color: '#1D4162',
            data: <?php echo $morghMojody; ?>
        },
		{
            name: 'گوشت',
            color: '#7cb5ec',
			data: <?php echo $gooshtMojody; ?>
        },
		{
            name: 'کنسرو',
			color: '#660033',
            data: <?php echo $conserveMojody; ?>
        },
		{
            name: 'تخم مرغ خوراکی',
			color: '#037318',
            data: <?php echo $eggMojody; ?>
        },
		{
            name: 'تخم مرغ صنعتی',
			color: '#e3090e',
            data: <?php echo $eggSMojody; ?>
        }
		]
    });
 <?php } ?>
});
</script>