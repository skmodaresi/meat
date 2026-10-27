<?php
require_once __DIR__ . '/../../../mysql_compat.php';
 
//$GLOBALS['access_allow'] = array(1,5,10,15);
function regProd1(){
	echo $_SESSION['prodSave'];
	
	if($_SESSION['prodSave']==1){		
//echo $p_pakage_type;
    $p_id = isset($_REQUEST['p_id']) ? $_REQUEST['p_id'] : '';    
	$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
	$p_price_code = isset($_REQUEST['p_price_code']) ? (int)($_REQUEST['p_price_code']) : '';
	$p_name = isset($_REQUEST['p_name']) ? ($_REQUEST['p_name']) : '';
	$p_pakage_type = isset($_REQUEST['p_pakage_type']) ? ($_REQUEST['p_pakage_type']) : '';
	$p_sellprice = isset($_REQUEST['p_sellprice']) ? ($_REQUEST['p_sellprice']) : '';	
    $p_number = isset($_REQUEST['p_number']) ? $_REQUEST['p_number'] : '';
    $p_iran_code = isset($_REQUEST['p_iran_code']) ? $_REQUEST['p_iran_code'] : '';
    $p_unit = isset($_REQUEST['p_unit']) ? $_REQUEST['p_unit'] : '';
    $p_subsidies = isset($_REQUEST['p_subsidies']) ? $_REQUEST['p_subsidies'] : '';
	$p_category = isset($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
    $p_type = isset($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
    $p_charge = isset($_REQUEST['p_charge']) ? $_REQUEST['p_charge'] : '';
    $p_group_id = isset($_REQUEST['p_group_id']) ? $_REQUEST['p_group_id'] : '';
    $p_valueadd = isset($_REQUEST['p_valueadd']) ? $_REQUEST['p_valueadd'] : '';
    $p_kilo = isset($_REQUEST['p_kilo']) ? $_REQUEST['p_kilo'] : '';
    
    $queryp = "
    
				select * from dm_listprod 						 
				WHERE 
					p_id = ".$p_id."
				"; 
	$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$p_code=$rowp['p_code'];
		$p_name=$rowp['p_name'];
    
	$p_sellprice=str_replace(",","",$p_sellprice);
	$p_sellprice=str_replace("ريال","",$p_sellprice);	
	$query = "SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
					 WHERE p_iran_code=".$p_iran_code;
	$lnk = mysql_query($query); 
	$query = "
		INSERT INTO dm_product 
			(    
			   
				`p_code`, 
				`p_iran_code`, 
				`p_kilo`, 
				`p_name`, 
				`p_pakage_type`,
				`p_reg_date` ,			
				`p_unit` ,
				`p_subsidies` ,
				`p_category` ,
				`p_charge` ,
				`p_group_id` ,
				`p_u_id` ,
				`p_valueadd`,
				`p_type` 	
								
			)
			
		VALUES
			(  
				'".$p_code."', 				
				'".$p_iran_code."', 
				'".$p_kilo."', 
				'".$p_name."', 
				'".$p_pakage_type."', 
				'".gmdate('Y-m-d H:i:s')."',
				'".$p_unit."', 				
				'".$p_subsidies."',
				'".$p_category."',
				'".$p_charge."',
				'".$p_group_id."',
				'".$_SESSION['dm_user_profile']['u_id']."',
				'".$p_valueadd."',
				'".$p_type."'				
									
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['prodSave']=0;
	$_SESSION['pp_prod_id']=$p_id = mysql_insert_id();
//	print $query;
	$query1 = array(
	
		'price_p_id' => $p_id,
		'p_sellprice' => $p_sellprice,
	    'p_sellpriceh' => $p_sellprice,
		'p_price_code' => $p_price_code,
		'price_reg_date' => gmdate('Y-m-d'),
		'price_u_id' => $_SESSION['dm_user_profile']['u_id'],
     	'price_id_province' => $_SESSION['dm_user_profile']['u_province_id']
	   	   
     	);

	$query1 = inserterQMaker('dm_price', $query1);
//	print $query1;
	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();
	return $p_id;	
	}
	$_SESSION['prodSave']=0;
}
function updPrd_morgh(){
	
	$pm_id = isset($_REQUEST['pm_id']) ? (int)($_REQUEST['pm_id']) : 0;
	if($pm_id<1) die('Inv Id');
	
	$pm_pcode = isset($_REQUEST['pm_pcode']) ? $_REQUEST['pm_pcode'] : '';
	
	$pm_price_code = isset($_REQUEST['pm_price_code']) ? $_REQUEST['pm_price_code'] : '';
	$pm_price = isset($_REQUEST['pm_price']) ? $_REQUEST['pm_price'] : '';
	

	$query1 = "
		UPDATE dm_prod_morgh 
		SET 
			`pm_pcode` = '".$pm_pcode."',
			`pm_price_code` = '".$pm_price_code."', 
			`pm_price` = '".$pm_price."' 
			 			 
		WHERE 
			pm_id = ".$pm_id." 
	";

	//die($query);
	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();	
	
	
}
function updPrdInf_m(){
	
	
	$p_id = isset($_REQUEST['p_id']) ? (int)($_REQUEST['p_id']) : 0;
	if($p_id<1) die('Inv Id');
	
	$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
	
	$p_name = isset($_REQUEST['p_name']) ? $_REQUEST['p_name'] : '';
	

	$query = "
		UPDATE dm_listprod 
		SET 
			`p_code` = '".$p_code."',
			`p_name` = '".$p_name."'  
			 			 
		WHERE 
			p_id = ".$p_id." 
	";

	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	
}
function updPrdInfbcode(){
	
$p_id1 = isset($_REQUEST['p_id1']) ? (int)($_REQUEST['p_id1']) : 0;
	if($p_id1<1) die('Inv Id');
	
	$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
	$p_price_code = isset($_REQUEST['p_price_code']) ? (int)($_REQUEST['p_price_code']) : 0;
	$p_iran_code = $_REQUEST['p_iran_code'];
	$p_name = isset($_REQUEST['p_name']) ? $_REQUEST['p_name'] : '';
	$p_pakage_type = $_REQUEST['p_pakage_type'];
	$p_unit = isset($_REQUEST['p_unit']) ? $_REQUEST['p_unit'] : '';
	$p_sellprice = isset($_REQUEST['p_sellprice']) ? ($_REQUEST['p_sellprice']) : '';	
	$p_subsidies = isset($_REQUEST['p_subsidies']) ? ($_REQUEST['p_subsidies']) : '';
	$p_category = isset($_REQUEST['p_category']) ? ($_REQUEST['p_category']) : '';
	$p_type = isset($_REQUEST['p_type']) ? ($_REQUEST['p_type']) : '';
	$p_charge = isset($_REQUEST['p_charge']) ? $_REQUEST['p_charge'] : '';
	$p_redundancy = isset($_REQUEST['p_redundancy']) ? ($_REQUEST['p_redundancy']) : '';
	$p_group_id = isset($_REQUEST['p_group_id']) ? ($_REQUEST['p_group_id']) : '';
	$status1 = isset($_REQUEST['status1']) ? ($_REQUEST['status1']) : '';	
	$p_sellprice=str_replace(",","",$p_sellprice);
	$p_sellprice=str_replace("ريال","",$p_sellprice);
	$p_id = isset($_REQUEST['p_id']) ? (int)($_REQUEST['p_id']) : 0;
	$p_kilo = isset($_REQUEST['p_kilo']) ? (int)($_REQUEST['p_kilo']) : 0;
	
	$price_id = isset($_REQUEST['price_id']) ? ($_REQUEST['price_id']) : '';	
//	$p_sellprice = substr($p_sellprice, 0, strpos($p_sellprice, "."));

	
	 $queryp = "
    
				select * from dm_listprod 						 
				WHERE 
					p_id = ".$p_id."
				"; 
	$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$p_code=$rowp['p_code'];
		$p_name=$rowp['p_name'];
if($status1==1){
	if ($_SESSION['dm_user_profile']['u_province_id']==3){
	$query = "
		UPDATE dm_product 
		SET 
			
			`p_iran_code`= '".$p_iran_code."',   
			`p_pakage_type` = '".$p_pakage_type."',
			`p_unit` = '".$p_unit."', 			
			`p_subsidies` = '".$p_subsidies."',
			`p_category` = '".$p_category."', 
			`p_group_id` = '".$p_group_id."', 
			`p_charge` = '".$p_charge."', 
			`p_kilo` = '".$p_kilo."', 
			`p_type` = '".$p_type."' 			 
		WHERE 
			p_id = ".$p_id1." 
	";}else{
	
	$query = "
		UPDATE dm_product 
		SET 
			
			
			`p_type` = '".$p_type."' 			 
		WHERE 
			p_id = ".$p_id1." 
	";
	
	
	}
	
	
}else{
	
	
	$query = "
		UPDATE dm_product 
		SET 
			`p_code` = '".$p_code."',
			`p_iran_code`= '".$p_iran_code."', 
			`p_name` = '".$p_name."',  
			`p_pakage_type` = '".$p_pakage_type."',
			`p_unit` = '".$p_unit."', 			
			`p_subsidies` = '".$p_subsidies."',
			`p_category` = '".$p_category."', 
			`p_group_id` = '".$p_group_id."', 
			`p_charge` = '".$p_charge."', 
			`p_kilo` = '".$p_kilo."', 
			`p_type` = '".$p_type."' 			 
		WHERE 
			p_id = ".$p_id1." 
	";
}
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	$query4 = "
		select * from dm_price 						 
		WHERE 
			price_p_id = ".$p_id1."
		AND
		   price_id_province = '".$_SESSION['dm_user_profile']['u_province_id']."'"; 
	$lnk4=mysql_query($query4);
		print mysql_error();
		$row4=mysql_fetch_assoc($lnk4);
		if(mysql_affected_rows()>0){
			
			if($status1==1){
						
					
			}else{
				
				$query = "
						UPDATE dm_price 
						SET 
							`p_price_code` = ".$p_price_code.", 
							`p_sellprice` = '".$p_sellprice."',
							`price_reg_date` = '". gmdate('Y-m-d')."',			 
							`price_u_id`= '".$_SESSION['dm_user_profile']['u_id']."'						 
						WHERE 
							price_id = ".$price_id."
						AND
						   price_id_province = '".$_SESSION['dm_user_profile']['u_province_id']."'"; 
						$lnk = mysql_query($query);
			//		print $query;
					if(mysql_error()) print mysql_error();
				
			}
					
		}else{
				$query1 = array(
			
				'price_p_id' => $p_id1,
				'p_sellprice' => $p_sellprice,
				'p_price_code' => $p_price_code,
				'price_reg_date' => gmdate('Y-m-d'),
				'price_u_id' => $_SESSION['dm_user_profile']['u_id'],
		     	'price_id_province' => $_SESSION['dm_user_profile']['u_province_id']
			   	   
		     	);
		
			$query1 = inserterQMaker('dm_price', $query1);
		//	print $query1;
			$lnk1 = mysql_query($query1);
			if(mysql_error()) print mysql_error();
	}
	
	
	
	
}
function updPrdInf(){
	$p_id1 = isset($_REQUEST['p_id1']) ? (int)($_REQUEST['p_id1']) : 0;
	if($p_id1<1) die('Inv Id');
	
	$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
	$p_price_code = isset($_REQUEST['p_price_code']) ? (int)($_REQUEST['p_price_code']) : 0;
	$p_iran_code = $_REQUEST['p_iran_code'];
	$p_name = isset($_REQUEST['p_name']) ? $_REQUEST['p_name'] : '';
	$p_pakage_type = $_REQUEST['p_pakage_type'];
	$p_unit = isset($_REQUEST['p_unit']) ? $_REQUEST['p_unit'] : '';
	$p_sellprice = isset($_REQUEST['p_sellprice']) ? ($_REQUEST['p_sellprice']) : '';	
	$p_subsidies = isset($_REQUEST['p_subsidies']) ? ($_REQUEST['p_subsidies']) : '';
	$p_category = isset($_REQUEST['p_category']) ? ($_REQUEST['p_category']) : '';
	$p_type = isset($_REQUEST['p_type']) ? ($_REQUEST['p_type']) : '';
	$p_charge = isset($_REQUEST['p_charge']) ? $_REQUEST['p_charge'] : '';
	$p_redundancy = isset($_REQUEST['p_redundancy']) ? ($_REQUEST['p_redundancy']) : '';
	$p_group_id = isset($_REQUEST['p_group_id']) ? ($_REQUEST['p_group_id']) : '';
	$status1 = isset($_REQUEST['status1']) ? ($_REQUEST['status1']) : '';	
	$p_sellprice=str_replace(",","",$p_sellprice);
	$p_sellprice=str_replace("ريال","",$p_sellprice);
	$p_id = isset($_REQUEST['p_id']) ? (int)($_REQUEST['p_id']) : 0;
	$p_kilo = isset($_REQUEST['p_kilo']) ? (int)($_REQUEST['p_kilo']) : 0;
	
	$price_id = isset($_REQUEST['price_id']) ? ($_REQUEST['price_id']) : '';	
//	$p_sellprice = substr($p_sellprice, 0, strpos($p_sellprice, "."));

	
	 $queryp = "
    
				select * from dm_listprod 						 
				WHERE 
					p_id = ".$p_id."
				"; 
	$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$p_code=$rowp['p_code'];
		$p_name=$rowp['p_name'];
if($status1==1){
	if ($_SESSION['dm_user_profile']['u_province_id']==3){
	$query = "
		UPDATE dm_product 
		SET 
			
			`p_iran_code`= '".$p_iran_code."',   
			`p_pakage_type` = '".$p_pakage_type."',
			`p_unit` = '".$p_unit."', 			
			`p_subsidies` = '".$p_subsidies."',
			`p_category` = '".$p_category."', 
			`p_group_id` = '".$p_group_id."', 
			`p_charge` = '".$p_charge."', 
			`p_kilo` = '".$p_kilo."', 
			`p_type` = '".$p_type."' 			 
		WHERE 
			p_id = ".$p_id1." 
	";}else{
	
//	$query = "
//		UPDATE dm_product 
//		SET 
//			
//			
//			`p_type` = '".$p_type."' 			 
//		WHERE 
//			p_id = ".$p_id1." 
//	";
	
	
	}
	
	
}else{
	
	
	$query = "
		UPDATE dm_product 
		SET 
			`p_code` = '".$p_code."',
			`p_iran_code`= '".$p_iran_code."', 
			`p_name` = '".$p_name."',  
			`p_pakage_type` = '".$p_pakage_type."',
			`p_unit` = '".$p_unit."', 			
			`p_subsidies` = '".$p_subsidies."',
			`p_category` = '".$p_category."', 
			`p_group_id` = '".$p_group_id."', 
			`p_charge` = '".$p_charge."', 
			`p_kilo` = '".$p_kilo."', 
			`p_type` = '".$p_type."' 			 
		WHERE 
			p_id = ".$p_id1." 
	";
}
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	$query4 = "
		select * from dm_price 						 
		WHERE 
			price_p_id = ".$p_id1."
		AND
		   price_id_province = '".$_SESSION['dm_user_profile']['u_province_id']."'"; 
	$lnk4=mysql_query($query4);
		print mysql_error();
		$row4=mysql_fetch_assoc($lnk4);
		if(mysql_affected_rows()>0){
			
			if($status1==1){
						
					
			}else{
				
				$query = "
						UPDATE dm_price 
						SET 
							`p_price_code` = ".$p_price_code.", 
							`p_sellprice` = '".$p_sellprice."',
							`price_reg_date` = '". gmdate('Y-m-d')."',			 
							`price_u_id`= '".$_SESSION['dm_user_profile']['u_id']."'						 
						WHERE 
							price_id = ".$price_id."
						AND
						   price_id_province = '".$_SESSION['dm_user_profile']['u_province_id']."'"; 
						$lnk = mysql_query($query);
			//		print $query;
					if(mysql_error()) print mysql_error();
				
			}
					
		}else{
				$query1 = array(
			
				'price_p_id' => $p_id1,
				'p_sellprice' => $p_sellprice,
				'p_price_code' => $p_price_code,
				'price_reg_date' => gmdate('Y-m-d'),
				'price_u_id' => $_SESSION['dm_user_profile']['u_id'],
		     	'price_id_province' => $_SESSION['dm_user_profile']['u_province_id']
			   	   
		     	);
		
			$query1 = inserterQMaker('dm_price', $query1);
		//	print $query1;
			$lnk1 = mysql_query($query1);
			if(mysql_error()) print mysql_error();
	}
}
function updPrdInfM(){
	$p_id = isset($_REQUEST['p_id']) ? (int)($_REQUEST['p_id']) : 0;
	if($p_id<1) die('Inv Id');
	
	$p_price_code = isset($_REQUEST['p_price_code']) ? (int)($_REQUEST['p_price_code']) : 0;
	$p_sellprice = isset($_REQUEST['p_sellprice']) ? ($_REQUEST['p_sellprice']) : '';		
	
    $p_sellprice=str_replace(",","",$p_sellprice);
	$p_sellprice=str_replace("ريال","",$p_sellprice);
//	$p_sellprice = substr($p_sellprice, 0, strpos($p_sellprice, "."));		
	$query4 = "
		select * from dm_price 						 
		WHERE 
			price_p_id = ".$p_id."
		AND
		   price_id_province = '".$_SESSION['dm_user_profile']['u_province_id']."'"; 
	$lnk4=mysql_query($query4);
		print mysql_error();
		$row4=mysql_fetch_assoc($lnk4);
		if(mysql_affected_rows()>0){
						$query = "
						UPDATE dm_price 
						SET 
							`p_price_code` = ".$p_price_code.", 
							`p_sellprice` = '".$p_sellprice."',
							`price_reg_date` = '". gmdate('Y-m-d')."',			 
							`price_u_id`= '".$_SESSION['dm_user_profile']['u_id']."'						 
						WHERE 
							price_p_id = ".$p_id."
						AND
						   price_id_province = '".$_SESSION['dm_user_profile']['u_province_id']."'"; 
						  	
					$lnk = mysql_query($query);
			//		print $query;
					if(mysql_error()) print mysql_error();
		}else{
				$query1 = array(
			
				'price_p_id' => $p_id,
				'p_sellprice' => $p_sellprice,
				'p_price_code' => $p_price_code,
				'price_reg_date' => gmdate('Y-m-d'),
				'price_u_id' => $_SESSION['dm_user_profile']['u_id'],
		     	'price_id_province' => $_SESSION['dm_user_profile']['u_province_id']
			   	   
		     	);
		
			$query1 = inserterQMaker('dm_price', $query1);
		//	print $query1;
			$lnk1 = mysql_query($query1);
			if(mysql_error()) print mysql_error();
	}
}
function deleteProd1(){
		
	$p_id = isset($_REQUEST['p_id']) ? (int)($_REQUEST['p_id']) : 0;
	$price_id = isset($_REQUEST['price_id']) ? (int)($_REQUEST['price_id']) : 0;
	if($p_id<1) die('Inv Id');
	
$query = "select * from   dm_product product                    
				left join dm_price price
				 on product.p_id=price.price_p_id 
					where 
					    p_id=".$p_id."
					  and
					  price_id=".$price_id."
                  and
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					  
					  ";		   
		$lnk = mysql_query($query);
	//	print $query;
	    $row= mysql_fetch_assoc($lnk);
	    $p_code =$row['p_code'];
	    $p_price_code = $row['p_price_code'];
	    $query1 = "select * from   dm_pish_havale_det 	                                  				
					where 
					    phd_pid=".$p_code."
					  and
					  phd_price_code=".$p_price_code."
					  and
                     phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	
	    $lnk1 = mysql_query($query1);
	     $row1= mysql_fetch_assoc($lnk1);
	    $ph_code =$row1['phd_ph_code'];
	  //  print $query1;
    	if(mysql_num_rows($lnk1)>0){
         $query2 = "select * from   dm_pish_factor 	                                  				
					where 
					    pf_ph_code=".$ph_code."
					  and				
                     pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	
	     $lnk2 = mysql_query($query2);
	     $row2= mysql_fetch_assoc($lnk2);
	//     print $query2;
	     if(mysql_num_rows($lnk2)>0){    					       
			       ?>  
			       <script>
			                 alert('شما از این کالا استفاده کردید و حق حذف آن را ندارید');
			       </script>
			       
			       <?php 
			       		
	                                }
		    }
		    
		    else {
    	          $query = "
				DELETE FROM dm_product
			 
					WHERE 
						p_id = ".$p_id." 
				";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
		    }			 		
    	
}

function dspProdRegFrm1(){
	
	
	?>

<script language="JavaScript" type="text/JavaScript">
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num)) {
        num = "0";
    }
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num % 100;
    num = Math.floor(num/100).toString();
    if(cents < 10) {
        cents = "0" + cents;
    }
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++) {
        num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
    }
    if(cents>0){
    return (((sign)?'':'-')  + num + '.' + cents);
    }else{
    	 return (((sign)?'':'-')  + num );

    }
}
function isNumber(field) {
        var re = /^[0-9-'.'-',']*$/;
        if (!re.test(field.value)) {
            alert('شما مجازيد فقط عدد وارد كنيد');
            field.value = field.value.replace(/[^0-9-'.'-',']/g,"");
        }
    }
	
function validateAndSaveProd(){

		if(fObj('p_id').value==-2){
			
			alert('لطفا کالارا انتخاب بفرماييد');
			return;
		}
		if(fObj('p_name').value==''){
			
			alert('لطفا نام كالا انتخاب کنید');
			return;
		}
		
	if(fObj('p_sellprice').value==''){
			
			alert('لطفا قيمت فروش را وارد کنید');
			return;
		}
	if(fObj('p_kilo').value==''){
		
		alert('لطفا مقداررا وارد کنید');
		return;
	}
	
if(fObj('p_price_code1').value==''){
		
		alert('لطفا کد قیمت را وارد کنید');
		return;
	}



    checkAndValidProdName();
    
	}
function searchprice_code(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchprice_code.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}
			                      
	}
function searchproduct(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchproduct.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}
			                      
	}

	</script>
	<?php $province_id = $_SESSION['dm_user_profile']['u_province_id']; 
	
	$_SESSION['prodSave']=1;
	?> 
	<span style="color:blue;"><span style="color:red;">  *  </span> در فيلد كد قيمت  ميتوانيد با كليد F1 به جستجو بپردازيد  </span>
		<br></br><span style="color:blue;"><span style="color:red;">  *  </span> برای کالاهایی که واحد آنها کیلو گرم است مفدار همواره 1 می باشد  </span> 
	 
	<br></br>
	<form method="post" name="form1" action="" id="commentForm">
	<input name="p_price_code" id="p_price_code" type="hidden" value="<?php $p_price_code ?>" />	
		<table  align="center" class="nasi" width=70% style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
		       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="5">مشخصات كالا</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
	        	<td><center> كالا </center></td>
	        	<td>
			  		<?php echo getProduct('p_id')?>
				</td>
		       <!--   <td><input name="p_code" id="p_code" type="text"    onkeypress="searchproduct(event,<?php echo $province_id ?>);" onkeyup="isNumber(this)"/></td>
		       -->
		        <td ><center> </center> </td>
		        <td><span name="p_name" id="p_name" ></span></td>
		        		  
	        </tr>
	        <tr>
		       	<td ><center>بسته بندي </center> </td>
			  	<td>
			  		<?php echo getPkgTypesComboBox('p_pakage_type')?>
				</td>
				<td ><center>واحد</center> </td>
		        <td>
			  		<?php echo getUnitTypesComboBox('p_unit')?>
				</td>
	        </tr>
	      	<tr>
		        <td  align="center"><center>ايران كد </center> </td>
		        <td><input name="p_iran_code" type="text"  id="p_iran_code" /></td>
		        <td ><center>قيمت فروش</center> </td>
		        <td><input name="p_sellprice" id="p_sellprice" type="text"  /></td>
	        </tr>
	       
	      	<tr>
		        <td ><center>كد قيمت </center> </td>
		        <td><input name="p_price_code1" id="p_price_code1"  type="text"    onkeypress="searchprice_code(event,<?php echo $province_id ?>);"  /></td>
		       
		        <td ><center>نوع </center> </td>
			  	<td>
			  		<?php echo getTypesComboBox('p_type')?>
				</td>
				</tr>
				<tr>
				
				 <td ><center>مقدار(به کیلوگرم)</center> </td>
		        <td><input name="p_kilo" id="p_kilo" type="text" value="1" /></td>
 	
	          </tr>	      	
	       	  <tr>
	      		<td ><center> يارانه اي </center> </td>
			  	<td>
			  		<?php echo getSubsidiesTypesComboBox('p_subsidies')?>
				</td>
				<td ><center>دسته</center> </td>
			  	<td>
			  		<?php echo getCategoryTypesComboBox('p_category')?>
				</td>				
	      	</tr>	
	      	   	<tr>
	      		<td ><center> هزینه افزودنی </center> </td>
			  	<td>
			  		<?php echo getTypeschargeComboBox('p_charge')?>
				</td>
				
				<td ><center> ارزش افزوده </center> </td>
			  	<td>
			  		<?php echo getvalueaddComboBox('p_valueadd')?>
				</td>
								
	      	</tr>	      	   	      		      	
	      	<tr>	      	         
		       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>		      
               <td colspan="3"><button  type="button" onclick="validateAndSaveProd();" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button> </td>                  
		     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php

/*
	$query="select DISTINCT p_category from dm_product ";
	$lnk=mysql_query($query);
	//print$query;
	print mysql_error();
	 echo "<select name='item'>\n";
        echo "<option>-- Equipment --</option>\n";
	
	while($row = mysql_fetch_assoc($lnk)){
	  echo "<option value='$row[p_category]'>$row[p_category]</option>\n";

        // End the combo-box
        
      }
echo "</select>\n";
*/  
}
function dspProdFrmEdit_morgh()
{
		?>
<script>
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num)) {
        num = "0";
    }
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num % 100;
    num = Math.floor(num/100).toString();
    if(cents < 10) {
        cents = "0" + cents;
    }
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++) {
        num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
    }
    if(cents>0){
    return (((sign)?'':'-')  + num + '.' + cents);
    }else{
    	 return (((sign)?'':'-')  + num );

    }
}
function validateAndSaveProd(){
		if(fObj('pm_pcode').value==''){
			
			alert('لطفا كد كالا را وارد کنید');
			return;
		}
		if(fObj('pm_price_code').value==''){
			
			alert('لطفا کد قیمت را وارد کنید');
			return;
		}

    if(fObj('pm_price').value==''){
			
			alert('لطفا قیمت را وارد کنید');
			return;
		}
    checkprod_morgh();

	}
function searchprice_code(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchprice_code.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}			                      
	}
function searchproduct(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchproduct.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}			                      
	}
</script>
<?php 
	$pm_id = isset($_REQUEST['pm_id']) ? (int)($_REQUEST['pm_id']) : 0;

	if($pm_id<1) die('Invalid product id!');
	
	$lnk = mysql_query("SELECT *  FROM dm_prod_morgh
							
					   WHERE
					    pm_id=".$pm_id."

					   ");
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
		?>
		

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		
		<input type="hidden" name="pm_id" id="pm_id" value="<?php echo $pm_id; ?>">  
		
		<table align="center"  class="nasi">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">مشخصات کالاهای نوع مرغ </font></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
	      	    <td ><center>كد كالا </center> </td>
		        <td><input name="pm_pcode" id="pm_pcode" type="text" value="<?php echo $row['pm_pcode']; ?>"  onkeypress="searchproduct(event,<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>);" /></td>
		        <td ><center>کد قیمت </center> </td>
		        <td><input name="pm_price_code" id="pm_price_code" type="text" value="<?php echo $row['pm_price_code']; ?>" /></td>
		         <td ><center>قیمت </center> </td>
		        <td><input name="pm_price" id="pm_price" type="text" value="<?php echo $row['pm_price']; ?>" /></td>
		     </tr>
		    
	      	<tr>    	       
				   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>			      			      	
                    <td colspan="3"><button  type="button" onclick="validateAndSaveProd();"value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				         
	      	</tr>
	    </table>
	</form> 
	    
	<?php
	
	
	
	
}
function dspProdFrmEdit_m(){
	
	
		?>
<script>
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num)) {
        num = "0";
    }
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num % 100;
    num = Math.floor(num/100).toString();
    if(cents < 10) {
        cents = "0" + cents;
    }
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++) {
        num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
    }
    if(cents>0){
    return (((sign)?'':'-')  + num + '.' + cents);
    }else{
    	 return (((sign)?'':'-')  + num );

    }
}
function validateAndSaveProd(){
		if(fObj('p_code').value==''){
			
			alert('لطفا كد كالا را وارد کنید');
			return;
		}
		if(fObj('p_name').value==''){
			
			alert('لطفا نام كالا انتخاب کنید');
			return;
		}

//	checkAndValiPriceCode();
    checkAndValidProdNameEdit_m();

	}
function searchprice_code(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchprice_code.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}			                      
	}
function searchproduct(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchproduct.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}			                      
	}
</script>
<?php 
	$p_id = isset($_REQUEST['p_id']) ? (int)($_REQUEST['p_id']) : 0;

	if($p_id<1) die('Invalid product id!');
	
	$lnk = mysql_query("SELECT *  FROM dm_listprod 
							
					   WHERE
					    p_id=".$p_id."

					   ");
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
		?>
		

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="updPrdInf">   
		<input type="hidden" name="p_id" id="p_id" value="<?php echo $p_id; ?>">  
		
		<table align="center"  class="nasi">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">مشخصات كالا</font></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
	      	    <td ><center>كد كالا </center> </td>
		        <td><input name="p_code" id="p_code" type="text" value="<?php echo $row['p_code']; ?>"  onkeypress="searchproduct(event,<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>);" /></td>
		        <td ><center>نام كالا </center> </td>
		        <td><input name="p_name" id="p_name" type="text" value="<?php echo $row['p_name']; ?>" /></td>
		     </tr>
		    
	      	<tr>    	       
				   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>			      			      	
                    <td colspan="3"><button  type="button" onclick="validateAndSaveProd();"value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				         
	      	</tr>
	    </table>
	</form> 
	    
	<?php
	
	
	
	
}
function dspProdFrmEdit(){
	?>
<script>
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num)) {
        num = "0";
    }
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num % 100;
    num = Math.floor(num/100).toString();
    if(cents < 10) {
        cents = "0" + cents;
    }
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++) {
        num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
    }
    if(cents>0){
    return (((sign)?'':'-')  + num + '.' + cents);
    }else{
    	 return (((sign)?'':'-')  + num );

    }
}
function validateAndSaveProd(){
		if(fObj('p_code').value==-2){
			
			alert('لطفا  کالا را انتخاب بفرماييد');
			return;
		}
		
		if(fObj('p_iran_code').value==''){
			
			alert('لطفا ايران كد را وارد کنید');
			return;
		}
	if(fObj('p_sellprice').value==''){
			
			alert('لطفا قيمت فروش را وارد کنید');
			return;
		}
	
	if(fObj('p_kilo').value==''){
		
		alert('لطفا مقدار را به کیلوگرم وارد کنید');
		return;
	}
	if(fObj('p_price_code').value==''){
		
		alert('لطفا كد قيمت را وارد کنید');
		return;
	}
//	checkAndValiPriceCode();
    checkAndValidProdNameEdit();

	}
function searchprice_code(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchprice_code.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}			                      
	}
function searchproduct(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchproduct.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}			                      
	}
