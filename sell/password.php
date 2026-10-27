
<?php
require_once __DIR__ . '/../mysql_compat.php';

include_once 'includer.php';
$query = "SELECT * FROM  dm_user_profile   ";	
		$lnk = mysql_query($query);
	if(mysql_affected_rows()>0){
		
		while($row= mysql_fetch_assoc($lnk)){
						 

		$query1 = "
			UPDATE dm_user_profile 
			SET 
				`u_pass_word` = '". md5($row['u_pass_word1']) ."'
													 
			WHERE 
				u_id=".$row['u_id']."	";

	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();
		
		    print  $query1;                       
		         }
												   
												   
												   
									}
									
									
									
?>