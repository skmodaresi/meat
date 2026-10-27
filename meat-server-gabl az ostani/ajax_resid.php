<?php
require_once __DIR__ . '/../mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
if(isset($_POST['codeKALA2']))//اطلاعات کالا برای فایل رسید
{
  $result1=$db->query("SELECT kala.name_kala,vahed_kala.sharh_vahedkala,bastebandy.sharh_bastebandy FROM kala 
                      INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala 
					  INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy WHERE code_kala='$codeKALA2'");
  $row1=$db->fetch_assoc($result1);
  $todaydate=$yy.'/'.$mm.'/'.$dd;  
  $exist=$db->get_from_where("count(*)","gheymat","deleted=0");
  if($exist>0)
  {
   $res1_1=$db->query("SELECT id_gheymat FROM gheymat WHERE tarikh_etebar>='".$todaydate."' AND deleted=0 order by id_gheymat DESC LIMIT 0,1");//شماره آخرین جدول قیمت
   if(mysql_num_rows($res1_1)>0)
   {
    $row1_1=$db->fetch_assoc($res1_1);
    $res1_2=$db->query("SELECT * FROM gheymat_detail WHERE id_gheymat=".$row1_1['id_gheymat']." AND code_kala='$codeKALA2' AND deleted=0 ");//بدست آوردن فی و ضریب کد کالا
    $row1_2=$db->fetch_assoc($res1_2);
   }
  }
  $shomare_safar=$db->get_from_where("shomare_safar","resid INNER JOIN shomare_safar ON resid.id_safar=shomare_safar.id_safar","id=$IdResid");
  $exist_gharardad=$db->get_from_where("count(*)","gharardad_kharid","shomare_gharardad='".$shomare_safar."'");
  $id_dastorolamal=$db->get_from_where("id_dastorolamal","gharardad_kharid","shomare_gharardad='$shomare_safar'");
  if($exist_gharardad>0)//اگر قرارداد دارد
  {
   $id_gheymat=$db->get_from_where("id_gheymat_kharid","gheymat_kharid","id_dastorolamal='".$id_dastorolamal."' AND code_kala=$codeKALA2 ");
   $fee_this=$db->get_from_where("gheymat_kharid","gheymat_kharid","id_dastorolamal='".$id_dastorolamal."' AND code_kala=$codeKALA2 ");
   //$fee_this=$db->get_from_where("gheymat_har_kilo","gharardad_kharid","shomare_gharardad='".$shomare_safar."'");
  }
  else {$fee_this=$row1_2['fee'];$id_gheymat=$row1_1['id_gheymat'];}
  //بدست آوردن نرخ تخلیه کالا اگر انبار پیمانکار دارد
  if($_SESSION['mt_status_peymankar']==1)
  {
	 $res_sh_takhlie=$db->query("SELECT sh_jadval_takhlie FROM hazine_takhlie WHERE code_ostan='$mt_gl_code_ostan' AND deleted=0 order by sh_jadval_takhlie DESC LIMIT 0,1");//شماره آخرین جدول هزینه تخلیه
     if(mysql_num_rows($res_sh_takhlie)>0)
	 {
	   $row_sh=$db->fetch_assoc($res_sh_takhlie);
       $nerkhTakhlie=$db->get_from_where("nerkh_takhlie","hazine_takhlie_detail","sh_jadval_takhlie=".$row_sh['sh_jadval_takhlie']." AND code_ostan='$mt_gl_code_ostan' AND code_kala='$codeKALA2'");  
     }
   }
  //هر وقت کد کالا را انتخاب کرد ظاهر شود
  //if($codeKALA2!=Null)
   //{$mojody_img_resid='<img border="0" src="images/animated_help.gif" onClick="window.open(\'help_mojodykala.php?code_kala_='.$codeKALA2.'\',\'_blank\',\'width=700px,left=400px,top=100px,scrollbars=yes\')" title="جدول موجودی کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_center.png\'" onmouseOut="this.src=\'images/animated_help.gif\'"/>';} 
  echo $row1['name_kala'].'^'.$row1['sharh_vahedkala'].'^'.$row1['sharh_bastebandy'].'^'.$id_gheymat.'^'.$fee_this.'^'.$row1_2['zarib'].'^'.$nerkhTakhlie; 
}
/*************************************************************/ 
if(isset($_POST['vaznKHALES']))//اطلاعات باسکول برای فایل رسید
{
	$result_baskul=mysql_query("SELECT nerkh_baskul FROM hazine_baskul WHERE az_vazn<='$vaznKHALES' AND ta_vazn>='$vaznKHALES'");
	$row_baskul=mysql_fetch_array($result_baskul);
	echo $row_baskul['nerkh_baskul'];
}
/*************************************************************/
if(isset($_POST['codeOSTAN1']))//آمدن لیست انبارها با کلیک روی استان
{
  $result7 = $db->query("SELECT * FROM list_sardkhane WHERE code_ostan='$codeOSTAN1'");
  while($row7=$db->fetch_assoc($result7))  
   $anbar_options .= "<option value=".$row7['code_anbar'].">".$row7['name_anbar']."</option>";
  echo $anbar_options;   
}
/*************************************************************/
//ظاهر شدن اطلاعات براساس انتخاب نوع تحویل بار
if(isset($_POST['noeTAHVIL']))
{
  if($noeTAHVIL==4)//اگر نوع تحویل بار جابه جایی باشد
  {echo'
        <td align="left"><span style="color:red">*</span> نام استان مبدأ : </td><td align="right">'.listbox("code_ostan_mabda",$code_ostan_mabda,"code_ostan","name_ostan","ostan","1=1","onchange=getAnbareOstan(this.value) class='text4'","").'</td>
		<td align="left"><span style="color:red">*</span> نام انبار مبدأ :</td><td align="right"><select name="code_anbar_mabda" id="anbar_mabda" class="text4"><option value="0">انتخاب کنيد</option></select></td>';
  }
  else //در سایر موارد
  {echo'
       <td align="left"><span style="color:red">*</span> نام کشتی / فروشنده : </td><td align="right">'.listbox("code_skk",$code_skk,"code_skk","name_skk","keshty","1=1","onchange=getShomareSafar(this.value) class='text4'","").'</td>
	   <td align="left"><span style="color:red">*</span> شماره سفر :</td><td align="right"><select name="id_safar" id="shomare_safar" class="text4"><option value="0">انتخاب کنيد</option></select></td>
	   <td align="left"><span style="color:red">*</span> مبدأ بارگيری : </td><td align="right">'.listbox("code_mabda",$code_mabda,"code_mabda","name_mabda","mabady_vorudy","","class='text4'","").'</td>';
  }
}
/*************************************************************/
if(isset($_POST['codePEYMAN']))//نام پیمانکار حمل
{
  $peymankar=$db->get_from_where("name_peymankar_haml","peymankar_haml","code_peymankar_haml=$codePEYMAN");
  echo $peymankar;   
}
/*************************************************************/
if(isset($_POST['codeMABDA_V']))//نام مبدأ ورودی
{
  $name_mabda=$db->get_from_where("name_mabda","mabady_vorudy","code_mabda=$codeMABDA_V");
  echo $name_mabda;   
}
?>