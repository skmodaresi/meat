<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <script type="text/javascript" src="jquery-1.2.3.pack.js"></script> 
</head> 
<?php

/*ebh_type=1 yani kole havale ebtal shode
pas ebh_h_id=h_id bode
va
baraye ebh_type=0
ebh_h_id=his_id

*/

/*
 phd_status=1 yani baraye en kala havale zade shode
 agar h_ebtalk_amount va status=2 yani kole havale ebrtal shode va en meghdaro dashte
 */

?>
<?php
include_once 'includer.php';
$i=1;
for ( ; $i <37; ++$i ){
$query = "SELECT * FROM  dm_pish_havale_det where phd_id_province=".$i."  ";	
		$lnk = mysql_query($query);

	if(mysql_affected_rows()>0){
				
		while($row= mysql_fetch_assoc($lnk)){
			
			if($row['phd_price']==0){
				
				
				$query2 = "
					UPDATE dm_pish_havale_det  
					SET 
						`phd_p_price` = '". 29000 ."'
														 
					WHERE 
						 phd_id_province='".$i."'	
					 and 
						 phd_id=".$row['phd_id']."";
						
				$lnk2 = mysql_query($query2);
				if(mysql_error()) print mysql_error();
				
				$phd_price=$row['phd_p_price']*$row['phd_amount'];
					
					$query1 = "
					UPDATE dm_pish_havale_det  
					SET 
						`phd_price` = '". $phd_price ."'
														 
					WHERE 
						 phd_id_province='".$i."'	
					 and 
						 phd_id=".$row['phd_id']."";
						
				$lnk1 = mysql_query($query1);
				if(mysql_error()) print mysql_error();
					
					
				}
						
			}			
	}
}

$i=1;
for ( ; $i <37; ++$i ){
$query = "SELECT * FROM  dm_havale where h_id_province=". $i ."  ";	
		$lnk = mysql_query($query);
//print $query;
	if(mysql_affected_rows()>0){
				
		while($row= mysql_fetch_assoc($lnk)){
			//if($row['h_price']==0){
			echo $row['h_amount'];
				$h_price= $row['h_p_price'] * $row['h_amount'];
			
					$query1 = "
					UPDATE dm_havale  
					SET 
						`h_price` = '". $h_price ."'
														 
					WHERE 
						 h_id_province='". $i ."'
						 and 
						 h_id=".$row['h_id']."	
					 ";
						
				$lnk1 = mysql_query($query1);
				if(mysql_error()) print mysql_error();
				print $query1;	
					
				}
						
			}			
	}
//}
function num_to_str($x ,$and0=false){
if($and0)
	$x = str_replace(0,'صفر',$x);
	
$x = str_replace(1,'يک',$x);
$x = str_replace(2,'دو',$x);
$x = str_replace(3,'سه',$x);
$x = str_replace(4,'چهار',$x);
$x = str_replace(5,'پنج',$x);
$x = str_replace(6,'شش',$x);
$x = str_replace(7,'هفت',$x);
$x = str_replace(8,'هشت',$x);
$x = str_replace(9,'نه',$x);

return $x;
}

function num_to_str2($x,$inten=false){
if($inten)
{
$x = str_replace(11,'یازده',$x);
$x = str_replace(12,'دوازده',$x);
$x = str_replace(13,'سیزده',$x);
$x = str_replace(14,'چهارده',$x);
$x = str_replace(15,'پانزده',$x);
$x = str_replace(16,'شانزده',$x);
$x = str_replace(17,'هفده',$x);
$x = str_replace(18,'هجده',$x);
$x = str_replace(19,'نوزده',$x);
}

$x = str_replace(10,'ده',$x);
$x = str_replace(20,'بیست',$x);
$x = str_replace(30,'سی',$x);
$x = str_replace(40,'چهل',$x);
$x = str_replace(50,'پنجاه',$x);
$x = str_replace(60,'شصت',$x);
$x = str_replace(70,'هفتاد',$x);
$x = str_replace(80,'هشتاد',$x);
$x = str_replace(90,'نود',$x);

return $x;
}

function num_to_str3($x){
$x = str_replace(200,'دویست',$x);
$x = str_replace(300,'سیصد',$x);
$x = str_replace(400,'چهارصد',$x);
$x = str_replace(500,'پانصد',$x);
$x = str_replace(600,'ششصد',$x);
$x = str_replace(700,'هفتصد',$x);
$x = str_replace(800,'هشتصد',$x);
$x = str_replace(900,'نهصد',$x);
$x = str_replace(100,'صد',$x);

return $x;
}


function number_to_str3($x){
$x =$x-1;
$x++;
$len=strlen($x);
$spl=str_split($x);

if($len==1)      # یک رقمی
	$output = num_to_str($x,true);
elseif($len==2){ # دورقمی
		if($spl[0]==1)
			$output = num_to_str2($x,true);
		elseif($spl[1]==0)
			$output = num_to_str2($spl[0]*10);
		else
			$output = num_to_str2($spl[0]*10).' و '.num_to_str($spl[1]);	
}
elseif($len==3){  # سه رقمی
		if(($spl[2]==0) && ($spl[1]==0))	
			$output = num_to_str3($x);
		elseif($spl[2]==0)
			$output = num_to_str3($spl[0]*100).' و '.num_to_str2($spl[1]*10);
		elseif($spl[1]==1)
			$output = num_to_str3($spl[0]*100).' و '.num_to_str2(($spl[1]*10)+$spl[2],true);
		elseif($spl[1]==0)
			$output =num_to_str3($spl[0]*100).' و '.num_to_str($spl[2]);
		else
			$output =num_to_str3($spl[0]*100).' و '.num_to_str2($spl[1]*10).' و '.num_to_str($spl[2]);	
}
return $output;
}

function int_to_pstr($x){
$x =$x-1;
$x++;
$len=strlen($x);
$spl=str_split($x);

if($len<=3)
	$out = number_to_str3($x);
elseif($len == 4){  # چهار رقمی
	if($spl[0]==1)
		$out = ' هزار و '.number_to_str3($x-$spl[0]*1000);
	else
		$out = num_to_str($spl[0]).' هزار و '.number_to_str3($x-$spl[0]*1000);
	}
elseif($len == 5)    # پنج رقمی
	$out = number_to_str3(($spl[0]*10)+$spl[1]).' هزار و '.number_to_str3($x-(($spl[0]*10)+$spl[1])*1000);
elseif($len == 6){   # شش رقمی
	$spl3=str_split($x,3);
	$out = number_to_str3($spl3[0]).' هزار و '.number_to_str3($spl3[1]);
}
elseif($len == 7){   # شش رقمی
	$spl3=str_split($x,3);
	$out = number_to_str3($spl3[0]).' هزار و '.number_to_str3($spl3[1]);
}
else
	$out = 'خطا !';

return $out;
}
$x=999999; 
//echo int_to_pstr($x);
 
 
 
 
$IP_address = VisitorIP();



