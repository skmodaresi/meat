<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>window.location='mainpage.php';</script>";
$FileName="resid_detail_new.php";
$TableName="resid_detail";
$logtime=date('H:i:s');
  // $tmp_q=("CREATE TEMPORARY TABLE IF NOT EXISTS `tmp_resid_detail` (
  // `id` int(11) NOT NULL auto_increment,
  // `code_ostan` int(11) NOT NULL,
  // `code_anbar` int(11) NOT NULL,
  // `shomare_resid` varchar(50) collate utf8_persian_ci NOT NULL,
  // `year` smallint(6) NOT NULL,
  // `code_kala` int(11) NOT NULL,
  // `code_keshvar` mediumint(9) NOT NULL,
  // `id_gheymat_this` int(11) default NULL,
  // `fee_this` int(11) default NULL,
  // `zarib_this` int(11) default NULL,
  // `nerkh_takhlie_this` int(11) default NULL,
  // `vazn_mabda_r_d` double NOT NULL,
  // `kasry_mojaz_r_d` float NOT NULL,
  // `kasry_kol_r_d` int(11) NOT NULL,
  // `kasry_gheyremojaz_r_d` float NOT NULL,
  // `vazn_ezafe_r_d` float NOT NULL,
  // `code_karton` mediumint(9) NOT NULL,
  // `vazn_karton_this` float NOT NULL,
  // `vazn_nakhales_r_d` float NOT NULL,
  // `tedad_karton_r_d` mediumint(9) NOT NULL,
  // `sum_karton_r_d_this` float NOT NULL,
  // `vazn_khales_r_d` float NOT NULL,
  // `mablagh_jarimekasry_r_d` int(11) default NULL,
  // `mablagh_takhlie_r_d` int(11) default NULL,
  // PRIMARY KEY  (`code_ostan`,`code_anbar`,`year`,`shomare_resid`,`code_kala`,`code_keshvar`),
  // UNIQUE KEY `id` (`id`)
 // ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1;");
  // $tmp_res=mysql_query($tmp_q);

  //echo $shomare_resid_;
//echo $cid;
//$right_ins=0;$right_edt=0;$right_del=0;
// if (right(35)) $right_ins=1;
// if (right(36)) $right_edt=1;
// if (right(37)) $right_del=1;
  $right_ins=1;
  $right_edt=1;
  $right_del=1;  
//echo $mt_gl_code_ostan.'<br/>';  
//echo $code_ostan_.'<br/>';  
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>افزودن کالا به رسید</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
} 
function getDetailKala2(code_kala)<!--اطلاعات کالا-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKALA2:code_kala},function(data){			 		 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#sharh_bastebandy").val(splKala[2]);
			  $("#id_gheymat_this").val(splKala[3]);
			  $("#fee_this").val(splKala[4]);
			  $("#zarib_this").val(splKala[5]);
			  $("#nerkh_takhlie_this").val(splKala[6]);
		 });
    $("#loading").fadeOut("fast");
}
function getDetailKeshvar(code_keshvar)<!--اطلاعات کشور-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKESHVAR : code_keshvar},function(data){$("#name_keshvar").val(data);});
    $("#loading").fadeOut("fast");
}
function getVaznKarton(c_karton)<!-- اطلاعات کارتن-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeKARTON: c_karton},function(data){
		   var splKarton = data.split("^");
		   $("#vazn_karton_this").val(splKarton[1]);
		 });
   $("#loading").fadeOut("fast");	
}
function sumkarton()
{
 var sum_k;
 sum_k=Number(document.myform.vazn_karton_this.value)*Number(document.myform.tedad_karton_r_d.value);
 document.myform.sum_karton_r_d_this.value=sum_k;
}
<!--محاسبه کسری مجاز-->
function mojaz()
{
 var natije_mojaz;
 natije_mojaz=parseFloat((document.myform.vazn_mabda_r_d.value)*((document.myform.zarib_this.value)/1000)).toFixed(2);                                       
 document.myform.kasry_mojaz_r_d.value=natije_mojaz;
 return natije_mojaz;
}
function vazn_khales_resid()
{
 var natije_vazn;
 natije_vazn=Number(document.myform.vazn_nakhales_r_d.value)-Number(document.myform.sum_karton_r_d_this.value);                                      
 document.myform.vazn_khales_r_d.value=natije_vazn;
} 
</script>
</head>';
if(!(isset($Mode))) $Mode='';
$cnt=$db->get_from_where("COUNT(*)","$TableName","shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$gl_code_sardkhane AND year=$mtActiveYear");
/******************** Insert- Edit- Delete ************/
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($c_kala,$c_keshvar,$t_tolid,$c_karton,$v_n_r_d)
 // if(isPermitSave($code_kala,$code_keshvar,$tarikh_tolid,$code_karton,$vazn_nakhales_r_d,$vazn_karton_this,$tedad_karton_r_d,
                 // $sum_karton_r_d_this,$vazn_khales_r_d,$mt_gl_code_ostan,$gl_code_sardkhane,$mtActiveYear,$fee,$zarib,$cid))
{
 $flag=false;
 if(!($a and $b and $c))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($a))//تکراری نبودن این کد کالا در جدول جزئیات قیمت
 { 
    $q8="SELECT code_kala FROM gheymat_detail WHERE code_kala='$a' AND id='$d'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('برای این کد کالا قبلاً قیمت ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
 if (!justNumber($b))//عدد بودن في 
 {
   $flag=false;
   echo"<script>alert('فيلد فی نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
 //else if((!empty($zarib)) and (preg_match('/^[0-9]+$/', $zarib) === 0))//عدد بودن ضريب
  //echo"<script>alert('فيلد ضريب نامعتبر است')</script>"; 
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$c,$d,$e)
{
  $flag=false;
  if(!($a and $b and $c))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا تمام فيلد ها را تکميل نماييد');</script>";
   return $flag;
  } 
  else $flag=true;
  if(!empty($a))//تکراری نبودن این کد کالا در جدول جزئیات قیمت
  {  
   $q10="SELECT * FROM gheymat_detail WHERE code_kala='$a' AND id='$e'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$d)){
   echo"<script>alert('برای این کد کالا قبلاً قیمت ثبت شده است!')</script>";
   $flag=false;
   return $flag;
   }
  else $flag=true;
  }
  else $flag=true;
  if (!justNumber($b))//عدد بودن في 
  {
   $flag=false;
   echo"<script>alert('فيلد فی نامعتبر است!')</script>";
   return $flag;
  }
  else $flag=true;
 return $flag;
}