</script>
<?php 
	$p_id = isset($_REQUEST['p_id']) ? (int)($_REQUEST['p_id']) : 0;
	$price_id = isset($_REQUEST['price_id']) ? (int)($_REQUEST['price_id']) : 0;
	if($p_id<1) die('Invalid product id!');
	
	$lnk = mysql_query("SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
					   WHERE p_id=".$p_id."
					        AND 
					        price_id=".$price_id."
					   
					   ");
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
		?>
		<span style="color:blue;"><span style="color:red;">  *  </span> در فيلد كد قيمت  ميتوانيد با كليد F1 به جستجو بپردازيد  </span> 
	    <br></br>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="updPrdInf">   
		<input type="hidden" name="p_id1" id="p_id1" value="<?php echo $p_id; ?>">  
		<input type="hidden" name="p_id" id="price_id" value="<?php echo $price_id; ?>"> 
		<table align="center"  class="nasi">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">مشخصات كالا</font></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	       
	       
	       <tr>
	       	<td><center>كد كالا </center></td>
	        	<td>
			  		<?php echo getProduct1($p_id,'p_id')?>
				</td>
		       
		        <td ><center> </center> </td>
		        <td><span name="p_name" id="p_name" ></span></td>
		     </tr>
	      	
		     <tr>
		       	<td><center>بسته بندی </center> </td>
			  	<td>
			  		<?php echo getPkgTypesComboBox('p_pakage_type', $row['p_pakage_type']) ?>
				</td>
				<td >واحد </td>
		        <td>
			  		<?php echo getUnitTypesComboBox('p_unit',$row['p_unit'])?>
				</td>
	        </tr>
	      	<tr>
		      	<td align="center"><center>ايران كد </center> </td>
			    <td><input name="p_iran_code" id="p_iran_code" type="text"  value="<?php echo $row['p_iran_code']; ?>" /></td><!--name kala-->
			    <td >قيمت فروش </td>
			    <td><input name="p_sellprice" id="p_sellprice" type="text" value="<?php echo $row['p_sellprice']; ?>"  onBlur="this.value=formatCurrency(this.value);"/></td>     
	      	</tr> 
	       
	      	<tr>
		        <td ><center>كد قيمت </center> </td>
		        <td><input name="p_price_code" id="p_price_code" type="text" value="<?php echo $row['p_price_code']; ?>"  onkeypress="searchprice_code(event,<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>);" /></td>
		         <td>نوع</td>
	            <td>
			  		<?php echo getTypesComboBox('p_type',$row['p_type'])?>
				 </td>
	        </tr>
	        	<tr>
		        <td ><center>مقدار به کیلوگرم </center> </td>
		        <td><input name="p_kilo"   id="p_kilo"  type="text" value="<?php echo $row['p_kilo']; ?>"   /></td>
		       
	        </tr>
	      	<tr>
	      	     <td>يارانه</td>
	             <td>
			  		<?php echo getSubsidiesTypesComboBox('p_subsidies',$row['p_subsidies'])?>
				 </td> 
				 <td>دسته</td>
				 <td>
			  		<?php echo getCategoryTypesComboBox('p_category',$row['p_category'])?>
				  </td>
			</tr>
			<tr>
	      	     <td>افزودني</td>
	             <td>
			  		<?php echo getTypeschargeComboBox('p_charge',$row['p_charge'])?>
				 </td> 
				
			</tr>
	      	<tr>    	       
				   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>			      			      	
                    <td colspan="3"><button  type="button" onclick="validateAndSaveProd();"value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				         
	      	</tr>
	    </table>
	</form> 
	    
	<?php
}
function ejadshod(){
	
echo 'این مجوز ایجاد شد';	
	
	
}
function searchmojavezName()
{
	
	?>
	<script>
	function ConfirmDel()
	{
		if (! confirm('! آيا از حذف آن اطمينان داريد')) { return false; } 
	} 
	function Access(){
		  alert('شما حق دسترسي نداريد');

	  } 
</script>

	<?php 
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '<br>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchmojavezName"> 
			 شماره مجوز را جستجو کنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;"/> 
			<button type="submit" name="Search" value="Search" />جستجو</button></div>
			
		</form>
	';
	//echo $_SESSION['srchStr'];
	
	$outHtml .= '	
		<div  style="width:100%;height:400px;align:center; overflow:auto">
			<table  border="1"  style="width:50%" align="center" class="list">
		  	<tr align="middle" class="rw1">
		     <td colspan="11"  style="height: 50px;vertical-align:middle;"  ><font size="7">ليست مجوز ها</font-size></td>
	        </tr>
      			<tr class="rw0" style="font-weight:bold;">
      		    	<td style="align:center;vertical-align:middle;">رديف</td>
			        <td style="align:center;vertical-align:middle;">شماره مجوز</td>
			        <td colspan="1" style="vertical-align:middle;">نوع عمليات</td>
			        <td colspan="1" style="vertical-align:middle;">دسته </td>
			         <td colspan="1" style="vertical-align:middle;">نوع </td>
			          <td colspan="1" style="vertical-align:middle;">مقدار مجاز</td>
			        <td colspan="" style="vertical-align:middle;">مقدار مانده</td>
			        <td colspan="1" style="vertical-align:middle;">تاريخ شروع</td>
			        <td colspan="3" style="vertical-align:middle;">تاريخ پايان</td>
			       
			       
			       
				</tr>
	';
	
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					phm_mojavez  LIKE '%".$_SESSION['srchStr']."%' 
					
					
				
				 
			)
		";
		
	}
	$typeQ = '';
	 
	$genQuery = "
		
		FROM dm_op_mojavez  opm   
	               left join  dm_operation_acc  op_acc 
	                   on opm.phm_op_id=op_acc.g_id
		WHERE 
			phm_id_province= ".$_SESSION['dm_user_profile']['u_province_id']."
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
			
			
	$lnkcat = mysql_query("SELECT *  FROM dm_prod_det_c
										 
								   WHERE cat_prod_id=".$row['phm_type_id']."
								        
								   ");
				
					$rowcat = mysql_fetch_assoc($lnkcat);
					
					$lnktype = mysql_query("SELECT *  FROM dm_prod_det_t
										 
								   WHERE type_prod_id=".$row['phm_ptype']."
								        
								   ");
//				echo "SELECT *  FROM dm_prod_det_t
//										 
//								   WHERE type_prod_id=".$row['phm_ptype']."";
					$rowtype = mysql_fetch_assoc($lnktype);
			
		if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete1';
				}
			
			$inx++;
			$gdate=$row['phm_date_l'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$phm_date_l = $jyear."/".$jmonth."/".$jday;
			
			//
			$gdate=$row['phm_date_f'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$phm_date_f = $jyear."/".$jmonth."/".$jday;
			
			
			$outHtml .= '
				 <tr class='.$class.'>
					<td style="vertical-align:middle;" align="center">'.$inx.'</td>
					<td style="vertical-align:middle;" align="center">'.$row['phm_mojavez'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$row['g_acc_name'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$rowcat['cat_prod_name'].'</td>
					
					<td width=50% style="vertical-align:middle;" align="center">'.$rowtype['type_prod_name'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$row['phm_amountpre'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$row['phm_amount'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$phm_date_f.'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$phm_date_l.'</td>';
			 $query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'20000\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=editmojavezfrm&phm_id='.$row['phm_id'].'"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';
						
					}
					$query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'300003\' ';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=deletemojavez&phm_id='.$row['phm_id'].'" onclick="return ConfirmDel();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
			           // $outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';        
			                    
			                    }
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
						
					}
					
				$outHtml .= '</tr>';
				
		}
		
    }else{
    	$outHtml .= '<tr><td colspan="6">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '  
	
				          
	     
	      	</table></div><div align="center">'.getNavBar_moj().' '.getRPPCombo_moj();
    return $outHtml;
		
	
	
	
	
}
function mojavezList(){
	
	?>
	<script>
	function ConfirmDel()
	{
		if (! confirm('! آيا از حذف آن اطمينان داريد')) { return false; } 
	} 
	function Access(){
		  alert('شما حق دسترسي نداريد');

	  } 
</script>

	<?php 
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '<br>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchmojavezName"> 
			 شماره مجوز را جستجو کنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;"/> 
			<button type="submit" name="Search" value="Search" />جستجو</button></div>
			
		</form>
	';
	
	$outHtml .= '	
		<div  style="width:100%;height:400px;align:center; overflow:auto">
			<table  border="1"  style="width:50%" align="center" class="list">
		  	<tr align="middle" class="rw1">
		     <td colspan="11"  style="height: 50px;vertical-align:middle;"  ><font size="7">ليست مجوز ها</font-size></td>
	        </tr>
      			<tr class="rw0" style="font-weight:bold;">
      		    	<td style="align:center;vertical-align:middle;">رديف</td>
			        <td style="align:center;vertical-align:middle;">شماره مجوز</td>
			        <td colspan="1" style="vertical-align:middle;">نوع عمليات</td>
			        <td colspan="1" style="vertical-align:middle;">دسته </td>
			         <td colspan="1" style="vertical-align:middle;">نوع </td>
			          <td colspan="1" style="vertical-align:middle;">مقدار مجاز</td>
			        <td colspan="" style="vertical-align:middle;">مقدار مانده</td>
			        <td colspan="1" style="vertical-align:middle;">تاريخ شروع</td>
			        <td colspan="3" style="vertical-align:middle;">تاريخ پايان</td>
			       
			       
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					phm_mojavez  LIKE '%".$_SESSION['srchStr']."%' 
				
				 
			)
		";
		
	}
	$typeQ = '';
	 
	$genQuery = "
		
		FROM dm_op_mojavez  opm   
	               left join  dm_operation_acc  op_acc 
	                   on opm.phm_op_id=op_acc.g_id
		WHERE 
			phm_id_province= ".$_SESSION['dm_user_profile']['u_province_id']."
			and 
			phm_status=0
		".$srchQ." 
		".$typeQ." 
		order by phm_id desc
		
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
			
			
			$lnkcat = mysql_query("SELECT *  FROM dm_prod_det_c
										 
								   WHERE cat_prod_id=".$row['phm_type_id']."
								        
								   ");
				
					$rowcat = mysql_fetch_assoc($lnkcat);
					
					$lnktype = mysql_query("SELECT *  FROM dm_prod_det_t
										 
								   WHERE type_prod_id=".$row['phm_ptype']."
								        
								   ");
//				echo "SELECT *  FROM dm_prod_det_t
//										 
//								   WHERE type_prod_id=".$row['phm_ptype']."";
					$rowtype = mysql_fetch_assoc($lnktype);
			
		if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete1';
				}
			
			$inx++;
			$gdate=$row['phm_date_l'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$phm_date_l = $jyear."/".$jmonth."/".$jday;
			
			//
			$gdate=$row['phm_date_f'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$phm_date_f = $jyear."/".$jmonth."/".$jday;
			
			
			$outHtml .= '
				 <tr class='.$class.'>
					<td style="vertical-align:middle;" align="center">'.$inx.'</td>
					<td style="vertical-align:middle;" align="center">'.$row['phm_mojavez'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$row['g_acc_name'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$rowcat['cat_prod_name'].'</td>
					
					<td width=50% style="vertical-align:middle;" align="center">'.$rowtype['type_prod_name'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$row['phm_amountpre'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$row['phm_amount'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$phm_date_f.'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$phm_date_l.'</td>';
			 $query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'20000\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){
				 $outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=editmojavezfrm&phm_id='.$row['phm_id'].'"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';
									//hazf	$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
					
			                    }
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';
						
					}
					$query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'300003\' ';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=deletemojavez&phm_id='.$row['phm_id'].'" onclick="return ConfirmDel();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
									//hazf	$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
			                    	
			                    
			                    }
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
						
					}
					
				$outHtml .= '</tr>';
				
		}
		
    }else{
    	$outHtml .= '<tr><td colspan="6">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '  
	
				          
	     
	      	</table></div><div align="center">'.getNavBar_moj().' '.getRPPCombo_moj();
    return $outHtml;
		
}
function getNavBar_moj(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=mojavezList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
        <td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=mojavezList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلی"></img></a></td>
       <td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=mojavezList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
            <td>&nbsp;&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=mojavezList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" >بعدي</a></td>
        <td>&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=mojavezList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="آخر"></img></a></td>	
        <td>&nbsp;&nbsp;</td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_moj(){
	$out = '
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=mojavezList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
<br><br>	';
	return $out;
}
function upmojavez(){
	
	
	    $phm_mojavez = isset($_REQUEST['phm_mojavez']) ? $_REQUEST['phm_mojavez'] : '';
		$phm_op_id = isset($_REQUEST['phm_op_id']) ? $_REQUEST['phm_op_id'] : '';
		$phm_id = isset($_REQUEST['phm_id']) ? $_REQUEST['phm_id'] : '';
		$phm_date_f = isset($_REQUEST['phm_date_f']) ? $_REQUEST['phm_date_f'] : '';
		$phm_date_l = isset($_REQUEST['phm_date_l']) ? $_REQUEST['phm_date_l'] : '';
		$phm_cat_l = isset($_REQUEST['phm_date_l']) ? $_REQUEST['phm_date_l'] : '';
		$phm_ptype = isset($_REQUEST['phm_ptype']) ? $_REQUEST['phm_ptype'] : '';
		
		$phm_type_id = isset($_REQUEST['phm_type_id']) ? $_REQUEST['phm_type_id'] : '';
		$phm_amount = isset($_REQUEST['phm_amount']) ? $_REQUEST['phm_amount'] : '';
		echo $phm_amount;
		//
		 $date = explode('/', $phm_date_f);
     $phm_date_f=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$phm_date_f;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$phm_date_f = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
	//
		
	 $date = explode('/', $phm_date_l);
     $phm_date_l=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$phm_date_l;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$phm_date_l = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25

	$querymm = "
	 	SELECT *  FROM dm_op_mojavez 
 
		WHERE 
			phm_id = ". $phm_id." ";		
				
    			$lnkmm = mysql_query($querymm);
			
				$rowmm = mysql_fetch_assoc($lnkmm);
				
			

	$phm_amountes=$rowmm['phm_amountes'];
	
	if ($phm_amountes==''){
		
		$phm_amountes=0;
		
	}
	
	$mande=($phm_amount-$phm_amountes);
	
	//mojavezi	
	
	if($rowmm['phm_amount']== $rowmm['phm_origamount']){
		
		$query = "
			UPDATE dm_op_mojavez 
			SET 
				
				`phm_mojavez` = '". $phm_mojavez ."',
				`phm_op_id` = '". $phm_op_id ."',
				`phm_date_l` = '". $phm_date_l ."',
				`phm_type_id` = '". $phm_type_id ."',
				`phm_date_f` = '". $phm_date_f ."',
				`phm_ptype` = '". $phm_ptype ."',
				`phm_amountes` = '". $phm_amountes ."',
				`phm_type_id` = '". $phm_type_id ."',
				`phm_amountpre` = '". $phm_amount ."',
				`phm_amount` = '". $mande ."'
							
			 WHERE 
				phm_id = ". $phm_id."";	
		
		
	}else{
		 $query = "
			UPDATE dm_op_mojavez 
			SET 
					
				`phm_op_id` = '". $phm_op_id ."',
				`phm_date_l` = '". $phm_date_l ."',
				`phm_type_id` = '". $phm_type_id ."',
				`phm_date_f` = '". $phm_date_f ."',
				`phm_ptype` = '". $phm_ptype ."',				
				`phm_type_id` = '". $phm_type_id ."'
					
			 WHERE 
				phm_id = ". $phm_id."";	
	
	}
					 
				$lnk = mysql_query($query);
				if(mysql_error()) print mysql_error();

}
function upmojavezk(){
	
	//echo hello;
	    $phm_mojavez = isset($_REQUEST['phm_mojavez']) ? $_REQUEST['phm_mojavez'] : '';
		$phm_op_id = isset($_REQUEST['phm_op_id']) ? $_REQUEST['phm_op_id'] : '';
		$phm_id = isset($_REQUEST['phm_id']) ? $_REQUEST['phm_id'] : '';
		$phm_date_f = isset($_REQUEST['phm_date_f']) ? $_REQUEST['phm_date_f'] : '';
		$phm_date_l = isset($_REQUEST['phm_date_l']) ? $_REQUEST['phm_date_l'] : '';
		$phm_cat_l = isset($_REQUEST['phm_date_l']) ? $_REQUEST['phm_date_l'] : '';
		$phm_mojavezj = isset($_REQUEST['phm_mojavezj']) ? $_REQUEST['phm_mojavezj'] : '';
		$phm_op_idj = isset($_REQUEST['phm_op_idj']) ? $_REQUEST['phm_op_idj'] : '';
		$phm_type_id = isset($_REQUEST['phm_type_id']) ? $_REQUEST['phm_type_id'] : '';
		$phm_ptype = isset($_REQUEST['phm_ptype']) ? $_REQUEST['phm_ptype'] : '';
		//$phm_amount = isset($_REQUEST['$phm_amount']) ? $_REQUEST['phm_ptype'] : '';
		 
		 $date = explode('/', $phm_date_f);
	     $phm_date_f=$date[2].'/'.$date[1].'/'.$date[0] ;      
	     $jdate=$phm_date_f;
	     $jdate .= '/\/';
	     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$phm_date_f = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
	//
		
	 $date = explode('/', $phm_date_l);
     $phm_date_l=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$phm_date_l;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$phm_date_l = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
	//mojavezi
 
	 $queryy = "
			UPDATE dm_op_mojavez 
			SET 
				
				`phm_mojavez` = '". $phm_mojavezj ."',
				`phm_op_id` = '". $phm_op_idj ."',
				`phm_date_l` = '". $phm_date_l ."',
				`phm_type_id` = '". $phm_type_id ."',
				`phm_ptype` = '". $phm_ptype ."',
				`phm_date_f` = '". $phm_date_f ."'
							
			 WHERE 
			    `phm_mojavez` = '". $phm_mojavez ."'
			   AND
				`phm_op_id` = '". $phm_op_id ."'
				";	
			 
				$lnky = mysql_query($queryy);
				if(mysql_error()) print mysql_error();
				//print $queryy;
	
	$i=44;//yani kol ostanha
	
 $query1 = array(
					
				    'phm_reg_date'=> gmdate('Y-m-d'),
		            'phm_op_id'=>  $phm_op_id,
		            'phm_mojavez'=>   $phm_mojavez,
                    'phm_ptype'=>   $phm_ptype,
		            'phm_id_province'=>  $i,
				 	
		             
				);
			
				$query1 = inserterQMaker('dm_op_mojavez_log', $query1);
				$lnk1 = mysql_query($query1);
                       if(mysql_error()) print mysql_error();
         //  print $query1; 
				
	
}
function dspProdFrmEditM(){
	?>
<script>
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num)) {
        num = "0";
    }
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num % 100;
    num = Math.floor(num/100).toString();
    if(cents < 10) {
        cents = "0" + cents;
    }
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++) {
        num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
    }
    if(cents>0){
    return (((sign)?'':'-')  + num + '.' + cents);
    }else{
    	 return (((sign)?'':'-')  + num );

    }
}function validateAndSaveProd(){
			
	if(fObj('p_sellprice').value==''){
			
			alert('لطفا قيمت فروش را وارد کنید');
			return;
		}
	if(fObj('p_price_code').value==''){
		
		alert('لطفا كد قيمت را وارد کنید');
		return;
	}
    checkAndValidProdNameEditM();

	}
function searchprice_code(e,val) {
	if(e.keyCode==112){
	
		window.open( 'searchprice_code.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}
			                      
	}

</script>
<?php 
	$p_id = isset($_REQUEST['p_id']) ? (int)($_REQUEST['p_id']) : 0;
	if($p_id<1) die('Invalid product id!');
	
	$lnk = mysql_query("SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
					   WHERE p_id=".$p_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
	global $p_Subsidies;
	$queryu = "
						 	SELECT *  FROM dm_prod_det_u 
					 
							WHERE 
								unit_prod_id = '".$row['p_unit']."' ";		
				
    			$lnku = mysql_query($queryu);
				sqlErr('for customer');
				$rowu = mysql_fetch_assoc($lnku);
					$unit=$rowu['unit_prod_name'];
					$queryc = "
						 	SELECT *  FROM dm_prod_det_c 
					 
							WHERE 
								cat_prod_id = '".$row['p_category']."' ";		
				
    			$lnkc = mysql_query($queryc);
				sqlErr('for category');
				$rowc = mysql_fetch_assoc($lnkc);
					$category=$rowc['cat_prod_name'];
					$queryp = "
						 	SELECT *  FROM dm_prod_det_p 
					 
							WHERE 
								pack_prod_id = '".$row['p_pakage_type']."' ";		
				
    			$lnkp = mysql_query($queryp);
				sqlErr('for package');
				$rowp = mysql_fetch_assoc($lnkp);
				$package=$rowp['pack_prod_name'];
//	print $queryp; 			
				$queryt = "
						 	SELECT *  FROM dm_prod_det_t 
					 
							WHERE 
								type_prod_id = '".$row['p_type']."' ";		
			
    			$lnkt = mysql_query($queryt);
				sqlErr('for type');
				$rowt = mysql_fetch_assoc($lnkt);
				$type=$rowt['type_prod_name'];					
		        $p_sellprice=formatMoney($row['p_sellprice']);
			       
   $p_Subsidies1 = $p_Subsidies[$row['p_subsidies']]['title'];
   $p_Subsidies2 = $p_Subsidies[$row['p_subsidies']]['cmnt'];
		?>
	<?php $province_id = $_SESSION['dm_user_profile']['u_province_id']; ?>  
	<span style="color:blue;"><span style="color:red;">  *  </span> در فيلد كد قيمت  ميتوانيد با كليد F1 به جستجو بپردازيد  </span>  

	<form method="post" action="" >
	   	
		<input type="hidden"  name="pg" value="prodMgmtPg">   
		<input type="hidden"  name="cmd" value="updPrdInfM">   
		<input type="hidden"  name="p_id" id="p_id" value="<?php echo $p_id; ?>"> 
		<input type="hidden"  name="p_name" id="p_name" value="<?php echo $row['p_name']; ?>">   
		  
		<table align="center"  class="nasi">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">مشخصات كالا</font></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
	      	    <td ><center>كد كالا </center> </td>
		        <td><?php echo $row['p_code'] ?></td>
		        <td ><center>نام كالا </center> </td>
		        <td><?php echo $row['p_name'] ?></td>
		     </tr>
		     <tr>
		       	<td><center>بسته بندي </center> </td>
			  	<td>
			  		<?php echo $package ?>
				</td>
				<td >واحد </td>
		        <td>
			  		<?php echo $unit ?>
				</td>
	        </tr>
	      	<tr>
		      	<td align="center"><center>ايران كد </center> </td>
			    <td><?php echo $row['p_iran_code'] ?></td><!--name kala-->
			    <td >قيمت فروش </td>
			    <td><input name="p_sellprice" id="p_sellprice" type="text" value="<?php echo $row['p_sellprice']; ?>"  onBlur="this.value=formatCurrency(this.value);"/></td>     
	      	</tr> 
	       
	      	<tr>
		        <td ><center>كد قيمت </center> </td>
		        <td><input name="p_price_code" id="p_price_code" type="text" value="<?php echo $row['p_price_code']; ?>"   onkeydown="searchprice_code(event,<?php echo $province_id ?>);" /></td>
		         <td>نوع</td>
	            <td>
			  		<?php echo $type ?>
				 </td>
	        </tr>
	      	<tr>
	      	     <td>رایانه</td>	            
			  		<td title="<?php echo $p_Subsidies2 ?>" align="center" style="vertical-align:middle;"><?php echo $p_Subsidies1 ?></td>		
				 <td>دسته</td>
				 <td>
			  		<?php echo $category ?>
				 </td>
			</tr>
			<tr>
			    <td>گروه كالا</td>
			    <td>
			  		<?php echo getTypesgroupComboBox('p_group_id')?>
				</td>
			</tr>
			
	      	<tr>    	       
				   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>			      			      	
                    <td colspan="3"><button  type="button" onclick="validateAndSaveProd();"value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				         
	      	</tr>
	    </table>
	</form> 
	    
	<?php
}
function getProdList(){
	
	?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
		
	<?php 
		
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	$srchStr;
	$outHtml = '	<br><br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodeProd">
			<table border=0 >
			<tr> 
			    <td style="font-weight:bold;">
			        کد ویا نام کالای مورد نظر را وارد نمایید 
			    </td>
			  <tr>
			  <div id="search">
			  
			     <td>
			     <div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			           <button value="draft" name="commit" type="submit" >جستجو</button> </div>
			     </td>
                 
              </tr>
              </table>
		</form>
	';

	$outHtml .= '<br>	
		<div align = "center">
		<div align = "center" style="width:100%;height:400px; overflow:auto">
			<table border="5" align="center" style="padding:20px;"  class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;"><center>لیست کالاها </center></th>
        		</tr>
      			<tr class="rw0" style="height: 50px;vertical-align:middle;font-size:15px;">
			        <td align="center" style="vertical-align:middle;" width="5%">ردیف</td>
			        <td align="center" style="vertical-align:middle;" width="15%">نام كالا </td>
			        <td align="center" style="vertical-align:middle;" width="5%">کد كالا </td>
			        <td align="center" style="vertical-align:middle;" width="5%">کد قيمت </td>
			        <td align="center" style="vertical-align:middle;" width="10%">تاريخ تعريف </td>
			        <td align="center" style="vertical-align:middle;" width="5%">ایران کد </td>
			        <td align="center" style="vertical-align:middle;" width="5%">بسته بندي </td>
			        <td align="center" style="vertical-align:middle;" width="5%">واحد </td>
			        <td align="center" style="vertical-align:middle;" width="15%">نوع </td>
			        <td align="center" style="vertical-align:middle;" width="5%">دسته</td>
			        <td align="center" style="vertical-align:middle;" width="5%">يارانه</td>
			        <td align="center" style="vertical-align:middle;" width="15%">قيمت فروش </td>		       
			        <td colspan="4" align="center"> &nbsp; </td>
				</tr>';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		
		$srchStr=str_replace("ي","ی",$_SESSION['srchStr']);
		$srchQ = " 
			AND(
					p_code = '".$srchStr."' 
				OR 
				
					p_name  LIKE '%".$srchStr."%' 
					
				OR
					
					p_name  LIKE '%".$_SESSION['srchStr']."%'
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "		
		FROM 
			dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id
		WHERE 
		 (price_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
		 or  price_id_province is null)
			".$srchQ." 
			".$typeQ." 
		 order by p_id desc";	
	

	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	
	$lnk = mysql_query($countQuery);		
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	echo '<br>';
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;	
	//print $resQuery;
	$_SESSION['srchStr'] = '';
	$_SESSION['srchStr'] = '';	
	$lnk1 = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk1)){
			
			if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete';
				}
				 
			$gdate=$row['p_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
        
			$queryu = "
						 	SELECT *  FROM dm_prod_det_u 
					 
							WHERE 
								unit_prod_id = '".$row['p_unit']."' ";		
				
    			$lnku = mysql_query($queryu);
				sqlErr('for customer');
				$rowu = mysql_fetch_assoc($lnku);
					$unit=$rowu['unit_prod_name'];
					$queryc = "
						 	SELECT *  FROM dm_prod_det_c 
					 
							WHERE 
								cat_prod_id = '".$row['p_category']."' ";		
				
    			$lnkc = mysql_query($queryc);
				sqlErr('for category');
				$rowc = mysql_fetch_assoc($lnkc);
					$category=$rowc['cat_prod_name'];
					$queryp = "
						 	SELECT *  FROM dm_prod_det_p 
					 
							WHERE 
								pack_prod_id = '".$row['p_pakage_type']."' ";		
				
    			$lnkp = mysql_query($queryp);
				sqlErr('for package');
				$rowp = mysql_fetch_assoc($lnkp);
				$package=$rowp['pack_prod_name'];
//	print $queryp; 			
				$queryt = "
						 	SELECT *  FROM dm_prod_det_t 
					 
							WHERE 
								type_prod_id = '".$row['p_type']."' ";		
			
    			$lnkt = mysql_query($queryt);
				sqlErr('for type');
				$rowt = mysql_fetch_assoc($lnkt);
					$type=$rowt['type_prod_name'];		
												
					$queryg = "SELECT * FROM  dm_operation_acc
							WHERE
                             g_id=".$row['p_group_id']."";  
				//	print $queryg;                        								    					       						       
								$lnkg = mysql_query($queryg);
								$rowg = mysql_fetch_assoc($lnkg);
					//			 $group=convert_charset($rowg['name']);
			       $p_sellprice=formatMoney($row['p_sellprice']);
			       
   $queryc = "
			 	SELECT *  FROM dm_charge 
		 
				WHERE 
					ch_id = '".$row['p_charge']."' ";		
				
    			$lnkc = mysql_query($queryc);
				sqlErr('for charge');
				$rowc = mysql_fetch_assoc($lnkc);
				 $queryp = "SELECT * FROM  dm_province
							WHERE
								province_id=".$_SESSION['dm_user_profile']['u_province_id']."  ";	
											       						       
		$lnkp = mysql_query($queryp);												
		$rowp= mysql_fetch_assoc($lnkp);
		
		$province_code = $rowp['province_code'];
				
			   $querys = "
				 	SELECT *  FROM dm_subsidies 
			 
					WHERE 
						sub_id = '".$row['p_subsidies']."' ";		
				
    			$lnks = mysql_query($querys);
				sqlErr('for subdidies');
				$rows = mysql_fetch_assoc($lnks);
   		 
   			      
		$outHtml .= '
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_price_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_iran_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$package.'</td>
					<td  align="center" style="vertical-align:middle;">'.$unit.'</td>
					<td  align="center" style="vertical-align:middle;">'.$type.'</td>
					<td align="center" style="vertical-align:middle;">'.$category.'</td>
					<td align="center" style="vertical-align:middle;">'.$rows['sub_name'].'</td>					
					
					<td  align="center" style="vertical-align:middle;">'.$p_sellprice.'ريال</td>			
					';
			                    $query2='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'112\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    
		  //                 print $query2;
		  //nasim
			        //nasim             if( mysql_num_rows($lnk2)==0){
			         //nasim            	$row2 = mysql_fetch_assoc($lnk2);
				
			                    
			              //nasim       }
				 //nasim	else{
					  $outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=dspProdFrmEdit&p_id='.$row['p_id'].'&price_id='.$row['price_id'].'"><img src="images/'.$edit.'.png" width="20" height="20" title="ویرایش" "></img></a></td>';
						
						//$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" "></img></a></td>';
						
			 //nasim	}
					//	$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><a href="?pg=prodMgmtPg&cmd=dspProdFrmEditM&p_id='.$row['p_id'].'"><img src="images/edit.png" width="20" height="20" title="ویرایش" "></img></a></td>';
	//				 $outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=dspProdFrmEdit&p_id='.$row['p_id'].'"><img src="images/'.$edit.'.png" width="20" height="20" title="ویرایش" "></img></a></td>';
					$query2='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'112\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                   
//		                    print $query2;
			                    if(mysql_affected_rows()>0){
			                    	 $row2 = mysql_fetch_assoc($lnk2);
			                    	 
					$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=deleteProd1&p_id='.$row['p_id'].'&price_id='.$row['price_id'].'"><img src="images/'.$delete.'.PNG" width="20" height="20" title="حذف" "></img></a></td>';
					//$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/'.$delete.'.PNG" width="20" height="20" title="حذف" "></img></a></td>';
			                    }
		else{
						$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/'.$delete.'.PNG" width="20" height="20" title="حذف" "></img></a></td>';
						
					}
					
				$outHtml .= '</tr>';
			
			$inx++;
		}
    }else{
    	$outHtml .= '<tr ><td colspan="13">هیچ اطلاعاتي موجود نیست</td></tr>';
    }
    $outHtml .= '</table></div ><br><div align="center" >'.getNavBar().' </div>'.getRPPCombo();
    return $outHtml;
    
		
}
function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
} 
function getNavBar(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showprodList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=showprodList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=showprodList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showprodList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=showprodList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=showprodList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}


//براي اسناد		
function dspRegDocumentFrm(){
	$_SESSION['saveDoc']=1;
	$_SESSION['pardakhti']='';
	
	?>
	<script type="text/javascript">
	function validateAndSaveDoc(){
		
	  if(fObj('d_code').value==''){
			
			alert('لطفا کد سند را وارد کنید');
			return;
		}
		if(fObj('d_pardakht_t').value==1){
		
			      if(fObj('d_accountnum').value==''){
				
				alert('لطفا شماره حساب را وارد کنید');
				return;
			}
		      if(fObj('d_branch').value==''){
				
				alert('لطفا نام شعبه را وارد کنید');
				return;
			}
			  
			   if(fObj('d_ac_bed').value==''){
					
					alert('فیلد حساب بدهکاررا وارد کنید');
					return;
				}
			   
		}
		if(fObj('d_pardakht_t').value==2){
	   if( fObj('d_ac_bes').value==''){
			
			alert('فیلد  بستانكار را وارد کنید');
			return;
		}
	  
		}
	   
	   validDocCode();
//	   if($_SESSION['checkCodeDoc']==0){
//		   window.open('?pg=havaleMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountNum='+fObj('d_accountNum').value+'&d_branch='
//		   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value , '_self');
//	   }
	}
  </script>
<div>
  <p> راهنمای ورود اطلاعات حساب بدهکار/ بستانکار</p>
  <p>نوع پرداختی---> پرداختی/ نفدی :کد 12 رقمی می باشد مثل:301001000013</p>
  <p>نوع پرداختی---> در جریان وصول :کد 12 رقمی می باشد مثل:301001000013</p>
  <p>نوع پرداختی---> نزد صندوق :کد 6 رقمی می باشد مثل:301001</p>
  <p>نوع پرداختی---> اضافه پرداختی :کد 6 رقمی می باشد مثل:301001</p>
  <p>نوع پرداختی---> في مابين :کد 6 رقمی می باشد مثل:301001</p>
</div>

		<table  align="center"  class="nasi"  width="80%" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">مشخصات اسناد</font></b></td>
	        </tr>
	        <tr>
	             <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>	
	        <tr>
		        <td ><center>كد سند </center> </td>
		        <td><input name="d_code"  id="d_code" type="text"  class="chk"/></td>
		        <td ><center>نوع سند </center> </td>
			  	<td>
			  		<?php echo getdocTypesComboBox('d_documentType')?>
				</td>  
	        </tr>
	        <tr>
		        <td ><center>نوع پرداختی </center> </td>
		        <td>
			  		<?php echo getpardakhtiTypesComboBox('d_pardakht_t')?>
				</td>		         
	        </tr>
	      	<tr id="d">
		        <td  align="center"><center>شماره حساب </center> </td>
		        <td><input name="d_accountnum" id="d_accountnum"  type="text" class="chk" /></td>
		        <td ><center> نام بانك</center> </td>
		        <td>
			  		<?php echo getbankTypesComboBox1('d_bank')?>
				</td> 
	        </tr>
	      	<tr id="d1" >
		        <td ><center>نام شعبه </center> </td>
		        <td><input name="d_branch" id="d_branch" type="text" class="chk"/></td>
		        
	        </tr>
	        <tr id="d2" >
		        <td ><center>حساب بدهکار </center> </td>
		        <td><input name="d_ac_bed" id="d_ac_bed" type="text" class="chk"/></td>
		        <td >شرح بدهکار </td>
		        <td><input name="d_ac_bed_dis" id="d_ac_bed_dis" type="text"  class="chk"/></td>
	        </tr>
	         <tr id="d3"  style='display:none;'>
		        <td ><center>حساب بستانکار </center> </td>
		        <td><input name="d_ac_bes" id="d_ac_bes" type="text" class="chk"/></td>
		        <td >شرح بستانکار </td>
		        <td><input name="d_ac_bes_dis" id="d_ac_bes_dis" type="text"  class="chk"/></td>
	        </tr>
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>      	
			     <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveDoc();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	      	</tr>
	    </table>
<!--	</form> -->
	    
	<?php
	
}
function dspRegDocumentFrmk(){
	$_SESSION['saveDoc']=1;
	$_SESSION['pardakhti']='';
	
	?>
	<script type="text/javascript">
	function validateAndSaveDoc(){
		
	  if(fObj('d_code').value==''){
			
			alert('لطفا کد سند را وارد کنید');
			return;
		}
		
		    
			  
			   if(fObj('d_ac_bed').value==''){
					
					alert('فیلد حساب بدهکاررا وارد کنید');
					return;
				}
			   
	
		
	   
	   validDocCodek();
//	   if($_SESSION['checkCodeDoc']==0){
//		   window.open('?pg=havaleMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountNum='+fObj('d_accountNum').value+'&d_branch='
//		   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value , '_self');
//	   }
	}

  </script>


		<table  align="center"  class="nasi"  width="80%" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">مشخصات اسناد(کلی)</font></b></td>
	        </tr>
	        <tr>
	             <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>	
	        <tr>
		        <td ><center>كد سند </center> </td>
		        <td><input name="d_code"  id="d_code" type="text"  class="chk"/></td>
		         <td ><center>نوع پرداختی </center> </td>
		        <td>
			  		<?php echo getpardakhtiTypesComboBox('d_pardakht_t')?>
				</td>
	        </tr>
	       
	      	
	      
	        <tr id="d2" >
		        <td ><center>حساب بدهکار </center> </td>
		        <td><input name="d_ac_bed" id="d_ac_bed" type="text" class="chk"/></td>
		        <td >شرح بدهکار </td>
		        <td><input name="d_ac_bed_dis" id="d_ac_bed_dis" type="text"  class="chk"/></td>
	        </tr>
	         <tr id="d3"  >
		        <td ><center>حساب بستانکار </center> </td>
		        <td><input name="d_ac_bes" id="d_ac_bes" type="text" class="chk"/></td>
		        <td >شرح بستانکار </td>
		        <td><input name="d_ac_bes_dis" id="d_ac_bes_dis" type="text"  class="chk"/></td>
	        </tr>
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>      	
			     <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveDoc();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	      	</tr>
	    </table>
	</form> 
	    
	<?php
	
}
function regDocument(){ 
	if($_SESSION['saveDoc']==1){
	$d_code = isset($_REQUEST['d_code']) ? $_REQUEST['d_code'] : '';
	$d_documentType = isset($_REQUEST['d_documentType']) ? ($_REQUEST['d_documentType']) : '';
	$d_accountnum = isset($_REQUEST['d_accountnum']) ? ($_REQUEST['d_accountnum']) : '';
	$d_bank = isset($_REQUEST['d_bank']) ? ($_REQUEST['d_bank']) : '';
	$d_branch = isset($_REQUEST['d_branch']) ? ($_REQUEST['d_branch']) : '';
	$d_fluentAccount = isset($_REQUEST['d_fluentAccount']) ? ($_REQUEST['d_fluentAccount']) : '';
	$d_ac_bed = isset($_REQUEST['d_ac_bed']) ? ($_REQUEST['d_ac_bed']) : '';
	$d_ac_bed_dis = isset($_REQUEST['d_ac_bed_dis']) ? ($_REQUEST['d_ac_bed_dis']) : '';
	$d_ac_bes = isset($_REQUEST['d_ac_bes']) ? ($_REQUEST['d_ac_bes']) : '';
	$d_ac_bes_dis = isset($_REQUEST['d_ac_bes_dis']) ? ($_REQUEST['d_ac_bes_dis']) : '';
	$d_pardakht_t = isset($_REQUEST['d_pardakht_t']) ? ($_REQUEST['d_pardakht_t']) : '';
	
	
	$query = array(
		'd_code' => $d_code,
		'd_documenttype' => $d_documentType,
		'd_accountnum' => $d_accountnum,
		'd_bank' => $d_bank,
		'd_branch' => $d_branch,
     	'd_fluentaccount' => $d_fluentAccount,
	    'd_reg_date' => gmdate('Y-m-d'),
	    'd_ac_bed' => $d_ac_bed.$s,
	    'd_ac_bes' => $d_ac_bes.$s,
	    'd_ac_bes_dis' => $d_ac_bes_dis,
	    'd_ac_bed_dis' => $d_ac_bed_dis,
	    'd_pardakht_t' => $d_pardakht_t,
	    'd_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
	    'd_u_id' => $_SESSION['dm_user_profile']['u_id'],
	);

	$query = inserterQMaker('dm_document', $query);
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['saveDoc']=0;
	$d_id = mysql_insert_id();
	return $d_id;	
	}
}
function regDocumentk(){ 
	if($_SESSION['saveDoc']==1){
	$d_code = isset($_REQUEST['d_code']) ? $_REQUEST['d_code'] : '';
	$d_documentType = isset($_REQUEST['d_documentType']) ? ($_REQUEST['d_documentType']) : '';
	$d_accountnum = isset($_REQUEST['d_accountnum']) ? ($_REQUEST['d_accountnum']) : '';
	$d_bank = isset($_REQUEST['d_bank']) ? ($_REQUEST['d_bank']) : '';
	$d_branch = isset($_REQUEST['d_branch']) ? ($_REQUEST['d_branch']) : '';
	$d_fluentAccount = isset($_REQUEST['d_fluentAccount']) ? ($_REQUEST['d_fluentAccount']) : '';
	$d_ac_bed = isset($_REQUEST['d_ac_bed']) ? ($_REQUEST['d_ac_bed']) : '';
	$d_ac_bed_dis = isset($_REQUEST['d_ac_bed_dis']) ? ($_REQUEST['d_ac_bed_dis']) : '';
	$d_ac_bes = isset($_REQUEST['d_ac_bes']) ? ($_REQUEST['d_ac_bes']) : '';
	$d_ac_bes_dis = isset($_REQUEST['d_ac_bes_dis']) ? ($_REQUEST['d_ac_bes_dis']) : '';
	$d_pardakht_t = isset($_REQUEST['d_pardakht_t']) ? ($_REQUEST['d_pardakht_t']) : '';
	
	
	$query = array(
		'd_code' => $d_code,
		'd_documenttype' => $d_documentType,
		'd_accountnum' => $d_accountnum,
		'd_bank' => $d_bank,
		'd_branch' => $d_branch,
     	'd_fluentaccount' => $d_fluentAccount,
	    'd_reg_date' => gmdate('Y-m-d'),
	    'd_ac_bed' => $d_ac_bed.$s,
	    'd_ac_bes' => $d_ac_bes.$s,
	    'd_ac_bes_dis' => $d_ac_bes_dis,
	    'd_ac_bed_dis' => $d_ac_bed_dis,
	    'd_pardakht_t' => $d_pardakht_t,
	    'd_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
	    'd_u_id' => $_SESSION['dm_user_profile']['u_id'],
	);

	$query = inserterQMaker('dm_documentk', $query);
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['saveDoc']=0;
	$d_id = mysql_insert_id();
	return $d_id;	
	}
}

