<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
require_once __DIR__ . '/../mysql_compat.php';
 
 header('Content-Type: text/html; charset=UTF-8');
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
//mysql_query("SET NAMES 'windows-1256'",$myconn);	
mysql_query("SET NAMES 'utf8'",$myconn);

mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());

$query1 = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_code=$row1['year_code'];
		$year_code=95;
$yearmali=1395;
		$query = "SELECT * FROM  mali.acc_mofaser_detail  where   (mk=16  or  mk=21) AND  flag='". 1 ."' and year=1395";
    
		$lnk = mysql_query($query);
	print 	$query;
	if(mysql_affected_rows()>0){
		
while($row= mysql_fetch_assoc($lnk)){
			
			$query1 = "SELECT * FROM  dm_customer_asli  where  code_customer=".$row['code']."    ";
				//print $query1;
				$lnk1 = mysql_query($query1);
		
			if(mysql_num_rows($lnk1)==0){
				//echo 'hast';
								 
					//	$name = iconv("windows-1256", "UTF-8", $row['name']);
					//	$gl_code = iconv("windows-1256", "UTF-8", $row['gl_code']);
					//	$gl_economic = iconv("windows-1256", "UTF-8", $row['gl_economic']);
			//echo mb_detect_encoding($row['name']);
						$query1 = "INSERT INTO  dm_customer_asli 
						( 
							`code_customer`, 
						    `customer_code_org`, 
			    			`name_customer` ,
			    			`customer_national_tax`, 
						    `customer_gl_code`, 
			    			`customer_gl_economic` 
						)
						
					VALUES
						(
							'".$row['code']."', 
							'".$row['org']."', 
							'".$row['name']."' ,
							'".$row['national_tax']."', 
							'".$row['gl_code']."', 
							'".$row['gl_economic']."'
								
						)
				";
			print $query1;
			mysql_query("SET NAMES 'utf8'",$myconn);
				$lnk1 = mysql_query( $query1 );
				if(mysql_error()) print mysql_error();
				
			                                  }
		
		                                           }
		$query3 = "
			UPDATE mali.acc_mofaser_detail  
			SET 
				`flag` = '". 0 ."'
													 
			WHERE 
				 year='". $yearmali ."'  AND  (mk=16 or mk=21) AND  flag='". 1 ."'	";
				
		$lnk3 = mysql_query($query3);
	print ($query);
	if(mysql_error()) print mysql_error();                                           
		                                           
		 echo '<div bgcolor="#99CCCC">مشتري جديدي  به سيستم فروش اضافه شد</div>';                                          
	}else{
		echo '<div bgcolor="#99CCCC">مشتري جديدي  براي ايجاد وجود ندارد</div>';
	}
		
	$query2 = "SELECT * FROM  mali.acc_mofaser_detail  where  year='". $yearmali ."'  AND  (mk=16 or mk=21)  AND  flag='". 2 ."' ";
	
		
		$lnk2 = mysql_query($query2);
		if(mysql_affected_rows()>0){
		
		while($row= mysql_fetch_assoc($lnk2)){
		 $code=$row['code'];
		 $org=$row['org'];
		//$gl_code = iconv("windows-1256", "UTF-8", $row['gl_code']);
		//$gl_economic = iconv("windows-1256", "UTF-8", $row['gl_economic']);
		 $name = iconv("windows-1256", "UTF-8", $row['name']);
		
		$query1 = "SELECT * FROM  dm_customer_asli  where code_customer=$code  "; 
		                	
		$lnk1 = mysql_query($query1);
				
          $query = "
						UPDATE dm_customer_asli
							  SET 			
								
								`name_customer` = '". $row['name'] ."',
								`customer_gl_code` = '". $row['gl_code'] ."',
								`customer_gl_economic` = '". $row['gl_economic'] ."',
								`customer_national_tax` = '". $row['national_tax'] ."'
											
							WHERE 
								code_customer=$code "; 
							
							    
							    
						    
                         
             mysql_query("SET NAMES 'utf8'",$myconn);		       						
			$lnk = mysql_query($query);
			
			
							
		 echo '<div bgcolor="#99CCCC">تغییرات مشتریان انجام شد.</div>';                                          
			   
		
		                                    }  

		    mysql_select_db("mali",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());
                  $query = "
							UPDATE mali.acc_mofaser_detail  
							SET 
								`flag` = '". 0 ."'
																	 
							WHERE 
								 year='". $yearmali ."' AND  (mk=16 or mk=21) AND  flag='". 2 ."'	";
								
						$lnk = mysql_query($query);
					//	print ($query);
						if(mysql_error()) print mysql_error();        
				
		                             }
		mysql_close() ;
		?>