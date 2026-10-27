<?php
require_once __DIR__ . '/../mysql_compat.php';
 
$myconn = mysql_connect( "localhost" , "root" , "xlsdj110");
mysql_query("SET NAMES 'utf8'",$myconn);
mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());

 $query = "SELECT * FROM dm_havale WHERE h_robari !=null";
					
		$lnk = mysql_query($query);
	
		if(mysql_num_rows($lnk)>0){
		
		while($row= mysql_fetch_assoc($lnk)){
			
			
		$query1 = "SELECT * FROM dm_location_goods WHERE l_id =".$row['h_robari']."";
					
		$lnk1 = mysql_query($query1);
	$row1= mysql_fetch_assoc($lnk1);
	
	 $query = "
					UPDATE dm_havale 
					SET 
						
						`h_robari_code` = '". $row1['l_code'] ."'			
					 WHERE 
						h_id = ". $row['h_id'] ."";				
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
						print $query;
			
		
		}
		}