function getDocumentList(){
	
	?>-->
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	<?php 

	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodedocument"> 
			 کد سند مورد نظر را وارد كنيد 
			<div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '	<br>
		<div align = "center">
			<table  border="2" align="center" cellpadding="0" cellspacing="0"   class="list" >
      			<tr class="rw1">
        			<td colspan="19" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;"><b>مشخصات اسناد </b></td>
        		</tr>
      			<tr class="rw0"  style="height: 30px;vertical-align:middle;font-weight:bold;">
      			    <td align="center" style="vertical-align:middle;">رديف</td>
			        <td align="center" style="vertical-align:middle;">كد سند</td>
			        <td align="center" style="vertical-align:middle;">نوع سند </td>
			        <td align="center" style="vertical-align:middle;">شماره حساب</td>
			        <td align="center" style="vertical-align:middle;">نام بانك</td>
			        <td align="center" style="vertical-align:middle;">نام شعبه </td>
			        <td align="center" style="vertical-align:middle;">حساب بدهکار </td>
			        <td align="center" style="vertical-align:middle;">شرح حساب بدهکار</td>
			         <td align="center" style="vertical-align:middle;">حساب بستانکار </td>
			        <td align="center" style="vertical-align:middle;">شرح حساب بستانکار</td>
			         <td align="right" colspan="3" style="vertical-align:middle;">نوع پرداختی </td>
				</tr>';
	
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					d_code LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					d_bank LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					d_branch  LIKE '%".$_SESSION['srchStr']."%' 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_document 
		WHERE 
			d_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['d_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
		
if(($inx)%2==1){
				$class="rw0";
				$edit='edit1';
				$delete='delete1';
			
			}
				else{
					$edit='edit';
				    $class="rw1";
				    $delete='delete';
				}
				$inx++;
			$queryt = "
						 	SELECT *  FROM dm_doc_det_t 
					 
							WHERE 
								doc_t_id = '".$row['d_documenttype']."' ";		
				
    			$lnkt = mysql_query($queryt);
				sqlErr('for type doc');
				$rowt = mysql_fetch_assoc($lnkt);	
				$type=$rowt['doc_t_name'];
				$queryb = "
						 	SELECT *  FROM dm_doc_det_b 
					 
							WHERE 
								doc_b_id = '".$row['d_bank']."' ";		
				
    			$lnkb = mysql_query($queryb);
				sqlErr('for bank doc');
				$rowb = mysql_fetch_assoc($lnkb);	
				$bank=$rowb['doc_b_name'];
				
				
				$querypa = "
						 	SELECT *  FROM dm_doc_p
					 
							WHERE 
								docp_id = '".$row['d_pardakht_t']."' ";		
				
    			$lnkpa = mysql_query($querypa);
				sqlErr('for type doc');
				$rowpa = mysql_fetch_assoc($lnkpa);	
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center" width="5%">'.$inx.'</td>
					<td align="center" width="7%">'.$row['d_code'].'</td>
					<td alig="center"  width="7%">'.$type.'</td>
					<td align="center" width="7%">'.$row['d_accountnum'].'</td>
					<td alig="center"  width="10%">'.$bank.'</td>
					<td align="center" width="10%">'.$row['d_branch'].'</td>
					<td align="center" width="10%">'.$row['d_ac_bed'].'</td>
					<td align="center" width="10%">'.$row['d_ac_bed_dis'].'</td>
					<td align="center" width="10%">'.$row['d_ac_bes'].'</td>
					<td align="center" width="10%">'.$row['d_ac_bes_dis'].'</td>
					<td align="center" width="7%">'.$rowpa['docp_name'].'</td>';	
			          $query2='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'122\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){				
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=dspdocFrmEdit&d_id='.$row['d_id'].'"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></a></td>';}
					else
					    {
							$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" onmouseOver="this.src=\'images/edit2.PNG\'" onmouseOut="this.src=\'images/'.$edit.'.PNG\'"></a></td>';
					    }
		     $query2='select *
									from dm_um_rel t
									     inner join dm_listmenu l on l.menu_id = t.um_menu_id
									where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
									      l.menu_code = \'122\' and t.um_can_delete=1';
                    $lnk2 = mysql_query($query2);
                    $row2 = mysql_fetch_assoc($lnk2);
                    if($_SESSION['dm_user_profile']['u_id']==3){	
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=deletedocument&d_id='.$row['d_id'].'"><img src="images/delete.PNG" width="20" height="20" title="حذف"></a></td>';}
					else{
							$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></a></td>';
						
					}
				$outHtml .= '</tr>';
			
		}
    }else{
    	$outHtml .= '<tr class="rw1"><td colspan="15">هیچ سندي موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_d().' '.getRPPCombo_d();
   
    return $outHtml;
		
}

function getNavBar_d(){
	$out = '<div align="center">
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showdocumentList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=showdocumentList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" > <img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=showdocumentList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showdocumentList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=showdocumentList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" > <img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
		</div>
	';	
	return $out;
}

function getRPPCombo_d(){
	$out = '<div align="center">
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=showdocumentList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
 









function getDocumentListk(){
	
	?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	<?php 

	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodedocument"> 
			 کد سند مورد نظر را وارد كنيد 
			<div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '	<br>
		<div align = "center">
			<table  border="2" align="center" cellpadding="0" cellspacing="0"   class="list" >
      			<tr class="rw1">
        			<td colspan="19" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;"><b>مشخصات اسناد </b></td>
        		</tr>
      			<tr class="rw0"  style="height: 30px;vertical-align:middle;font-weight:bold;">
      			    <td align="center" style="vertical-align:middle;">رديف</td>
			        <td align="center" style="vertical-align:middle;">كد سند</td>
			      
			      
		
			        <td align="center" style="vertical-align:middle;">حساب بدهکار </td>
			        <td align="center" style="vertical-align:middle;">شرح حساب بدهکار</td>
			         <td align="center" style="vertical-align:middle;">حساب بستانکار </td>
			        <td align="center" style="vertical-align:middle;">شرح حساب بستانکار</td>
			         <td align="right" colspan="3" style="vertical-align:middle;">نوع پرداختی </td>
				</tr>';
	
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					d_code LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					d_bank LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					d_branch  LIKE '%".$_SESSION['srchStr']."%' 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_documentk 
		WHERE 
		1
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['d_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
		
if(($inx)%2==1){
				$class="rw0";
				$edit='edit1';
				$delete='delete1';
			
			}
				else{
					$edit='edit';
				    $class="rw1";
				    $delete='delete';
				}
				$inx++;
			$queryt = "
						 	SELECT *  FROM dm_doc_det_t 
					 
							WHERE 
								doc_t_id = '".$row['d_documenttype']."' ";		
				
    			$lnkt = mysql_query($queryt);
				sqlErr('for type doc');
				$rowt = mysql_fetch_assoc($lnkt);	
				$type=$rowt['doc_t_name'];
				$queryb = "
						 	SELECT *  FROM dm_doc_det_b 
					 
							WHERE 
								doc_b_id = '".$row['d_bank']."' ";		
				
    			$lnkb = mysql_query($queryb);
				sqlErr('for bank doc');
				$rowb = mysql_fetch_assoc($lnkb);	
				$bank=$rowb['doc_b_name'];
				
				
				$querypa = "
						 	SELECT *  FROM dm_doc_p
					 
							WHERE 
								docp_id = '".$row['d_pardakht_t']."' ";		
				
    			$lnkpa = mysql_query($querypa);
				sqlErr('for type doc');
				$rowpa = mysql_fetch_assoc($lnkpa);	
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center" width="5%">'.$inx.'</td>
					<td align="center" width="7%">'.$row['d_code'].'</td>
					
					<td align="center" width="10%">'.$row['d_ac_bed'].'</td>
					<td align="center" width="10%">'.$row['d_ac_bed_dis'].'</td>
					<td align="center" width="10%">'.$row['d_ac_bes'].'</td>
					<td align="center" width="10%">'.$row['d_ac_bes_dis'].'</td>
					<td align="center" width="7%">'.$rowpa['docp_name'].'</td>';	
			          $query2='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'122\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){				
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=dspdocFrmEditk&d_id='.$row['d_id'].'"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></a></td>';}
					else
					    {
							$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" onmouseOver="this.src=\'images/edit2.PNG\'" onmouseOut="this.src=\'images/'.$edit.'.PNG\'"></a></td>';
					    }
		     $query2='select *
									from dm_um_rel t
									     inner join dm_listmenu l on l.menu_id = t.um_menu_id
									where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
									      l.menu_code = \'122\' and t.um_can_delete=1';
                    $lnk2 = mysql_query($query2);
                    $row2 = mysql_fetch_assoc($lnk2);
                    if($_SESSION['dm_user_profile']['u_id']==3){	
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=deletedocument&d_id='.$row['d_id'].'"><img src="images/delete.PNG" width="20" height="20" title="حذف"></a></td>';}
					else{
							$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></a></td>';
						
					}
				$outHtml .= '</tr>';
			
		}
    }else{
    	$outHtml .= '<tr class="rw1"><td colspan="15">هیچ سندي موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_dk().' '.getRPPCombo_dk();
   
    return $outHtml;
		
}

function getNavBar_dk(){
	$out = '<div align="center">
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showdocumentListk&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=showdocumentListk&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" > <img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=showdocumentListk&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showdocumentListk&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=showdocumentListk&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" > <img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
		</div>
	';	
	return $out;
}

function getRPPCombo_dk(){
	$out = '<div align="center">
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=showdocumentListk&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}




function dspdocFrmEditk(){
	?>
	<script type="text/javascript">
	function validateAndSaveDoc(){
if(fObj('d_code').value==''){
			
			alert('لطفا کد سند را وارد کنيد');
			return;
		}
		
	
	   validDocCodeEditk();
//	   if($_SESSION['checkCodeDoc']==0){
//		   window.open('?pg=havaleMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountNum='+fObj('d_accountNum').value+'&d_branch='
//		   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value , '_self');
//	   }
	
	}
  </script>
  <?php 
	
	$d_id = isset($_REQUEST['d_id']) ? (int)($_REQUEST['d_id']) : 0;
	if($d_id<1) die('Invalid document id!');
	
	$lnk = mysql_query("SELECT * FROM dm_documentk WHERE d_id=".$d_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
	
	echo '<font color="red"> **** به نوع پرداختی دقت کنید</font>';
		?>
	

	<form method="post" action="" >
	   	
<!--		<input type="hidden" name="pg" value="prodMgmtPg">   -->
<!--		<input type="hidden" name="cmd" value="updocumenInf">   -->
		<input type="hidden" name="d_id" id="d_id" value="<?php echo $d_id; ?>">   
		<table  align="center"  class="nasi"   >
		 	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">مشخصات اسناد</font></b></td>
	        </tr>
	        <tr>
	             <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>	
	        <tr>
		        <td ><center>كد سند </center> </td>
		        <td><input name="d_code"  id="d_code" type="text" value="<?php echo $row['d_code']; ?>"  class="chk"/></td>
		        <td ><center>نوع پرداختي </center> </td>
		        <td>
			  		<?php echo getpardakhtiTypesComboBox('d_pardakht_t',$row['d_pardakht_t'])?>
				</td>  
	        </tr>
	       
	        <tr id="d2">
		        <td ><center>حساب بدهکار </center> </td>
		        <td><input name="d_ac_bed" id="d_ac_bed"  value="<?php echo $row['d_ac_bed']; ?>" type="text" class="chk"/></td>
		        <td >شرح بدهکار </td>
		        <td><input name="d_ac_bed_dis" id="d_ac_bed_dis" value="<?php echo $row['d_ac_bed_dis']; ?>" type="text"  class="chk"/></td>
	        </tr>
	        <!--  <tr>
		        <td ><center>حساب بستانکار </center> </td>
		        <td><input name="d_ac_bes" id="d_ac_bes" type="text" value="<?php echo $row['d_ac_bes']; ?>" class="chk"/></td>
		        <td >شرح بستانکار </td>
		        <td><input name="d_ac_bes_dis" id="d_ac_bes_dis" type="text"  value="<?php echo $row['d_ac_bes_dis']; ?>" class="chk"/></td>
	        </tr> -->
	      <tr>
				       
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				       </td>
			      	
				        <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveDoc();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
	    </table>
		
	</form>
	
	<?php
}





function dspdocFrmEdit(){
	?>
	<script type="text/javascript">
	function validateAndSaveDoc(){
if(fObj('d_code').value==''){
			
			alert('لطفا کد سند را وارد کنيد');
			return;
		}
		if(fObj('d_pardakht_t').value==1){
		
			      if(fObj('d_accountnum').value==''){
				
				alert('لطفا شماره حساب را وارد کنيد');
				return;
			}
		      if(fObj('d_branch').value==''){
				
				alert('لطفا نام شعبه را وارد کنيد');
				return;
			}
			  
			   if(fObj('d_ac_bed').value==''){
					
					alert('فيلد حساب بدهکاررا وارد کنيد');
					return;
				}
			   
		}
		
	   if( fObj('d_ac_bes').value==''){
			
			alert('فيلد  بستانكار را وارد کنيد');
			return;
		}
	   
	
	   validDocCodeEdit();
//	   if($_SESSION['checkCodeDoc']==0){
//		   window.open('?pg=havaleMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountNum='+fObj('d_accountNum').value+'&d_branch='
//		   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value , '_self');
//	   }
	
	}
  </script>
  <?php 
	
	$d_id = isset($_REQUEST['d_id']) ? (int)($_REQUEST['d_id']) : 0;
	if($d_id<1) die('Invalid document id!');
	
	$lnk = mysql_query("SELECT * FROM dm_document WHERE d_id=".$d_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
	
	echo '<font color="red"> **** به نوع پرداختی دقت کنید</font>';
		?>
	

	<form method="post" action="" >
	   	
<!--		<input type="hidden" name="pg" value="prodMgmtPg">   -->
<!--		<input type="hidden" name="cmd" value="updocumenInf">   -->
		<input type="hidden" name="d_id" id="d_id" value="<?php echo $d_id; ?>">   
		<table  align="center"  class="nasi"   >
		 	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">مشخصات اسناد</font></b></td>
	        </tr>
	        <tr>
	             <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>	
	        <tr>
		        <td ><center>كد سند </center> </td>
		        <td><input name="d_code"  id="d_code" type="text" value="<?php echo $row['d_code']; ?>"  class="chk"/></td>
		        <td ><center>نوع سند </center> </td>
			  	<td>
			  		<?php echo getdocTypesComboBox('d_documentType',$row['d_documenttype'])?>
				</td>  
	        </tr>
	        <tr>
		        <td ><center>نوع پرداختي </center> </td>
		        <td>
			  		<?php echo getpardakhtiTypesComboBox('d_pardakht_t',$row['d_pardakht_t'])?>
				</td>
		         
	        </tr>
	      	<tr id="d">
		        <td  align="center"><center>شماره حساب </center> </td>
		        <td><input name="d_accountnum" id="d_accountnum"  value="<?php echo $row['d_accountnum']; ?>" type="text" class="chk" /></td>
		        <td ><center> نام بانك</center> </td>
		        <td>
			  		<?php echo getbankTypesComboBox('d_bank')?>
				</td> 
	        </tr>
	      	<tr id="d1">
		        <td ><center>نام شعبه </center> </td>
		        <td><input name="d_branch" id="d_branch"  value="<?php echo $row['d_branch']; ?>" type="text" class="chk"/></td>
		        
	        </tr>
	        <tr id="d2">
		        <td ><center>حساب بدهکار </center> </td>
		        <td><input name="d_ac_bed" id="d_ac_bed"  value="<?php echo $row['d_ac_bed']; ?>" type="text" class="chk"/></td>
		        <td >شرح بدهکار </td>
		        <td><input name="d_ac_bed_dis" id="d_ac_bed_dis" value="<?php echo $row['d_ac_bed_dis']; ?>" type="text"  class="chk"/></td>
	        </tr>
	         <tr>
		        <td ><center>حساب بستانکار </center> </td>
		        <td><input name="d_ac_bes" id="d_ac_bes" type="text" value="<?php echo $row['d_ac_bes']; ?>" class="chk"/></td>
		        <td >شرح بستانکار </td>
		        <td><input name="d_ac_bes_dis" id="d_ac_bes_dis" type="text"  value="<?php echo $row['d_ac_bes_dis']; ?>" class="chk"/></td>
	        </tr>
	      <tr>
				       
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				       </td>
			      	
				        <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveDoc();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
	    </table>
		
	</form>
	
	<?php
}
function updocumentInf(){
	$d_id = isset($_REQUEST['d_id']) ? (int)($_REQUEST['d_id']) : 0;
	if($d_id<1) die('Inv Id');
	
	$d_code = isset($_REQUEST['d_code']) ? $_REQUEST['d_code'] : '';
	$d_documentType = isset($_REQUEST['d_documentType']) ? ($_REQUEST['d_documentType']) : '';
	$d_accountnum = isset($_REQUEST['d_accountnum']) ? ($_REQUEST['d_accountnum']) : '';
	$d_bank = isset($_REQUEST['d_bank']) ? $_REQUEST['d_bank'] : '';
	$d_branch = $_REQUEST['d_branch'];
	$d_fluentAccount = isset($_REQUEST['d_fluentAccount']) ? $_REQUEST['d_fluentAccount'] : '';
	$d_ac_bed = isset($_REQUEST['d_ac_bed']) ? $_REQUEST['d_ac_bed'] : '';
	$d_ac_bed_dis = isset($_REQUEST['d_ac_bed_dis']) ? $_REQUEST['d_ac_bed_dis'] : '';
	$d_ac_bes = isset($_REQUEST['d_ac_bes']) ? $_REQUEST['d_ac_bes'] : '';
	$d_ac_bes_dis = isset($_REQUEST['d_ac_bes_dis']) ? $_REQUEST['d_ac_bes_dis'] : '';
	
	//	`d_pardakht_t`= '".$_SESSION['pardakhti']."', 	
			
	$query = "
		UPDATE dm_document 
		SET 
			`d_code` = '".$d_code."',
			`d_documenttype` = '".$d_documentType."',  
			`d_accountnum`= '".$d_accountnum."', 
			`d_bank` = '".$d_bank."',
		    `d_ac_bed`= '".$d_ac_bed.$s."', 
			`d_ac_bed_dis` = '".$d_ac_bed_dis."',
		    `d_ac_bes`= '".$d_ac_bes.$s. "', 
			`d_ac_bes_dis` = '".$d_ac_bes_dis."',
			`d_reg_date`= '".gmdate('Y-m-d')."', 
		
			`d_u_id` = '".$_SESSION['dm_user_profile']['u_id']."',
			`d_fluentaccount` = '".$d_fluentAccount."'			
		WHERE 
			d_id = ".$d_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	//print $query;
}

function updocumentInfk(){
	$d_id = isset($_REQUEST['d_id']) ? (int)($_REQUEST['d_id']) : 0;
	if($d_id<1) die('Inv Id');
	
	$d_code = isset($_REQUEST['d_code']) ? $_REQUEST['d_code'] : '';
	$d_documentType = isset($_REQUEST['d_documentType']) ? ($_REQUEST['d_documentType']) : '';
	$d_accountnum = isset($_REQUEST['d_accountnum']) ? ($_REQUEST['d_accountnum']) : '';
	$d_bank = isset($_REQUEST['d_bank']) ? $_REQUEST['d_bank'] : '';
	$d_branch = $_REQUEST['d_branch'];
	$d_fluentAccount = isset($_REQUEST['d_fluentAccount']) ? $_REQUEST['d_fluentAccount'] : '';
	$d_ac_bed = isset($_REQUEST['d_ac_bed']) ? $_REQUEST['d_ac_bed'] : '';
	$d_ac_bed_dis = isset($_REQUEST['d_ac_bed_dis']) ? $_REQUEST['d_ac_bed_dis'] : '';
	$d_ac_bes = isset($_REQUEST['d_ac_bes']) ? $_REQUEST['d_ac_bes'] : '';
	$d_ac_bes_dis = isset($_REQUEST['d_ac_bes_dis']) ? $_REQUEST['d_ac_bes_dis'] : '';
	
	//	`d_pardakht_t`= '".$_SESSION['pardakhti']."', 	
			
	$query = "
		UPDATE dm_documentk 
		SET 
			`d_code` = '".$d_code."',
			`d_documenttype` = '".$d_documentType."',  
		
		    `d_ac_bed`= '".$d_ac_bed.$s."', 
			`d_ac_bed_dis` = '".$d_ac_bed_dis."',
		    `d_ac_bes`= '".$d_ac_bes.$s. "', 
			`d_ac_bes_dis` = '".$d_ac_bes_dis."',
			`d_reg_date`= '".gmdate('Y-m-d')."', 
		
			`d_u_id` = '".$_SESSION['dm_user_profile']['u_id']."',
			`d_fluentaccount` = '".$d_fluentAccount."'			
		WHERE 
			d_id = ".$d_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	//print $query;
}
function deletedocument(){
		$d_id = isset($_REQUEST['d_id']) ? (int)($_REQUEST['d_id']) : 0;
		if($d_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_document
	 
			WHERE 
				d_id = ".$d_id." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	}
	
	
//محل هاي تحويل كالا
function dspRegLocationGoodsFrm(){
	$_SESSION['loc']=1;
	
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#commentForm").validate();
		});
   </script>
   <script> 
  function validateAndSaveLocation(){
	  if(fObj('l_code').value==''){
			
			alert('لطفا کد محل را وارد کنید');
			return;
		}
	if(fObj('l_name').value==''){
		
		alert('لطفا نام محل را وارد کنید');
		return;
	}
if(fObj('l_distance').value==''){
		
		alert('لطفا مقدار فاصله را وارد کنید');
		return;
	}

	  CheckCodeL();
		     
  }
   </script> 
	<br>
	 <form method="post"   action=""   id="commentForm">
<!--		<input type="hidden" name="pg" value="prodMgmtPg">   -->
<!--		<input type="hidden" name="cmd" value="regLocationGoods">   -->
		<table  align="center"  class="nasi"  style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">	      
		       <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">محل هاي تحويل كالا</font></b></td>
		     
	        </tr>	
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>	      
	      	<tr>
		        <td ><center> كد محل :</center> </td>
		        <td><input name="l_code" type="text"  id="l_code"   /></td>
		        <td ><center> نام محل : </center> </td>
		        <td><input name="l_name" type="text"  id="l_name"/></td>		        
	        </tr>
	      	<tr>
		        
		        <td ><center> فاصله : </center> </td>
		        <td><input name="l_distance" type="text"  id="l_distance"/></td>
		         <td ><center> نوع : </center> </td>
		        <td>
			  		<?php echo getTypeslocComboBox('l_type')?>
				</td>
		    </tr>
		 
	        <tr>
      	        
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			     </td>
                     <td colspan="3"><button  type="button" onclick="validateAndSaveLocation();" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
                     
			      	
<!--				     <td colspan="3"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>-->
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				           
	      	</tr>
	      	
	    </table>
	</form> 
	    
	<?php
}


function regLocationGoods(){ 
	if($_SESSION['loc']==1){
	$l_code = isset($_REQUEST['l_code']) ? $_REQUEST['l_code'] : '';
	$l_name = isset($_REQUEST['l_name']) ? ($_REQUEST['l_name']) : '';
	$l_distance = isset($_REQUEST['l_distance']) ? ($_REQUEST['l_distance']) : '';
	$l_type = isset($_REQUEST['l_type']) ? ($_REQUEST['l_type']) : '';
	$l_delivery = isset($_REQUEST['l_delivery']) ? ($_REQUEST['l_delivery']) : '';
	$l_type = isset($_REQUEST['l_type']) ? ($_REQUEST['l_type']) : '';
	$query = array(
		'l_code' => $l_code,
		'l_name' => $l_name,
		'l_distance' => $l_distance,
	    'l_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
	    'l_type' => $l_type,
		'l_delivery' => $l_delivery,
		
	);

	$query = inserterQMaker('dm_location_goods', $query);

	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['loc']=0;
	$l_id = mysql_insert_id();
	return $l_id;	
	}
}

function getLocationGoodsList(){
			?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	
	<?php 
	
if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	$srchStr;
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodelocation"> 
			  کد ویا نام محل مورد نظر را وارد کنید  
			<div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
		</form>
	';
	     		
		$outHtml .= '<br>
				        <div align="center">
				
						   <div align = "center" style="width:50%;height:400px; overflow:auto">
						   <table  border="2" align="center" cellpadding="0" cellspacing="0" class="list">
				      			<tr class="rw1">
				        			<th colspan="19" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;"><center> مشخصات محل ها </center></th>
				        		</tr>
				      			<tr class="rw0" style="font-weight:bold;">
				      		    	<td align="center" style="vertical-align:middle;">رديف</td>
							        <td align="center" style="vertical-align:middle;">كد محل</td>
							        <td align="center" style="vertical-align:middle;">نام محل </td>			       
							         <td colspan="3" align="right" style="vertical-align:middle;">نوع </td>
								</tr>';
	

    if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					l_code LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					l_name LIKE '%".$_SESSION['srchStr']."%' 
				
		";
		
	}
	
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_location_goods 
		WHERE 
			l_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
		if(($inx)%2==1){
				$class="rw0";
				$edit='edit1';
				$delete='delete1';
			
			}
				else{
					$edit='edit';
				    $class="rw1";
				    $delete='delete';
				}
			$inx++;
			 $l_distance=formatMoney($row['l_distance']);
			 $query1='select * from dm_location_type
			             where
			             lt_id='.$row['l_type'].'
							';
			// print $queryll;
			                    $lnk1 = mysql_query($query1);
			                    $row1 = mysql_fetch_assoc($lnk1);
			                   
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['l_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row1['lt_name'].'</td>';
			 $query2='select *
								from dm_um_rel t
									     inner join dm_listmenu l on l.menu_id = t.um_menu_id
										where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												    l.menu_code = \'132\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=dspLocationFrmEdit&l_id='.$row['l_id'].'"><img src="images/edit.png" width="20" height="20" title="حذف"  ></img></a></td>';}
		    else{
						$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="حذف"  ></img></a></td>';
						
					}
					 $query2='select *
								from dm_um_rel t
									     inner join dm_listmenu l on l.menu_id = t.um_menu_id
										where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												    l.menu_code = \'132\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=deleteLocationGoods&l_id='.$row['l_id'].'"><img src="images/delete.PNG" width="20" height="20" title="حذف"  ></img></a></td>';}
		 else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف"  ></img></a></td>';
						
					}
					
				$outHtml .= '</tr>
			';
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '</table><br></div>'.getNavBar_l().' '.getRPPCombo_l();
    return $outHtml;
		
}

function getNavBar_l(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showlocationList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td><td>&nbsp</td>
		<td><a href="?pg=prodMgmtPg&cmd=showlocationList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=showlocationList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>	<td>&nbsp</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showlocationList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp</td>
		<td><a href="?pg=prodMgmtPg&cmd=showlocationList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_l(){
	$out = '
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=showlocationList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
        <span style="color:blue;"><b>پاسخ در صفحه</b></span>';
	return $out;
}

    	


function dspLocationFrmEdit(){
?>
	<script>
function validateAndSaveLocation(){
	  if(fObj('l_code').value==''){
			
			alert('لطفا کد محل را وارد کنید');
			return;
		}
	if(fObj('l_name').value==''){
		
		alert('لطفا نام محل را وارد کنید');
		return;
	}
if(fObj('l_distance').value==''){
		
		alert('لطفا مقدار فاصله را وارد کنید');
		return;
	}
CheckCodeLEdit();
	
	     
  }
</script>
<?php 
	$l_id = isset($_REQUEST['l_id']) ? (int)($_REQUEST['l_id']) : 0;
	if($l_id<1) die('Invalid docoment id!');
	
	$lnk = mysql_query("SELECT * FROM dm_location_goods WHERE l_id=".$l_id."  AND l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	if(mysql_affected_rows()>0){
	$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid document id2!');
	}
		?>
	
	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="upLocationGoodsInf">   
		<input type="hidden" name="l_id" id="l_id" value="<?php echo $l_id; ?>">   
		<table  align="center" class="nasi" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">محل هاي تحويل كالا</font></td>
	        </tr>
	         <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	        <tr>
		       	<td ><center>كد محل </center> </td>
		        <td><input name="l_code"  id="l_code" type="text" value="<?php echo $row['l_code']; ?>"></td>
				<td >نام محل </td>
			  	<td><input name="l_name" id="l_name" type="text" value="<?php echo $row['l_name']; ?>" ></td>
			  	
	        </tr>
	      	
	      	<tr>
		        
				<td >فاصله </td>
			  	<td><input name="l_distance" id="l_distance" type="text" value="<?php echo $row['l_distance']; ?>" ></td>
	      		 <td ><center> نوع : </center> </td>
		        <td>
			  		<?php echo getTypeslocComboBox('l_type',$row['l_type'])?>
				</td>
	      	</tr>
	      	<tr>
	      	         
				       <td>&nbsp;&nbsp;
				       </td>
				       <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveLocation();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
				       
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
	    </table>
	</form>
	
	<?php
}
	
	
function upLocationGoodsInf(){
	
	$l_id = isset($_REQUEST['l_id']) ? (int)($_REQUEST['l_id']) : 0;
	if($l_id<1) die('Inv Id');
	$l_code = isset($_REQUEST['l_code']) ? $_REQUEST['l_code'] : '';
	$l_name = isset($_REQUEST['l_name']) ? ($_REQUEST['l_name']) : '';	
	$l_delivery = isset($_REQUEST['l_delivery']) ? $_REQUEST['l_delivery'] : '';
	$l_distance = isset($_REQUEST['l_distance']) ? $_REQUEST['l_distance'] : '';
	$l_type = isset($_REQUEST['l_type']) ? $_REQUEST['l_type'] : '';
	
	$lnkl = mysql_query("select * from dm_pish_havale_det
	            where phd_l_id=".$l_id."");
	
	 if(mysql_num_rows($lnkl)>0){
	 	
	 	
	 	     $query = "
		UPDATE dm_location_goods 
		SET 
			
		    `l_code` = '".$l_code."',
		    `l_distance` = '".$l_distance."', 
		     `l_type` = '".$l_type."', 
			`l_delivery` = '".$l_delivery."'
			
		WHERE 
			l_id = ".$l_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	  //`l_name` = '".$l_name."', 
	 //	print  $query;
	 	
	 }else{
	
	$query = "
		UPDATE dm_location_goods 
		SET 
			`l_code` = '".$l_code."',
			
		    `l_distance` = '".$l_distance."', 
			`l_delivery` = '".$l_delivery."'
			
		WHERE 
			l_id = ".$l_id." 
	";
	//`l_name` = '".$l_name."',  
	//print  $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	 }
}


function deleteLocationGoods(){
	$l_id = isset($_REQUEST['l_id']) ? (int)($_REQUEST['l_id']) : 0;
	if($l_id<1) die('Inv Id');
	$lnkl = mysql_query("select * from dm_pish_havale_det
	     where phd_l_id=".$l_id."");
	
	 if(mysql_num_rows($lnkl)>0){
	 	
	 	
	 	      echo 'مجاز به انجام چنين كاري نيستيد';
	 	
	 	
	 	
	 }else{
	
	
	$query = "
	DELETE FROM dm_location_goods
 
		WHERE 
			l_id = ".$l_id."
		AND
		  l_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	 }
}
//براي هزينه هاي افزودني و كاستني

function regChargeFactors(){ 
	if($_SESSION['charge']==1){
	
	$ch_code = isset($_REQUEST['ch_code']) ? $_REQUEST['ch_code'] : '';
	$ch_topic = isset($_REQUEST['ch_topic']) ? ($_REQUEST['ch_topic']) : '';
	$ch_date = isset($_REQUEST['ch_date']) ? ($_REQUEST['ch_date']) : '';
	$ch_accountnum = isset($_REQUEST['ch_accountnum']) ? ($_REQUEST['ch_accountnum']) : '';
	$ch_type = isset($_REQUEST['ch_type']) ? ($_POST['ch_type']) : '';
	$ch_emerge_factor = isset($_REQUEST['ch_emerge_factor']) ? ($_REQUEST['ch_emerge_factor']) : '';
	$ch_dependancy = isset($_REQUEST['ch_dependancy']) ? ($_REQUEST['ch_dependancy']) : '';	
	$ch_ratio = isset($_REQUEST['ch_ratio']) ? ($_REQUEST['ch_ratio']) : '';
	$ch_code_location = isset($_REQUEST['ch_code_location']) ? ($_REQUEST['ch_code_location']) : '';
	$ch_name_location = isset($_REQUEST['ch_name_location']) ? ($_REQUEST['ch_name_location']) : '';
	$ch_code_good = isset($_REQUEST['ch_code_good']) ? ($_REQUEST['ch_code_good']) : '';
	$ch_name_good = isset($_REQUEST['ch_name_good']) ? ($_REQUEST['ch_name_good']) : '';
	$ch_charge = isset($_REQUEST['ch_charge']) ? ($_REQUEST['ch_charge']) : '';
	$ch_licenseNo= isset($_REQUEST['ch_licenseNo']) ? ($_POST['ch_licenseNo']) : '';
	$ch_lisenceDate= isset($_REQUEST['ch_lisenceDate']) ? ($_REQUEST['ch_lisenceDate']) : '';
	$ch_considerations= isset($_REQUEST['ch_considerations']) ? ($_REQUEST['ch_considerations']) : '';
	$ch_type_redundancy= isset($_REQUEST['ch_type_redundancy']) ? ($_REQUEST['ch_type_redundancy']) : '';
	$ch_pricecode_good= isset($_REQUEST['ch_pricecode_good']) ? ($_REQUEST['ch_pricecode_good']) : '';
	$ch_ldate= isset($_REQUEST['ldate']) ? ($_REQUEST['ldate']) : '';
	$ch_fdate= isset($_REQUEST['fdate']) ? ($_REQUEST['fdate']) : '';
 //   $opr_list = !empty($_REQUEST['opr_list']) ? $_REQUEST['opr_list'] : '';
    $i = !empty($_REQUEST['i']) ? $_REQUEST['i'] : '';

     $date = explode('/', $ch_fdate);
     $ch_fdate=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$ch_fdate;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$ch_fdate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
//change ldate 
	 $date = explode('/', $ch_ldate);
     $ch_ldate=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$ch_ldate;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$ch_ldate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
$lnkp = mysql_query("select * from dm_product product
						left join dm_price price
							on product.p_id=price.price_p_id
				 	 WHERE 
					      p_code=".$ch_code_good." AND p_price_code=".$ch_pricecode_good."
					 AND
					     price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	$rowp = mysql_fetch_assoc($lnkp);
	
	if($ch_dependancy==1){
		     	 //yani vabaste
			     	 if($ch_type_redundancy==1)
			     	 {
			        	$p_sellpriceh=($rowp['p_sellprice']*$ch_ratio)+ $rowp['p_sellprice'];
			     	 }else{
			     	 	$p_sellpriceh=$rowp['p_sellprice']-($rowp['p_sellprice']*$ch_ratio);
			     	 }
		     	
		     }else if($ch_dependancy==2){
		     	//yani mostaghel
		     	if($ch_type_redundancy==1)
		     	{
		        $p_sellpriceh=$rowp['p_sellprice']+$ch_charge;
		     	}else{
		     		$p_sellpriceh=$rowp['p_sellprice']-$ch_charge;
		     		
		     	}
		     	
		     }
		   $add = $p_sellpriceh - $rowp['p_sellprice']; 
	$query = array(
			
		    'ch_code'=> $ch_code,
            'ch_topic'=>  $ch_topic,
            'ch_date'=>  gmdate('Y-m-d'),
            'ch_accountnum'=>  $ch_accountnum,
            'ch_type' =>  $ch_type,
            'ch_emerge_factor' => $ch_emerge_factor,
	        'ch_dependancy' => $ch_dependancy,
            'ch_ratio' => $ch_ratio,
	        'ch_p_sellprice' => $rowp['p_sellprice'],
        	'ch_p_sellpriceh' => $p_sellpriceh,
	        'ch_code_location' =>$ch_code_location, 
	        'ch_code_good' => $ch_code_good,	
	        'ch_charge' => $ch_charge,
            'ch_licenseNo' => $ch_licenseNo,
	        'ch_lisenceDate' => $ch_lisenceDate, 
            'ch_considerations' => $ch_considerations,	
	        'ch_pricecode_good' => $ch_pricecode_good, 
            'ch_type_redundancy' => $ch_type_redundancy,
	        'ch_u_id' => $_SESSION['dm_user_profile']['u_id'],
	        'ch_price_id' => $rowp['price_id'],
	        'ch_fdate' => $ch_fdate, 
	        'ch_ldate' => $ch_ldate, 
        	'ch_p_add' => $add,  
            'ch_id_province' => $_SESSION['dm_user_profile']['u_province_id']
		);		
		$query = inserterQMaker('dm_charge_factors', $query);
	//print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['charge']=0;
	$ch_id = mysql_insert_id();
	      
//	    $query = "
//		UPDATE  dm_price 
//		SET 
//			`p_sellpriceh` = '". $p_sellpriceh ."',
//			`price_ch_id` = '". $ch_id ."'
//		
//      WHERE 
//		  `price_id`  = '". $rowp['price_id'] ."'";	
//		
//	//print $query;
//	$lnk = mysql_query($query);
//	if(mysql_error()) print mysql_error();
	
			foreach( $_GET['c'] as $value)
		{
		  if( $value== 'mj')
		  {
		  	
		  }else
		     {
		  	 
			  	$query = array(
	
			    'oph_ch_id'=> $ch_id,
			  	'oph_id_province'=> $_SESSION['dm_user_profile']['u_province_id'],
	            'oph_op_id'=>  $value
			  	);
					
			$query = inserterQMaker('dm_opr_ch', $query);
			$lnk = mysql_query($query);
	      if(mysql_error()) print mysql_error();
		//	print $query;
		  	
		      }
			}
		
	//add location
 	foreach( $_GET['f'] as $value)
		{
		  if( $value== 'mj')
		  {
		  	
		  }else
		     {
		  	 
			  	$query = array(
			  	
			    'chl_ch_id'=> $ch_id,
			  	'chl_id_province'=> $_SESSION['dm_user_profile']['u_province_id'],
			  	'chl_reg_date'=> gmdate('Y-m-d'), 
	            'chl_l_id'=>  $value
			  	);
					
			$query = inserterQMaker('dm_loc_ch', $query);
			$lnk = mysql_query($query);
	      if(mysql_error()) print mysql_error();
		//	print $query;
		  	
		      }
			}
	}	

	
}

function deleteChargeFactors(){
	$ch_id = isset($_REQUEST['ch_id']) ? (int)($_REQUEST['ch_id']) : 0;
	$p_code = isset($_REQUEST['p_code']) ? (int)($_REQUEST['p_code']) : 0;
	$p_price_code = isset($_REQUEST['p_price_code']) ? (int)($_REQUEST['p_price_code']) : 0;
	$price = isset($_REQUEST['p_sellprice']) ? (int)($_REQUEST['p_sellprice']) : 0;
		if($ch_id<1) die('Inv Id');
	
	$query = "
	DELETE FROM dm_charge_factors
 
		WHERE 
			ch_id = ".$ch_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	
}



function dspRegChargeFactorsFrm(){
	$_SESSION['charge']=1;
	
	?>
	<style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
   
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
		function check_all() {
			   // gets Instance to the Form
			   this.form = document.getElementById('form1');
			   
			   // verifies if the instance was successfully obtained
			   if (this.form) {
			   
			      // gets the current check state
			      this.newCheckedValue = document.getElementById('check_all_box').checked;
				  

			      // gets instace array for all input elements of the form
			      this.checkboxNodes = this.form.getElementsByTagName('input');
				  
				  // loops the array
			      for (this.i = 0; this.i < this.checkboxNodes.length; this.i++) {

			          // verifies if the input element is a checkbox
			          if (this.checkboxNodes[i].getAttribute('type') == 'checkbox') {
				   
				         // sets the new check value
			             this.checkboxNodes[i].checked = this.newCheckedValue;
					  
					  }
					  
			      }
				  
			   }
			}
		
	 $(function() {
		    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#fdate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#ldate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	  function  validateAndSavecharge(){
	    	  
	    	if(fObj('ch_code').value==''){
				
				alert('لطفا كد هزينه را وارد كنيد');
				return;
			}
            if(fObj('ch_topic').value==''){
				
				alert('لطفا عنوان هزينه را وارد كنيد');
				return;
			}
           

          if(fObj('ch_name_good').value==''){
				
				alert('لطفا نام كالا را وارد کنید');
				return;
        }
          if(fObj('fdate').value==''){
				
				alert('لطفا تاريخ شروع را وارد كنيد');
				return;
      }
          if(fObj('ldate').value==''){
				
				alert('لطفا تاريخ پايان را وارد كنيد');
				return;
      }
//          if(fObj('ch_lisenceNo').value==''){
//  			
//  			alert('لطفا شماره مجوز را وارد کنید');
//  			return;
//         }
//            if(fObj('ch_lisenceDate').value==''){
//  				
//  				alert('لطفا تاريخ مجوز را وارد کنید');
//  				return;
//        }  
     
          if(fObj('p_code').value==''){
				
				alert('لطفا كد كالا را وارد کنید');
				return;
      } 
          if(fObj('p_price_combo').value==''){
				
				alert('لطفا كد قيمت را وارد کنید');
				return;
    } 
	  	        validCodech();
	  	       
//	    	 window.open('?pg=prodMgmtPg&cmd=regchargeFactors&ch_code='+fObj('ch_code').value+'&ch_topic='+fObj('ch_topic').value+'&ch_accountNum='+fObj('ch_accountNum').value+
//			 		 '&ch_ratio='+fObj('ch_ratio').value+'&ch_code_location='+fObj('ch_code_location').value+'&ch_name_location='+fObj('ch_name_location').value+'&ch_code_good='+fObj('ch_code_good').value+'&ch_name_good='+fObj('ch_name_good').value+
//				     '&ch_charge='+fObj('ch_charge').value+'&ch_lisenceNo='+fObj('ch_lisenceNo').value+'&ch_lisenceDate='+fObj('datepicker6').value , '_self');
	  	       
	    }
    </script>
<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("rpc.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
		
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);	
	}
	function searchProd(e,val) {
		if(e.keyCode==112){
		window.open( 'searchProd.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" );
		}
		}
	
</script>

<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 11px;
		
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: absolute;
		right: 700px;
		top: 200px;
		margin: 10px 0px 0px 0px;
		width: 70px;
		background-color: #3399FF;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #330099;	
		color: #cccccc;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #003366;
	}
	
</style>
   	<?php 
	$out='<br>
	
			<form method="post" id="form2" action="" id="commentForm">
			   	
				<input type="hidden" name="pg" value="prodMgmtPg">   
				<input type="hidden" name="cmd" value="regchargeFactors">   
				
				<table  align="center"  class="nasi" style="font-weight:bold;">
				  	<tr style="background-color:'. $_SESSION['htablecolor'] .';">
				        <td colspan="6"  style="height: 50px;vertical-align:middle;"><b><font size="5">هزينه های افزودنی و كاستنی</font></b></td>
			        </tr>
			        <tr>
			            <td colspan="8"><hr style="color:'. $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			       </tr>	
			      	<tr>
				       	<td ><center>كد هزينه </center> </td>
					  	<td><input name="ch_code" id="ch_code" type="text"  ></td>
						<td ><center> عنوان هزينه</center> </td>
				        <td><input name="ch_topic" type="text"  id="ch_topic" ></td>
			        </tr>
			      	<tr>
				        <td align="center">نوع </td>
				        <td>
					  		'. getFactorTypesComboBox('ch_type_redundancy').'
						</td>
						 <td ><center>وابسته/مستقل </center> </td>
				        <td>
					  		'. getDependancyTypesComboBox('ch_dependancy') .'
						</td>
				    </tr>
					
			      	
			        <tr>
			            <td ><center>كد كالاي مربوطه </center> </td>
						<td><input type="text"  id="p_code"   onkeydown="searchProd(event,'. $_SESSION['dm_user_profile']['u_province_id']  .');" ></input></td>
			            <td align="center">کد قیمت مربوطه</td>			  	
			            <td><input id="p_price_combo" /></td>
			            
			        </tr>	        	       
			      	<tr id="row"> 
			      		      	   
				<!--         <td align="center" id="codeL">كد محل مربوطه </td>
				         '. getLocationCombo('LocationCombo') .'</td>
				       <td><input name="ch_code_location" type="text" id="ch_code_location" ></td>
				        <td id="nameL"><center>نام محل مربوطه </center> </td>
				        <td><span name="l_name" id="l_name" ></span></td>
					  	<td><input name="ch_name_location" type="text"  id="ch_name_location" ></td>
			        </tr>-->
			        
			      	<tr id="row1">
			      	
				        <td  align="center" ><center>ضريب وابستگی </center> </td>
				        <td><input name="ch_ratio" type="text" id="ch_ratio"></td>
			               <div class="suggestionsBox" id="suggestions" style="display: none;">
								<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
						   <div class="suggestionList" id="autoSuggestionsList">
						&nbsp;
						</div>
			      	</tr>
			      	<tr id="rowh" style="display: none;">
			      	
				        <td align="center" >مقدار هزينه</td>
					  	<td><input name="ch_charge" type="text"  id="ch_charge"></td>
			               <div class="suggestionsBox" id="suggestions" style="display: none;">
								<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
						   <div class="suggestionList" id="autoSuggestionsList">
						&nbsp;
						</div>
			      	</tr>
			      	
		<!--  	     <tr>
					      	<td><center>شماره مجوز</center> </td>
						    <td><input name="ch_lisenceNo" type="text" id="ch_lisenceNo"  ></td>
						    <td><center>تاريخ مجوز </center> </td>
						    <td> <input type="text" name="ch_lisenceDate" id="datepicker6" style="align:center;"  ></td>
						    
					</tr>-->
					<tr>
					       <td>تاريخ شروع</td>
					       <td><input name="fdate" id="fdate" type="text" /></td>
					       <td>تاريخ پايان:</td>
					       <td><input name="ldate" id="ldate" type="text" /></td>
					</tr>';
							
$lnk = mysql_query("SELECT * FROM  dm_operation_acc");

		if(mysql_num_rows($lnk)>0)		
		{
			
			$out .= '
			
				 <tr>
					<td colspan="4">
						 <center><span onclick="altrO('. 1 .')" style="cursor:pointer;height:100px;color:red; "><B>اطلاعات نوع عمليات</B></span></center>
					</td>
				</tr>
				<tr>
				
				<td colspan="4">
				<div id="1" style="display:none;" >
				<form method="post" id="form1" action="" id="commentForm">
				  <table width=100% border="1"  >';	
					//	$out .= '<tr><td colspan="4"><hr></hr></td></tr>
						//		
						      //   <tr style="overflow:auto;">
						 //          <td>'.$i.'</td>
						//		   <td>همه عمليات</td>
						//		   <td><input type="checkbox"  name="check_all_box" id="check_all_box" onclick="check_all()"    value="'. 600 .'" /></td>
							//	</tr>';
						
							$out .= '	
					         <tr style="overflow:auto;">';
							$i=1;
							while($row=mysql_fetch_assoc($lnk))
							{
								
					           $out .= ' <td>'.$i.'</td>
								<td>'. $row['g_acc_name'].'</td>
								<td><input type="checkbox"  name="opr_list"  id="opr_list[]"    value="'.$row['g_id'].'" /></td>';
						 $out .= '</tr>';
								$i++;		
							}
						}
	     $out .='</td></table></form></div><tr>
	     ';

	     $lnk = mysql_query("SELECT * FROM  dm_location_goods where l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	            
		if(mysql_num_rows($lnk)>0)		
		{
			
			$out .= '
			
				 <tr>
					<td colspan="4">
						 <center><span onclick="altrO('. 2 .')" style="cursor:pointer;height:100px;color:red; "><B>اطلاعات محل های تحويل</B></span></center>
					</td>
				</tr>
				<tr>
				
				<td colspan="4">
				<div id="2" style="display:none;">
				  <table width=100% border="1"  >';	
					//	$out .= '<tr><td colspan="4"><hr></hr></td></tr>
								
						 //        <tr style="overflow:auto;">
						     //      <td>'.$j.'</td>
							//	   <td>همه محلها</td>
							//	   <td><input type="checkbox"  name="check_all_boxl" id="check_all_boxl" onclick="check_alll()"    value="'. 600 .'" /></td>
							//	</tr>';
						
							$out .= '	
					         <tr style="overflow:auto;">';
							$j=1;
							while($row=mysql_fetch_assoc($lnk))
							{
								
					           $out .= ' <td>'.$j.'</td>
								<td>'. $row['l_name'].'</td>
								<td><input type="checkbox"  name="l_list"  id="l_list[]"    value="'.$row['l_id'].'" /></td>';
						 $out .= '</tr>';
								$j++;		
							}
						}
	     $out .='</td></table></div><tr>';
	
		      	$out .='</tr>
				<tr>
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				       </td>
				      
			         <td colspan="3"><button  type="button" onclick="validateAndSavecharge()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخيره</button></td>
<!--				     <td colspan="3"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>-->
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>     
	      	  </tr>

	    </table>

	<br>';
	 echo $out;   
	
}
function FactorFrmEditloc(){
	
	$ch_id = isset($_REQUEST['ch_id']) ? $_REQUEST['ch_id'] : '';
	 $query="SELECT * FROM dm_charge_factors WHERE ch_id=" .$ch_id."";

	 $lnk = mysql_query($query);
	 $row=mysql_fetch_assoc($lnk);
		
	$outHtml = '	<br>
		<div align = "center">
			<table  border="2" align="center" cellpadding="0" cellspacing="0"   class="list" style="width:85%;">
      			<tr class="rw1">
        			<td colspan="8" align="center" scope="row" style="height: 50px;vertical-align:middle;"><b>انواع عمليات </b></td>
        		</tr>
        		 <tr class="rw0">
			              <td >&nbsp;<b>كد كالا:</b></td><td ><b>&nbsp;'.$row['ch_code_good'].'</b>
			              <td >&nbsp;<b>كد قيمت:</b></td><td colspan="7"><b>&nbsp;'.$row['ch_pricecode_good'].'</b></td>
			              
			       </tr>
			       
			       <tr class="rw1">
				          <td align="center"><b> رديف</b></td>
				          <td align="center"><b>كد محل</b></td>	
				          <td align="center"><b>نام محل</b></td>			
				          <td align="center"><b>اضافه </b></td>
				          <td align="center"><b>حذف </b></td>
				          
			        </tr>';
	    	
	$genQuery = "
		
		FROM 
			 dm_location_goods 
		WHERE 
			 
		  l_id_province=".$_SESSION['dm_user_profile']['u_province_id']." "; 
	
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
//	print($resQuery);
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);

	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
				if(($inx)%2==1){
				$class="rw0";
				$pictureKam='del';				
			    $pictureEzaf='ok';
                }
				else{
				$class="rw1";
				$pictureKam='del';
				$pictureEzaf='ok';
				
				}

			$query1 = "SELECT   * 	FROM 
						dm_location_goods  l
						left join  dm_loc_ch  chl
						 on l.l_id=chl.chl_l_id 
						 
						  
				 
					WHERE 
						 
					    chl_ch_id =".$ch_id."
					AND
					    chl_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				    
		            AND
					    chl_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				    AND
					    chl_l_id= ".$row['l_id']."   "; 
					    
	         $lnk1 = mysql_query($query1);
			//	print $query1;
				   if(mysql_num_rows($lnk1)>0)
				   {
				  
				  	$row1 = mysql_fetch_assoc($lnk1);
				    $Display2='none';
                    $Display1='block';	 
                            								  
		            }else{
		            $Display2='block';
                    $Display1='none';	
                     
		            }
		                          
			
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.' style="width:50%;">
					 <td align="center">'.$inx.'</td>
					 <td align="center">'.$row['l_code'].'</td>
					 <td align="center">'.$row['l_name'].'</td>
					 <td align="center"><span id="ezaf_'.$row['l_id'].'"  style="cursor:pointer;display:'.$Display2. ';"    onclick="addloc(\'\', \''.$ch_id.'\', \''.$row['l_id'].'\') " this.style.display=\'none\'"><img src="images/'.$pictureEzaf.'.png" border="0" align="center" style="height:20px;width=20px;"></img></span></td>
	    	         <td align="center"><span id="kam_'.$row['l_id'].'"   style="cursor:pointer;display:'.$Display1.';"   onclick="delloc(\'\', \''.$row1['chl_id'].'\', \''.$row['l_id'].'\') " this.style.display=\'none\'"> <img src="images/'.$pictureKam.'.png" border="0" align="center"  style="height:20px;width=20px;"></img></span></td>
					 
				</tr>';
			
		}
		    
    }else{
    	$outHtml .= '<tr class="rw1"><td colspan="10">هیچ سندي موجود نیست</td></tr>';
    }
     $outHtml .= '</table>';

   
    return $outHtml;
			
	
	
	
}
function FactorFrmEditop(){
	
 $ch_id = isset($_REQUEST['ch_id']) ? $_REQUEST['ch_id'] : '';
	 $query="SELECT * FROM dm_charge_factors WHERE ch_id=" .$ch_id."";

	 $lnk = mysql_query($query);
	 $row=mysql_fetch_assoc($lnk);
		
	$outHtml = '	<br>
		<div align = "center">
			<table  border="2" align="center" cellpadding="0" cellspacing="0"   class="list" style="width:85%;">
      			<tr class="rw1">
        			<td colspan="8" align="center" scope="row" style="height: 50px;vertical-align:middle;"><b>انواع عمليات </b></td>
        		</tr>
        		 <tr class="rw0">
			              <td >&nbsp;<b>كد كالا:</b></td><td ><b>&nbsp;'.$row['ch_code_good'].'</b>
			              <td >&nbsp;<b>كد قيمت:</b></td><td colspan="7"><b>&nbsp;'.$row['ch_pricecode_good'].'</b></td>
			              
			       </tr>
			       
			       <tr class="rw1">
				          <td align="center"><b> رديف</b></td>
				          <td align="center"><b>نوع عمليات</b></td>			
				          <td align="center"><b>اضافه </b></td>
				          <td align="center"><b>حذف </b></td>
				          
			        </tr>';
	    	
	$genQuery = "
		
		FROM 
			 dm_operation_acc 
		WHERE 
			 
		   1 "; 
	
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
//	print($resQuery);
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);

	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
				if(($inx)%2==1){
				$class="rw0";
				$pictureKam='del';				
			    $pictureEzaf='ok';
                }
				else{
				$class="rw1";
				$pictureKam='del';
				$pictureEzaf='ok';
				
				}

			$query1 = "SELECT   * 	FROM 
						dm_operation_acc  opr_acc
						left join  dm_opr_ch  opr_ch
						 on opr_acc.g_id=opr_ch.oph_op_id 
						 left join dm_charge_factors charge
						 on charge.ch_id=opr_ch.oph_ch_id
						  
				 
					WHERE 
						 
					    oph_ch_id =".$ch_id."
					AND
					    oph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				    AND          
		                    '".gmdate('Y-m-d')."'   between  `ch_fdate`   AND  `ch_ldate`
		            AND
					    ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				    AND
					    oph_op_id= ".$row['g_id']."   "; 
					    
	         $lnk1 = mysql_query($query1);
			//	print $query1;
				   if(mysql_num_rows($lnk1)>0)
				   {//echo mysql_num_rows($lnk1);
				  
				  	$row1 = mysql_fetch_assoc($lnk1);
				    $Display2='none';
                    $Display1='block';	 
                            								  
		            }else{
		            $Display2='block';
                    $Display1='none';	
                     
		            }
		                          
			
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.' style="width:50%;">
					 <td align="center">'.$inx.'</td>
					 <td align="center">'.$row['g_acc_name'].'</td>
					 <td align="center"><span id="ezaf_'.$row['g_id'].'"  style="cursor:pointer;display:'.$Display2. ';"    onclick="addoper(\'\', \''.$ch_id.'\', \''.$row['g_id'].'\') " this.style.display=\'none\'"><img src="images/'.$pictureEzaf.'.png" border="0" align="center" style="height:20px;width=20px;"></img></span></td>
	    	         <td align="center"><span id="kam_'.$row['g_id'].'"   style="cursor:pointer;display:'.$Display1.';"   onclick="delopr(\'\', \''.$row1['oph_id'].'\', \''.$row['g_id'].'\') " this.style.display=\'none\'"> <img src="images/'.$pictureKam.'.png" border="0" align="center"  style="height:20px;width=20px;"></img></span></td>
					 
				</tr>';
			
		}
		    
    }else{
    	$outHtml .= '<tr class="rw1"><td colspan="10">هیچ سندي موجود نیست</td></tr>';
    }
     $outHtml .= '</table>';

   
    return $outHtml;
			
	
}
function dspChargeFactorFrmEdit(){

		?>
		<style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
   
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
 <script type="text/javascript">
	 $(function() {
		    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#fdate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#ldate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	  function  validateAndSavecharge(){
	    	  
	    	if(fObj('ch_code').value==''){
				
				alert('لطفا كد هزينه را وارد كنيد');
				return;
			}
            if(fObj('ch_topic').value==''){
				
				alert('لطفا عنوان هزينه را وارد كنيد');
				return;
			}
           
		  if(fObj('fdate').value==''){
						
						alert('لطفا تاريخ شروع را وارد كنيد');
						return;
		      }
		          if(fObj('ldate').value==''){
						
						alert('لطفا تاريخ پايان را وارد كنيد');
						return;
		      }
     
          if(fObj('p_code').value==''){
				
				alert('لطفا كد كالا را وارد کنيد');
				return;
      } 
          if(fObj('p_price_combo').value==''){
				
				alert('لطفا كد قيمت را وارد کنيد');
				return;
    } 
          validCodechedit();
	  	       

	    }
    </script>
   
	<style type="text/css">
	        *
	        {
	          
	        }
	        body
	        {
	            direction: rtl;
	          
	        }
	        p
	        {
	            padding: 25px;
	            margin: 25px auto;
	            width: 450px;
	        }
	        .ui-widget-header
	        {
	            text-align: center;
	            font-weight: normal;
	        }
	        .ui-state-active
	        {
	            display: block;
	            padding: 3px;
	            text-align: center;
	        }
	    </style>
		
	
	<?php 
	
	$ch_id = isset($_REQUEST['ch_id']) ? (int)($_REQUEST['ch_id']) : 0;
	if($ch_id<1) die('Invalid product id!');
	
	$lnk = mysql_query("SELECT * FROM dm_charge_factors WHERE ch_id=".$ch_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
	//fadte
            $gdate=$row['ch_fdate'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			
	      if($jmonth<=9){
				
				$jmonth="0".$jmonth;
			}if($jday<=9 ){
				
				$jday ="0".$jday;
			}
			$fdatef = $jday."/".$jmonth."/".$jyear;
	//ldate			
			$gdate=$row['ch_ldate'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			
	      if($jmonth<=9){
				
				$jmonth="0".$jmonth;
			}if($jday<=9 ){
				
				$jday ="0".$jday;
			}
			$ldatel = $jday."/".$jmonth."/".$jyear;

  
  $out=' <input type="hidden"  name="ch_id"       id="ch_id"   value="'. $ch_id .'">   
	     <input type="hidden"    name="statusedit"  id="statusedit" value="1"> 
	     <input type="hidden"  id="p_code"       name="p_code"  value="'. $row['ch_code_good'] .'" ></input>
	     <input type="hidden"  id="p_price_code" name="p_price_code"  value="'. $row['ch_pricecode_good'] .'"  ></input>
		
		<table  align="center"  class="nasi" style="font-weight:bold;">
		  	<tr style="background-color:'. $_SESSION['htablecolor'] .';">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"><b><font size="5">هزينه های افزودني و كاستنی</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:'. $_SESSION['htablecolor'] .';height:40%;"></hr></td>
	       </tr>	
	      	<tr>
		       	<td ><center>كد هزينه </center> </td>
			    <td><input name="ch_code" id="ch_code" type="text" value="'. $row['ch_code'] .'" /></td>
				<td ><center> عنوان هزينه</center> </td>
		        <td><input name="ch_topic" type="text"  id="ch_topic" value="'. $row['ch_topic'] .'"></td>
	        </tr>
	      	<tr>
		        <td align="center">نوع </td>
		        <td>
			  		'. getFactorTypesComboBox('ch_type_redundancy') .'
				</td>
				 <td ><center>وابسته/مستقل </center> </td>
		        <td>
			  		'. getDependancyTypesComboBox('ch_dependancy') .'
				</td>
		  		        		        
	        </tr>

	        <tr>
	            <td ><center>كد كالای مربوطه </center> </td>
				<td><input type="text"  id="p_code" name="p_code"   value="'. $row['ch_code_good'] .'" ></input></td>

	            <td align="center">کد قيمت مربوطه</td>			  	
				<td><input type="text"  id="p_price_code" name="p_price_code"  value="'. $row['ch_pricecode_good'] .'"  ></input></td>
	            
	        </tr>	        	       
	      	<tr id="row"> 
	      		      	   
		<!--    <td align="center" id="codeL">كد محل مربوطه </td>
		        <td>'. getLocationCombo('LocationCombo').'</td>
		        <td><input name="ch_code_location" type="text" id="ch_code_location" ></td>
		        <td id="nameL"><center>نام محل مربوطه </center> </td>
		        <td><span name="l_name" id="l_name" ></span></td>
			  	<td><input name="ch_name_location" type="text"  id="ch_name_location" ></td>
	        </tr>-->
	        
	      	<tr id="row1">
	      	
		        <td  align="center" ><center>ضريب وابستگی </center> </td>
		        <td><input name="ch_ratio" type="text" id="ch_ratio" value="'. $row['ch_ratio'] .'"></td>
	               <div class="suggestionsBox" id="suggestions" style="display: none;">
						<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				   <div class="suggestionList" id="autoSuggestionsList">
				&nbsp;
				</div>
	      	</tr>
	      	<tr id="rowh" style="display: none;">
	      	
		        <td align="center" >مقدار هزينه</td>
			  	<td><input name="ch_charge" type="text"  id="ch_charge" value="'. $row['ch_charge'] .'"></td>
	               <div class="suggestionsBox" id="suggestions" style="display: none;">
						<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				   <div class="suggestionList" id="autoSuggestionsList">
				&nbsp;
				</div>
	      	</tr>
	      	
	<!--       	<tr>
			      	<td><center>شماره مجوز</center> </td>
				    <td><input name="ch_lisenceno" type="text" id="ch_lisenceno"  value="'. $row['ch_licenseno'] .'" ></td>
				    <td><center>تاريخ مجوز </center> </td>
				   <td> <input type="text" name="ch_lisencedate" id="ch_lisencedate" value="'. $row['ch_lisencedate'] .'" style="align:center;"  ></td>
				    
			</tr>--> 
			<tr>
					       <td>تاريخ شروع</td>
					       <td><input name="fdate" id="fdate" value="'. $fdatef .'" type="text" /></td>
					       <td>تاريخ پايان:</td>
					       <td><input name="ldate" id="ldate" value="'. $ldatel .'" type="text" /></td>
					
					</tr>
			<tr>
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				       </td>
				      
			         <td colspan="3"><button  type="button" onclick="validateAndSavecharge()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخيره</button></td>
<!--				     <td colspan="3"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>-->
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				        
	      	</tr>
	    </table>

	<br>';
	$out1='	<input type="hidden" name="ch_id"  id="ch_id" value="'. $ch_id .'"> 
	        <input type="hidden" name="statusedit"  id="statusedit" value="2">
	        <input type="hidden"  id="p_code"       name="p_code"  value="'. $row['ch_code_good'] .'" ></input>
	        <input type="hidden"  id="p_price_code" name="p_price_code"  value="'. $row['ch_pricecode_good'] .'"></input>   	
		<table  align="center"  class="nasi" style="font-weight:bold;">
		  	<tr style="background-color:'. $_SESSION['htablecolor'] .';">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"><b><font size="5">هزينه های افزودني و كاستنی</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:'. $_SESSION['htablecolor'] .';height:40%;"></hr></td>
	       </tr>	
	      	<tr>
		       	<td ><center>كد هزينه </center> </td>
			    <td>'. $row['ch_code'] .'</td>
				<td ><center> عنوان هزينه</center> </td>
		        <td>'. $row['ch_topic'] .'</td>
	        </tr>
	      	

	        <tr>
	            <td ><center>كد كالای مربوطه </center> </td>
				<td>'. $row['ch_code_good'] .'</input></td>

	            <td align="center">کد قيمت مربوطه</td>			  	
				<td>'. $row['ch_pricecode_good'] .'</input></td>
	            
	        </tr>	        	       
	      	<tr id="row"> 
	      		      	   
		<!--    <td align="center" id="codeL">كد محل مربوطه </td>
		        <td>'. getLocationCombo('LocationCombo').'</td>
		        <td><input name="ch_code_location" type="text" id="ch_code_location" ></td>
		        <td id="nameL"><center>نام محل مربوطه </center> </td>
		        <td><span name="l_name" id="l_name" ></span></td>
			  	<td><input name="ch_name_location" type="text"  id="ch_name_location" ></td>
	        </tr>-->
	
			<tr>
					       <td>تاريخ شروع</td>
					       <td>'. $fdatef .'</td>
					       <td>تاريخ پايان:</td>
					       <td><input name="ldate" id="ldate" value="'. $ldatel .'" type="text" /></td>
					
					</tr>
			<tr>
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				       </td>
				      
			         <td colspan="3"><button  type="button" onclick="validateAndSavecharge()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخيره</button></td>
<!--				     <td colspan="3"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>-->
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				        
	      	</tr>
	    </table>

	<br>';
	if($_SESSION['dm_user_profile']['u_id']==3)
	{	
	echo $out1;}
	else{
	echo $out1;	
	}
}

function getChargeFactorsList(){
	
		?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	<?php 
	
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
		
	global $ChargeFactorsTypes;
	
	$outHtml = '<br>
		<div align="center">
		<div align = "center" style="height:200px; overflow:auto" >
			<table  border="2" align="center" cellpadding="0" Cellspacing="2"  class="list" >
      			<tr class="rw0">
        			<th colspan="25" align="center" scope="row" style="height: 50px;vertical-align:middle;" ><center>ليست هرينه هاي افزودنی و كاستنی</center> </th>
        		</tr>
      			<tr class="rw1" style="font-weight:bold;">
			        <td width="*" align="cenetr">ردیف</td>
			        <td align="center">كد هزينه </td>
			        <td style="width:150px;" align="cenetr">عنوان هزينه </td>
			        <td  align="cenetr">تاريخ تعريف </td>
			        <td  align="cenetr">كد كالا </td>
			        <td " align="cenetr">كد قيمت </td>		       
			        <td align="cenetr">هزينه مستقل</td>			    		       
			        <td align="cenetr">ضريب وابستگی</td>
			        <td align="cenetr">از تاريخ</td>
			        <td align="cenetr">تا تاريخ</td>		       		        
				</tr>';
		
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					ch_code LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					ch_topic LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			 dm_charge_factors 
		WHERE 
			ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			 
		".$srchQ." 
		".$typeQ." 
		
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
			$inx++;
			if(($inx)%2==1)
				$class="rw0";
				else
				 $class="rw1";
			 $charge=formatMoney($row['ch_date']);
			
			$gdate=$row['ch_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate1 = $jyear."/".$jmonth."/".$jday;
			
			$gdate=$row['ch_fdate'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			$ch_fdate=$jdate;
			$gdate=$row['ch_ldate'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			$ch_ldate=$jdate;
			$outHtml .= '
				<tr class='.$class.'>
					<td align="cenetr">'.$inx.'</td>
					<td align="cenetr">'.$row['ch_code'].'</td>
					<td align="cenetr">'.$row['ch_topic'].'</td>
					<td align="cenetr">'.$jdate1.'</td>						
					<td align="cenetr">'.$row['ch_code_good'].'</td>				
					<td align="cenetr">'.$row['ch_pricecode_good'].'</td>
					<td align="cenetr">'.$row['ch_charge'].'</td>
					<td align="cenetr">'.$row['ch_ratio'].'</td>
					<td align="cenetr">'.$ch_fdate.'</td>
					<td align="cenetr">'.$ch_ldate.'</td>			
					';
			  $query2='select *
								from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'142\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                   // print $query2;
			                    if(mysql_affected_rows()>0){
					
					$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=dspChargeFactorFrmEdit&ch_id='.$row['ch_id'].'"><img src="images/edit.png" width="20" height="20" title="ويرايش"  ></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ويرايش"  ></img></a></td>';
						
					}
					$query2='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'142\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query2;
			                    if(mysql_affected_rows()>0){
			                     $outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=FactorFrmEditop&ch_id='.$row['ch_id'].'"><img src="images/opr.png" width="20" height="20" title="ويرايش"  ></img></a></td>';
			                    $outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=FactorFrmEditloc&ch_id='.$row['ch_id'].'"><img src="images/loc.png" width="20" height="20" title="ويرايش"  ></img></a></td>';
			                     
			              if($_SESSION['dm_user_profile']['u_id']==3){
			            
						     $outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=deleteChargeFactor&ch_id='.$row['ch_id'].'&p_code='.$row['ch_code_good'].'&p_price_code='.$row['ch_pricecode_good'].'"><img src="images/delete.PNG" width="20" height="20" title="حذف"  ></img></a></td>';
			              }
						     					
			              }
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف"  ></img></a></td>';
						
					}
				//	$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=FactorFrmEditop&ch_id='.$row['ch_id'].'"><img src="images/edit.png" width="20" height="20" title="ويرايش"  ></img></a></td>';
				$outHtml .= '</tr>
			';
		}
    }else{
	    	$outHtml .= '<tr><td colspan="15">هیچ اطلاعاتی موجود نیست</td></tr>';
	}
    $outHtml .= '</table></div>'.getNavBar_ch().' '.getRPPCombo_ch();
    return $outHtml;
		
}

function getNavBar_ch(){
	$out = '<br>
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showChargeFactorsList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=showChargeFactorsList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=showChargeFactorsList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>			<td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=showChargeFactorsList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=showChargeFactorsList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_ch(){
	$out = '
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=showChargeFactorsList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width: 50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
     <span style="color:blue;"><b>پاسخ در صفحه</b></span>
	';
	return $out;
}


//علل ابطال حواله



function dspRegCauseOfCanceledOrder(){
		?>


	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="regListCauseOfCanceledOrder">   
		<table  bgcolor="#99B3E9" align="center" border="2">
		  	<tr align="center">
		        <td colspan="6" align="center" ><h2>علت حواله هاي كنسل شده  </h2></td>
	        </tr>
	        <tr> 
		        <td ><center>كد علت </center> </td>
		        <td><input name="code_order" type="text"  /></td>
		        <td ><center>شرح علت </center> </td>
			  	<td><textarea name="discription_order" rows="5" >
	  
	            </textarea></td>
		        
	        </tr>
	      <tr>
		       
			      	<td colspan="3"><input type="submit" value="تاييد" ></td>
	      	</tr>
	    </table>
	</form> 
	    
	<?php
}



function dspListCauseOfCanceledOrderEdit(){
	
	$cansel_id = isset($_REQUEST['cansel_id']) ? (int)($_REQUEST['cansel_id']) : 0;
	if($cansel_id<1) die('Invalid document id!');
	
	$lnk = mysql_query("SELECT * FROM canseled_order WHERE cansel_id=".$cansel_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
		?>
	

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="upListCauseOfCanceledOrder">   
		<input type="hidden" name="d_id" value="<?php echo $cansel_id; ?>">   
		<table  bgcolor="#99B3E9" align="center" border="2">
		  	<tr align="center">
		        <td colspan="7" align="center" ><h2>علل ابطال حواله  </h2></td>
	        </tr>
	      	<tr>
		       	<td ><center>كد علت </center> </td>
		        <td><input name="code_order" type="text" value="<?php echo $row['code_order']; ?>" /></td>
				<td >شرح علت </td>
		        <td><input name="discription_order" type="text" value="<?php echo $row['discription_order']; ?>" /></td>
	        </tr>
	      	<tr>
	      		   <td colspan="3"><input type="submit" value="تایید" ></td>
	      	</tr>
	    </table>
	</form>
	
	<!--<?php
}

function upListCauseOfCanceledOrder(){
	
	$cansel_id = isset($_REQUEST['cansel_id']) ? (int)($_REQUEST['cansel_id']) : 0;
	if($cansel_id<1) die('Inv Id');

	$code_order = isset($_POST['code_order']) ? $_POST['code_order'] : '';
	$discription_order = isset($_POST['discription_order']) ? ($_POST['discription_order']) : '';
	
	$query = "
		UPDATE canseled_order 
		SET 
			`code_order` = '".$code_order."',
			`discription_order` = '".$discription_order."'  
			
		WHERE 
			cansel_id = ".$cansel_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}


function deleteCauseOfCanceledOrder(){
	$cansel_id = isset($_REQUEST['cansel_id']) ? (int)($_REQUEST['cansel_id']) : 0;
	if($cansel_id<1) die('Inv Id');
	
	$query = "
	DELETE FROM  canseled_order
 
		WHERE 
			cansel_id = ".$cansel_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
	
//براي اطلاعات مشتريان

function dspRegInformationCustomer(){
	
$query1 = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_code=$row1['year_code'];
$query = "SELECT * FROM  accnting.acc_mofaser_detail  where   year='". $year_code ."' and mk=16  AND  flag='". 1 ."' ";	
		$lnk = mysql_query($query);
	//print 	$query;
	if(mysql_affected_rows()>0){
		
while($row= mysql_fetch_assoc($lnk)){
			
			$query1 = "SELECT * FROM  dm_customer  where  code_customer=".$row['code']."  ";	
				$lnk1 = mysql_query($query1);
		
			if(mysql_num_rows($lnk1)==0){
								 
						$name = iconv("windows-1256", "UTF-8", $row['name']);
			
						$query1 = "INSERT INTO  dm_customer 
						( 
							`code_customer`, 
						    `customer_code_org`, 
			    			`name_customer` 		
						)
						
					VALUES
						(
							'".$row['code']."', 
							'".$row['org']."', 
							'".$name."' 
								
						)
				";
			
				$lnk1 = mysql_query($query1);
				if(mysql_error()) print mysql_error();
				
			                                  }
		
		                                           }
		$query = "
			UPDATE accnting.acc_mofaser_detail  
			SET 
				`flag` = '". 0 ."'
													 
			WHERE 
				 year='". $year_code ."' AND  mk=16  AND  flag='". 1 ."'	";
				
		$lnk = mysql_query($query);
//	print ($query);
	if(mysql_error()) print mysql_error();                                           
		                                           
		 echo '<div bgcolor="#99CCCC">مشتري جديدي  به سيستم فروش اضافه شد</div>';                                          
	}else{
		echo '<div bgcolor="#99CCCC">مشتري جديدي  براي ايجاد وجود ندارد</div>';
	}
	$query = "SELECT * FROM  accnting.acc_mofaser_detail  where year='". $year_code ."' AND  mk=16  AND  flag='". 2 ."' ";	
		$lnk = mysql_query($query);
		if(mysql_affected_rows()>0){
		
		while($row= mysql_fetch_assoc($lnk)){
		 $code=$row['code'];
		 $org=$row['org'];
		 $name = iconv("windows-1256", "UTF-8", $row['name']);
		
		$query1 = "SELECT * FROM  dm_customer  where code_customer=$code   
		                ";	
		$lnk1 = mysql_query($query1);
		if(mysql_affected_rows()>0){
		
		                         $query = "
									UPDATE dm_customer
									  SET 			
										
										`name_customer` = '". $name ."'
													
									WHERE 
										code_customer=$code  
									";
										       						
								$lnk = mysql_query($query);
							
							//	print $query;   
									}
		
		                                    }
		                                   		                                    
                  $query = "
							UPDATE accnting.acc_mofaser_detail  
							SET 
								`flag` = '". 0 ."'
																	 
							WHERE 
								 year='". $year_code ."' AND  mk=16  AND  flag='". 2 ."'	";
								
						$lnk = mysql_query($query);
					//	print ($query);
						if(mysql_error()) print mysql_error();        
				
		                             }
		
	}

function regListInformationCustomer(){ 
	
	$code_customer = isset($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '';
	$name_customer = isset($_REQUEST['name_customer']) ? ($_REQUEST['name_customer']) : '';
	$code_economic_customer = isset($_REQUEST['code_economic_customer']) ? ($_REQUEST['code_economic_customer']) : '';
	$code_postal_costumer = isset($_REQUEST['code_postal_costumer']) ? ($_REQUEST['code_postal_costumer']) : '';
	$customer_cusid_city = isset($_REQUEST['customer_cusid_city']) ? ($_REQUEST['customer_cusid_city']) : '';
	$customer_province_id 	= isset($_REQUEST['customer_province_id']) ? ($_REQUEST['customer_province_id']) : '';
	$code_province_customer=isset($_REQUEST['code_province_customer']) ? ($_REQUEST['code_province_customer']) : '';
	$code_identificate_customer = isset($_REQUEST['code_identificate_customer']) ? ($_REQUEST['code_identificate_customer']) : '';
	$cart_asnaf_customer = isset($_REQUEST['cart_asnaf_customer']) ? $_REQUEST['cart_asnaf_customer'] : '';
	$customer_category = isset($_REQUEST['customer_category']) ? $_REQUEST['customer_category'] : '';	
	$customer_address_office = isset($_REQUEST['customer_address_office']) ? ($_REQUEST['customer_address_office']) : '';
	$address_location_delivery_c = isset($_REQUEST['address_location_delivery_c']) ? ($_REQUEST['address_location_delivery_c']) : '';
	$customer_date = isset($_REQUEST['customer_date']) ? ($_REQUEST['customer_date']) : '';
	$type_activity_customer = isset($_REQUEST['type_activity_customer']) ? ($_REQUEST['type_activity_customer']) : '';
    $customer_tel = isset($_REQUEST['customer_tel']) ? ($_REQUEST['customer_tel']) : '';
	$condition_share_customer= isset($_REQUEST['condition_share_customer']) ? ($_REQUEST['condition_share_customer']) : '';
	$condition_pay_customer = isset($_REQUEST['condition_pay_customer']) ? ($_REQUEST['condition_pay_customer']) : '';
	$condition_activity_customer = isset($_REQUEST['condition_activity_customer']) ? ($_REQUEST['condition_activity_customer']) : '';
	$type_customer = isset($_REQUEST['type_customer']) ? ($_REQUEST['type_customer']) : '';
	$personality_customer = isset($_REQUEST['personality_customer']) ? ($_REQUEST['personality_customer']) : '';
	
	$date = explode('/', $customer_date);
    $customer_date=$date[2].'/'.$date[1].'/'.$date[0] ;  
	$jdate=$customer_date;
	$jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
	$customer_date = $gyear."-".$gmonth."-".$gday;
	
	$query = array(
		'code_customer' => $code_customer,
		'name_customer' => $name_customer,
		'code_economic_customer' => $code_economic_customer,
		'code_postal_costumer' => $code_postal_costumer,
     	'customer_province_id' => $_SESSION['dm_user_profile']['u_province_id'],
		'code_identificate_customer' => $code_identificate_customer,
		'cart_asnaf_customer' => $cart_asnaf_customer,
		'customer_category' => $customer_category,
		'customer_address_office' => $customer_address_office,
		'address_location_delivery_c' => $address_location_delivery_c,
		'customer_date' => $customer_date,
		'type_activity_customer' => $type_activity_customer,
		'customer_tel' => $customer_tel,
		'condition_share_customer' => $condition_share_customer,
		'condition_pay_customer' => $condition_pay_customer,
		'condition_activity_customer' => $condition_activity_customer,
		'type_customer' => $type_customer,
		'personality_customer' => $personality_customer,
	);

	$query = inserterQMaker('dm_customer', $query);
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$customer_id = mysql_insert_id();
	return $customer_id;	
	}

	function getListInformationCustomer1(){
		
			?>				
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>		
<?php 
	
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;				
		}
	}
	
	$outHtml = '<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodecustomer"> 
			 نام ، کد مشتری ، کد ملی و یا کد شناسه  را وارد کنید 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;"/> 
			<button type="submit" value="draft" name="commit"  >جستجو</button></div>
		</form>';
	echo  $outHtml;

		
		
	}
function getListInformationCustomer(){
		
	?>				
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>		
<?php 
	
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;				
		}
	}
	
	$outHtml = '<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodecustomer"> 
			 نام ، کد مشتری ، کد ملی و یا کد شناسه  را وارد کنید 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;"/> 
			<button type="submit" value="draft" name="commit"  >جستجو</button></div>
		</form>';
	
	$outHtml .= '<div align="left"> <a href="report/printcustomer.php?province_id='. $_SESSION['dm_user_profile']['u_province_id'] .'
			           " target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>';
	
	$queryp="SELECT * FROM 
	                  dm_province  
		            WHERE
		               province_id=".$_SESSION['dm_user_profile']['u_province_id']."
		             ";
		            	
			$lnkp=mysql_query($queryp);
			print mysql_error();
			$rowp=mysql_fetch_assoc($lnkp);
//	print $queryp;
	$outHtml .= '		
		<div align = "center">
		<div align = "center" style="height:400px; overflow:auto">
			<table  style="border:2px;" align="right" cellpadding="0" cellspacing="0" bgcolor="#99B3a7" class="list" style="width:100%;">
      			<tr class="rw1">
        			<th colspan="22" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;" >ليست مشتريان </th>
        		</tr>
      			<tr bgcolor="orange" class="rw0" style="font-weight:bold;height: 30px;">
      			    <td align="center">رديف</td>
			        <td align="center">كد مشتري</td>
			        <td align="center">نام مشتري </td>
			        <td align="center">شناسه ملی </td>			        	        
			        <td align="center">کد/شماره ملی</td>
			        <td align="center">کد اقتصادی</td>
			        
			       			             
				</tr>';
			
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		
		$_SESSION['srchStr']=str_replace("ی","ي",$_SESSION['srchStr']);
		$_SESSION['srchStr']=str_replace("ک","ك",$_SESSION['srchStr']);
	
		
		$srchQ = " 
			AND(
					code_customer = '".$_SESSION['srchStr']."' 
				OR 
					name_customer LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					customer_national_tax LIKE '%".$_SESSION['srchStr']."%'
				OR 
					customer_gl_code LIKE '%".$_SESSION['srchStr']."%' 
				
				
			)";
				
	}
	$typeQ = '';	
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	
//	print $querypro;
	$genQuery = "
		
				FROM 
					dm_customer_asli 
				WHERE
					1
							
					".$srchQ." 
					".$typeQ."
				
				ORDER BY code_customer ASC ";			
			
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print $resQuery;
		//$_SESSION['srchStr'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
		
	if(mysql_affected_rows()>0){
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			$inx++;
			if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete1';
				}
			
			
			
	//	print $queryt;
		
		$ostan=$rowpro['province_name'];
		
		$queryc = "
		       SELECT * FROM dm_customer
	 
		     	WHERE 
				code_customer = ".$row['code_customer']."
				AND
				customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']." 

				";
		//print $queryc;
		$lnkc = mysql_query($queryc);
		
		if(mysql_num_rows($lnkc)==0){
			
			$takmili='اطلاعات ناقص است';
		}
		$takmili='اطلاعات کامل است';
					
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['code_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['customer_national_tax'].'</td>					
					<td align="center" style="vertical-align:middle;">'.$row['customer_gl_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['customer_gl_economic'].'</td>	
					
					';
			  $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'162\' and t.um_can_edit=1';
	//		print   $query2;
//			                    $lnk2 = mysql_query($query2);
//			                  $row2 = mysql_fetch_assoc($lnk2);
//			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=upcodeCustomer&code_customer='.$row['code_customer'].'&customer_code_org='.$province_code.'"><img src="images/ok.png" width="20" height="20" title="ok" ></img></a></td>';
			  
					$outHtml .= '<td style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=dspListInformationCustomerEdit&customer_id='.$row['customer_id'].'"><img src="images/'.$edit.'.png" width="20" height="20" title="ویرایش" ></img></a></td>';
//		}
//  	else{
//						$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';
						
//					}
//					$query2='select *
//							from dm_um_rel t
//							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
//							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
//							      l.menu_code = \'162\' and t.um_can_delete=1';
//			                    $lnk2 = mysql_query($query2);
//			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    if(mysql_affected_rows()>0){
            if($_SESSION['dm_user_profile']['u_id']==3){
					$outHtml .= '<td style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=deleteListInformationCustomer&customer_id='.$row['customer_id'].'"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
               }else{
//		}
$outHtml .= '<td style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';}
//		else{
//						$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" ><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
//						
//					}


				$outHtml .= '</tr>
			';
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ اطلاعاتي موجود نيست.</td></tr>';
    }
     $outHtml .= '</table></div><br>'.getNavBar_customer().' '.getRPPCombo_customer();
    return $outHtml;
		
}

function getNavBar_customer(){
	
	
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getListInformationCustomer&cmd2=setPg&pgNum=1&search="'.$_SESSION['srchStr'].'"" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp; </td>
				      
		<td><a href="?pg=prodMgmtPg&cmd=getListInformationCustomer&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'&search="'.$_SESSION['srchStr'].'"" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp; </td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=getListInformationCustomer&cmd2=setPg&pgNum='.($stNum+$inx).'&search="'.$_SESSION['srchStr'].'"" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getListInformationCustomer&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'&search="'.$_SESSION['srchStr'].'"" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp; </td>
		<td><a href="?pg=prodMgmtPg&cmd=getListInformationCustomer&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'&search="'.$_SESSION['srchStr'].'"" ><img src="images/last.gif" title="بعدي"></img></a></td>
	';
	
	$out .= '
			</tr>
			
		</table>
	
	';	
	return $out;
}

function getRPPCombo_customer(){
	$out = '
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=searchCodecustomer&search="'.$_SESSION['srchStr'].'"&cmd2=setRPP&rPP=\'+this.value, \'_self\') " style="width:50px; >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	';
	return $out;
}
    


function dspListInformationCustomerEdit(){

	?>
	<script>
	function validcustomerAndSave(){
					  if(fObj('code_customer').value==''){
							
							alert('لطفا کد مشتري را وارد کنید');
							return;
						}
					  if(fObj('name_customer').value==''){
							
							alert('لطفا نام مشتري را وارد کنید');
							return;
						}
					  
					  if(fObj('code_postal_costumer').value==''){
							
							alert('لطفا کد پستي را وارد کنید');
							return;
						}
					 
					
					  if(fObj('customer_tel').value==''){
							
							alert('لطفا شماره تلفن را وارد کنید');
							return;
						}
					 
					  if(fObj('address_location_delivery_c').value==''){
							
							alert('لطفا آدرس محل تحويل را وارد کنید');
							return;
						}
					  if(fObj('customer_address_office').value==''){
							
							alert('لطفا آدرس دفتر وارد کنید');
							return;
						}
						if(fObj('customer_cusid_province').value==''){
							
							alert('لطفا استان  را انتخاب كنيد');
							return;
						}
						if(fObj('city_id').value==-2){
							
							alert('لطفا شهر را انتخاب كنيد');
							return;
						}
						validCustomercodeEdit();
				
				}
		 </script>
<?php 


	$customer_id = isset($_REQUEST['customer_id']) ? (int)($_REQUEST['customer_id']) : 0;
	//if($customer_id<1) die('Invalid document id!');
	$lnkj = mysql_query("SELECT * FROM  dm_customer_asli WHERE customer_id=".$customer_id);
	//if(mysql_affected_rows()>0){
		$rowj = mysql_fetch_assoc($lnkj);
		
	$lnk = mysql_query("SELECT * FROM  dm_customer WHERE code_customer=".$rowj['code_customer']."  and  customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']."");
	//print "SELECT * FROM  dm_customer WHERE code_customer=".$rowj['code_customer']."  and  customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']."";
	//if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
//	}else{
//		die('Invalid product id2!');
//	}
		?>
		<input type="hidden" name="customer_id" id="customer_id"   value="<?php  echo   $customer_id; ?>"> 
		<input type="hidden" name="name_customer" id="customer_id" value="<?php  echo $rowj['name_customer']; ?>"> 
	    <input type="hidden" name="code_customer" id="code_customer" value="<?php  echo $rowj['code_customer']; ?>"> 
		  
		<table  align="center" class="nasi" >
		     <tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			     <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">مشخصات مشتري</font></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	<tr>
		       	<td ><center>كد مشتري </center> </td>
		        <td> <?php echo $rowj['code_customer']?></td>
				<td >نام مشتري </td>
		        <td><?php echo $rowj['name_customer']; ?></td>
	        </tr>
	        <tr>
	             <td >  شخصيت </td>
		         <td> 
			  		   <?php echo getPersonalityTypesComboBox('personality_customer',$row['personality_customer'])?>
				 </td>
				<!-- <td >وضعيت </td>
		         <td> 
			  		   <?php echo getActivityTypesComboBox('condition_activity_customer',$row['condition_activity_customer'])?>
				 </td>-->
	        </tr>

		     <tr>
		           <td align="center"><center>دسته بندي </center> </td>
	               <td> 
			  		   <?php echo getCustomerTypesComboBox('customer_category',$row['customer_category'])?>
				   </td>
				   <td align="center"><center>نوع فعاليت </center> </td>
	               <td> 
			  		   <?php echo getActivityDifTypesComboBox('type_activity_customer',$row['type_activity_customer'])?>
				   </td>
			 </tr>
			 <tr>
			       <td >تلفن </td>
		           <td><input name="customer_tel" id="customer_tel" type="text"  value="<?php echo $row['customer_tel']; ?>"></input></td>
		           <td >تاريخ شروع فعاليت</td>
		           <td><input name="customer_date" id="customer_date" type="text"  value="<?php echo $row['customer_date']; ?>"></input></td>
			 </tr>
			 <tr>
			       <td>  وضعيت سهميه بندي </td>
		           <td> 
			  		   <?php echo getShareTypesComboBox('condition_share_customer',$row['condition_share_customer'])?>
				   </td>
		           <td >اصناف كارت </td>
		           <td><input name="cart_asnaf_customer" id="cart_asnaf_customer" type="text"  value="<?php echo $row['cart_asnaf_customer']; ?>"></input></td>		          
		     </tr>
		     <tr>
		           <td ><center>كد پستي </center> </td>
		           <td><input name="code_postal_costumer" id="code_postal_costumer" type="text" value="<?php echo $row['code_postal_costumer']; ?>" /></td>
		           <td align="center"><center>نوع مشتری(دارایی)  </center> </td>
	               <td> 
			  		   <?php echo getCustomerTypesComboBox('type_customer',$row['type_customer'])?>
				   </td>		          
		     </tr>
		     <tr>   
		             <td >استان  </td>
                     <td><?php echo getProvinceCombox('customer_cusid_province',$row['customer_cusid_province'],$rowj['customer_id']); ?></td>
                     <td >شهر  </td>
                      <td><?php echo getcitybox('city_id',$row['customer_cusid_city']); ?></td>                 
		    </tr>
		    <tr>
		           <td >آدرس دفتر</td>
		            <td><input  name="customer_address_office" id="customer_address_office"  value="<?php echo $row['customer_address_office']; ?>"></input></td>  
		           
		 	       <td align="center"><center>آدرس محل تحويل </center> </td>
	               <td><input name="address_location_delivery_c" id="address_location_delivery_c"  value="<?php echo $row['address_location_delivery_c']; ?>"></input></td>  
		     </tr>		    
		     <tr>
		    	   <td>&nbsp;&nbsp;  </td>	     
			       <td colspan="3"> <button name="subject" type="button"  onclick="validcustomerAndSave()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"   > ذخيره</button></td>                       
				   <td colspan="2">&nbsp;&nbsp;&nbsp;</td>				      
	      	</tr>
	    </table>	
	<?php
}

function upListInformationCustomer(){
	$customer_id = isset($_REQUEST['customer_id']) ? (int)($_REQUEST['customer_id']) : 0;
	//if($customer_id<1) die('Inv Id');
	//echo $personality_customer;
	$code_customer = isset($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '';
	$name_customer = isset($_REQUEST['name_customer']) ? ($_REQUEST['name_customer']) : '';
	$code_economic_customer = isset($_REQUEST['code_economic_customer']) ? ($_REQUEST['code_economic_customer']) : '';
	$code_postal_costumer = isset($_REQUEST['code_postal_costumer']) ? ($_REQUEST['code_postal_costumer']) : '';	
	$code_identificate_customer = isset($_REQUEST['code_identificate_customer']) ? ($_REQUEST['code_identificate_customer']) : '';
	$cart_asnaf_customer = isset($_REQUEST['cart_asnaf_customer']) ? $_REQUEST['cart_asnaf_customer'] : '';
	$customer_category = isset($_REQUEST['customer_category']) ? ($_REQUEST['customer_category']) : '';
	$customer_address_office = isset($_REQUEST['customer_address_office']) ? ($_REQUEST['customer_address_office']) : '';
	$customer_category = isset($_REQUEST['customer_category']) ? ($_REQUEST['customer_category']) : '';
	$address_location_delivery_c = isset($_REQUEST['address_location_delivery_c']) ? ($_REQUEST['address_location_delivery_c']) : '';
	$customer_date = isset($_REQUEST['customer_date']) ? ($_REQUEST['customer_date']) : '';
	$type_activity_customer = isset($_REQUEST['type_activity_customer']) ? ($_REQUEST['type_activity_customer']) : '';
    $customer_tel = isset($_REQUEST['customer_tel']) ? ($_REQUEST['customer_tel']) : '';
	$condition_share_customer= isset($_REQUEST['condition_share_customer']) ? ($_REQUEST['condition_share_customer']) : '';
	$condition_pay_customer = isset($_REQUEST['condition_pay_customer']) ? ($_REQUEST['condition_pay_customer']) : '';
	$condition_activity_customer = isset($_REQUEST['condition_activity_customer']) ? ($_REQUEST['condition_activity_customer']) : '';
	$type_customer = isset($_REQUEST['type_customer']) ? ($_REQUEST['type_customer']) : '';
	$personality_customer = isset($_REQUEST['personality_customer']) ? ($_REQUEST['personality_customer']) : '';
	$customer_cusid_city = isset($_REQUEST['customer_cusid_city']) ? ($_REQUEST['customer_cusid_city']) : '';
	$customer_cusid_province = isset($_REQUEST['customer_cusid_province']) ? ($_REQUEST['customer_cusid_province']) : '';	
	$city_id = isset($_REQUEST['city_id']) ? ($_REQUEST['city_id']) : '';	
	//echo $code_customer;
	$condition_activity_customer=0;
	  $query = "SELECT *  FROM dm_customer 
		        WHERE
		             `code_customer`='".$code_customer."' 
		         AND
		           customer_code_org='".$_SESSION['dm_user_profile']['u_province_id']."'";
		           
		   	    
	   $lnk = mysql_query($query);
    	
	   $row= mysql_fetch_assoc($lnk);
	// print $query;
    	if(mysql_num_rows($lnk)>0){ 
	
	
	$query = "
		UPDATE dm_customer_det
		SET 
			
			`code_postal_costumer` = '".$code_postal_costumer."',  			
			
			`customer_city_id` = '".$_SESSION['dm_user_profile']['u_city_id']."',
			`customer_cusid_city` = '".$city_id."',	
			`customer_cusid_province` = '".$customer_cusid_province."',		
			
			`cart_asnaf_customer` = '".$cart_asnaf_customer."',
			`customer_address_office` = '".$customer_address_office."',
			`customer_category` = '".$customer_category."',
			`address_location_delivery_c` = '".$address_location_delivery_c."',
			`customer_date` = '".$customer_date."',
			`type_activity_customer` = '".$type_activity_customer."',
			`customer_tel` = '".$customer_tel."',
			`condition_share_customer` = '".$condition_share_customer."',
							
			`condition_activity_customer` = '".$condition_activity_customer."',
			`type_customer` = '".$type_customer."',			
			`personality_customer` = '".$personality_customer."'
						
		WHERE 
			code_customer = ".$code_customer." 
			and
			customer_code_org='".$_SESSION['dm_user_profile']['u_province_id']."'
	";

	//print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	  $_SESSION['cityCntnr']='';
	}else{
		$queryi = "SELECT *  FROM dm_customer_asli 
		        WHERE
		             
		           customer_id='".$customer_id."'";
		           
		   	    
	   $lnki = mysql_query($query);
    	
	   $rowi= mysql_fetch_assoc($lnk);
		
		$query1 = array(
		
			'code_customer' => $code_customer, 
	 
			 'code_postal_costumer' => $code_postal_costumer,  			
			'customer_code_org' => $_SESSION['dm_user_profile']['u_province_id'],
			'customer_city_id'=> $_SESSION['dm_user_profile']['u_city_id'],
			'customer_cusid_city' => $city_id,	
			'customer_cusid_province'=> $customer_cusid_province,		
			
			'cart_asnaf_customer' => $cart_asnaf_customer,
			'customer_address_office' =>$customer_address_office,
			'customer_category' => $customer_category,
			'address_location_delivery_c' => $address_location_delivery_c,
			'customer_date' => $customer_date,
			'type_activity_customer' => $type_activity_customer,
			'customer_tel' => $customer_tel,
			'condition_share_customer' => $condition_share_customer,
			'condition_pay_customer' => $condition_pay_customer,					
			'condition_activity_customer' => $condition_activity_customer,
			'type_customer' => $type_customer,			
			'personality_customer' => $personality_customer
	             
			);
		
			$query1 = inserterQMaker('dm_customer_det', $query1);
		//	print $query1;
			$lnk1 = mysql_query($query1);
			if(mysql_error()) print mysql_error();
		
		
	//	print $query1;
		
		
	}
}
function upcodeCustomer(){
	
	$customer_code_org = isset($_REQUEST['customer_code_org']) ? (int)($_REQUEST['customer_code_org']) : 0;
	$code_customer = isset($_REQUEST['code_customer']) ? (int)($_REQUEST['code_customer']) : 0;
	
	$query1 = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_code=$row1['year_code'];
		$year_code=1395;
		
$query = "
			UPDATE mali.acc_mofaser_detail  
			SET 
				`flag` = '". 2 ."'
													 
			WHERE 
				 year='". $year_code ."' AND  mk=16  AND  code='". $code_customer ."' 	";
				
		$lnk = mysql_query($query);
	//print $query;
}
function deleteListInformationCustomer(){
	
	$customer_id = isset($_REQUEST['customer_id']) ? (int)($_REQUEST['customer_id']) : 0;
	if($customer_id<1) die('Inv Id');
	
	$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		    $province_code=$rowprov['province_code'];
	
	$query = "
	DELETE FROM  dm_customer_asli
 
		WHERE 
			customer_id = ".$customer_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}


//برای شهرها
function dspregInformationProvince(){
	$_SESSION['province']=1;
	?>
	<script type="text/javascript">
	function validProvinceAndSave(){
		if(fObj('province_code').value==''){
  			
  			alert('كد استان را وارد کنید');
  			return;
  		}
   if(fObj('province_code').value==''){
  			
  			alert('نام استان را وارد کنید');
  			return;
  		}
if(fObj('province_ecode').value==''){
  			
  			alert('كد اقتصادي استان راوارد كنيد');
  			return;
  		}
if(fObj('province_address').value==''){
  			
  			alert('كد اقتصادي استان راوارد كنيد');
  			return;
  		}
   validProvincecode();
	}
   </script>
   
	<br>
	<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="c">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">اطلاعات استانها</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>	
	        <tr>
		       	<td align="center"><b>&nbsp; كد استان: </b>  </td>
			  	<td><input name="province_code" type="text"  id="province_code" /></td>
				<td align="center"><b>نام استان:</b>   </td>
		        <td><input name="province_name" id="province_name" type="text"  /></td>
	        </tr>
	         <tr>
		       	<td align="center"><b>&nbsp; تلفن: </b>  </td>
			  	<td><input name="province_tel" type="text"  id="province_tel" /></td>
				<td align="center"><b>كد پستی:</b>   </td>
		        <td><input name="province_postal" id="province_postal" type="text"  /></td>
	        </tr>
	        <tr>
		       	<td align="center"><b>&nbsp; شماره ثبت: </b>  </td>
			  	<td><input name="province_sabt" type="text"  id="province_sabt" /></td>
				<td align="center"><b>&nbsp; كد اقتصادي: </b>  </td>
			  	<td><input name="province_ecode" type="text"  id="province_ecode" /></td>
	        </tr>
	        <tr>
		       	
			     <td align="center"><b>&nbsp; آدرس: </b>  </td>
			  	<td><textarea name="province_address"   id="province_address" ></textarea></td>
				
	        </tr>
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			       <td colspan="3"> <button name="subject" type="button"  onclick="validProvinceAndSave()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"   > ذخيره</button></td>                       
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
	    </table>
	</form> 
	    
	<?php
}
function deletemojavez(){
	
	$phm_id = isset($_REQUEST['phm_id']) ? (int)($_REQUEST['phm_id']) : 0;
	if($phm_id<1) die('Inv Id');
	
	$query = "SELECT *  FROM dm_ph_mojavez
		           WHERE `phm_id`='".$phm_id."' ";
		  $lnk = mysql_query($query);
		  $row= mysql_fetch_assoc($lnk);
	
	
	//insert to log	

		  $query1 = array(
				
			    'phml_reg_date'=> gmdate('Y-m-d'),
	            'phml_phm_op_id'=>  $row['phm_op_id'],
	            'phml_phm_mojavez'=>   $row['hm_mojavez'],
	            'phml_id_province'=> $_SESSION['dm_user_profile']['u_province_id'],
	            'phml_phm_u_id'=>   $_SESSION['dm_user_profile']['u_id'],
		        'phml_phm_id'=>   $phm_id,
		        'phml_phm_reg_date'=>   $row['phm_reg_date'], 
	             
			);
		
			$query1 = inserterQMaker('dm_log_mojavez', $query1);
			$lnk1 = mysql_query($query1);
			if(mysql_error()) print mysql_error();
		//print  $query1;

	$query = "DELETE FROM  dm_op_mojavez
		 
				WHERE 
				phm_id = ".$phm_id." ";
			  
				
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	//print  $query;
	
	
}
function deleteCityInf(){
	$city_id = isset($_REQUEST['city_id']) ? (int)($_REQUEST['city_id']) : 0;
	if($city_id<1) die('Inv Id');
	
	$query = "
	DELETE FROM  dm_city
 
		WHERE 
			city_id = ".$city_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
	
	function regInformationProvince(){
		if($_SESSION['province']==1){
		
	$province_code = isset($_REQUEST['province_code']) ? $_REQUEST['province_code'] : '';
	$province_name = isset($_REQUEST['province_name']) ? $_REQUEST['province_name'] : '';
	$province_ecode = isset($_REQUEST['province_ecode']) ? $_REQUEST['province_ecode'] : '';
    $province_address = isset($_REQUEST['province_address']) ? $_REQUEST['province_address'] : '';
    
    $province_tel = isset($_REQUEST['province_tel']) ? $_REQUEST['province_tel'] : '';
	$province_sabt = isset($_REQUEST['province_sabt']) ? $_REQUEST['province_sabt'] : '';
    $province_postal = isset($_REQUEST['province_postal']) ? $_REQUEST['province_postal'] : '';
	
	
	
	$query = array(
		'province_code' => $province_code,
		'province_name' => $province_name,
	    'province_address' => $province_address,
		'province_ecode' => $province_ecode,
	    'province_tel' => $province_tel,
	    'province_sabt' => $province_sabt,
		'province_postal' => $province_postal,
		
	);
	
	$query = inserterQMaker('dm_province', $query);
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['province']=0;
	$provice_id = mysql_insert_id();
	return $provice_id;
		}
		
}
function regCityInf(){
		if($_SESSION['city']==1){
	$city_code = isset($_REQUEST['city_code']) ? $_REQUEST['city_code'] : '';
	$city_name = isset($_REQUEST['city_name']) ? $_REQUEST['city_name'] : '';
	$city_province = isset($_REQUEST['city_province']) ? $_REQUEST['city_province'] : '';
	
	$query = array(
		'city_code' => $city_code,
		'city_name' => $city_name,
	    'city_province' => $city_province,
		
	);
	
	$query = inserterQMaker('dm_city', $query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['city']=0;
	$city_id = mysql_insert_id();
	return $city_id;
		}
		
}

  function getProvinceNameList(){
  			?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	
	<?php 
  	
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCityName"> 
			 کد استان و یا نام استان را وارد کنید 
			<div>  <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			<button value="draft" name="commit" type="submit" >جستجو</button></div>
		</form>';
	
	global $province_name;
	
	$outHtml .= '	<br>
		<div align = "center">
		<div align = "center" style="width:100%;height:200px; overflow:auto">
			<table  border="2" align="center" cellpadding="0" cellspacing="0" class="list" style="width=40%">
      			<tr class="rw0">
        			<th colspan="19" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;font-weight:bold;">اسامي استان ها </th>
        		</tr>
      			<tr class="rw1" style="height: 30px;vertical-align:middle;font-size:15px;font-weight:bold;">
      		    	<td align="center" style="vertical-align:middle;">رديف</td>
			        <td align="center"  style="vertical-align:middle;">كد استان</td>
			        <td   align="center" style="vertical-align:middle;">&nbsp; نام استان</td>
			        <td  align="center" style="vertical-align:middle;">&nbsp; كد اقتصادي استان</td>
			        <td  align="center" style="vertical-align:middle;">&nbsp; تلفن</td>
			        <td  align="center" style="vertical-align:middle;">&nbsp; كد پستی</td>
			        <td  align="center" style="vertical-align:middle;">&nbsp; شماره ثبت</td>
			        <td  colspan="3" >&nbsp; آدرس استان</td>		      
				</tr>';
	
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					province_name LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					province_code LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_province 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ."
		order by province_code 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
			if(($inx)%2==1){
				$class="rw0";
				
			
			}
				else{
				
				    $class="rw1";
				   
				}
			
			$inx++;
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['province_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['province_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['province_tel'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['province_postal'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['province_sabt'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['province_ecode'].'</td>
					<td align="center" width=50% style="vertical-align:middle;">'.$row['province_address'].'</td>';	
			  $query2='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'152\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){			
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=dspProvinceNameFrmEdit&province_id='.$row['province_id'].'"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';}
		    else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';
						
					}
					 $query2='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'152\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=deleteCityName&province_id='.$row['province_id'].'"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';}
	 	else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.png" width="20" height="20" title="حذف" ></img></a></td>';
						
					}
				$outHtml .= '</tr>';
			
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '</table></div>'.getNavBar_province().' '.getRPPCombo_province();
    return $outHtml;
		
}

function getNavBar_province(){
	$out = '<br>
		<table style="direction:ltr" >
			<tr>';
				
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
        <td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
       <td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
		<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
        <td>&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>	
        <td>&nbsp;&nbsp;</td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_province(){
	$out = '
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
<br><br>	';
	return $out;
}
function getCityNameList(){
		
					?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	
	<?php 
  	
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchcityName"> 
			 کد شهر و یا نام شهر مورد نظر را وارد کنید 
			<div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			<button value="draft" name="commit" type="submit" >جستجو</button></div>
		</form>';
	
	global $province_name;
	
	$outHtml .= '	<br>
		<div align = "center">
		<div align = "center" style="width:100%;height:200px; overflow:auto">
			<table  border="2" align="center" cellpadding="0" cellspacing="0" class="list"  style="width:70%">
      			<tr class="rw0">
        			<th colspan="19" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;">اسامي شهر ها </th>
        		</tr>
      			<tr class="rw1" style="font-weight:bold;height:30px;vertical-align:middle;">
      		    	<td align="center" style="vertical-align:middle;">رديف</td>
			        <td align="center" style="vertical-align:middle;">كد شهر</td>
			        <td align="center" style="vertical-align:middle;">نام شهر</td>
			        <td  colspan="3" style="vertical-align:middle;">&nbsp; نام استان</td>
				</tr>';
	
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					city_code LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					city_name LIKE '%".$_SESSION['srchStr']."%' 
								 
			)
		";
		
	}
	$typeQ = '';
	
	 $query4="SELECT * FROM dm_user_profile WHERE u_id=".$_SESSION['dm_user_profile']['u_id']."
								            AND
								           u_province_id=". 100 ."";
	$lnk4 = mysql_query($query4);
	$row4= mysql_fetch_assoc($lnk4);
	if($row4['u_province_id']==100){
				
			$genQuery = "
			
			FROM 
				dm_city 
			WHERE 
				1 
			".$srchQ." 
			".$typeQ." ";
			
			
	}else{
		
		$genQuery = "
			
			FROM 
				dm_city 
			WHERE 
				1 
			".$srchQ." 
			".$typeQ." 
			AND
			   city_province=".$_SESSION['dm_user_profile']['u_province_id']."";
		
	 }
	

	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	
	$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
			
			
			$queryp = "
		SELECt * FROM dm_province
	 
			WHERE 
				province_id = ".$row['city_province']." 
			
		";
		$lnkp = mysql_query($queryp);
		$rowp = mysql_fetch_assoc($lnkp);
								
			if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete1';
				}
		
			$inx++;
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['city_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['city_name'].'</td>	
					<td align="center" style="vertical-align:middle;">'.$rowp['province_name'].'</td>';
			 $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'154\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){			
					$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=dspCityFrmEdit&city_id='.$row['city_id'].'"><img src="images/edit.png" width="20" height="20" title="" ></img></a></td>';}
		else{
						$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';
						
					}
					 $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'154\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                  //  if(mysql_affected_rows()>0){	
			                    	if($_SESSION['dm_user_profile']['u_id']==3)
			                    	{
					$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=deleteCityInf&city_id='.$row['city_id'].'"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';}
			                    //	}
		else{
						$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
						
					}
				$outHtml .= '</tr>
			';
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '</table></div>'.getNavBar_province_city().' '.getRPPCombo_province_city();
    return $outHtml;
		
}

function getNavBar_province_city(){
	$out = '<br>
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getCityNameList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
        <td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getCityNameList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
       <td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
		<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=getCityNameList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getCityNameList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
        <td>&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getCityNameList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>	
        <td>&nbsp;&nbsp;</td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_province_city(){
	$out = '
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=getCityNameList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
<br><br>	';
	return $out;
}
function dspregInformationCity(){
	$_SESSION['city']=1;
	?>
	<script type="text/javascript">
	function validCityAndSave(){
		if(fObj('city_code').value==''){
  			
  			alert('كد شهر را وارد کنید');
  			return;
  		}
   if(fObj('city_code').value==''){
  			
  			alert('نام شهر را وارد کنید');
  			return;
  		}
   validCitycode();
	}
   </script>
   
	<br>
	
	<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="regInformationProvince">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">اطلاعات شهرها</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>	
	        <tr>
		       	<td align="center"><b>&nbsp; كد شهر: </b>  </td>
			  	<td><input name="city_code" type="text"  id="city_code" /></td>
				<td align="center"><b>نام شهر:</b>   </td>
		        <td><input name="city_name" id="city_name" type="text"  /></td>
	        </tr>
	        <tr>
		       	<td align="center"><b>&nbsp; نام استان: </b>  </td>
			    <td><?php echo getProvinceCombo('city_province'); ?></td>			
	        </tr>
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			     <td colspan="3"> <button name="subject" type="button"  onclick="validCityAndSave()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"   > ذخيره</button></td>                       
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>				          
	      </tr>
	    </table>
	</form> 
	    
	<?php
	
}

function dspProvinceNameFrmEdit(){
	?>
	<script type="text/javascript">
	function validProvinceAndSave(){
		if(fObj('province_code').value==''){
  			
  			alert('كد استان را وارد کنید');
  			return;
  		}
   if(fObj('province_code').value==''){
  			
  			alert('نام استان را وارد کنید');
  			return;
  		}
   if(fObj('province_ecode').value==''){
			
			alert('كد اقتصادي استان را وارد کنید');
			return;
		}
   if(fObj('province_address').value==''){
		
		alert('آدرس استان را وارد کنید');
		return;
	}
   validProvincecodeEdit();
	}
	
		   function isNumber(field) {
		           var re = /^[0-9-'.'-',']*$/;
		           if (!re.test(field.value)) {
		               alert('شما مجازيد فقط عدد وارد كنيد');
		               field.value = field.value.replace(/[^0-9-'.'-',']/g,"");
		           }
		       }
   </script>
   <?php 
	
	$province_id = isset($_REQUEST['province_id']) ? (int)($_REQUEST['province_id']) : 0;
	if($province_id<1) die('Invalid  id!');
	
	$lnk = mysql_query("SELECT * FROM  dm_province WHERE province_id=".$province_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid  id2!');
	}
		?>
	
	<form method="post" action="" >

		<input type="hidden" name="province_id"  id="province_id" value="<?php echo $province_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	 <tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">اسامي استان ها</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>كد استان </center> </td>
		          <td><input name="province_code" id="province_code" type="text" value="<?php echo $row['province_code']; ?>" /></td>
				<td >نام استان </td>
				  <td><input name="province_code" id="province_name" type="text" value="<?php echo $row['province_name']; ?>" /></td>
		     
	        </tr>
	        <tr>
		       	<td ><center>تلفن</center> </td>
		          <td><input name="province_tel" id="province_tel" type="text" value="<?php echo $row['province_tel']; ?>" /></td>
				<td >كد پستی</td>
				  <td><input name="province_postal" id="province_postal" type="text" value="<?php echo $row['province_postal']; ?>" /></td>
		     
	        </tr>
	        <tr>
		       	<td ><center>شماره ثبت</center> </td>
		        <td><input name="province_sabt" id="province_sabt" type="text" value="<?php echo $row['province_sabt']; ?>" /></td>
				<td ><center>كد اقتصادي استان </center> </td>
		        <td><input name="province_ecode" id="province_ecode" type="text"  value="<?php echo $row['province_ecode']; ?>" /></td>
		     
	        </tr>
	        <tr>
		       	 
				  <td ><center>آدرس استان </center> </td>
		          <td><input name="province_address" id="province_address" type="text"  value="<?php echo $row['province_address']; ?>" /></td>
	      	
		    <tr>
	      	        
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				       </td>
			      	
				       <td colspan="3"> <button name="subject" type="button"  onclick="validProvinceAndSave()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"   > ذخيره</button></td>                       
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
	    </table>
	</form>
	
	<?php
}

function dspCityFrmEdit(){
	
	?>
	<script type="text/javascript">
	function validCityAndSave(){
		if(fObj('city_code').value==''){
  			
  			alert('كد شهر را وارد کنید');
  			return;
  		}
   if(fObj('city_code').value==''){
  			
  			alert('نام شهر را وارد کنید');
  			return;
  		}
   validCitycodeEdit();
	}
   </script>
   <?php 
	
	$city_id = isset($_REQUEST['city_id']) ? (int)($_REQUEST['city_id']) : 0;
	if($city_id<1) die('Invalid  id!');
	
	$lnk = mysql_query("SELECT * FROM  dm_city WHERE city_id=".$city_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid  id2!');
	}
		?>
	
	<form method="post" action="" >

		<input type="hidden" name="city_id"  id="city_id" value="<?php echo $city_id; ?>">   
		<table  align="center"  class="nasi" >
		  <tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="8"  style="height: 50px;vertical-align:middle;" ><b><font size="5">اسامي شهرها</font></b></td>
	      </tr>
	      <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	      </tr>
	      <tr>
		       	<td><center>كد شهر </center> </td>
		        <td><input name="city_code" id="city_code" type="text" value="<?php echo $row['city_code']; ?>" /></td>
				<td>نام شهر </td>
				<td><input name="city_name" id="city_name" type="text" value="<?php echo $row['city_name']; ?>" /></td>
	      </tr>
	      <tr>
		       	<td align="center"><b>&nbsp; نام استان: </b>  </td>
			    <td><?php echo getProvinceCombo('city_province'); ?></td>
	      </tr>	      	
		  <tr>
		       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	           <td colspan="3"> <button name="subject" type="button"  onclick="validCityAndSave()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"   > ذخيره</button></td>                       
		       <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	      </tr>
	    </table>
	</form>
	
	<?php
}

function upProvinceName(){
	
	$province_id = isset($_REQUEST['province_id']) ? (int)($_REQUEST['province_id']) : 0;
//	print $province_id;
	if($province_id<1) die('Inv Id');
	
	$province_code = isset($_REQUEST['province_code']) ? $_REQUEST['province_code'] : '';
	$province_name = isset($_REQUEST['province_name']) ? $_REQUEST['province_name'] : '';
	$province_ecode = isset($_REQUEST['province_ecode']) ? $_REQUEST['province_ecode'] : '';
     $province_address = isset($_REQUEST['province_address']) ? $_REQUEST['province_address'] : '';
	
	 $province_tel = isset($_REQUEST['province_tel']) ? $_REQUEST['province_tel'] : '';
	$province_sabt = isset($_REQUEST['province_sabt']) ? $_REQUEST['province_sabt'] : '';
    $province_postal = isset($_REQUEST['province_postal']) ? $_REQUEST['province_postal'] : '';
	
	$query = "
		UPDATE dm_province
		SET 
			`province_code` = '".$province_code."',
			`province_ecode` = '".$province_ecode."',
			`province_address` = '".$province_address."',
			`province_name` = '".$province_name."',
		    `province_tel` = '".$province_tel."',
			`province_postal` = '".$province_postal."',
			`province_sabt` = '".$province_sabt."'
		WHERE 
			province_id = ".$province_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}

function upCityInf(){
	
	  $city_id = isset($_REQUEST['city_id']) ? (int)($_REQUEST['city_id']) : 0;
	if($city_id<1) die('Inv Id');
	
	$city_code = isset($_REQUEST['city_code']) ? $_REQUEST['city_code'] : '';
	$city_name = isset($_REQUEST['city_name']) ? $_REQUEST['city_name'] : '';
	$city_province = isset($_REQUEST['city_province']) ? $_REQUEST['city_province'] : '';
	
	$query = "
		UPDATE dm_city
		SET 
			`city_code` = '".$city_code."',
			`city_name` = '".$city_name."',
			`city_province` = '".$city_province."'
		
		WHERE 
			city_id = ".$city_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}


function deleteCityName(){
	$province_id = isset($_REQUEST['province_id']) ? (int)($_REQUEST['province_id']) : 0;
	if($province_id<1) die('Inv Id');
	
	$query = "
	DELETE FROM  dm_province
 
		WHERE 
			province_id = ".$province_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
//برای دسته بندی مشتریان


function deleteCategoryName(){
	$category_id = isset($_REQUEST['category_id']) ? ($_REQUEST['category_id']) : 0;
	if($category_id<1) die('Inv Id');
	
	$query = "
	DELETE FROM  dm_customer_category
 
		WHERE 
			category_id = ".$category_id." 
	";
	$lnk = mysql_query($query);
	sqlErr('delete category');
}
function dspRegcategoryCustomer(){
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#commentForm").validate();
		});
   </script>
	<br>
	
	<form method="post" action="" id="commentForm">
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="RegcategoryCustomer">   
		<table  align="center" class="nasi" style="font-weight:bold;">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
 
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">دسته بندي مشتريان</font></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>كد دسته بندي مشتري  </center> </td>
			  	<td><input name="category_code" type="text"   class="required digits"/></td>
				<td >نام دسته بندي مشتري   </td>
		       <td><input name="category_name" type="text"   class="required"/></td> 
	        </tr>
			  <tr>
	      	         
				       <td>&nbsp;&nbsp;
				       </td>
			      	
				     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"
				                              > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				           
	      	</tr>
	    </table>
	</form> 
	    
	<?php
}
function taghir_codeh(){
	
?>
    <script type="text/javascript">
		$(document).ready(function() {
			$("#commentForm").validate();
		});
   </script>
	<?php 

	$out='<table  align="center" class="nasi" style="font-weight:bold;">
			    	<form method="post" action="" >
					<input type="hidden" name="pg" value="prodMgmtPg">   
					<input type="hidden" name="cmd" value="taghir_savecodeh"> 
					  	<tr align="middle"  style="background-color:'. $_SESSION['htablecolor'] .';">
					        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">تغییرات کد کالا و کد قیمت حواله ها</font-size></td>
				        </tr>
				        <tr>
				            <td colspan="9"><hr></hr></td>
				        </tr>
				       
				         <tr>
				           <td style="color:red;">&nbsp;کد کالا قدیم :</td><td><input name="p_codegh" type="text" /></td>
				           <td >&nbsp; کد قیمت قدیم :</td><td><input name="p_price_codegh" type="text" /></td>
				           
				        </tr>
				        <tr>
				           <td style="color:red;">&nbsp;کدکالا جدید :</td><td><input name="p_codej" type="text" /></td>
				           <td >&nbsp;کد قیمت جدید :</td><td><input name="p_price_codej" type="text" /></td>
				           
				        </tr>
				        <tr>
						     <td>&nbsp;&nbsp;</td>
						     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"  > ذخيره</button></td>
						                             
						     <td colspan="2">&nbsp;&nbsp;</td>
						 </tr>
		        
	       </table>
	              </form>
	';
	echo $out;	
	
	
	
	
}
function taghir_cust(){
	
	?>
    <script type="text/javascript">
		$(document).ready(function() {
			$("#commentForm").validate();
		});
   </script>
<?php 

	$out='<table  align="center" class="nasi" style="font-weight:bold;">
			    	<form method="post" action="" >
					<input type="hidden" name="pg" value="prodMgmtPg">   
					<input type="hidden" name="cmd" value="save_cust"> 
					  	<tr align="middle"  style="background-color:'. $_SESSION['htablecolor'] .';">
					        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">تغییر کد مشتری استان</font-size></td>
				        </tr>
				        <tr>
				            <td colspan="9"><hr></hr></td>
				        </tr>
				       
				        <tr>
				           <td style="color:red;">&nbsp;کد مشتری قدیم :</td><td><input name="h_customer_code_gh" type="text" /></td>
				           <td >&nbsp; کد مشتری جدید :</td><td><input name="h_customer_code" type="text" /></td>
				           
				        </tr>				       
				        <tr>
						     <td>&nbsp;&nbsp;</td>
						     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"  > ذخيره</button></td>
						                             
						     <td colspan="2">&nbsp;&nbsp;</td>
						</tr>
		        
	       </table>
	              </form>';
	
	echo $out;	
		
	
}
function up_cust(){
	
	?>
    <script type="text/javascript">
		$(document).ready(function() {
			$("#commentForm").validate();
		});
   </script>
<?php 

	$out='<table  align="center" class="nasi" style="font-weight:bold;">
			    	<form method="post" action="" >
					<input type="hidden" name="pg" value="prodMgmtPg">   
					<input type="hidden" name="cmd" value="update_cust"> 
					  	<tr align="middle"  style="background-color:'. $_SESSION['htablecolor'] .';">
					        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">تغییر کد مشتری استان</font-size></td>
				        </tr>
				        <tr>
				            <td colspan="9"><hr></hr></td>
				        </tr>
				       
				        <tr>
				           <td style="color:red;">&nbsp;کد مشتری :</td><td><input name="h_customer_code_gh" type="text" /></td>
				           
				        </tr>				       
				        <tr>
						     <td>&nbsp;&nbsp;</td>
						     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"  > ذخيره</button></td>
						                             
						     <td colspan="2">&nbsp;&nbsp;</td>
						</tr>
		        
	       </table>
	              </form>';
	
	echo $out;	
		
	
}
function taghir_h(){
	
?>
    <script type="text/javascript">
		$(document).ready(function() {
			$("#commentForm").validate();
		});
   </script>
	<?php 

	$out='<table  align="center" class="nasi" style="font-weight:bold;">
			    	<form method="post" action="" >
					<input type="hidden" name="pg" value="prodMgmtPg">   
					<input type="hidden" name="cmd" value="taghir_saveh"> 
					  	<tr align="middle"  style="background-color:'. $_SESSION['htablecolor'] .';">
					        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">تغییرات حواله</font-size></td>
				        </tr>
				        <tr>
				            <td colspan="9"><hr></hr></td>
				        </tr>
				        <tr>
				           <td >&nbsp; شماره حواله :</td><td><input name="h_code" type="text" /></td>
				            <td >&nbsp; محل تحویل :</td><td>'. getLocationCombo('l_id').'</td>
				           
				        </tr>
				         <tr>
				           <td >&nbsp; کد کالا :</td><td><input name="p_code" type="text" /></td>
				           <td >&nbsp; کد قیمت :</td><td><input name="p_price_code" type="text" /></td>
				           
				        </tr>
				         <tr>
				           <td >&nbsp; شماره مجوز :</td><td><input name="ph_mojavez" type="text" /></td>
				           <td >&nbsp; کد مشتری :</td><td><input name="customer_code" type="text" /></td>
				           
				        </tr>
				        <tr>
					          <td>نام تحویل گیرنده:</td><td><input name="ph_deli_name"  type="text" /></td>
					          <td></td><td></td>
				        </tr>
				        <tr>
						     <td>&nbsp;&nbsp;</td>
						     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"  > ذخيره</button></td>
						                             
						     <td colspan="2">&nbsp;&nbsp;</td>
						 </tr>
		        
	       </table>
	              </form>
	';
	echo $out;
		
	
}
function save_cust(){
	
     $h_customer_code = !empty($_REQUEST['h_customer_code']) ? $_REQUEST['h_customer_code'] :'-2' ;
	 $h_customer_code_gh = !empty($_REQUEST['h_customer_code_gh']) ? $_REQUEST['h_customer_code_gh'] :'-2' ;
	 	
	 	 $query = "
					UPDATE dm_havale
						SET 			
							`h_customer_code` = '". $h_customer_code ."'			
						WHERE 
							 h_customer_code=".$h_customer_code_gh."
		         
				         AND
				         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				        
						";     
	 	//print  $query; 						
				$lnk = mysql_query($query);
				
	  $query1 = "
				UPDATE dm_pish_havale
					SET 			
						`ph_customer_code` = '". $h_customer_code ."'			
					WHERE 
						 ph_customer_code=".$h_customer_code_gh."
	         
			        AND
			         ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			        
					";     
	 	// print  $query1; 						
				$lnk = mysql_query($query1);
	echo 'تغییرات انجام شد';
}
function update_cust(){
	
	 $h_customer_code_gh = !empty($_REQUEST['h_customer_code_gh']) ? $_REQUEST['h_customer_code_gh'] :'-2' ;
	 	
	 	 $query = "
					UPDATE mali.acc_mofaser_detail  
      SET 
          `flag` =1
          
																	 
      WHERE 
           year=1395 
           AND 
            (mk=16 or mk=21) 
           and 
          code =".$h_customer_code_gh."";  			   
	 	//print  $query; 						
				$lnk = mysql_query($query);
				
	 
	echo 'حالا میتوانید از منوی مشتری جدید مشتری را اضافه کنید';
}
function taghir_savecodeh(){
	
	
	 $p_codegh = !empty($_REQUEST['p_codegh']) ? $_REQUEST['p_codegh'] :'-2' ;
	 $p_price_codegh = !empty($_REQUEST['p_price_codegh']) ? $_REQUEST['p_price_codegh'] :'-2' ;
	 $p_codej = !empty($_REQUEST['p_codej']) ? $_REQUEST['p_codej'] :'-2' ;
	 $p_price_codej = !empty($_REQUEST['p_price_codej']) ? $_REQUEST['p_price_codej'] :'-2' ;
	 

       $querylog = array(
						
				        'clog_codepricegh' => $p_price_codegh,
                        'clog_codepricej' => $p_price_codej,
				        'clog_p_codegh' => $p_codegh,				       
			            'clog_p_codej' => $p_codej,
			            'clog_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
			            'clog_u_id' => $_SESSION['dm_user_profile']['u_id'],
			);
		
			$querylog = inserterQMaker('dm_code_log', $querylog);
			//print $query;
			$lnklog = mysql_query($querylog);
			if(mysql_error()) print mysql_error();
	  
	  if($p_codegh==-2 or  $p_codej==-2){
	  	
	  	echo 'کد کالا نباید خالی باشد';
	  }
	  
	  
	else if($p_price_codegh==-2 or  $p_price_codej==-2)
	{
		
		
		
		
			$queryp = "select * from dm_product product
					left join dm_price price
							on product.p_id=price.price_p_id
							 WHERE 
							     p_code=".$p_codegh." 
							 AND
							     price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					
				$lnkp = mysql_query($queryp);
				$rowp= mysql_fetch_assoc($lnkp);
				
		
		
		
	 $query = "select * from  dm_havale 
	            where
	              h_p_code=".$p_codegh."
	         
			    AND
			         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  ";	
                     
                   
	    $lnk = mysql_query($query);
	  // print $query;
	       if( mysql_affected_rows()>0){
	     	   
	     	
	     	 $query0 = "
					UPDATE dm_havale
						SET 			
							`h_p_code` = '". $p_codej ."'			
						WHERE 
							 h_p_code=".$p_codegh."
		         
				         AND
				         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";       						
				$lnk0 = mysql_query($query0);
			//print $query0;
				if(mysql_error()) print mysql_error();
				
				 $queryu = "
					UPDATE dm_product
						SET 			
							`p_code` = '". $p_codej ."'			
						WHERE 
							 p_code=".$p_codegh."
		         
				         AND
				         p_id=".$rowp['p_id']."
						";       						
				$lnku = mysql_query($queryu);
			//print $query0;
				if(mysql_error()) print mysql_error();	
				
				
	
	                                        }
	                                        

	 $query1 = "select * from  dm_pish_havale_det 
	            where
	             phd_pid=".$p_codegh."
	         
			    AND
			         phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  ";	
                     
                   
	    $lnk1 = mysql_query($query1);
	    // print $query1;
	     if( mysql_affected_rows()>0){
	
	     	
	     	 $query2 = "
					UPDATE dm_pish_havale_det 
						SET 			
							`phd_pid` = '". $p_codej ."'			
						WHERE 
							 phd_pid=".$p_codegh."
		         
				         AND
				         phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";       						
				$lnk2 = mysql_query($query2);
				if(mysql_error()) print mysql_error();
			//	print $query2;
	
	                                        }                                   
	                                        
   
	     
	}else{
		
		
	$queryprod = "select * from dm_product product
					left join dm_price price
							on product.p_id=price.price_p_id
							 WHERE 
							     p_code=".$p_codegh." 
							    AND 
							     p_price_code=".$p_price_codegh."
							    AND
							     price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					
				$lnkprod = mysql_query($queryprod);
				$rowprod= mysql_fetch_assoc($lnkprod);
		
		
		
	$query3 = "select * from  dm_havale 
		          where
		              h_p_code=".$p_codegh."
		            AND
		                h_price_code=".$p_price_codegh."
		         
				    AND
				         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  ";	
                     
                   
	   //  $lnk3 = mysql_query($query3);
	     $row3 = mysql_fetch_assoc($lnk);
	    // print $query3;
	    if( mysql_affected_rows()>0)
	     {
	     	   
	     	
	     	 $query4 = "
					UPDATE dm_havale
						SET 			
							`h_p_code` = '". $p_codej ."',
							 h_price_code=".$p_price_codej."			
						WHERE 
							 h_p_code=".$p_codegh."
					    AND
		                   h_price_code=".$p_price_codegh."
		         
				         AND
				         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";       						
				$lnk4 = mysql_query($query4);
			//print $query4;
				if(mysql_error()) print mysql_error();
				
				
				 $queryuu = "
					UPDATE dm_product
						SET 			
							`p_code` = '". $p_codej ."'			
						WHERE 
							 p_code=".$p_codegh."
		         
				         AND
				         p_id=".$rowprod['p_id']."
						";       						
				$lnkuu = mysql_query($queryuu);
			//print $query0;
				if(mysql_error()) print mysql_error();	
				
				
				 $queryuu = "
					UPDATE dm_price
						SET 			
							`p_price_code` = '". $p_price_codej ."'			
						WHERE 
							`p_price_code` = '". $p_price_codegh ."'	
		         
				         AND
				         price_id=".$rowprod['price_id']."
				         
				         AND
				         price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";       						
				$lnkuu = mysql_query($queryuu);
			//print $query0;
				if(mysql_error()) print mysql_error();	
				
				
	
	                                        }
	                                        

	 $query5 = "select * from  dm_pish_havale_det 
	            where
	                phd_pid=".$p_codegh."
	             AND 
	                phd_price_code=".$p_price_codegh."
			     AND
			         phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  ";	
                     
                   
	     $lnk5 = mysql_query($query5);
	 // print $query5;
	     if( mysql_affected_rows()>0){
	     	   
	     	
	     	 $query6 = "
					UPDATE dm_pish_havale_det 
						SET 			
							`phd_pid` = '". $p_codej ."',
							 phd_price_code=".$p_price_codej."			
						WHERE 
							 phd_price_code=".$p_codegh."
						 AND
							  phd_price_code=".$p_price_codegh."	
		         
				         AND
				         phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";       						
				$lnk6 = mysql_query($query6);
			//print $query6;
				if(mysql_error()) print mysql_error();
	
	                                        }  
					
	}
	echo 'انجام شد';
}

function taghir_savecust(){
	
	
	 $code_cus = isset($_REQUEST['h_code']) ? ($_REQUEST['h_code']) : '-2';
	 $code_cusj = !empty($_REQUEST['code_cusj']) ? $_REQUEST['code_cusj'] :'-2' ;
	 
	
		 	$querys = "
					UPDATE dm_pish_havale
					SET 
					
						`ph_customer_code`= '".$code_cusj."' 
												 
					WHERE 
						ph_customer_code = ".$code_cus." 
					AND
					   ph_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
					print $query;
				//	$lnks = mysql_query($querys);
					if(mysql_error()) print mysql_error();
					
			$queryf = "
					UPDATE dm_havale
					SET 
					
						`h_customer_code`= '".$code_cusj."' 
												 
					WHERE 
						h_customer_code = ".$code_cus." 
					AND
					   h_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
					print $queryf;
				//	$lnkf = mysql_query($queryf);
					if(mysql_error()) print mysql_error();		
				
echo 'انجام شد';	
}
function taghir_saveh(){
	
	
	 $h_code = isset($_REQUEST['h_code']) ? ($_REQUEST['h_code']) : '-2';
	 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] :'-2' ;
	 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] :'-2' ;
	 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] :'-2' ;
	 
     $ph_mojavez = !empty($_REQUEST['ph_mojavez']) ? $_REQUEST['ph_mojavez'] :'-2' ;

	 $phd_deli_name = !empty($_REQUEST['ph_deli_name']) ? $_REQUEST['ph_deli_name'] :'-2' ;
	
	 $customer_code = !empty($_REQUEST['customer_code']) ? $_REQUEST['customer_code'] :'-2' ;
	

	 $query2 = "select * from  dm_havale h
	 
	          left join   dm_pish_factor    pf   on   h.h_pf_code=pf.pf_code
	          left join   dm_pish_havale    ph   on   pf.pf_ph_code=ph.ph_code
	          left join dm_pish_havale_det  phd  on   phd.phd_ph_code=ph.ph_code 
	                                  				
					where 
					     h_code=".$h_code."
					  AND				
	                     pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	                  AND
			             ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			          AND
			            h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			          AND
			            phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  ";	
                     
                   
	     $lnk2 = mysql_query($query2);
	     $row2= mysql_fetch_assoc($lnk2);
	//echo $l_id;
	     
	     
	     if($ph_mojavez !=-2)
	     {
	     	

			     	 	$query = "
								UPDATE dm_pish_havale
								SET
								   `ph_taghir`= '1',  
									
									`ph_mojavez`= '".$ph_mojavez."' 
															 
								WHERE 
									ph_code = ".$row2['ph_code']." 
								AND
								   ph_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
								"; 
							
							//print $query;
						$lnk = mysql_query($query);
							if(mysql_error()) print mysql_error();
	     	
	     }
	
		 if($customer_code !=-2)
		 {
		 	
		 	$queryy = "
						UPDATE dm_pish_havale
						SET 
					     	`ph_taghir`= '1',
							
							`ph_customer_code`= '".$customer_code."' 
													 
						WHERE 
							ph_code = ".$row2['ph_code']." 
						AND
						   ph_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
					//print $queryy;
					$lnky = mysql_query($queryy);
					if(mysql_error()) print mysql_error();
					
					$queryyy = "
						UPDATE dm_havale
						SET 
					     	`h_taghir`= '1',
							
							`h_customer_code`= '".$customer_code."' 
													 
							WHERE 
								 
							h_code = ".$h_code." 
						   AND
						   h_id_province  = '".$_SESSION['dm_user_profile']['u_province_id'] ."' 
							"; 
						
						//print $queryyy;
						$lnkyy = mysql_query($queryyy);
						if(mysql_error()) print mysql_error();
		 		
		 }
		 
 if($phd_deli_name !=-2)
	 {
	 	$querydeli = "
					UPDATE dm_pish_havale_det
					SET 
						`phd_taghir`= '1',
						`phd_deli_name`= '".$phd_deli_name."' 
												 
					WHERE 
						phd_id = ".$row2['h_phd_id']." 
					AND
					   phd_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." ";
					 
					
					//print $query;
					$lnkdeli = mysql_query($querydeli);
					if(mysql_error()) print mysql_error();
					
					$querydeli1 = "
					UPDATE dm_havale
					SET 
						`h_taghir`= '1',
						`h_deli_name`= '".$phd_deli_name."' 
												 
					WHERE 
						h_code = ".$h_code." 
					AND
					   h_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
					//print $query1;
					$lnkdeli1 = mysql_query($querydeli1);
					if(mysql_error()) print mysql_error();
	 	
	 	
	 }
	
	 if($p_code !=-2)
	 {
	 	$queryh = "
					UPDATE dm_pish_havale_det
					SET 
						`phd_taghir`= '1',
						`phd_pid`= '".$p_code."' 
												 
					WHERE 
						phd_id = ".$row2['h_phd_id']." 
					AND
					   phd_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
					//print $query;
					$lnkh = mysql_query($queryh);
					if(mysql_error()) print mysql_error();
					
					$query1 = "
					UPDATE dm_havale
					SET 
						`h_taghir`= '1',
						`h_p_code`= '".$p_code."' 
												 
					WHERE 
						h_code = ".$h_code." 
					AND
					   h_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
					//print $query1;
					$lnk1 = mysql_query($query1);
					if(mysql_error()) print mysql_error();
	 	
	 	
	 }
		 
	if($p_price_code !=-2)
	{
		
		 	$querys = "
					UPDATE dm_pish_havale_det
					SET 
						`phd_taghir`= '1',
						`phd_price_code`= '".$p_price_code."' 
												 
					WHERE 
						phd_id = ".$row2['h_phd_id']." 
					AND
					   phd_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
				//	print $query;
					$lnks = mysql_query($querys);
					if(mysql_error()) print mysql_error();
					
					$queryf = "
					UPDATE dm_havale
					SET 
						`h_taghir`= '1',
						`h_price_code`= '".$p_price_code."' 
												 
					WHERE 
						h_code = ".$h_code." 
					AND
					   h_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
					//print $queryf;
					$lnkf = mysql_query($queryf);
					if(mysql_error()) print mysql_error();
				
	}	

	echo  $l_id;
	if($l_id !=-2)	
	{
		
		
		$queryj = "SELECT *  FROM dm_location_goods 
		           WHERE `l_id`='".$l_id."' 
		      
		        AND 
		           l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		               
		    ";
		  $lnkj = mysql_query($queryj);
	     $rowj= mysql_fetch_assoc($lnkj);
		
	//	print $queryj;
		
			$queryu = "
					UPDATE dm_pish_havale_det
					SET 
						`phd_taghir`= '1',
						`phd_l_id`= '".$rowj['l_id']."' 
												 
					WHERE 
						phd_id = ".$row2['h_phd_id']." 
					AND
					   phd_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
				//	print $query;
					$lnku = mysql_query($queryu);
					if(mysql_error()) print mysql_error();
					
					$queryg = "
					UPDATE dm_havale
					SET 
						`h_taghir`= '1',
						`h_l_code`= '".$rowj['l_id']."' 
												 
					WHERE 
					    	h_code = ".$h_code." 
					AND
					     h_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
						"; 
					
				//	print $queryg;
					$lnkg = mysql_query($queryg);
					if(mysql_error()) print mysql_error();
		
	
	} 
						
echo 'انجام شد';
	
}
function prod_morgh(){
	
	
	
?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
		
	<?php 
		
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	$srchStr;
	$outHtml = '	<br><br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodeProd_m">
			<table border=0 >
			<tr> 
			    <td style="font-weight:bold;">
			        کد  مورد نظر را وارد نمایید 
			    </td>
			  <tr>
			  <div id="search">
			  
			     <td>
			     <div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			           <button value="draft" name="commit" type="submit" >جستجو</button> </div>
			     </td>
                 
              </tr>
              </table>
		</form>
	';

	$outHtml .= '<br>	
		<div align = "center">
		<div align = "center" style="width:100%;height:400px; overflow:auto">
			<table border="5" align="center" style="padding:20px;"  class="list" >
      			<tr class="rw1">
        			<th colspan="7" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;"><center>لیست کالاها </center></th>
        		</tr>
      			<tr class="rw0" style="height: 50px;vertical-align:middle;font-size:15px;">
			        <td align="center" style="vertical-align:middle;" >ردیف</td>
			        <td align="center" style="vertical-align:middle;" >کدکالا </td>
			        <td align="center" style="vertical-align:middle;">کد قیمت </td>
			        <td align="center" style="vertical-align:middle;">قیمت </td>	       
			        <td  align="center"> &nbsp; </td>
				</tr>';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		
		$srchStr=str_replace("ي","ی",$_SESSION['srchStr']);
		$srchQ = " 
			AND(
					pm_pcode = '".$srchStr."' 
				 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_prod_morgh
			where   
			1
					
		".$srchQ." 
		".$typeQ."
		
		ORDER BY pm_id desc ";
	

	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	
	$lnk = mysql_query($countQuery);		
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	echo '<br>';
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;	
	//print $resQuery;
	$_SESSION['srchStr'] = '';
	$_SESSION['srchStr'] = '';	
	$lnk1 = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk1)){
			
			if($row['p_status']==1){
            $Display2='none';
            $Display1='block';
			}else{
				
				
				$Display2='block';
                $Display1='none';
				
			}
			if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete';
				}
				 
      
		$outHtml .= '
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pm_pcode'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pm_price_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pm_price'].'</td>
					
					
					';
		
					
			                
					
					  $outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=dspProdFrmEdit_morgh&pm_id='.$row['pm_id'].'"><img src="images/'.$edit.'.png" width="20" height="20" title="ویرایش" "></img></a></td>';
						
				
			                    	 
				//	$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=deleteProd1&p_id='.$row['p_id'].'&price_id='.$row['price_id'].'"><img src="images/'.$delete.'.PNG" width="20" height="20" title="حذف" "></img></a></td>';
					
						//$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/'.$delete.'.PNG" width="20" height="20" title="حذف" "></img></a></td>';
						
				
				$outHtml .= '</tr>';
			
			$inx++;
		}
    }else{
    	$outHtml .= '<tr ><td colspan="13">هیچ اطلاعاتي موجود نیست</td></tr>';
    }
    $outHtml .= '</table></div ><br><div align="center" >'.getNavBar_morgh().' </div>'.getRPPCombo_morgh();
    return $outHtml;
    
		
}

function getNavBar_morgh(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=listprod_morgh&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=listprod_morgh&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=listprod_morgh&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=listprod_morgh&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=listprod_morgh&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_morgh(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=showprodList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}

	





















function listprod_m(){
	
	?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
		
	<?php 
		
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	$srchStr;
	$outHtml = '	<br><br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodeProd_m">
			<table border=0 >
			<tr> 
			    <td style="font-weight:bold;">
			        کد ویا نام کالای مورد نظر را وارد نمایید 
			    </td>
			  <tr>
			  <div id="search">
			  
			     <td>
			     <div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			           <button value="draft" name="commit" type="submit" >جستجو</button> </div>
			     </td>
                 
              </tr>
              </table>
		</form>
	';

	$outHtml .= '<br>	
		<div align = "center">
		<div align = "center" style="width:100%;height:400px; overflow:auto">
			<table border="5" align="center" style="padding:20px;"  class="list" >
      			<tr class="rw1">
        			<th colspan="6" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;"><center>لیست کالاها </center></th>
        		</tr>
      			<tr class="rw0" style="height: 50px;vertical-align:middle;font-size:15px;">
			        <td align="center" style="vertical-align:middle;" >ردیف</td>
			        <td align="center" style="vertical-align:middle;" >نام كالا </td>
			        <td align="center" style="vertical-align:middle;">کد كالا </td>
			        <td align="center" style="vertical-align:middle;">فعال </td>
			         <td align="center" style="vertical-align:middle;">غير فعال </td>
			        	       
			        <td  align="center"> &nbsp; </td>
				</tr>';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		
		$srchStr=str_replace("ي","ی",$_SESSION['srchStr']);
		$srchQ = " 
			AND(
					p_code = '".$srchStr."' 
				OR 
				
					p_name  LIKE '%".$srchStr."%' 
					
				OR
					
					p_name  LIKE '%".$_SESSION['srchStr']."%'
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_listprod
			where   
			1
					
		".$srchQ." 
		".$typeQ."
		
		ORDER BY p_id desc ";
	

	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	
	$lnk = mysql_query($countQuery);		
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	echo '<br>';
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;	
	//print $resQuery;
	$_SESSION['srchStr'] = '';
	$_SESSION['srchStr'] = '';	
	$lnk1 = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk1)){
			
			if($row['p_status']==1){
            $Display2='none';
            $Display1='block';
			}else{
				
				
				$Display2='block';
                $Display1='none';
				
			}
			if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete';
				}
				 
      
		$outHtml .= '
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_code'].'</td>';
		
					 $outHtml .= '<td align="center"><span id="ezaf_'.$row['p_id'].'"  style="cursor:pointer;display:'.$Display2. ';"        onclick="Addprodv(\'\', \''.$row['p_id'].'\') "  this.style.display=\'none\'"><img src="images/ok.png" border="0" align="center" style="height:20px;width=20px;"></img></span></td>';
	    	        $outHtml .= ' <td align="center"><span id="kam_'.$row['p_id'].'"   style="cursor:pointer;display:'.$Display1.';"         onclick="delprodv(\'\', \''.$row['p_id'].'\') "  this.style.display=\'none\'"><img src="images/del.png" border="0" align="center"  style="height:20px;width=20px;"></img></span></td>
							
					';
			                
					
					  $outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=dspProdFrmEdit_m&p_id='.$row['p_id'].'&p_id='.$row['p_id'].'"><img src="images/'.$edit.'.png" width="20" height="20" title="ویرایش" "></img></a></td>';
						
				
			                    	 
				//	$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="?pg=prodMgmtPg&cmd=deleteProd1&p_id='.$row['p_id'].'&price_id='.$row['price_id'].'"><img src="images/'.$delete.'.PNG" width="20" height="20" title="حذف" "></img></a></td>';
					
						//$outHtml .= '<td align="center" style="vertical-align:middle;"><a href="" onclick="Access();"><img src="images/'.$delete.'.PNG" width="20" height="20" title="حذف" "></img></a></td>';
						
				
				$outHtml .= '</tr>';
			
			$inx++;
		}
    }else{
    	$outHtml .= '<tr ><td colspan="13">هیچ اطلاعاتي موجود نیست</td></tr>';
    }
    $outHtml .= '</table></div ><br><div align="center" >'.getNavBar_mm().' </div>'.getRPPCombo_mm();
    return $outHtml;
    
		
}

function getNavBar_mm(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=listprod_m&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=listprod_m&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=listprod_m&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=listprod_m&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=listprod_m&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_mm(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=showprodList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}















































function dspInseNewGroupFrm(){
	
    $_SESSION['NewGroup']=1;
	?>
	<script>
	  function validateAndSavegroup(){
	  	
	  	if(fObj('ug_category').value==''){
	  			
	  			alert('نام دسته بندی را وارد کنید');
	  			return;
	  		}
checkGroupName();

	      }
	
	</script>
	 
		<table  align="center" class="nasi" style="font-weight:bold;">
		  <tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">گروه بندي كاربران</font></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
					 <td align="center">&nbsp; نام گروه جدید  : </td>
				     <td><input name="ug_category" id="ug_category" type="text"  /></td> 
	        </tr> 
		    <tr>
				     <td>&nbsp;&nbsp;</td>  
	                 <td colspan="3"><button  type="button" onclick="return validateAndSavegroup();"value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>			                            
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	      	</tr>
	    </table>
	 
	    
	<?php 
}

function RegcategoryCustomer(){
		
	$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
	$category_code = isset($_POST['category_code']) ? $_POST['category_code'] : '';
	$category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
	
	
	$query = array(
		'category_code' => $category_code,
		'category_name' => $category_name,
		
	);
	

	$query = inserterQMaker('dm_customer_category', $query);
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$category_id = mysql_insert_id();
	return $category_id;
		
}
function RegNewGroup(){
	
	if($_SESSION['NewGroup']==1){

	$ug_category = isset($_REQUEST['ug_category']) ? $_REQUEST['ug_category'] : '0';
	
		$query = array(
				'ug_category' => $ug_category,
				
			);

	$query = inserterQMaker('dm_usergroup', $query);	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['NewGroup']=0;
	$ug_id = mysql_insert_id();	
	$_SESSION['ug_id']=$ug_id;
   return 	 $ug_id;
	}
}

function RegAccessGroup(){
		
	$rel_ug_id = isset($_POST['rel_ug_id']) ? $_POST['rel_ug_id'] : '';
	$rel_menu_id = isset($_POST['rel_menu_id']) ? $_POST['rel_menu_id'] : '';
	
	$query = array(
	
		'rel_ug_id' => $rel_ug_id,
	    'rel_menu_id' => $rel_menu_id,	
	);
	
	$query = inserterQMaker('dm_list_group_rel', $query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$rel_id = mysql_insert_id();
	return $rel_id;
		
}

 function dspAccessGroupFrm($ug_id){
 	
 	
   $ug_id = isset($_REQUEST['ug_id']) ? $_REQUEST['ug_id'] : $_SESSION['ug_id']; 
	$queryg="SELECT * FROM dm_usergroup WHERE ug_id=" .$ug_id."";
	$lnkg = mysql_query($queryg);
	$rowg=mysql_fetch_assoc($lnkg);
	
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '	<br>
	               
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchg"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px" /> 
           <button value="search" name="search" type="submit">جستجو</button></form></div>
	';

	
	$outHtml .= '	<br>
		<div align="center">
		
		<div align = "center" style="width:50%;height:200px; overflow:auto">
			<table  border="2" align="center" cellpadding="0" cellspacing="0" class="list">
      			<tr class="rw1">
        			<th colspan="18" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center> گروه های دسترسی </center></th>
        		</tr>
        		 <tr style="background-color:#999989;height:40px;" >
			          <td colspan="1" > &nbsp;&nbsp;گروه :</td><td colspan="3">&nbsp;'.$rowg['ug_category'].'</td>
			         
      			<tr class="rw0">
      		    	<td align="center">رديف</td>
			        <td align="center">لیست منوها</td>
			        <td align="center">اضافه </td>			       
			        <td  align="center">حذف </td>
			        
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					menu_name '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_listmenu 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		print $query;
		while($row = mysql_fetch_assoc($lnk)){
			if(($inx)%2==1){
				$class="rw0";
				$pictureKam='del';				
			    $pictureEzaf='ok';
                }
				else{
				$class="rw1";
				$pictureKam='del';
				$pictureEzaf='ok';
				
				}
				
			$inx++;
				$queryd="SELECT * FROM dm_list_group_rel 
	                           WHERE rel_ug_id=".$ug_id." AND rel_menu_id=".$row['menu_id']." ";
//				print $queryd;
	            $lnkd=mysql_query($queryd);
	            $rowd = mysql_fetch_assoc($lnkd);
	            if(mysql_affected_rows()>0){
	            	$Display2='block';
	            	$Display1='none';
	            }else{
	            	$Display2='none';
	            	$Display1='block';
	            }
		      
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['menu_name'].'</td>
					<td align="center"><span  id="ezaf_'.$row['menu_id'].'" style="cursor:pointer;display:'.$Display1.';"  onclick="AddAMenuToList(\'\', \''.$row['menu_id'].'\', \''. $ug_id .'\') "  align="center"><img src="images/'.$pictureEzaf.'.png"" border="0" style="width:20px;height:20px;" align="center"></img></span></td>			
	    	        <td align="center"><span id="kam_'.$row['menu_id'].'" style="cursor:pointer;display:'.$Display2.';"  onclick="DelAMenuToList(\'\', \''.$row['menu_id'].'\') " "><img src="images/'.$pictureKam.'.png" border="0" width=50% align="center" style="width:30px;height:20px;"></img></span></td>								
				</tr>
			';
		}
		$outHtml .= '<tr style="background-color: #CC9999;">
	      	         
				     <td colspan="3" align="center"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px;
				      color:#FFFFFF" onclick=window.open("home.php?pg=prodMgmtPg&cmd=ListAccessMenu","_self") > لیست گروه های دسترسی</button></td>
				      <td>&nbsp;</td>                       				         
	      	</tr>
	      	';
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '</table><br></div>'.getNavBar_g().' '.getRPPCombo_g();
    return $outHtml;
		
}

function getNavBar_g(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=dspAccessGroupFrm&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td><td>&nbsp</td>
		<td><a href="?pg=prodMgmtPg&cmd=dspAccessGroupFrm&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=showprodList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>	<td>&nbsp</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=dspAccessGroupFrm&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp</td>
		<td><a href="?pg=prodMgmtPg&cmd=dspAccessGroupFrm&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_g(){
	$out = '
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=dspAccessGroupFrm&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
        <span style="color:blue;"><b>پاسخ در صفحه</b></span>';
	return $out;
}

    	
function  ListAccessMenu(){
	?>
	<script>
	function ConfirmDel()
	{
		if (! confirm('! آیااز حذف این گروه مطمئن هستید')) { return false; } 
	} 
	 function Access(){
		  alert('شما حق دسترسي نداريد');

	  } 
	</script>
	<?php 
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	$srchStr;
	$outHtml = '	<br><br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchGroup">
			<table border=0 >
			<tr> 
			    <td>
			        کلمه مورد نظر را وارد كنيد 
			    </td>
			  <tr>
			  <div id="search">
			  
			     <td>
			     <div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
			     </td>
                 
              </tr>
              </table>
		</form>
	';
	
	
	$outHtml .= '<br>	
		<div align = "center">
		<div align = "center" style="width:70%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>لیست گروه های دسترسی </center></th>
        		</tr>
      			<tr class="rw0">
			        <td align="center">ردیف</td>
			        <td align="center">کد گروه </td>
			        <td align="center">نام گروه </td>
			         <td colspan="2">&nbsp; </td>			        
				</tr>
	';
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					ug_code LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					ug_category LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_usergroup 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk)){
			if(($inx)%2==1)
				$class="rw0";
				else
				 $class="rw1";
				 
			$gdate=$row['p_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
        
	
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center" width="10%">'.$inx.'</td>
					<td align="center"  width="15%">'.$row['ug_code'].'</td>
					<td align="center"  width="50%">'.$row['ug_category'].'</td>';
      $query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'511\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=ShowAccess1&ug_id='.$row['ug_id'].'"><img src="images/display.png" width="20" height="20" title="مشاهده  دسترسي"  ></img></a></td>';}
		   else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ويرايش"  ></img></a></td>';
						
					}
			$query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'511\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query2;
			                    if(mysql_affected_rows()>0){
                    $outHtml .= '<td align="center"> <a href="?pg=prodMgmtPg&cmd=DeleteGroup&ug_id='.$row['ug_id'].'" onclick="return ConfirmDel();"><img src="images/delete.PNG" width="20" height="20" border="0"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف"  ></img></a></td>';
						
					}
						
				$outHtml .= '</tr>
			';
			$inx++;
		}
    }else{
    	$outHtml .= '<tr ><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
    }
    $outHtml .= '</table></div ><br><div align="center" >'.getNavBar_catGroup().' </div>'.getRPPCombo_catGroup();
    return $outHtml;
    
		
}

function getNavBar_catGroup(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=ListAccessMenu&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=+
		
		+&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=ListAccessMenu&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=ListAccessMenu&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=ListAccessMenu&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_catGroup(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=ListAccessMenu&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}


	
function getcategoryNameList(){
	?>
	<script>
	function ConfirmDel()
	{
		if (! confirm('! با حذف اين گروه تمام دسترسي هاي كاربران مربوطه نيز حذف مي شود')) { return false; } 
	} 
	function Access(){
		  alert('شما حق دسترسي نداريد');

	  } 
</script>
			
	
	
	<?php 
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '<br>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchCategoryName"> 
			 کد و یا نام دسته بندی مورد نظر را وارد کنید 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;"/> 
			<button type="submit" name="Search" value="Search" />جستجو</button></div>
			
		</form>
	';
	
	$outHtml .= '	
		<div  style="width:100%;height:200px;align:center; overflow:auto">
			<table  border="1"  style="width:50%" align="center" class="list">
		  	<tr align="middle" class="rw1">
		     <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">انواع دسته بندي</font-size></td>
	        </tr>
      			<tr class="rw0" style="font-weight:bold;">
      		    	<td style="align:center;vertical-align:middle;">رديف</td>
			        <td style="align:center;vertical-align:middle;">كد دسته بندي مشتري</td>
			        <td colspan="4" style="vertical-align:middle;">نام دسته بندي مشتري</td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					category_name LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					category_code LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			 dm_customer_category 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
			
		if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete1';
				}
			
			$inx++;
			$outHtml .= '
				 <tr class='.$class.'>
					<td style="vertical-align:middle;" align="center">'.$inx.'</td>
					<td style="vertical-align:middle;" align="center">'.$row['category_code'].'</td>
					<td width=50% style="vertical-align:middle;" align="center">'.$row['category_name'].'</td>';
			 $query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'164\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=dspCategoryNameFrmEdit&category_id='.$row['category_id'].'"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" width="20" height="20" title="ویرایش" ></img></a></td>';
						
					}
					$query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'164\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=deleteCategoryName&category_id='.$row['category_id'].'" onclick="return ConfirmDel();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>';
						
					}
					
				$outHtml .= '</tr>';
				
		}
		
    }else{
    	$outHtml .= '<tr><td colspan="6">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '  
	
				          
	     
	      	</table></div><div align="center">'.getNavBar_category().' '.getRPPCombo_category();
    return $outHtml;
		
}
function getNavBar_category(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getcategoryNameList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
        <td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getcategoryNameList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلی"></img></a></td>
       <td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=getcategoryNameList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
            <td>&nbsp;&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getcategoryNameList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" >بعدي</a></td>
        <td>&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getcategoryNameList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="آخر"></img></a></td>	
        <td>&nbsp;&nbsp;</td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_category(){
	$out = '
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=getcategoryNameList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
<br><br>	';
	return $out;
}

  	
function getGroupUserList(){
	
	
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;				
		}
	}
	
	$outHtml = '<br>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchUgroup"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;"/> 
			<button type="submit" name="Search" value="Search" />جستجو</button></div>
			
		</form>
	';

	
	$outHtml .= '	
		<div align = "center" style="width:100%;height:200px; overflow:auto">
			<table  align="center" class="list" >
		  	<tr align="middle" class="rw1">
		     <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">لیست گروه کاربران</font-size></td>
	        </tr>
      			<tr class="rw0">
      		    	<td>رديف</td>
			        <td >كد گروه</td>
			        <td >نام گروه</td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					category_name LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					category_code LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			 dm_userGroup 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
			
			 if(($inx)%2==1){
				$class="rw1";}
				else{
				 $class="rw0";}
			
			$inx++;
			$outHtml .= '
				 <tr class='.$class.'>
					<td>'.$inx.'</td>
					<td>'.$row['ug_id'].'</td>
					<td>'.$row['ug_category'].'</td>
					
					<td><a href="?pg=prodMgmtPg&cmd=dspGUserFrmEdit&ug_id='.$row['ug_id'].'">ويرايش</a></td>
					  <td>&nbsp;&nbsp;</td>
				       
					<td><a href="?pg=prodMgmtPg&cmd=deleteUserGroup&ug_id='.$row['ug_id'].'">حذف</a></td>
					
				</tr>
				
			';
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '  <tr class="rw0">
	      	   
				       <td>&nbsp;&nbsp;
				       </td>
			      	
				     <td colspan="3"> <button name="subject" type="submit"  onclick="return check()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"
				                              > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
	      	</table>'.getNavBar_categoryG().' '.getRPPCombo_categoryG();
    return $outHtml;
		
}
function getNavBar_categoryG(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setPg&pgNum=1" >اول</a></td>
		<td>&nbsp;&nbsp;</td>		       
		<td><a href="?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" >قبلي</a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=getProvinceNameList&cmd2=setPg&pgNum='.($stNum+$inx).'" >'.($stNum+$inx).'</a></td>
			<td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getcategoryNameList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" >بعدي</a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getcategoryNameList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" >last</a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_categoryG(){
	$out = '
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=ListAccessMenu&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width: 50px;">
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		پاسخ در صفحه
<br></br>	';
	return $out;
}
function editmojavezfrm(){
	
$phm_id = isset($_REQUEST['phm_id']) ? (int)($_REQUEST['phm_id']) : 0;
	if($phm_id<1) die('Invalid  id!');	
	
	$query="select * FROM dm_op_mojavez  opm   
	               left join  dm_operation_acc  op_acc 
	                   on opm.phm_op_id=op_acc.g_id
		WHERE 
			phm_id_province= ".$_SESSION['dm_user_profile']['u_province_id']."
			
	    AND
	       phm_id=".$phm_id."";
			

	 $lnk = mysql_query($query);
	  $row= mysql_fetch_assoc($lnk);
	
	?>
	  <link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	<script type="text/javascript">
	$(function() {
			    
		        //-----------------------------------
		        // انتخاب با کليک بر روي عکس
		        $("#phm_date_f").datepicker({
		            showOn: 'button',
		            buttonImage: 'lib/styles/images/calendar.png',
		            buttonImageOnly: true
		        });
		    })
		$(function() {
		    
		        //-----------------------------------
		        // انتخاب با کليک بر روي عکس
		        $("#phm_date_l").datepicker({
		            showOn: 'button',
		            buttonImage: 'lib/styles/images/calendar.png',
		            buttonImageOnly: true
		        });
		    })
		    
		    
	function validateAndSaveDoc(){
		
	  if(fObj('phm_mojavez').value==''){
			
			alert('لطفا شماره مجوز را وارد کنيد');
			return;
		}
		if(fObj('phm_op_id').value==-2){
		
			      if(fObj('phm_op_id').value==-2){
				
				alert('لطفا نوع عمليات را وارد کنيد');
				return;
			}
	      if(fObj('phm_date_f').value==''){
				
				alert('لطفا تاريخ شروع را وارد نماييد');
				return;
			}
	      if(fObj('phm_date_l').value==''){
				
				alert('لطفا تاريخ پايان را وارد نماييد');
				return;
			}   
	      if(fObj('phm_type_id').value==''){
				
				alert('لطفا نوع را وارد نمایید');
				return;
			} 
	      if(fObj('phm_amount').value==''){
				
				alert('مقدار مجاز وارد شود');
				return;
			} 
		}
	   
		edit_mojavez();
	   
//	   if($_SESSION['checkCodeDoc']==0){
//		   window.open('?pg=havaleMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountNum='+fObj('d_accountNum').value+'&d_branch='
//		   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value , '_self');
//	   }

	}
	<?php 
	    $gdate=$row['phm_date_f'];
		list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
		list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
		if($jmonth<=9){
		       $jmonth='0'.$jmonth;  
		     }
		if($jday<=9){
		       $jday='0'.$jday;  
		     }
		     $phm_date_f = $jday."/".$jmonth."/".$jyear;
			
		//
		 $gdate=$row['phm_date_l'];
		list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
		list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
		if($jmonth<=9){
				       $jmonth='0'.$jmonth;  
				     }
				if($jday<=9){
				       $jday='0'.$jday;  
				     }
		$phm_date_l = $jday."/".$jmonth."/".$jyear;
		//echo $row['phm_op_id'];
	?>
  </script>
          <form action="" >
            <input name="phm_id" id="phm_id"  type="hidden"   value="<?php echo $phm_id  ?>"></input>
         </form>
		<table  align="center"  class="nasi"  width="50%" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">ویرایش مجوز</font></b></td>
	        </tr>
	     
	      	<tr >
		        <td  align="center"><center>شماره مجوز </center> </td>
		        <td><input name="phm_mojavez" id="phm_mojavez"  value="<?php echo $row['phm_mojavez'] ?>" type="text" class="chk" /></td>
		        <td ><center> نوع عمليات</center> </td>
		        <td>
			  		<?php echo  getopTypesComboBox('phm_op_id',$row['phm_op_id'])?>
				</td> 
	        </tr>
	        <tr>
		       <td>تاريخ شروع</td>
		       <td><input name="phm_date_f"  id="phm_date_f"   value="<?php echo $phm_date_f ?>"  type="text" /></td>
		       <td>تاريخ پايان:</td>
		       <td><input name="phm_date_l"  id="phm_date_l"   value="<?php echo $phm_date_l ?>"  type="text" /></td>
			</tr>
			  <tr>
		       <td>دسته</td>
		       <td><?php echo getCategoryTypesComboBoxr('phm_type_id',$row['phm_type_id'])?></td>
		       <td ><center>نوع </center> </td>
			  <td>
			  		<?php echo getTypesComboBox('p_type',$row['phm_ptype'])?>
			</tr>
 <tr >
		        <td  align="center"><center>مقدار مجاز </center> </td>
		        <td><input name="phm_amount" id="phm_amount"  value="<?php echo $row['phm_amountpre'] ?>" type="text" class="chk" /></td>
		         
	        </tr>
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>      	
			     <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveDoc();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	      	</tr>
	    </table>
<!--	</form> -->
	    
	<?php
	
	
	
}

function dspCategoryNameFrmEdit(){
	
	$category_id = isset($_REQUEST['category_id']) ? (int)($_REQUEST['category_id']) : 0;
	if($category_id<1) die('Invalid  id!');
	
	$lnk = mysql_query("SELECT * FROM  dm_customer_category WHERE category_id=".$category_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid  id2!');
	}
		?>
	

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="upCategoryName">   
		<input type="hidden" name="province_id" value="<?php echo $category_id; ?>">   
		<table  align="center" class="nasi" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		     <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">ليست دسته بندي ها</font></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>	
	      	<tr>
		       	<td ><center>كد دسته بندي </center> </td>
		         <td><input name="category_code" type="text" value="<?php echo $row['category_code']; ?>" /></td>
				<td >نام دسته بندي </td>
				 <td><input name="category_name" type="text" value="<?php echo $row['category_name']; ?>" /></td>
		     
	        </tr>
		    <tr>  				    
			      	
			     <td colspan="3"> <button name="subject" type="submit"  " value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"
			                              > ذخيره</button></td>
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				        
	      	</tr>
	    </table>
	</form>
	
	<?php
}

function dspGUserFrmEdit(){
	
	$ug_id = isset($_REQUEST['ug_id']) ? (int)($_REQUEST['ug_id']) : 0;
	if($ug_id<1) die('Invalid  id!');
	
	$lnk = mysql_query("SELECT * FROM  dm_userGroup WHERE ug_id=".$ug_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid  id2!');
	}
		?>
	

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="upGroupUser">   
		<input type="hidden" name="province_id" value="<?php echo $ug_id; ?>">   
		<table  align="center" class="nasi" >
		  	<tr align="middle" >
		     <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">ليست گروه ها</font-size></td>
	        </tr>
	      	<tr>
		       	<td ><center>كد گروه </center> </td>
		          <td><input name="ug_id" type="text" value="<?php echo $row['ug_id']; ?>" /></td>
				<td >نام گروه </td>
				  <td><input name="ug_category" type="text" value="<?php echo $row['ug_category']; ?>" /></td>
		     
	        </tr>
		    <tr>
	      	       
				       <td>&nbsp;&nbsp;
				       </td>
			      	
				     <td colspan="3"> <button name="subject" type="submit"  " value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"
				                              > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				         
	      	</tr>
	    </table>
	</form>
	
	<?php
}


function upCategoryName(){
	$category_id = isset($_REQUEST['category_id']) ? (int)($_REQUEST['category_id']) : 0;
	if($category_id<1) die('Inv Id');
	
	$category_code = isset($_POST['category_code']) ? $_POST['category_code'] : '';
	$category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';

	$query = "
		UPDATE dm_customer_category
		SET 
			`category_code` = '".$category_code."',
            `category_name` = '".$category_name."'
		WHERE 
			`category_id` = ".$category_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function upGroupUser(){
	$ug_id = isset($_REQUEST['ug_id']) ? (int)($_REQUEST['ug_id']) : 0;
	if($ug_id<1) die('Inv Id');
	
	$ug_category = isset($_POST['ug_category']) ? $_POST['ug_category'] : '';
		
	$query = "
		UPDATE dm_usergroup
		SET 
			`ug_category` = '".$ug_category."'
							
		WHERE 
			`ug_id` = ".$ug_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function DeleteGroup(){
	$ug_id = isset($_REQUEST['ug_id']) ? (int)($_REQUEST['ug_id']) : 0;
	$query = "
	DELETE FROM   dm_usergroup
 
		WHERE 
			ug_id = ".$ug_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$query1="SELECT * FROM dm_list_group_rel WHERE rel_ug_id=".$ug_id." ";
	$lnk1 = mysql_query($query1);
	$row1 = mysql_fetch_assoc($lnk1);
	if(mysql_affected_rows()>0){
		while($row1 = mysql_fetch_assoc($lnk1)){
			
		$query = "
				DELETE FROM   dm_list_group_rel
			 
					WHERE 
						rel_ug_id = ".$ug_id." 
				";
				$lnk = mysql_query($query);
				if(mysql_error()) print mysql_error();
						
		}
	}
}
function dspInseNewUserFrm(){
	$_SESSION['ug']=1;
	?>
	<script>
	function validateAndsaveUser(){
		if(fObj('u_name').value==''){
			alert('لطفا نام را وارد کنید');
		return;
		}
		if(fObj('u_family').value==''){
			alert('لطفا نام خانوادگی را وارد کنید');
		return;
		}
		if(fObj('u_user_name').value==''){
			alert('لطفا نام کاربری را وارد کنید');
		return;
		}
		
		if(fObj('u_pass_word').value==''){
			alert('لطفا رمز عیور را وارد کنید');
		return;
		}
		if(fObj('u_pass_word_again').value==''){
			alert('لطفا رمز عبور را دوباره  وارد کنید');
		return;
		}
		if(fObj('u_phone').value==''){
			alert('لطفا تلفن را وارد کنید');
		return;
		}
		if(fObj('u_pass_word').value==''){
			alert('رمز ورود را وارد کنید');
		return;
		}
		if(fObj('u_pass_word_again').value!=fObj('u_pass_word').value){
			alert('تکرار رمز عبور صحیح نیست');
		return;
		}
		
		validusername();

		
	}
	
	</script>
	<br>
	
	<form method="post" action="" >
	   	
<!--		<input type="hidden" name="pg" value="prodMgmtPg">   -->
<!--		<input type="hidden" name="cmd" value="regNewUser">   -->
		<table  align="center"  class="nasi"  >
		  <tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			     <td colspan="9"  style="height: 50px;vertical-align:middle;" ><b><font size="5">مشخصات كاربر</font></b></td>
	      </tr>
	      <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	      </tr>  
	      <tr>
		       	<td ><center> نام  </center> </td>
			  	<td><input name="u_name" id="u_name" type="text"  /></td>
				<td >نام خانوادگي </td>
		        <td><input name="u_family" id="u_family" type="text"  /></td>
	      </tr>
	      <tr>
		        <td ><center>نام كاربري </center> </td>
		        <td><input name="u_user_name" id="u_user_name" type="text"  /></td>
		        <td  align="center"><center>ايميل </center> </td>
		        <td><input name="u_email" id="u_email" type="text"  /></td>
		       	      
	        </tr>
	        <tr>
	            <td ><center>رمز عبور </center> </td>
		        <td><input name="u_pass_word" id="u_pass_word" type="password"  /></td>
		         <td ><center>تکرار رمز عبور</center> </td>
		        <td><input name="u_pass_word_again" id="u_pass_word_again" type="password"  /></td>	
	        </tr>
	      	<tr>
		       
		        <td align="center">تلفن </td>
		        <td><input name="u_phone" id="u_phone" type="text"  /></td>
		        <td ><center>گروه </center> </td>
                <td><?php echo getAccessMenuCombo('NameGroupCombo') ?> </td>
	        </tr>
	      	<tr>
		        <td ><center>استان </center> </td>
		        <td>
			  		<?php echo getNameProvinceCombooo('NameProvinceCombo1')?>
				</td>
				 <td ><center>شهر </center> </td>
		        <td>
			  		<span id="getCityCombo"></span>
				</td>
						      	  
	      	</tr>
	      	<tr>
		        <td ><center>سال كاري </center> </td>
		        <td>
			  		<?php echo getNameYearCombo('NameYearCombo')?>
				</td>
								      	  
	      	</tr>
			<tr>
	      	         
				      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				       
				     <td colspan="3"> <button name="subject" type="button" value="CSS" onclick="validateAndsaveUser()"class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
		       	
	    </table>
	</form>
	  
	<?php

}
function regNewUser(){
	
//print_r($_REQUEST);
  if($_SESSION['ug']==1){
	$u_name = isset($_REQUEST['u_name']) ? $_REQUEST['u_name'] : '';
	$u_family = isset($_REQUEST['u_family']) ? ($_REQUEST['u_family']) : '';
	$u_user_name = isset($_REQUEST['u_user_name']) ? ($_REQUEST['u_user_name']) : '';
	$u_email = isset($_REQUEST['u_email']) ? ($_REQUEST['u_email']) : '';
	$u_pass_word = isset($_REQUEST['u_pass_word']) ? ($_REQUEST['u_pass_word']) : '';	
	$u_phone = isset($_REQUEST['u_phone']) ? ($_REQUEST['u_phone']) : '';
	$u_group_menu_id = isset($_REQUEST['u_group_menu_id']) ? ($_REQUEST['u_group_menu_id']) : '';
	$u_province_id = isset($_REQUEST['u_province_id']) ? $_REQUEST['u_province_id'] : '';
    $u_city_id = isset($_REQUEST['u_city_id']) ? $_REQUEST['u_city_id'] : '';
    $u_year_id = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
	 echo $u_province_id;
//	
//	$selectedMenu=',';
//	foreach($GLOBALS['allMenus'] as $key=>$value ){
//		if($_REQUEST['menuChkBx_'.$key]=='on') $selectedMenu.= $key.',';
//	}
	$query = array(
	    'u_name' => $u_name,
		'u_family' => $u_family,
		'u_user_name' => $u_user_name,
		'u_pass_word' => md5($u_pass_word),
	   
	    'u_email' => $u_email,
		'u_phone' => $u_phone,
	    'u_group_menu_id' => $u_group_menu_id,
	    'u_province_id' => $u_province_id,
	    'u_city_id' => $u_city_id,
	    'u_year_id' => $u_year_id,
	);
	
global $general;
	$query = inserterQMaker('dm_user_profile', $query);
//	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$um_u_id = mysql_insert_id();
	$query="SELECT * FROM  dm_list_group_rel WHERE rel_ug_id=".$u_group_menu_id."";
///	print $query;
	$lnk = mysql_query($query);
	while($row = mysql_fetch_assoc($lnk)){
		
		$query1 = "
		INSERT INTO  dm_um_rel 
			( 
				`um_u_id`, 
				`um_menu_id` 	
			)
			
		VALUES
			(
				'".$um_u_id."', 
				'".$row['rel_menu_id']."' 
					
			)
	";
//	print $query1;
	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();

	}
	$_SESSION['ug']=0;
  }
  $_SESSION['ug']=0;
 }
 function getUserList(){
  	
		?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>		
	<?php 
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;				
		}
	}
	$outHtml = '<br>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchUseName"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;"/> 
			<button type="submit" name="Search" value="Search" />جستجو</button></div>
			
		</form>
	';
			
	$outHtml .= '	
		<div align = "center">
		<div align = "center" style="height:200px; overflow:auto">
			<table  border="2" align="center" cellpadding="0" cellspacing="0" class="list" style="width:95%;">
      			<tr class="rw0" >
        			<th colspan="19" align="center" scope="row" style="height: 50px;vertical-align:middle;" ><center>اسامي كاربرها </center></th>
        		</tr>
      			<tr class="rw1">
      		    	<td align="center">رديف</td>
			        <td align="center">نام</td>
			        <td align="center">نام خانوادگي</td>
			        <td align="center">كد كاربري </td>';
