<?php
require_once __DIR__ . '/../../mysql_compat.php';
include_once 'includer.php';

$i=1;
$disc='transfer from 93';
for ( ; $i <38; ++$i )
{
	
	$query = "SELECT * FROM  dm_customer1 
               
		        where  
		          customer_code_org=$i
		        "; 	                 	
	$lnk = mysql_query($query);
	//print $query;
	while($row= mysql_fetch_assoc($lnk))
	{
		
		
		$query2 = "
					UPDATE dm_customer 
					SET 
						`code_customern` = ".$row['code_customer_new']."
												 
					WHERE 
						customer_code_org=$i 

						and
						code_customer=".$row['code_customer']."
						
						";
			$lnk2 = mysql_query($query2);
			if(mysql_error()) print mysql_error();
		print $query2;
		
		$query3 = "
					UPDATE dm_havale
					SET 
						`h_customer_coden` = ".$row['code_customer_new']."
												 
					WHERE 
						h_id_province=$i 
						and
						
					`h_customer_code` = ".$row['code_customer']."
						
						";
			$lnk3 = mysql_query($query3);
			print $query3;
			if(mysql_error()) print mysql_error();
		
			$query4 = "
					UPDATE dm_pish_havale
					SET 
						`ph_customer_coden` = ".$row['code_customer_new']."												 
					WHERE 
						ph_id_province=$i 
					and
					 `ph_customer_code` = ".$row['code_customer']."
						
						";
			$lnk4 = mysql_query($query4);
			if(mysql_error()) print mysql_error();
			
			print $query4;
		
	}

}

?>