$detailArray=new array();

/*************INSERT Detail BUTTON******/// ثبت اطلاعات کالا    
if(isset($Insert_x_detail))
{
 //if(isPermitSave_d($code_kala,$code_keshvar,$tarikh_tolid,$code_karton,$vazn_nakhales_r_d,$vazn_karton_this,$tedad_karton_r_d,
   //             $sum_karton_r_d_this,$vazn_khales_r_d,$mt_gl_code_ostan,$gl_code_sardkhane,$mtActiveYear))
 //{  
  
  // $detailArray=array('id'=>$id,'code_ostan'=>$mt_gl_code_ostan,'code_anbar'=>$gl_code_sardkhane,'shomare_resid'=>$shomare_resid_,
                     // 'year'=>$mtActiveYear,'code_kala'=>$code_kala,'code_keshvar'=>$code_keshvar,'id_gheymat_this'=>$id_gheymat_this,
					 // 'fee_this'=>$fee_this,'zarib_this'=>$zarib_this,'nerkh_takhlie_this'=>$nerkh_takhlie_this,'vazn_mabda_r_d'=>$vazn_mabda_r_d,
					 // 'kasry_mojaz_r_d'=>$kasry_mojaz_r_d,'kasry_kol_r_d'=>$kasry_kol_r_d,'code_karton'=>$code_karton,'vazn_karton_this'=>$vazn_karton_this);
  
  // $detailArray=array_push($detailArray,array('id'=>$id,'code_ostan'=>$mt_gl_code_ostan,'code_anbar'=>$gl_code_sardkhane,'shomare_resid'=>$shomare_resid_,
                     // 'year'=>$mtActiveYear,'code_kala'=>$code_kala,'code_keshvar'=>$code_keshvar,'id_gheymat_this'=>$id_gheymat_this,
					 // 'fee_this'=>$fee_this,'zarib_this'=>$zarib_this,'nerkh_takhlie_this'=>$nerkh_takhlie_this,'vazn_mabda_r_d'=>$vazn_mabda_r_d,
					 // 'kasry_mojaz_r_d'=>$kasry_mojaz_r_d,'kasry_kol_r_d'=>$kasry_kol_r_d,'code_karton'=>$code_karton,'vazn_karton_this'=>$vazn_karton_this);
  // )
      
  //$_SESSION['r_detailArr']=$detailArray;
  echo"
	<script>
     window.close();
	 window.opener.location='resid_new.php?shomare_resid_=".$shomare_resid_."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';
	</script>";
 
 
 // $insert_detail_q=("INSERT INTO resid_detail(code_ostan,code_anbar,shomare_resid,year,code_kala,code_keshvar,id_gheymat_this,fee_this,zarib_this,nerkh_takhlie_this,
   //                  vazn_mabda_r_d,kasry_mojaz_r_d,kasry_kol_r_d,code_karton,vazn_karton_this)
    //                 VALUES('$mt_gl_code_ostan','$gl_code_sardkhane','$shomare_resid_','$mtActiveYear','$code_kala','$code_keshvar','$id_gheymat_this','$fee_this','$zarib_this','$nerkh_takhlie_this',
		//			 '$vazn_mabda_r_d','$kasry_mojaz_r_d','$kasry_kol_r_d','$code_karton','$vazn_karton_this')");  
  //$insert_detail_res=mysql_query($insert_detail_q);
    
	//خواندن موجودی  
        // $q_m="SELECT * from mojody_kala where code_kala=$code_kala AND code_keshvar=$code_keshvar AND sal_tolid_shamsi=$sal_tolid_shamsi AND mah_tolid_shamsi=$mah_tolid_shamsi AND code_ostan=$mt_gl_code_ostan AND code_anbar=$gl_code_sardkhane AND year=$mtActiveYear AND deleted=0";       
        // $res_m=mysql_query($q_m);
        // $row_m=mysql_fetch_assoc($res_m);
        // //آپدیت موجودی کالا
        // $update_mojody_nakhales=$row_m['mojody_nakhales']+$vazn_nakhales_r_d;//آپدیت موجودی ناخالص کالا در جدول موجودی کالا  
        // $update_mojody_khales=$row_m['mojody_khales']+$vazn_khales_r_d;//آپدیت موجودی خالص کالا در جدول موجودی کالا
        // $update_tedad_karton=$row_m['tedad_karton']+$tedad_karton_r_d;//آپدیت تعداد کارتن های موجود در انبار
        // $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton' WHERE code_kala='$code_kala' AND code_keshvar='$code_keshvar' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$gl_code_sardkhane' AND year='$mtActiveYear' AND deleted=0");  
  
  
   // $res_id = $db->query("SELECT Max(id) FROM resid_detail");
   // $row_id = $db->fetch_array($res_id);
    //$max_id=$row_id[0];
   // $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','resid_detail','$max_id','ثبت',".($yymmdd).",'$logtime')");   

 // }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x_detail))
{
 if(isPermitEdit($code_kala,$fee,$zarib,$id_,$cid))
 {
  $Mode=''; 
  $edit_q=("UPDATE $TableName SET id='$cid',code_kala='$code_kala',fee='$fee',zarib='$zarib' WHERE `id`='$id_';");	
  $edit_res=$db->query($edit_q,'مشکلي در ويرايش مشخصات به وجود آمده است');
  $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");  
 } 
}
/************DELETE BUTTON********/// حذف کالا از رسید
if (isset($Delete_x_detail))
{
 $Mode=''; 
 $del_detail_q = "DELETE FROM $TableName WHERE id=$id_ 
               AND($shomare_resid_ NOT IN(SELECT shomare_resid FROM resid_kala_detail WHERE shomare_resid=$shomare_resid_ AND code_kala=$code_kala_ AND code_ostan=$mt_gl_code_ostan AND code_anbar=$gl_code_sardkhane AND year=$mtActiveYear))";
 $del_detail_res = mysql_query($del_detail_q);
 if(mysql_affected_rows()==0)
   echo"<script>alert('برای این کالا جزئیاتی ثبت شده برای حذف ، ابتدا جزئیات را حذف نمایید!')</script>";
 else if($del_detail_res)
   {$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
   //echo "<script>window.location=resid_detail.php?shomare_resid_=".$shomare_resid."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";
    }
 else
    $message ='<span style="color:red;font: bold 12px tahoma;"> *مشکلی در حذف به وجود آمده است ! *</span>';
 }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus()">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">';
   if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
   else $code_a=$mt_gl_code_ostan;
	echo '	 
	  <table border="0" bgcolor="#E9F7FD" align="center" width="99%" height=350px cellpadding="0" cellspacing="0" style="">
        <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="11" align="center">افزودن کالای جدید به رسید شماره '.$code_a.$gl_code_sardkhane.$shomare_resid_.'</td></tr>
       <tr><td>&nbsp;</td></tr>	   
       <tr>
	    <td align="left" width=""><span style="color:red">*</span> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_kala" value="'.$code_kala.'" maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onchange="getDetailKala2(this.value);" onfocus="getDetailKala2(this.value);" style="width:50px"/>
		 <img border="0" src="images/help.png" onClick="window.open(\'help_kala.php\',\'_blank\',\'width=400px,height=500px,left=500px,top=100px\')" title="جدول کد کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
		</td>
	   	<td align="left" width="">نام کالا : &nbsp;</td><td align="right"><input class="textboxme" readonly type="text" name="name_kala" id="name_kala" value="'.$name_kala.'"/></td>
	   </tr>
	   <tr>
		  <input type="hidden"  id="id_gheymat_this" name="id_gheymat_this" value="'.$id_gheymat_this.'"/></td>
		<td align="left" width="">فی : &nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="fee_this" id="fee_this" value="'.$fee_this.'"/></td>
	    <td align="left" width="">ضریب : &nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly id="zarib_this" name="zarib_this" value="'.$zarib_this.'"/></td>
	    <td align="left" width="">نرخ تخلیه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly id="nerkh_takhlie_this" name="nerkh_takhlie_this" value="'.$nerkh_takhlie_this.'"/></td>
	   </tr>
	   <tr>
	   	<td align="left"><span style="color:red">*</span> کد کشور تولید کننده  :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);" style="width:50px"/>
 		 <img border="0" src="images/help.png" onClick="window.open(\'help_keshvar.php\',\'_blank\',\'width=400px,height=500px,left=500px,top=100px,scrollbars=yes\')" title="جدول کد کشور" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>		 
        </td>		
		<td align="left"> نام کشور : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="name_keshvar" id="name_keshvar" value="'.$name_keshvar.'"/></td>
	   <tr>
       </tr>	   
		<td align="left"><span style="color:red">*</span> وزن مبدأ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="vazn_mabda_r_d" value="'.($vazn_mabda_r_d).'" onblur="return mojaz()" onKeydown="return PressfloatOnly(event,this)"/></td>  
		<td align="left">کسری مجاز :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_mojaz_r_d" value="'.$kasry_mojaz_r_d.'"/></td>
	   </tr>
	   <tr>	
		<td align="left"><span style="color:red">*</span> کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>
			 <img border="0" src="images/help.png" onClick="window.open(\'help_karton.php\',\'_blank\',\'width=400px,height=500px,left=500px,top=100px,scrollbars=yes\')" title="جدول نوع کارتن" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
		</td>
	   	<td align="left"><span style="color:red">*</span> وزن کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" value="'.$vazn_karton_this.'"/></td>
	   </tr>
       <tr>	   
		 <td align="left"><span style="color:red">*</span> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton_r_d" value="'.$tedad_karton_r_d.'" onblur="return sumkarton()"  onkeypress="return isNumber(event)"/></td>       		
	   	 <td align="left"><span style="color:red">*</span> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_r_d_this" value="'.$sum_karton_r_d_this.'"/></td>
	   </tr>
	   <tr>
	    <td align="left"><span style="color:red">*</span> وزن ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="vazn_nakhales_r_d" value="'.$vazn_nakhales_r_d.'" onblur="return vazn_khales_resid()" onkeypress="return isNumber(event)"/></td>
		<td align="left"><span style="color:red">*</span> وزن خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="vazn_khales_r_d" value="'.$vazn_khales_r_d.'" onfocus="return vazn_khales_resid()"/></td>
	   </tr>
	   <tr>
	   	<td align="left">کل کسری :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_kol" value="'.$kasry_kol.'"/></td>
	   	<td align="left">کسری غیر مجاز :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_gheyremojaz" value="'.$kasry_gheyremojaz.'" /></td>
	    <td align="left">وزن اضافه :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_ezafe" value="'.$vazn_ezafe.'"/></td>
	   </tr>
	   <tr>
	    <td align="left">مبلغ جریمه کسری :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_jarimekasry_r_d" value="'.$mablagh_jarimekasry_r_d.'"/></td>
	    <td align="left">مبلغ تخلیه :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_takhlie_r_d" value="'.$mablagh_takhlie_r_d.'"/></td>
	   </tr>
	   <tr style="background-color : #32819b">
        <td colspan="11" align="center">
		 <input class="buttonme" type="submit" name="Insert_x_detail" id="sabt" value="ثبت کالا در رسید">
         <!--<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'resid_new.php?shomare_resid_='.$shomare_resid_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">-->
        </td>
       </tr>
      </table>
</div>';
/********************END********************/	
 echo'
'.$message .'
</form>
</body>
</html>';	
?>