//	if($_SESSION['dm_user_profile']['u_id']== 3){
//			        $outHtml .= '  <td align="center">كلمه عبور</td>';
 //}
			        $outHtml .= '  <td align="center">ايميل</td>
			        <td align="center">تلفن </td>
			        <td align="center">استان </td>
			        <td align="center">شهر</td>  
			        <td align="center">سال فعال</td>
					<td align="center">&nbsp;</td>
					 <td align="center">&nbsp;</td>
					 <td align="center">&nbsp;</td>					
				</tr>
	';	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					u_name LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					u_family LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
	 $query4="SELECT * FROM dm_user_profile WHERE u_id=".$_SESSION['dm_user_profile']['u_id']."
								            AND
								           u_province_id=". 100 ."";
	$lnk4 = mysql_query($query4);
	$row4= mysql_fetch_assoc($lnk4);
	if($row4['u_province_id']==100){
	
	$genQuery = "
		
		FROM 
			dm_user_profile 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	}else{
		
	$genQuery = "
		
		FROM 
			dm_user_profile 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		AND
		u_province_id=".$_SESSION['dm_user_profile']['u_province_id']."";	
	
		
	}
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';
	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$inx--;
	if(mysql_affected_rows()>0){
		while($row = mysql_fetch_assoc($lnk)){
			  if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
			$inx++;
		
			$queryp = "
		       SELECt * FROM dm_province
	 
		     	WHERE 
				province_id = ".$row['u_province_id']." 
			
		";
		$lnkp = mysql_query($queryp);
		
		 if(mysql_affected_rows()>0){ 
		 	$rowp = mysql_fetch_assoc($lnkp);
		 	$province_name=$rowp['province_name'];
		 }else{
		 	$province_name='همه استانها';
		 }
		$queryY = "
		       SELECt * FROM dm_year
	 
		     	WHERE 
				year_id = ".$row['u_year_id']." 
			
		";
		$lnkY = mysql_query($queryY);
		 if(mysql_affected_rows()>0){ 
		$rowY = mysql_fetch_assoc($lnkY);
		$year_name=$rowY['year_name'];
		 }else{
		 	$year_name='همه سالها';
		 }
		$queryc = "
		       SELECt * FROM dm_city	 
		     	WHERE 
				city_id = ".$row['u_city_id']." ";	
//		print $queryc;
		$lnkc = mysql_query($queryc);
		$rowc = mysql_fetch_assoc($lnkc);
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['u_name'].'</td>
					<td align="center">'.$row['u_family'].'</td>
					<td align="center">'.$row['u_user_name'].'</td>';
		//	if($_SESSION['dm_user_profile']['u_id']== 3){
			//	 $outHtml .= '<td align="center">'.$row['u_pass_word2'].'</td>';
				
		//	}
	    $outHtml .= '<td align="center">'.$row['u_email'].'</td>
					<td align="center">'.$row['u_phone'].'</td>		
					<td align="center">'.$province_name.'</td>
					<td align="center">'.$rowc['city_name'].'</td>
					<td align="center">'.$year_name.'</td>';
															
			  $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'513\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=dspUserNameFrmEdit&u_id='.$row['u_id'].'"><img src="images/edit.png" title="ويرايش" style="width:20px;height:20px;"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png" style="width:20px;height:20px;" title="ويرايش" ></img></a></td>';
						
					}
		 $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'513\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg&cmd=deleteUserName&u_id='.$row['u_id'].'"><img src="images/delete.PNG" title="حذف" style="width:20px;height:20px;" ></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG" style="width:20px;height:20px;" title="حذف"></img></a></td>';
						
					}
			     $outHtml .= ' <td align="center"><a href="?pg=prodMgmtPg&cmd=ShowAccess&ug_id='.$row['u_group_menu_id'].'&u_id='.$row['u_id'].'"><img src="images/display.png" title="مشاهده" style="width:20px;height:20px;"></img></a></td>';
				$outHtml .= '</tr>
			';
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
 	}
    $outHtml .= '</table></div>'.getNavBar_User().' '.getRPPCombo_User();
    echo $outHtml;
		
}

