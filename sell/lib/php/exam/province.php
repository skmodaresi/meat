<?php
include_once '../db_connect.php';
include_once '../jdf.php';
include_once '../gen_def.php';

$query = "
				 SELECT * FROM provice
				
		 ";	
	//	print  $query;
				 												     	 										   
    			     $lnk = mysql_query($query);
    			      $csv='1,name,code,melicode,tel,address,province,city';
    			       $csv .="\n";
    			//     $csv='شخصيت,نام مشتری , كد مشتری,كد ملی , تلفن, آدرس دفتر ,آي دي استان ,آيدی شهر';
    			  
				  $inx=1;
                     while($rowh = mysql_fetch_assoc($lnk)){
                  $inx++;					 
					//echo $rowh['code_economic_customer'];	
                     	
                 //	if($rowh['customer_province_id']==0){
                     		
                     		
                   // 	}else{
                     		 
                     		
                     	 $customer_address_office=str_replace("ی","ي", $rowh['customer_address_office']);
                              $name_customer=str_replace("ی","ي", $rowh['name_customer']);
					
					// $csv .=''.$inx.','.$name_customer.'';
                     	    $csv .=''.$inx.','.$name_customer.','.$rowh['code_customer'].','.$rowh['code_economic_customer'].','.$rowh['customer_tel'].','. $customer_address_office .','.$rowh['customer_code_org'].','.$rowh['customer_cusid_city'].',';	
                     	
					//	}
                     
                       
                       $csv .="\n"; 
                     }
                     
                   // $csv= iconv("utf-8","windows-1256",$csv);
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"1.csv\"");
			echo $csv;
			?>
		