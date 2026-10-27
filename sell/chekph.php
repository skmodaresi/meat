<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
   </head>
<?php
require_once __DIR__ . '/../mysql_compat.php';
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
mysql_query("SET NAMES 'utf8'",$myconn);
mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());

$now=gmdate('Y-m-d');
$threedays = date('Y-m-d', strtotime($now . ' -3 day'));

$query = "SELECT * FROM  

dm_pish_havale ph 
left join
dm_pish_havale_det  phd
on ph.ph_code=phd.phd_ph_code and ph.ph_id_province=phd.phd_id_province

where  phd_status=0  and   ph_reg_date = $threedays  ";	
$lnk = mysql_query($query);	

while($row= mysql_fetch_assoc($lnk)){	
$phd_id = $row['phd_id'];
$ph_code = $row['ph_code'];
   	$row['ph_id']=$ph_id;
			$querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$rowph['ph_phm_id']." ";
									//	print $querych;
										$lnkmm = mysql_query($querymm);
										$rowmm = mysql_fetch_assoc($lnkmm);
			$phm_amounti=($rowmm['phm_amount']+$row['phd_amount']);
			$phm_amountes=($rowmm['phm_amountes']-$row['phd_amount']);
			$queryphm = "
				UPDATE dm_op_mojavez 
				SET 
					  			 
					`phm_amount` = '".$phm_amounti."',
					`phm_amountes` = '".$phm_amountes."'   			
										 
				WHERE 
					phm_id = ".$rowph['ph_phm_id']." 	";
					
			$lnkphm = mysql_query($queryphm);
	
	echo $queryphm;
	
	
$query = "
	DELETE FROM   dm_pish_havale_det
 
		WHERE 
			phd_id = ".$phd_id.""; 
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$query1 = "
	DELETE FROM   dm_pish_havale
 
		WHERE 
			ph_id = ".$ph_id."
			and
			 phd_status=0";
			
	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();
	

	
	$lnk1 = mysql_query("SELECT * FROM dm_anbar_det where dad_phd_id=".$phd_id."");
          
	while($row1=mysql_fetch_assoc($lnk1)){
			
			$lnk2 = mysql_query("SELECT * FROM mojody_kala where id=".$row1['dad_anbar_id']."");
			$row2=mysql_fetch_assoc($lnk2);
			
			if($row1['dad_no']==8){
				
				$meghdar=$row1['dad_tedad']+$row2['tedad_sold'];
				
				 $queryanbari = "
									UPDATE mojody_kala 
										SET 			
										
											
											`tedad_sold`  = '".$meghdar."'			
										WHERE 
											  id=".$row1['dad_anbar_id']."
									    
										";       						
								$lnkanbari = mysql_query($queryanbari);
				
				
				
			}else{
				
				if(($rowphd['phd_pid']==50) or ($rowphd['phd_pid']==54)){
					
					$meghdar=$row1['dad_tedad']+$row2['tedad_sold'];
			     	$queryanbari = "
									UPDATE mojody_kala 
										SET 			
										
											
											`tedad_sold`  = '".$meghdar."'			
										WHERE 
											  id=".$row1['dad_anbar_id']."
									    
										";       						
								$lnkanbari = mysql_query($queryanbari);
				
				}else{
				
				$meghdar=$row1['dad_vazn_kh']+$row2['khales_sold'];
				
				
				 $queryanbari = "
								UPDATE mojody_kala 
									SET 			
									
										`khales_sold` = '". $meghdar ."'			
									WHERE 
										  id=".$row1['dad_anbar_id']."
								    
									";       						
							$lnkanbari = mysql_query($queryanbari);
				
				}	
				
			}
			
			
			$querydd = "DELETE FROM dm_anbar_det
	 
			             WHERE 
				       dad_phd_id = ".$phd_id.""; 
				
		
		$lnkdd = mysql_query($querydd);
		if(mysql_error()) print mysql_error();		
			
			
	
			
			
		}
	
		$querydet = "
	DELETE FROM   dm_anbar_det
 
		WHERE 
			dad_phd_id = ".$phd_id.""; 
	
	$lnkdet = mysql_query($querydet);
	if(mysql_error()) print mysql_error();
	
	
	
}
 

?>