function getNavBar_User(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getUserList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
        <td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getUserList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>	
       <td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=getUserList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>	
           <td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=getUserList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=getUserList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_User(){
	$out = '
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=getUserList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;">
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	';
	return $out;
}
 

 

function dspUserNameFrmEdit(){
?>
	<script>
	function validateAndsaveUser(){
		if(fObj('u_name').value==''){
			alert('لطفا نام را وارد کنید');
		return;
		}
		if(fObj('u_family').value==''){
			alert('لطفا نام خانوادگی را وارد کنید');
		return;
		}
		if(fObj('u_user_name').value==''){
			alert('لطفا نام کاربری را وارد کنید');
		return;
		}
		if(fObj('u_email').value==''){
			alert('لطفا ایمیل را وارد کنید');
		return;
		}
		if(fObj('u_pass_word').value==''){
			alert('لطفا رمز عیور را وارد کنید');
		return;
		}
		if(fObj('u_pass_word_again').value==''){
			alert('لطفا رمز عبور را دوباره  وارد کنید');
		return;
		}
		if(fObj('u_phone').value==''){
			alert('لطفا تلفن را وارد کنید');
		return;
		}
		if(fObj('u_pass_word').value==''){
			alert('رمز ورود را وارد کنید');
		return;
		}
		if(fObj('u_pass_word_again').value!=fObj('u_pass_word').value){
			alert('تکرار رمز عبور صحیح نیست');
		return;
		}
		if(fObj('NameProvinceCombo1').value==''){
			alert('استان وشهر را انتخاب کنید');
		return;
		}
		window.open('?pg=prodMgmtPg&cmd=upUserName&u_name='+fObj('u_name').value+'&u_family='+fObj('u_family').value+'&u_user_name='+fObj('u_user_name').value
				+'&u_email='+fObj('u_email').value+'&u_pass_word='+fObj('u_pass_word').value+
				'&u_phone='+fObj('u_phone').value+'&NameProvinceCombo1='+fObj('NameProvinceCombo1').value+'&u_city_id='+fObj('u_city_id').value+'&NameGroupCombo='+fObj('NameGroupCombo').value+'&u_id='+fObj('u_id').value+'&year_id='+fObj('NameYearCombo').value,'_self');
		
	}
	
	</script>
	<?php
	
   $u_id = isset($_REQUEST['u_id']) ? (int)($_REQUEST['u_id']) : 0;
	if($u_id<1) die('Invalid  id!');
	
	$lnk = mysql_query("SELECT * FROM  dm_user_profile WHERE u_id=".$u_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid  id2!');
	}
		?>
	
	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="upUserName">   
		<input type="hidden" name="u_id" id="u_id" value="<?php echo $u_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">اسامي كاربرها</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	      </tr>

	      	<tr>
		       	<td ><center>نام </center> </td>
		        <td><input name="u_name" id="u_name" type="text" value="<?php echo $row['u_name']; ?>" /></td>
				<td >نام خانوادگي </td>
		        <td><input name="u_family" id="u_family"  type="text" value="<?php echo $row['u_family']; ?>" /></td>
		     
	        </tr>
	      	<tr>
		        <td ><center>نام كاربري </center> </td>
		        <td><input name="u_user_name" id="u_user_name" type="text" value="<?php echo $row['u_user_name']; ?>" /></td>
		         <td ><center>ايميل </center> </td>
		        <td><input name="u_email" id="u_email" type="text" value="<?php echo $row['u_email']; ?>" /></td>
		       
	        </tr>
	        <tr>
	             <td ><center>رمز عبور </center> </td>
		        <td><input name="u_pass_word" id="u_pass_word" type="password" value="<?php echo $row['u_pass_word2']; ?>" /></td>
		        <td ><center>تکرار رمز عبور</center> </td>
		        <td><input name="u_pass_word" id="u_pass_word_again" type="password"  value="<?php echo $row['u_pass_word2']; ?>"/></td>
	        </tr>
	        <tr>
		       
		        <td ><center>تلفن </center> </td>
		        <td><input name="u_phone" id="u_phone" type="text" value="<?php echo $row['u_phone']; ?>" /></td>
		        <td ><center>گروه </center> </td>
                <td><?php echo getAccessMenuCombo() ?> </td>
	        </tr>
	      
		     <tr>
		       <td ><center>استان </center> </td>
		       <td>
			  		<?php echo getNameProvinceCombo('NameProvinceCombo1')?>
			   </td>
				<td ><center>شهر </center> </td>
		        <td>
			  		<span id="getCityCombo"></span>
				</td>
		      
	      	</tr>
	      	<tr>
		        <td ><center>سال كاری </center> </td>
		        <td>
			  		<?php echo getNameYearCombo('NameYearCombo',$row['u_year_id'])?>
				</td>								      	  
	      	</tr>
	      	
				<tr>
	      	      
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
				      			      	
				     <td colspan="3"> <button name="subject" type="button" value="CSS" onclick="validateAndsaveUser()"class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				         
	      	</tr>
				
	    </table>
	</form>
	<td>
	<?php
}
		        
function upUserName()
{

   $u_id = isset($_REQUEST['u_id']) ? (int)($_REQUEST['u_id']) : 0;
	if($u_id<1) die('Inv Id');
	$u_name = isset($_REQUEST['u_name']) ? $_REQUEST['u_name'] : '';
	$u_family = isset($_REQUEST['u_family']) ? ($_REQUEST['u_family']) : '';
	$u_user_name = isset($_REQUEST['u_user_name']) ? ($_REQUEST['u_user_name']) : '';
	$u_email = isset($_REQUEST['u_email']) ? ($_REQUEST['u_email']) : '';
	$u_pass_word = isset($_REQUEST['u_pass_word']) ? ($_REQUEST['u_pass_word']) : '';	
	$u_phone = isset($_REQUEST['u_phone']) ? ($_REQUEST['u_phone']) : '';
	$u_group_menu_id = isset($_REQUEST['u_group_menu_id']) ? ($_REQUEST['u_group_menu_id']) : '';
	$u_province_id = isset($_REQUEST['NameProvinceCombo1']) ? $_REQUEST['NameProvinceCombo1'] : '';
    $u_city_id = isset($_REQUEST['u_city_id']) ? $_REQUEST['u_city_id'] : '';
    $u_year_id = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
   
//$selectedMenu=',';
//	foreach($GLOBALS['allMenus'] as $key=>$value ){
//		if($_REQUEST['menuChkBx_'.$key]=='on') $selectedMenu.= $key.',';
//	}
	
	$query = "
		UPDATE  dm_user_profile
		SET 
			`u_name` = '".$u_name."',
		    `u_family` = '".$u_family."',
			`u_user_name` = '".$u_user_name."',
			`u_pass_word` = '".md5($u_pass_word)."',
			
			`u_email` = '".$u_email."',
			`u_group_menu_id` = '".$u_group_menu_id."',
			`u_province_id` = '".$u_province_id."',
			`u_year_id` = '".$u_year_id."',
			`u_city_id` = '".$u_city_id."'
			
		WHERE 
			`u_id` = ".$u_id." 
	";
//	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function getCategoryCustCombo($id='CategorycustCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" >';
	$lnk = mysql_query("SELECT * FROM dm_customer_category ORDER BY category_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['category_id'].'" >'.$row['category_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}
function getProvinceCombo($id='ProvinceCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" >';
	$lnk = mysql_query("SELECT * FROM dm_province ORDER BY province_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['province_id'].'" >'.  $row['province_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}

function getNameProvinceCombo($id='NameProvinceCombo1', $sCust=false){
	 
	$u_id = isset($_REQUEST['u_id']) ? (int)($_REQUEST['u_id']) : 0;
	$lnk = mysql_query("SELECT * FROM dm_user_profile where u_id=".$u_id."");
	$row=mysql_fetch_assoc($lnk);
	if($row['u_province_id']==100){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="GetCityCombo(\'\', this.value)"><option value="'. 100 .'" style="width:80px;" >همه استانها </option>';
	}else{
		
		$lnk1 = mysql_query("SELECT * FROM dm_province where province_id=".$row['u_province_id']."");
	    $row1=mysql_fetch_assoc($lnk1);
		$out = '<select id="'.$id.'" name="'.$id.'"><option value="'. $row1['province_id'] .'" style="width:80px;" >'. $row1['province_name'] .' </option>';
		
	}
	$lnk = mysql_query("SELECT * FROM dm_province where 1 ORDER BY province_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['province_id'].'" >'.$row['province_name'].'</option>';
			
		}
		
		$out .= '<option value="100" >همه استانها</option>';
	}
	$out .= '</select>';
	return $out;
}
function getNameProvinceCombooo($id='NameProvinceCombo1', $sCust=false){
	 
	$u_id = isset($_REQUEST['u_id']) ? (int)($_REQUEST['u_id']) : 0;
	$lnk = mysql_query("SELECT * FROM dm_user_profile where u_id=".$u_id."");
	$row=mysql_fetch_assoc($lnk);
	//if($row['u_province_id']==100){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="GetCityCombo(\'\', this.value)"><option value="'. 100 .'" style="width:80px;" >همه استانها </option>';
//	}else{
		
	//	$lnk1 = mysql_query("SELECT * FROM dm_province where province_id=".$row['u_province_id']."");
	//    $row1=mysql_fetch_assoc($lnk1);
	//	$out = '<select id="'.$id.'" name="'.$id.'"><option value="'. $row1['province_id'] .'" style="width:80px;" >'. $row1['province_name'] .' </option>';
		
//	}
	$lnk = mysql_query("SELECT * FROM dm_province where 1 ORDER BY province_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['province_id'].'" >'.$row['province_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}
function getNameYearCombo($id, $u_year_id){ 
	
	$u_id = isset($_REQUEST['u_id']) ? (int)($_REQUEST['u_id']) : '';
	$lnk = mysql_query("SELECT * FROM dm_user_profile where u_id=".$u_id."");
//	echo "SELECT * FROM dm_user_profile where u_id=".$u_year_id."";
	$row=mysql_fetch_assoc($lnk);
	if($row['u_year_id']==100){
	$out = '<select id="'.$id.'" name="'.$id.'"><option value="'. 100 .'" style="width:80px;" >همه سالها </option>';
	$nasim=100;
	}else{
		
		$lnk1 = mysql_query("SELECT * FROM dm_year where year_id=".$row['u_year_id']."");
		//echo "SELECT * FROM dm_year where year_id=".$row['u_year_id']."";
	     $row1=mysql_fetch_assoc($lnk1);
			$out = '<select id="'.$id.'" name="'.$id.'"><option value="'. $row1['year_id'] .'" style="width:80px;" >'. $row1['year_name'] .' </option>';
	   //  <option value="'. $row1['year_id'] .'" style="width:80px;" >'. $row1['year_name'] .' </option>
	   $nasim=$row1['year_id'];
		
	}
	
	if($nasim==0){
		
		$nasim=100;
	}	
	
	$lnk = mysql_query("SELECT * FROM dm_year where year_id !=". $nasim ." ORDER BY year_name");
	//echo "SELECT * FROM dm_year where year_id !=". $row1['year_id'] ." ORDER BY year_name";
	
	if(mysql_affected_rows()>0){
		if($row['u_year_id']!=100){
		$out .= '<option value="'. 100 .'" >همه سالها</option>';
		}
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['year_id'].'" >'. $row['year_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}
function getNameProvinceCombou($id='NameProvinceCombo', $sCust=false){

	$out = '<select id="'.$id.'" name="'.$id.'" style="width:150%;">';
	
	if ($_SESSION['dm_user_profile']['u_group_menu_id'] == 1){
		
	     $lnk = mysql_query("SELECT * FROM dm_province "); 
	     $row=mysql_fetch_assoc($lnk);
		     
		   while($row=mysql_fetch_assoc($lnk)){
		
			$out .= '<option value="'.$row['province_id'].'" >'. $row['province_name'].'</option>';
		   }
		
			
	}
	else{
	       $lnk = mysql_query("SELECT * FROM dm_province WHERE province_id={$_SESSION['dm_user_profile']['u_province_id']} ");
	        $row=mysql_fetch_assoc($lnk);
	
	
		$out .= '<option value="'.$row['province_id'].'" >'. $row['province_name'].'</option>';
	
			}
	
	
	$out .= '</select>';
	return $out;
}

function getNameCityCombo($id='NameProvinceCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" >';
	
	$lnk = mysql_query("SELECT * FROM dm_city where city_province=".$_SESSION['dm_user_profile']['u_province_id']." ORDER BY city_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['city_id'].'" >'.$row['city_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}

function getListMenuscheckBox($id='NameMenuesCombo', $sCust=false){
	$out='<table>
	       <tr>	 
	';
	$lnk = mysql_query("SELECT * FROM dm_listmenu ORDER BY menu_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .='<td><input type="checkbox" value="'.$row['menu_id'].'"  id="menuChkBx_'.$menu_id.'"  name="menuChkBx_'.$menu_id.'" > '.$row['menu_name'].'<span style="cursor:pointer"  onclick="AddAMenuToList(\'\', \''.$row['menu_id'].'\') " this.style.display=\'none\'"><font color="red">+</font></span></td>';			
		}
	}
	$out .= '</tr></table>';
	return $out;
}

function getAccessMenuCombo($id='NameGroupCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  onchange="hndlMenuComboChng(\'\', this.value)">';
	$lnk = mysql_query("SELECT * FROM dm_usergroup ORDER BY ug_id");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['ug_id'].'" >'.$row['ug_category'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function deleteUserName(){
	$u_id = isset($_REQUEST['u_id']) ? (int)($_REQUEST['u_id']) : 0;
	if($u_id<1) die('Inv Id');
	
	$query = "
	DELETE FROM   dm_user_profile
 
		WHERE 
			u_id = ".$u_id." 
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}

function ContactUs(){
?>


	<script src="lite_validation.js"></script>
	<script>
	required.add('Full_Name','NOT_EMPTY','Full Name');
	required.add('Email_Address','EMAIL','Email Address');
	required.add('Your_Message','NOT_EMPTY','Your Message')
	</script>
	<link rel="stylesheet" type="text/css" href="lite_styles.css">
	
	<table >
	<tr>
	   
	<td width="50%">
	
			<form name="contactformlite" method="post" action="lite_process.php" onsubmit="return validate.check(this)">
			<table width="400px" class="cflite">
			<tr>
			 <td colspan="2">
			  <p style="text-align:center">فیلد های با <span class="required_star"> * </span> الزامی هستند.</p>
			 </td>
			</tr>
			<tr>
			<td valign="top" class="cflite_td">
			  <label for="Full_Name" class="required">نام<span class="required_star"> * </span></label>
			 </td>
			 <td valign="top" class="cflite_td">
			  <input type="text" name="Full_Name" id="Full_Name" maxlength="80" style="width:250px">
			 </td>
			 
			
			</tr>
			<tr>
			 <td valign="top" class="cflite_td">
			  <label for="Email_Address" class="required">آدرس ایمیل<span class="required_star"> * </span></label>
			 </td>
			<td valign="top" class="cflite_td">
			  <input type="text" name="Email_Address" id="Email_Address" maxlength="100" style="width:250px">
			 </td>
		 
			</tr>
			<tr>
			<td valign="top" class="cflite_td">
			  <label for="Telephone_Number" class="not-required">شماره تلفن</label>
			 </td>
			 <td valign="top" class="cflite_td">
			  <input type="text" name="Telephone_Number" id="Telephone_Number" maxlength="100" style="width:250px">
			 </td>	
			</tr>
			<tr>
			 <td valign="top" class="cflite_td">
			  <label for="Your_Message" class="required">پیام شما<span class="required_star"> * </span></label>
			 </td>
			 <td valign="top" class="cflite_td">
			  <textarea style="width:250px;height:120px" name="Your_Message" id="Your_Message" maxlength="2000"></textarea>
			 </td>	
			</tr>
			<tr>
			 <td colspan="2" style="text-align:center"  class="cflite_td">
			  <button type="submit" >بفرست </button>
			  <br /><br />
			  <!-- Please support our efforts by keeping this link intact -->
			  <br /><br />
			 </td>
			</tr>
			</table>
	
	</form>
	</td>
	</tr>
	</table>


	
	<?php 

}
function dspcalender(){
	?>
	<CENTER>
<FORM name="Keypad" action="">
<TABLE border=0 width=50 height=60 cellspacing=5 style="border: 1px solid #CC3300">
<TR>
<TD colspan=3 >
<input name="ReadOut" type="Text" size=24 value="0" width=100%>
</TD>
<TD>
</TD>
<TD style="border: 1px solid #CCCCFF" align="center">
<input name="btnClear" type="button" value="  C  " onclick="Clear()" style="width: 40">
</TD>
<TD style="border: 1px solid #CCCCFF" align="center">
<input name="btnClearEntry" type="button" value="  CE " onclick="ClearEntry()" style="width: 40">
</TD>
</TR>
<TR>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnSeven" type="Button" value="  7  " onclick="NumPressed(7)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnEight" type="Button" value="  8  " onclick="NumPressed(8)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnNine" type="Button" value="  9  " onclick="NumPressed(9)">
</TD>
<TD height="30">
</TD>
<TD style="border: 1px solid #CCCCFF" align="center" height="30">
<input name="btnNeg" type="button" value=" +/- " onclick="Neg()" style="width: 40">
</TD>
<TD style="border: 1px solid #CCCCFF" align="center" height="30">
<input name="btnPercent" type="button" value="  % " onclick="Percent()" style="width: 40">
</TD>
</TR>
<TR>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnFour" type="Button" value="  4  " onclick="NumPressed(4)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnFive" type="Button" value="  5  " onclick="NumPressed(5)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnSix" type="Button" value="  6  " onclick="NumPressed(6)">
</TD>
<TD height="30">
</TD>
<TD align=middle style="border: 1px solid #CCCCFF" height="30">
<input name="btnPlus" type="button" value="  +  " onclick="Operation('+')" style="width: 40">
</TD>
<TD align=middle style="border: 1px solid #CCCCFF" height="30">
<input name="btnMinus" type="button" value="   -   " onclick="Operation('-')" style="width: 40">
</TD>
</TR>
<TR>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnOne" type="Button" value="  1  " onclick="NumPressed(1)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnTwo" type="Button" value="  2  " onclick="NumPressed(2)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnThree" type="Button" value="  3  " onclick="NumPressed(3)">
</TD>
<TD height="30">
</TD>
<TD  style="border: 1px solid #CCCCFF" height="30">
<input name="btnMultiply" type="button" value="  ×  " onclick="Operation('*')" style="width: 40">
</TD>
<TD  style="border: 1px solid #CCCCFF" height="30">
<input name="btnDivide" type="button" value="   /   " onclick="Operation('/')" style="width: 40">
</TD>
</TR>
<TR>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnZero" type="Button" value="  0  " onclick="NumPressed(0)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnDecimal" type="Button" value="   .  " onclick="Decimal()">
</TD>
<TD colspan=4 height="30">
<B>
<p align="right">
<input name="btnEquals" type="button" value="  =  " onclick="Operation('=')" style="width: 90">
</B>
</TD>
</TR>
</TABLE>
</TABLE>
</B>
</FORM>
</CENTER>
<font face="Verdana, Arial, Helvetica" size=2>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
var FKeyPad = document.Keypad;
var Accumulate = 0;
var FlagNewNum = false;
var PendingOp = "";
function NumPressed (Num) {
if (FlagNewNum) {
FKeyPad.ReadOut.value  = Num;
FlagNewNum = false;
   }
else {
if (FKeyPad.ReadOut.value == "0")
FKeyPad.ReadOut.value = Num;
else
FKeyPad.ReadOut.value += Num;
   }
}
function Operation (Op) {
var Readout = FKeyPad.ReadOut.value;
if (FlagNewNum && PendingOp != "=");
else
{
FlagNewNum = true;
if ( '+' == PendingOp )
Accumulate += parseFloat(Readout);
else if ( '-' == PendingOp )
Accumulate -= parseFloat(Readout);
else if ( '/' == PendingOp )
Accumulate /= parseFloat(Readout);
else if ( '*' == PendingOp )
Accumulate *= parseFloat(Readout);
else
Accumulate = parseFloat(Readout);
FKeyPad.ReadOut.value = Accumulate;
PendingOp = Op;
   }
}
function Decimal () {
var curReadOut = FKeyPad.ReadOut.value;
if (FlagNewNum) {
curReadOut = "0.";
FlagNewNum = false;
   }
else
{
if (curReadOut.indexOf(".") == -1)
curReadOut += ".";
   }
FKeyPad.ReadOut.value = curReadOut;
}
function ClearEntry () {
FKeyPad.ReadOut.value = "0";
FlagNewNum = true;
}
function Clear () {
Accumulate = 0;
PendingOp = "";
ClearEntry();
}
function Neg () {
FKeyPad.ReadOut.value = parseFloat(FKeyPad.ReadOut.value) * -1;
}
function Percent () {
FKeyPad.ReadOut.value = (parseFloat(FKeyPad.ReadOut.value) / 100) * parseFloat(Accumulate);
}
// End -->
</SCRIPT>

<!-- End Code  -->

	<?php 	
}
function dspAccessUserToMenuFrm(){
	
	$out='<table class="nasi">
	      <tr><td  style="height: 60px;vertical-align:middle;">دسترسی کاربر به منوها</td></tr>
	      <tr><td>نام کاربر:</td><td>'.getNameUserCombo('um_u_id').'<td></tr>
	      <tr><td colspan="3"><hr></hr><td><tr>
	      <tr><td>'.getListMenuscheckBox(rel_menu_id).'</td></tr>
	</table>';
	echo $out;
}
function getNameUserCombo($id='NameUserCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" ><option value="" > </option>';
	$lnk = mysql_query("SELECT * FROM dm_user_profile ORDER BY u_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['u_id'].'" >'.$row['u_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function ShowAccess(){
	
	 $ug_id = isset($_REQUEST['ug_id']) ? $_REQUEST['ug_id'] : '';
	 $u_id = isset($_REQUEST['u_id']) ? $_REQUEST['u_id'] : '';		 
	 $queryG="SELECT * FROM dm_usergroup WHERE ug_id=" .$ug_id."";

	 $lnkG = mysql_query($queryG);
	 $rowG=mysql_fetch_assoc($lnkG);
	 $queryu="SELECT * FROM dm_user_profile WHERE u_id=" .$u_id."";
//	 print $query;
	 $lnku = mysql_query($queryu);
	 $rowu=mysql_fetch_assoc($lnku);
	

	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchGroup"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '	<br>
		<div align = "center">
			<table  border="3" align="center" cellpadding="0" cellspacing="0"   class="list" style="width:85%;">
      			<tr class="rw1">
        			<td colspan="8" align="center" scope="row" style="height: 50px;vertical-align:middle;"><b>منوهاي حق دسترسي </b></td>
        		</tr>
        		 <tr class="rw0">
			              <td colspan="3">&nbsp;<b>نام کاربر:</b></td><td colspan="7"><b>&nbsp;'.$rowu['u_name'].'</b></td>
			       </tr>
			       
			       <tr class="rw1">
				          <td align="center"><b> رديف</b></td>
						   <td align="center"><b>كد منو</b></td>
				          <td align="center"><b>منوها</b></td>			
				          <td align="center"><b>اضافه كردن دسترسي</b></td>
				          <td align="center"><b>حذف دسترسي</b></td>
				          <td align="center"><b> ويرايش سطر</b></td>
				          <td align="center"><b>عدم ويرايش سطر</b></td>
				          <td align="center"><b>حذف سطر</b></td>
				          <td align="center"><b>عدم حذف سطر</b></td>
			        </tr>';
	    	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					menu_name LIKE '%".$_SESSION['srchStr']."%' 
			
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_listmenu 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);

	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			$menu_id=$row['menu_id'];
			
				$query2="SELECT * FROM dm_um_rel WHERE um_menu_id=".$menu_id."
			    	        AND um_u_id=".$u_id." ";
						    	$lnk2 = mysql_query($query2);
						    	    $row2=mysql_fetch_assoc($lnk2);
 //   	print $query2;
	                                     	

							    	   $status=0;									    
					    	if(mysql_affected_rows()>0){

					    		$Display2='none';
    	                        $Display1='block';	 
    	                        //yani delete va edit mani dare
									   if($row2['um_status']!=2){
//		print 'edit';
//		print $row2['um_can_delete'];							    		
											    	if($row2['um_can_delete']==1){
											    		
									        		 $DisplayDel1='none';
									        		   $DisplayDel2='block';
									        	      }else {
									        	      	 $DisplayDel1='block';
									        		     $DisplayDel2='none';
									        	      }	
									        	      	    		
		    	                                  if($row2['um_can_edit']==1){
									        		    $DisplayEdit2='block';
									        		    $DisplayEdit1='none';
									        	      }else {
									        	      	$DisplayEdit1='block';
									        		    $DisplayEdit2='none';
									        	      }
			       
									        }else{
									        	  $DisplayDel1='none';
	                                              $DisplayEdit1='none';
									              $DisplayDel2='none';
								                  $DisplayEdit2='none';
									        }									        	          									        	         	
			    		  		
			    	}else{
			    		
			    		$Display1='none';
			    		$Display2='block';	
			    		$DisplayDel1='none';
			    		$DisplayEdit1='none';
					    $DisplayDel2='none';
					    $DisplayEdit2='none';
			    		 	    		
			    	}	    	
	    	
			if(($inx)%2==1){
				$class="rw0";
				$pictureKam='del';
				$pictureKam1='del';
			    $pictureEzaf='ok';
                $pictureEzaf1='ok';}
				else{
				$class="rw1";
				$pictureKam='del';
				$pictureEzaf='ok';
				$pictureKam1='del';
				$pictureEzaf1='ok';
				}
	
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.' style="width:50%;">
					 <td align="center">'.$inx.')</td>
					 <td align="center">'.$row['menu_name'].'</td>
					  <td align="center">'.$row['menu_code'].'</td>
					 <td align="center"><span id="ezaf_'.$menu_id.'"  style="cursor:pointer;display:'.$Display2. ';"        onclick="AddAMenuToList1(\'\', \''.$menu_id.'\', \''.$ug_id.'\', \''.$u_id.'\') " this.style.display=\'none\'"><img src="images/'.$pictureEzaf.'.png" border="0" align="center" style="height:20px;width=20px;"></img></span></td>
	    	         <td align="center"><span id="kam_'.$menu_id.'"   style="cursor:pointer;display:'.$Display1.';"         onclick="DelAMenuToList1(\'\', \''.$menu_id.'\', \''.$ug_id.'\', \''.$u_id.'\') " this.style.display=\'none\'"><img src="images/'.$pictureKam.'.png" border="0" align="center"  style="height:20px;width=20px;"></img></span></td>
	    	         <td align="center"><span id="Edit_'.$menu_id.'"  style="cursor:pointer;display:'.$DisplayEdit1. ';"    onclick="AddAccessEdit(\'\', \''.$menu_id.'\', \''.$ug_id.'\', \''.$u_id.'\') " this.style.display=\'none\'"><img src="images/'.$pictureEzaf1.'.png" border="0" align="center"  style="height:20px;width=20px;"></img></span></td>
	    	         <td align="center"><span id="NoEd_'.$menu_id.'"  style="cursor:pointer;display:'.$DisplayEdit2. ';"    onclick="NoAccessEdit(\'\', \''.$menu_id.'\', \''.$ug_id.'\', \''.$u_id.'\') " this.style.display=\'none\'"><img src="images/'.$pictureKam1.'.png" border="0" align="center"    style="height:20px;width=20px;"></img></span></td>
	    	         <td align="center"><span id="Del_'.$menu_id.'"   style="cursor:pointer;display:'.$DisplayDel1.';"      onclick="AddAccessDelete(\'\', \''.$menu_id.'\', \''.$ug_id.'\', \''.$u_id.'\') " this.style.display=\'none\'"><img src="images/'.$pictureEzaf1.'.png" border="0" align="center" style="height:20px;width=20px;"></img></span></td>
	    	         <td align="center"><span id="NoDel_'.$menu_id.'" style="cursor:pointer;display:'.$DisplayDel2. ';"     onclick="NoAccessDelete(\'\', \''.$menu_id.'\', \''.$ug_id.'\', \''.$u_id.'\') " this.style.display=\'none\'"><img src="images/'.$pictureKam1.'.png" border="0" align="center" style="height:20px;width=20px;"></img></span></td>
				</tr>
			';
		}
		     $outHtml .= '	</table>
		    <div>				     
			      <span colspan="3" align="center"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px;
			      color:#FFFFFF;width:10%;" onclick=window.open("home.php?pg=prodMgmtPg&cmd=ListAccessMenu","_self") >  لیست گروه ها</button></span>     
			     <span> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px;
			      color:#FFFFFF;width:10%;" onclick=window.open("home.php?pg=prodMgmtPg&cmd=getUserList","_self") >  لیست كاربران</button></span>				     				                           	      
	      	</div>
 ';
    }else{
    	$outHtml .= '<tr class="rw1"><td colspan="10">هیچ سندي موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_access($u_id,$ug_id).' '.getRPPCombo_access($u_id,$ug_id);
   
    return $outHtml;
		
}

function getNavBar_access($u_id,$ug_id){
	$out = '<div align="center">
		<table style="direction:ltr" >
			<tr>';
			
	
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=ShowAccess&cmd2=setPg&pgNum=1"&ug_id='.$ug_id.'&u_id='.$u_id.' ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=ShowAccess&ug_id='.$ug_id.'&u_id='.$u_id.'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" > <img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=ShowAccess&ug_id='.$ug_id.'&u_id='.$u_id.'&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=ShowAccess&ug_id='.$ug_id.'&u_id='.$u_id.'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=ShowAccess&ug_id='.$ug_id.'&u_id='.$u_id.'&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" > <img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
		</div>
	';	
	return $out;
}
function getRPPCombo_access($u_id,$ug_id){
	$out = '<div align="center">
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=ShowAccess&ug_id='.$ug_id.'&u_id='.$u_id.'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}

function ShowAccess1(){
	
	 $ug_id = isset($_REQUEST['ug_id']) ? $_REQUEST['ug_id'] : '';	 
	 $queryG="SELECT * FROM dm_usergroup WHERE ug_id=" .$ug_id."";
//	 print $query;
	 $lnkG = mysql_query($queryG);
	 $rowG=mysql_fetch_assoc($lnkG);
	

	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchGroup"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
					
	
	$outHtml .= '	<br>
		 <div align="center">دادن همه ي دسترسي ها<span  style="cursor:pointer;"       onclick="AddAllMenuToList(\'\', \''.$ug_id.'\') " this.style.display=\'none\'"><img src="images/add.PNG" border="0" align="center" style="height:30px;width=30px;"></img></span></div>
		<div align = "center">
			<table  border="2" align="center" cellpadding="0" cellspacing="0"   class="list" style="width:85%;">
      			<tr class="rw1">
        			<td colspan="8" align="center" scope="row" style="height: 50px;vertical-align:middle;"><b>منوهاي حق دسترسي </b></td>
        		</tr>
        		 <tr class="rw0">
			              <td colspan="2">&nbsp;<b>نام گروه:</b></td><td colspan="7"><b>&nbsp;'.$rowG['ug_category'].'</b></td>
			       </tr>
			       
			       <tr class="rw1">
				          <td align="center"><b> رديف</b></td>
				          <td align="center"><b>منوها</b></td>			
				          <td align="center"><b>اضافه كردن دسترسي</b></td>
				          <td align="center"><b>حذف دسترسي</b></td>
				          
			        </tr>';
      	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					u_category LIKE '%".$_SESSION['srchStr']."%' 
			
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_listmenu 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	$_SESSION['srchStr'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
    $row = mysql_fetch_assoc($lnk);
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			$menu_id=$row['menu_id'];
				$query2="SELECT * FROM dm_list_group_rel WHERE rel_menu_id=".$menu_id."
	    	        AND rel_ug_id=".$ug_id."";
		    	$lnk2 = mysql_query($query2);
		    	$row2=mysql_fetch_assoc($lnk2);
//		    	print $query2;
	//	 echo  $row2['um_status'];  	
		    	$status=0;
		    
		if(mysql_affected_rows()>0){
	    		$Display2='none';
	    		$Display1='block';	    		
	    	}else{
	    	
	    	    $Display2='block';
	    		$Display1='none';		
	    		
	    	}					    	
					         	    	 	
			if(($inx)%2==1){
				$class="rw0";
				$pictureKam='delu';
				$pictureKam1='delu';
			    $pictureEzaf='add';
                $pictureEzaf1='add';}
				else{
				$class="rw1";
				$pictureKam='delu';
				$pictureEzaf='add';
				$pictureKam1='delu';
				$pictureEzaf1='add';
				}
	
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.' style="width:50%;">
					 <td align="center">'.$inx.')</td>
					 <td align="center">'.$row['menu_name'].'</td>
					 <td align="center"><span id="ezaf_'.$menu_id.'" style="cursor:pointer;display:'.$Display2. ';"       onclick="AddAMenuToList(\'\', \''.$menu_id.'\', \''.$ug_id.'\') " this.style.display=\'none\'"><img src="images/'.$pictureEzaf.'.PNG" border="0" align="center" style="height:20px;width=30px;"></img></span></td>
	    	         <td align="center"><span id="kam_'.$menu_id.'" style="cursor:pointer;display:'.$Display1.';"         onclick="DelAMenuToList(\'\', \''.$menu_id.'\', \''.$ug_id.'\') " this.style.display=\'none\'"><img src="images/'.$pictureKam.'.PNG" border="0" align="center" style="height:20px;width=20px;"></img></span></td>
	    	        
				</tr>
			';
		}
		     $outHtml .= '<tr >
				     
				    <td colspan="3" align="center"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px;
				      width:50%;" onclick=window.open("home.php?pg=prodMgmtPg&cmd=ListAccessMenu","_self") >  لیست گروه ها</button></td>
				      
				     <td colspan="3" align="center"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px;
				      color:#FFFFFF;width:50%;" onclick=window.open("home.php?pg=prodMgmtPg&cmd=getUserList","_self") >  لیست كاربران</button></td>
				           
	      	</tr>
	      	</table>
	      	</div>
 ';
    }else{
    	$outHtml .= '<tr class="rw1"><td colspan="10">هیچ سندي موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_access1().' '.getRPPCombo_access1();
   
    return $outHtml;
		
}

function getNavBar_access1(){
	$out = '<div align="center">
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=ShowAccess1&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=ShowAccess1&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" > <img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=ShowAccess&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=ShowAccess1&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg&cmd=ShowAccess1&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" > <img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
		</div>
	';	
	return $out;
}
function getRPPCombo_access1(){
	$out = '<div align="center">
	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=ShowAccess1&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function getLocationCombo($id='LocationCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlLocationComboChng(\'\', this.value)"  ><option value="" style="width:80px;" >..... </option>';
	print $r;
	$lnk = mysql_query("SELECT * FROM dm_location_goods where l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['l_id'].'" >'.$row['l_code'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}
function createMenu‍(){

?>
<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="regMenu">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">مشخصات اسناد</font></b></td>
	        </tr>
	        <tr>
	             <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>	
	        <tr>
		        <td ><center>كد منو </center> </td>
		        <td><input name="menu_code"  id="menu_code" type="text"  class="chk"/></td>

		        <td  align="center"><center>نام منو </center> </td>
		        <td><input name="menu_name" id="menu_name" type="text" class="chk" /></td>
		      
		       
	        </tr>
	      	
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>      	
			     <td colspan="3"><button name="button" type="submit" value="CSS"  class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
			   </td>      
	      	</tr>
	    </table>
	</form> 
	    
	<?php
}
function setting(){

	
		?>
	
	<form method="get" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="savesetting"> 
		<br></br>  
		<table  align="center"  class="nasi" width=50%  >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>">
		        <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">تغييرات ظاهری سيستم</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	<tr>
		       	<td style="font-weight:bold;"><center>رنگ پيش زمينه: <input class="color"  name="bgcolor" value="87AFE6"></center> </td>
		       
				<td style="font-weight:bold;">رنگ عنوان جدولها : <input class="color" name="htablecolor"  value="EBE9B9"></td>
	        </tr>
	      	<tr>		        
	        </tr>

			<tr>    
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
				      
			              <td colspan="3"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره </button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				   
	      	</tr>
				
	    </table>
	</form>
	
	<?php
	
}
function PrivatePanel(){
		$query = "
		 	SELECT *  FROM dm_user_profile 
	 
			WHERE 
				u_id = ".$_SESSION['dm_user_profile']['u_id']." 
		";
				
				$lnk = mysql_query($query);
				$row= mysql_fetch_assoc($lnk);
				
			//	print $query;
		?>
	
	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="EditPrivatePanel"> 
		<br></br>  
		 <div style="color:red;font-weight:blue;" align="center">    کاربر گرامی <?php echo $row['u_family'] ?>  به سیستم فروش خوش آمدید </div> 
		<table  align="center"  class="nasi" width=50%  >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">مشخصات کاربر</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	<tr>
		       	<td style="font-weight:bold;"><center>نام: </center> </td>
		        <td style="color:blue;font-weight:bold;" align="right"><?php echo $row['u_name'] ?></td>
		        <td>&nbsp;</td>
				<td style="font-weight:bold;">نام خانوادگي :</td>
		        <td style="color:blue;font-weight:bold;" align="right"><?php echo $row['u_family'] ?></td>
	        </tr>
	      	<tr>
		        <td style="font-weight:bold;"><center>نام كاربري :</center> </td>
		        <td style="color:blue;font-weight:bold;" align="right"><?php echo $row['u_user_name'] ?></td>
		        <td>&nbsp;</td>
		         <td style="font-weight:bold;"><center>ايميل: </center> </td>
		        <td  style="color:blue;font-weight:bold;" align="right"><?php echo  $row['u_email'] ?></td>
		       
	        </tr>
<!--	        <tr>-->
<!--	             <td ><center>رمز عبور </center> </td>-->
<!--		        <td><input name="u_pass_word" id="u_pass_word" type="password" value="<?php echo $row['u_pass_word']; ?>" /></td>-->
<!--		        <td ><center>تکرار رمز عبور</center> </td>-->
<!--		        <td><input name="u_pass_word" id="u_pass_word_again" type="password"  /></td>-->
<!--	        </tr>-->
	        <tr>		       
		        <td style="font-weight:bold;"><center>تلفن </center> </td>
		        <td style="color:blue;font-weight:bold;" align="right"><?php  echo $row['u_phone'] ?></td>
		       
	        </tr>
			<tr>    
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
				      
			              <td colspan="3"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > تغیر رمز عبور</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				   
	      	</tr>
				
	    </table>
	</form>
	
	<?php
	
}
function ShowAmessage1(){
$mes_id = isset($_REQUEST['mes_id']) ? $_REQUEST['mes_id'] : '';
	
	$query='select * from dm_message message
	          left join dm_user_profile prof
	         on prof.u_id=message.mes_to_id 
	         where
	         mes_id="'.$mes_id.'"';
	$lnk = mysql_query($query);
	$row = mysql_fetch_assoc($lnk);
	$query1 = "
		UPDATE  dm_message 
		SET 
			`mes_read_status` = '". 1 ."'
        WHERE 
		  `mes_id`  = '". $mes_id ."'";
	
	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();
	$out='<br>
	<table width="300" height="200" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#006666">
  <tr>
    <th width="106" bgcolor="#99FFCC" scope="col">به: </th>
    <th width="202" height="51" bgcolor="#99FFCC" scope="col"><div align="center"> '.$row['u_name'].' </div></th>
  
  </tr>
  <tr>
    <td height="169" colspan="2" bgcolor="#FFCCFF"><div align="center">
    '.$row['mes_message'].'
    </div></td>
  </tr>
  <tr>
    <td height="34" colspan="2" bgcolor="#99FFCC"><div align="center">
      <form id="form1" name="form1" method="post" action="">
        <input type="submit"  id="Button1"style="font-size:Medium;font-weight:bold;width:76px;background-color:cccccc;" name="Submit" value="پاسخ" />
      </form>
    </div></td>
  </tr>
</table>
<br>';
	
	echo $out;
}
function replymessage(){
	
	$mes_id = isset($_REQUEST['mes_id']) ? $_REQUEST['mes_id'] : '';
	$query='select * from dm_message message
	          left join dm_user_profile prof
	         on prof.u_id=message.mes_from_id 
	         where
	         mes_id="'.$mes_id.'"';
	$lnk = mysql_query($query);
	$row = mysql_fetch_assoc($lnk);
	$out='<br>
	   <form id="form2" name="form2" method="POST" action="?pg=prodMgmtPg&cmd=writemessage&status=1">
	              <input type="hidden" name="user_list[1]"  value="'. $row['u_id'] .'" />
	   
				<table width="300" height="70" border="1" align="center" cellpadding="2" cellspacing="2">
					<input name="status" type="hidden" value="1"></inpt>
					  <tr>
					    <th width="497" height="41" bgcolor="#996666" scope="col">پيغام خود را در اينجا بنويسيد </th>
					  </tr>
					  <tr>
					    <td height="200" bgcolor="#CCCCCC">
					      <p align="center">
					        <textarea name="message" cols="80" rows="8" style="{font-weight:bold;font-face:Zar;width:100%}" dir="rtl"></textarea>
					      </p> 
					     </td>
					  </tr>
					  <tr>
					    <td height="30" bgcolor="#996666">
					      <label></label>
					      <input type="submit" name="Submit" value="ارسال" />
					    </form>    </td>
					  </tr>
				</table>';
		echo $out;
	
	
}
function ShowAmessage(){
	
	$mes_id = isset($_REQUEST['mes_id']) ? $_REQUEST['mes_id'] : '';
	
	$query='select * from dm_message message
	          left join dm_user_profile prof
	         on prof.u_id=message.mes_from_id 
	         where
	         mes_id="'.$mes_id.'"';
	$lnk = mysql_query($query);
	$row = mysql_fetch_assoc($lnk);
	$query1 = "
		UPDATE  dm_message 
		SET 
			`mes_read_status` = '". 1 ."'
        WHERE 
		  `mes_id`  = '". $mes_id ."'";
	
	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();
	$out='<br>
	<table width="300" height="200" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#006666">
  <tr>
    <th width="106" bgcolor="#99FFCC" scope="col">از طرف: </th>
    <th width="202" height="51" bgcolor="#99FFCC" scope="col"><div align="center"> '.$row['u_name'].' </div></th>
  
  </tr>
  <tr>
    <td height="169" colspan="2" bgcolor="#FFCCFF"><div align="center">
    '.$row['mes_message'].'
    </div></td>
  </tr>
  <tr>
    <td height="34" colspan="2" bgcolor="#99FFCC"><div align="center">
    <form action="home.php"  method="get">
			  <input type="hidden" value="prodMgmtPg"      name="pg"  /> 
			  <input type="hidden" value="replymessage"  name="cmd"  />  
			  <input type="hidden"  name="mes_id" value="'.$mes_id.'"  name="cmd"  />  
        <input type="submit"  id="Button1"style="font-size:Medium;font-weight:bold;width:76px;background-color:cccccc;" name="Submit" value="پاسخ" />
      </form>
    </div></td>
  </tr>
</table>
<br>';
	
	echo $out;
}
function listsendmes(){
	
if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;
				
		}
	}
	$srchStr;
	$outHtml = '	<br><br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodePhavale">
			<table border=0 >
			  <tr> 
			    <td>
			        نام مورد نظر را وارد كنيد 
			    </td>
			  <tr>
			  <div id="search">
			  
			     <td>
			     <div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;" /> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
			     </td>
                 
              </tr>
              </table>
		</form>';
	
	$outHtml .= '	<br>
	<div align="center">
		<div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" class="list">
      			<tr class="rw0">
        			<th colspan="19" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;"><center> لیست پيغام های فرستاده شده</center> </th>
        		</tr>
      			<tr class="rw1" style="font-weight:bold;">
			        <td align="center">ردیف</td>			  
			        <td align="center">تاریخ نامه </td>
			        <td align="center">نام گيرنده </td>      
				</tr>';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
				ph_code LIKE '%".$_SESSION['srchStr']."%' 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_message 
		WHERE 
			mes_from_id=".$_SESSION['dm_user_profile']['u_id']." 
		".$srchQ." 
		".$typeQ." 
	  ORDER BY mes_id ASC ";
	
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery;
//	print $genQuery;
	
	$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['mes_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
		  if(($inx)%2==1){
				$class="rw0";
				$delete='delete1';}
				else{
				 $class="rw1";	
				 $delete='delete';}
				// echo 'phavale_';
			//	print $row['ph_id'];	
    	$query1='select * from  dm_user_profile 
	        
	         where
	         u_id="'.$row['mes_to_id'].'"' ;
  
	$lnk1 = mysql_query($query1);
	$row1 = mysql_fetch_assoc($lnk1);
			$outHtml .= ' 
			
				<tr class='.$class.'>
						<td style="vertical-align:middle;" align="center" width="5%">'.$inx.'</td>
						<td style="vertical-align:middle;" align="center" width="20%">'.$jdate.'</td>
						<td style="vertical-align:middle;" align="center" width="20%">'.$row1['u_name'].'</td>
						';      	
						$outHtml .= '<td  style="vertical-align:middle;" align="center"> <span style="cursor:pointer" " ><img src="images/delete.PNG" width="50%" height="50%" title="حذف" ></img></span>';
						$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=ShowAmessage1&mes_id='.$row['mes_id'].'"><img src="images/display.png" width="10%" height="10%" title="مشاهده"></img> </a></td>
				</tr>
			</div>
			
			';
			$inx++;
		}
    }else{
    	$outHtml .= '<tr ><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
    }
    $outHtml .= '</table></div ><br><div align="center" >';
    return $outHtml;
    		
}
function listunreadmes(){
	 
 $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] :'0' ;
	if($status==0){
		$titr='لیست پيغام های نخوانده';
	}else{
		
		$titr='لیست كل  پيغام ها';
	}
	$srchStr;
//	$outHtml = '	<br><br>
//		<form method="get" action="">
//			<input type="hidden" name="pg" value="havaleMgmtPg">   
//			<input type="hidden" name="cmd" value="searchCodePhavale">
//			<table border=0 >
//			  <tr> 
//			    <td>
//			        نام مورد نظر را وارد كنيد 
//			    </td>
//			  <tr>
//			  <div id="search">
//			  
//			     <td>
//			     <div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;" /> 
//			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
//			     </td>
//                 
//              </tr>
//              </table>
//		</form>';
	$outHtml = '';
	$outHtml .= '	<br>
	<div align="center">
		<div align = "center" style="width:50%;height:400px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" class="list">
      			<tr class="rw0">
        			<th colspan="19" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;"><center>'. $titr .'</center> </th>
        		</tr>
      			<tr class="rw1" style="font-weight:bold;">
			        <td align="center">ردیف</td>			  
			        <td align="center">تاریخ نامه </td>
			        <td align="center" >نام فرستنده </td>
			         <td align="center" colspan="2">&nbsp; </td>        
				</tr>';
	
	
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
				ph_code LIKE '%".$_SESSION['srchStr']."%' 
			)
		";
		
	}
	$typeQ = '';
	
$genQuery = "
		
		FROM 
			dm_message message
			left join dm_user_profile prof
			on message.mes_from_id=prof.u_id
		WHERE 
			 mes_to_id=".$_SESSION['dm_user_profile']['u_id']."
		
	 ";
	if($status==0){
	//yani unread ha ro biar
		$genQuery .="
		             AND    mes_read_status = 0 ";
		
	}

	$genQuery .= "".$srchQ." 
		".$typeQ." 
	
	  ORDER BY mes_id ASC";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	
	$resQuery = "
		SELECT 
			*  
	".$genQuery;
//	print $genQuery;
	
	$_SESSION['srchStr'] = '';
	$lnk1 = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk1)){
			
			$gdate=$row['mes_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			$queryu="select * from dm_user_profile where u_id=".$row['mes_from_id']."";
			$lnku = mysql_query($queryu);
			$rowu = mysql_fetch_assoc($lnku);
			
		  if(($inx)%2==1){
				$class="rw0";
				$delete='delete1';}
				else{
				 $class="rw1";	
				 $delete='delete';}
				// echo 'phavale_';
			//	print $row['ph_id'];	
    	
			$outHtml .= ' 
			
				<tr class='.$class.'>
						<td style="vertical-align:middle;" align="center" width="5%">'.$inx.'</td>
						<td style="vertical-align:middle;" align="center" width="20%">'.$jdate.'</td>
						<td style="vertical-align:middle;" align="center" width="20%">'.$rowu['u_name'].'</td>
						';      	
						$outHtml .= '<td  style="vertical-align:middle;" align="center"> <span style="cursor:pointer" " ><img src="images/delete.PNG" width="50%" height="50%" title="حذف" ></img></span>';
						$outHtml .= '<td><a href="?pg=prodMgmtPg&cmd=ShowAmessage&mes_id='.$row['mes_id'].'"><img src="images/display.png" width="10%" height="10%" title="مشاهده"></img> </a></td>
				</tr>
			</div>
			
			';
			$inx++;
		}
    }else{
    	$outHtml .= '<tr ><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
    }
    $outHtml .= '</table></div >';
    return $outHtml;
    		
}
function Privatemessage(){
	
$out='<br><br><table width="155" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#00CCCC" bgcolor="#CC9999">
  <tr>
 <form action=""  method="post">
  <input type="hidden" value="prodMgmtPg"      name="pg"  /> 
  <input type="hidden" value="newmessage"  name="cmd"  />  
    <td align="center"><button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" >ايجاد پيغام جديد</button></td>
 </form>   
  </tr>
  <form action="home.php"  method="get">
  <input type="hidden" value="prodMgmtPg"      name="pg"  /> 
  <input type="hidden" value="listunreadmes"  name="cmd"  />  
  <tr>
    <td width="143" align="center"><button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > پيغام های خوانده نشده</button></td>
  </tr>
  </form>
   <form action="home.php"  method="get">
  <input type="hidden" value="prodMgmtPg"      name="pg"  /> 
  <input type="hidden" value="listunreadmes"  name="cmd"  /> 
  <tr>
   <form action="home.php"  method="get">
  <input type="hidden" value="prodMgmtPg"      name="pg"  /> 
  <input type="hidden" value="listsendmes"  name="cmd"  /> 
    <td align="center"><button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > پيام مای ارسال شده</button>    </td>
  </form>
  </tr>
  </form>
    <form action="home.php"  method="get">
  <input type="hidden" value="prodMgmtPg"      name="pg"  /> 
  <input type="hidden" value="listunreadmes"  name="cmd"  />
  <input type="hidden" name="status" value="'. 1 .'" >
  <tr>
        <td align="center"><button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > آرشيو پيغام ها</button>    </td>
  
  </tr>
  </form>
</table>';
	return $out;
}
function savesetting(){
	$bgcolor = isset($_REQUEST['bgcolor']) ? $_REQUEST['bgcolor'] : '';
	$htablecolor = isset($_REQUEST['htablecolor']) ? ($_REQUEST['htablecolor']) : '';
	
	
	$querys="select * from  dm_setting 
				where
			s_u_id='".$_SESSION['dm_user_profile']['u_id']."'";
			
	$lnks = mysql_query($querys);
	//print $querys;
	if(mysql_num_rows($lnks)==0){
	
	
	 $query = "
		INSERT INTO dm_setting 
			(
			    `s_u_id`, 
				`s_reg_date`, 
				
				`s_bgcolor` ,
				`s_htablecolor` 

			)
		VALUES
			(   '". $_SESSION['dm_user_profile']['u_id']."',
				'".gmdate('Y-m-d')."',  				
				'". $bgcolor."',
				'". $htablecolor ."'
			)
	";
			// print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	}else{
		
		$query = "
						UPDATE dm_setting 
						SET 
					    	`s_reg_date` = '". gmdate('Y-m-d')."',
							`s_bgcolor` = '".$bgcolor."', 
							`s_htablecolor` = '".$htablecolor."'
													 
						WHERE 
							
						
						   s_u_id = '".$_SESSION['dm_user_profile']['u_id']."'"; 
						  	
					$lnk = mysql_query($query);
				//	print $query;
					if(mysql_error()) print mysql_error();
	//if(mysql_error()) print mysql_error();
	
	
	}
	
}
function EditPrivatePanel(){
	$query = "
		 	SELECT *  FROM dm_user_profile 
	 
			WHERE 
				u_id = ".$_SESSION['dm_user_profile']['u_id']." 
		";
				
				$lnk = mysql_query($query);
				$row= mysql_fetch_assoc($lnk);
				
				?>
	   	<form method="post" action="" >
		<input type="hidden" name="pg" value="prodMgmtPg">   
		<input type="hidden" name="cmd" value="upPrivatePanel">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">اسامي كاربرها</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	      </tr>
	      
	      	<tr>
		        <td ><center>نام كاربري </center> </td>
		        <td><?php echo $row['u_user_name']; ?> </td>
		         <td ><center>ايميل </center> </td>
		        <td><input name="u_email" id="u_email" type="text" value="<?php echo $row['u_email']; ?>" /></td>
		       
	        </tr>
	        <tr>
	             <td ><center>رمز عبور </center> </td>
		        <td><input name="u_pass_word" id="u_pass_word" type="password"  /></td>
		        <td ><center>تکرار رمز عبور</center> </td>
		        <td><input name="u_pass_word" id="u_pass_word_again" type="password"  /></td>
	        </tr>
	        <tr>
		       
		        <td ><center>تلفن </center> </td>
		        <td><input name="u_phone" id="u_phone" type="text" value="<?php echo $row['u_phone']; ?>" /></td>
		      
	        </tr>
			<tr>
	      	       
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
				      
			      	
				     <td colspan="3"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				         
	      	</tr>
				
	    </table>
	</form>
	<td>
	<?php
	
}
function upPrivatePanel(){
	 
	$u_name = isset($_REQUEST['u_name']) ? $_REQUEST['u_name'] : '';
	$u_family = isset($_REQUEST['u_family']) ? ($_REQUEST['u_family']) : '';
	$u_user_name = isset($_REQUEST['u_user_name']) ? ($_REQUEST['u_user_name']) : '';
	$u_email = isset($_REQUEST['u_email']) ? ($_REQUEST['u_email']) : '';
	$u_pass_word = isset($_REQUEST['u_pass_word']) ? ($_REQUEST['u_pass_word']) : '';	
	$u_phone = isset($_REQUEST['u_phone']) ? ($_REQUEST['u_phone']) : '';
 
	
	$query = "
		UPDATE  dm_user_profile
		SET 
			`u_phone` = '".$u_phone."',
			
			`u_pass_word` = '".md5($u_pass_word)."',
			`u_email` = '".$u_email."'
			
			
		WHERE 
			`u_id` = ".$_SESSION['dm_user_profile']['u_id']." 
	";
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
}
function regMenu(){
	
    $menu_code = isset($_REQUEST['menu_code']) ? $_REQUEST['menu_code'] : '';
	$menu_name = isset($_REQUEST['menu_name']) ? ($_REQUEST['menu_name']) : '';
	
	$query = array(
		'menu_code' => $menu_code,
		'menu_name' => $menu_name,
		
	);

	$query = inserterQMaker('dm_listmenu', $query);
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$menu_id = mysql_insert_id();
	return $menu_id;	
	}
function writemessage(){
	
$user_list=$_REQUEST['user_list'];

$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '0';
$message = isset($_REQUEST['message']) ? $_REQUEST['message'] : '0';

if(!empty($_REQUEST['user_list'])) {
    foreach($_REQUEST['user_list'] as $check) {
           $_session['user_list']=$check; 
        //   echo $_session['user_list'];
    }
}
?>
<form id="form2" name="form2" method="POST" action="?pg=prodMgmtPg&cmd=writemessage&status=1">
<?php 
 foreach($_REQUEST['user_list'] as $check) {
 	$i=1;      
  //  echo $check;
 ?>
           <input type="hidden" name="user_list[<?php $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    
 if($status==1){
    	
 if(!empty($_REQUEST['user_list'])) {
    foreach($_REQUEST['user_list'] as $check) {
           $_session['user_list']=$check; 
          // echo $check;
           	$query = array(
       	 	'mes_from_id' => $h_ph_id, 
		    'mes_date'=> gmdate('Y-m-d'),
		    'mes_from_id' => $_SESSION['dm_user_profile']['u_id'], 
		    'mes_to_id' => $check, 
		    'mes_message' => $message,
		);
		$query = inserterQMaker('dm_message', $query);
		
		//print $query;
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$mes_id = mysql_insert_id();     
    }
    		echo '<div align="center" style="background: yellow">  پيغام شما با موفقيت  ارسال شد </div>' ;         
    
    }	
    }

$out='<br>
			<table width="300" height="70" border="1" align="center" cellpadding="2" cellspacing="2">
					<input name="status" type="hidden" value="1"></inpt>
					  <tr>
					    <th width="497" height="41" bgcolor="#996666" scope="col">پيغام خود را در اينجا بنويسيد </th>
					  </tr>
					  <tr>
					    <td height="200" bgcolor="#CCCCCC">
					      <p align="center">
					        <textarea name="message" cols="80" rows="8" style="{font-weight:bold;font-face:Zar;width:100%}" dir="rtl"></textarea>
					      </p> 
					     </td>
					  </tr>
					  <tr>
					    <td height="30" bgcolor="#996666">
					      <label></label>
					      <input type="submit" name="Submit" value="ارسال" />
					    </form>    </td>
					  </tr>
				</table>';
		echo $out;
		
	}
function newmessage(){

$out = '<br>
		 <form action="?pg=prodMgmtPg&cmd=writemessage" method="post">
		  <div align="center" style="width:100%;height:200px; overflow:auto">
		     <table align="center" width=40%  border="1" bgcolor="#FFCCFF">
	           <tr>
	              <td colspan="3" align="center"> ليست كاربران سيستم<td>
	           </tr>';

		$lnk = mysql_query("SELECT * FROM  dm_user_profile");
		if(mysql_num_rows($lnk)>0){
			$i=1;
			while($row=mysql_fetch_assoc($lnk)){
				$lnk1 = mysql_query("SELECT * FROM  dm_province where province_id=".$row['u_province_id']."");
 	            $row1=mysql_fetch_assoc($lnk1);
	$out .= '<tr>
	            <td>'.$i.'</td>
				<td>'.$row['u_name'].'</td>
				<td>'. $row1['province_name'].'</td>
				<td><input type="checkbox" name="user_list['.$i.']"  value="'.$row['u_id'].'" /></td>
			</tr>';
				$i++;		
			}
	
		}
		$out .= '</table></div>
		
		';
		$out .= '<table align="center">
		           <tr>
		             <td>
		             <button type="submit">ادامه</button >
		             </td>
		            <tr>
		            </table></form>';
		           
	echo $out;
		
	}

function getProdCombo($id='ProdCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlProdComboChng1(\'\', this.value)" ><option value="" style="width:80px;" >..... </option>';
	$lnk = mysql_query("SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
					    GROUP BY p_code ORDER BY p_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['p_id'].'"  >'. $row['p_code'].'</option>';

		}
	}
	$out .= '</select>';}


?>

