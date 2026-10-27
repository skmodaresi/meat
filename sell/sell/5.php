<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
require_once __DIR__ . '/../../mysql_compat.php';
 
$myconn = mysql_connect( "localhost" , "root" , "xlsdj110");
mysql_query("SET NAMES 'utf8'",$myconn);
mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());
	

$i=36;
for ( ; $i <37; ++$i ){
	

	 $query1 = "select * from dm_pish_havale_det phd
	            left join dm_pish_havale ph
	            on phd.phd_ph_code=ph.ph_code and phd_id_province=ph_id_province
	            left join dm_pish_factor pf on ph.ph_code=pf.pf_ph_code and pf_id_province=ph_id_province
	            where
	            phd_status=0
	            and
	             phd_id_province=".$i."
	             and
	             ph_id_province=".$i."
	             and
	              ph_reg_date between '2018-09-19'   and    '2019-03-19' 
	              group by phd_id 
	             order by phd_id desc";
	 	$lnk1 = mysql_query($query1);
	 	print $query1;
		
			while($row1 = mysql_fetch_assoc($lnk1))
			{
	$ph_phm_id=$row1['ph_phm_id'];
	
		$querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$row1['ph_phm_id']."  ";
          
					$lnkmm = mysql_query($querymm);
					$rowmm = mysql_fetch_assoc($lnkmm);
				print $querymm;
				
					
	$phm_amount=($rowmm['phm_amount']+$row1['phd_amount']);
	$phm_amountes=($rowmm['phm_amountes']-$row1['phd_amount']);	
						
					$queryphm = "
							UPDATE dm_op_mojavez 
							SET 
								  			 
								`phm_amount` = '".$phm_amount."',
								`phm_amountes` = '".$phm_amountes."'   			
													 
							WHERE 
								phm_id = ".$ph_phm_id." 	";
								
						$lnkphm = mysql_query($queryphm);
					print ($queryphm);
					if(mysql_error()) print mysql_error();			

				$querypf = "
					DELETE FROM dm_pish_factor
				 
						WHERE 
							pf_ph_code = ".$row1['ph_code']." 
					AND
					        pf_id_province=".$i."";

					$lnkpf = mysql_query($querypf);
					
					if(mysql_error()) print mysql_error();
				print $querypf;
				$queryph = "
					DELETE FROM dm_pish_havale
				 
						WHERE 
							ph_id = ".$row1['ph_id']." 
					AND
					        ph_id_province=".$i."
					";
					
					$lnkph = mysql_query($queryph);
					if(mysql_error()) print mysql_error();
			print $queryph;
				
					
				$queryphd = "
					DELETE FROM dm_pish_havale_det
				 
						WHERE 
							phd_id = ".$row1['phd_id']." 
					AND
					        phd_id_province=".$i."
					  and
					  phd_status=0      
					        
					        ";

					$lnkphd = mysql_query($queryphd);
					
					if(mysql_error()) print mysql_error();
				
print $queryphd;
	
	
					}	
}


?>	