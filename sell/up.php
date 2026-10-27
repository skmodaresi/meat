<?php 
echo 'nasiim';
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
mysql_query("SET NAMES 'utf8'",$myconn);
mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());

 $query = "SELECT * FROM dm_havale WHERE h_robari !=''";
		
		$lnk = mysql_query($query);
	
		while($row= mysql_fetch_assoc($lnk)){
			echo $row['h_id'];
			echo '/';
			
		$query1 = "SELECT * FROM dm_location_goods WHERE l_id =".$row['h_robari']."";
					
		$lnk1 = mysql_query($query1);
	$row1= mysql_fetch_assoc($lnk1);
	
	 $query4 = "
					UPDATE dm_havale 
					SET 
						
						`h_robari_code` = '". $row1['l_code'] ."'			
					 WHERE 
						h_id = ". $row['h_id'] ."";				
						$lnk4 = mysql_query($query4);
						if(mysql_error()) print mysql_error();
						print $query4;
			
		
		}
		
		?>