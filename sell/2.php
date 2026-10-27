
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


$i=1;
for ( ; $i <37; ++$i ){
	

	$query1 = "select * from dm_havale
	            where
	             h_id_province=".$i."
	             and
	              h_phidrobari !=0";
	 	$lnk1 = mysql_query($query1);
		
			while($row1 = mysql_fetch_assoc($lnk1))
			{
				
				
				$query2="SELECT * FROM dm_pish_havale WHERE ph_id=".$row1['h_phidrobari']."  ";
          
					$lnk2 = mysql_query($query2);
					$row2 = mysql_fetch_assoc($lnk2);
			
				$query3="SELECT * FROM dm_pish_havale_det WHERE phd_ph_code=".$row2['ph_code']."

				and
				phd_id_province=".$i."";
	
					$lnk3 = mysql_query($query3);
					while($row3 = mysql_fetch_assoc($lnk3))
			{

				$queryphm = "
							UPDATE dm_havale 
							SET 
								  			 
								`h_hidrobari` = '".$row1['h_id']."',
								`h_cms` = '1'   			
													 
							WHERE 
								h_phd_id = ".$row3['phd_id']." 	";
								
						$lnkphm = mysql_query($queryphm);
					
					if(mysql_error()) print mysql_error();	
				
				
					
				
				
				
			}
					
					
				
				
				
				
				
				
			}
	
	
	
	
	
	
	
	
	
	
	
	
	
}

















//$query = "SELECT * FROM  dm_price  where   1 ";	
//	$lnk = mysql_query($query);
//	
//		
//while($row= mysql_fetch_assoc($lnk)){
//	$query1 = "
//		UPDATE  dm_price 
//		SET 
//			
//		    `p_sellpriceh` = '".$row['p_sellprice']."' 	 
//		WHERE 
//			price_id = ".$row['price_id'].""; 
//	
//	$lnk1 = mysql_query($query1);
//	
//	print $query1;
//}
//
//$query = "SELECT * FROM  dm_havale  where   1 ";	
//		$lnk = mysql_query($query);
//	
//		
//while($row= mysql_fetch_assoc($lnk)){
//	$query1 = "
//		UPDATE  dm_havale
//		SET 
//			
//		    `h_priceh` = '".$row['h_price']."' ,	
//		    `h_p_priceh` = '".$row['h_p_price']."' 
//		WHERE 
//			h_id = ".$row['h_id'].""; 
//	
//	$lnk1 = mysql_query($query1);
//	
//	print $query1;
//}
//
//$query = "SELECT * FROM  dm_pish_havale_det  where   1 ";	
//		$lnk = mysql_query($query);
//	
//		
//while($row= mysql_fetch_assoc($lnk)){
//	$query1 = "
//		UPDATE  dm_pish_havale_det
//		SET 
//			
//		    `phd_priceh` = '".$row['phd_price']."' ,	
//		    `phd_p_priceh` = '".$row['phd_p_price']."' 
//		WHERE 
//			phd_id = ".$row['phd_id'].""; 
//	
//	$lnk1 = mysql_query($query1);
//	
//	print $query1;
//}


?>