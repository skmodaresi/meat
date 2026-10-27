<?php
require_once __DIR__ . '/../../mysql_compat.php';
include_once 'includer.php';
$i=1;

for ( ; $i <37; ++$i )
{
$query = "select * from dm_havale
			where
                h_p_priceh=0 
             AND
			   h_id_province=$i"; 
			   		   	                 	
	$lnk = mysql_query($query);
//	print $query;
	while($row= mysql_fetch_assoc($lnk))
	{  
		
		$lnkp = mysql_query("SELECT * FROM dm_product product
								left join dm_price price
								on product.p_id=price.price_p_id
								 WHERE p_code=".$row['h_p_code']." AND p_price_code=".$row['h_price_code']."
								 AND
								  price_id_province=".$i."");		
					$rowp = mysql_fetch_assoc($lnkp);
		  
		 
		   $h_p_priceh=($row['h_p_price'] + $row['h_p_add']);
		   
		 
		$query2 = "
				UPDATE dm_havale
				SET 
					 h_p_priceh = '". $h_p_priceh ."'
										 
				WHERE 
					h_id = ".$row['h_id']." ";
		//	$lnk2 = mysql_query($query2);
		
//print $query2;

	}	
	
	
	
	
	
}