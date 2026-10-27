<?php
function dsppHavaleFrm(){
	
	$query = " SELECT *  FROM dm_pish_havale_det 			 
			 WHERE 
					phd_p_price = 0 
			 AND 
				phd_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'  ";	
						   								 	    					   
    			$lnk = mysql_query($query);
				if(mysql_num_rows($lnk)>0){
				
			while($row = mysql_fetch_assoc($lnk))
			{
				 $queryp="SELECT * FROM dm_product product
							left join dm_price price
						on product.p_id=price.price_p_id
						WHERE p_code=".$row['phd_pid']."
						 AND 
							    p_price_code=".$row['phd_price_code']."
						 AND
								  price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ." ";
							
					$lnkp = mysql_query($queryp);
					$rowp = mysql_fetch_assoc($lnkp);
					$phd_price=$rowp['p_sellprice'] * $row['phd_amount'];
					$phd_priceh=$rowp['p_sellpriceh'] * $row['phd_amount'];
					$query = "
							UPDATE dm_pish_havale_det 
							SET 
								`phd_price` = '".$phd_price."',
								`phd_p_price` = ".$rowp['p_sellprice'].", 
								`phd_priceh` = '".$phd_priceh."',
								`phd_p_priceh` = ".$rowp['p_sellpriceh']."  			 
								 			 
								
													 
							WHERE 
								phd_id_province = ".$_SESSION['dm_user_profile']['u_province_id']." 
                             AND
							 
							     phd_id=".$row['phd_id']."";
	
						$lnk = mysql_query($query);
					
								
				}
				                          }
	
                  $day_number = jdate('j');
                   $month_number = jdate('n');
                   $year_number = jdate('y');
                   $day_name = jdate('l');
	               $selectedItem=1;
	               ?>
	    <body onLoad="document.f1.userid.focus()"> 
	 <table  align="center"  class="nasi" onload="FocusOnInput()">
	       <tr  style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			  	       	
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				       <td colspan="5"  align="center" ><b> صدور معرفي نامه </b> </td>
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				    <td colspan="5">&nbsp;</td>
				</tr>
	 
				<tr>
					
						<td>تاريخ:<?php echo $year_number?>/<?php echo $month_number ?>/<?php echo $day_number ?>&nbsp;</td>
						
				</tr>
				<tr>
				<tr>
				        <td colspan="5"><hr></hr></td>
				
				</tr>
				
					
				<tr >
				
					<form method="post" action="" >
		              	<input type="hidden" name="pg"  value="PfactorMgmtPg" >   
		                <input type="hidden" name="cmd" value="dspmoarefi" >		                
		              	<td>&nbsp; <b> شماره پيش حواله :</b> </td>		              	
						<td><input name="ph_code" type="text"/></td>
					    <td colspan="3" align="center"><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px;width=20px; color:#FFFFFF" ></td>
				    </form>
				</tr>	
							 
  </table>
  </body>
  <?php 
	
	
}	
function dspPreHavaleFrm(){
	
	?>	  
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#cus_req_date").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	
	
function validateAndSave(){
	
	if(fObj('custCombo').value==''){
		
		alert('لطفا نام مشتری را انتخاب کنید');
		return;
	}
if(fObj('cus_req_num').value==''){
		
		alert('لطفا شماره درخواست را انتخاب کنید');
		return;
	}
	 if(fObj('cus_req_date').value==''){
		
		alert('لطفا تاریخ درخواست را انتخاب کنید');
		return;
	}
	 if(fObj('phm_id').value==-2){
			
			alert('لطفا شماره مجوز را انتخاب کنید');
			return;
		}
 checkvalidData();

}


function searchCustomer(e,val) {
	if(e.keyCode == 112){
	
		window.open( 'searchCus.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

	}
			                      
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
                   $selectedItem=1; 
                   $day_number = jdate('j');
                   $month_number = jdate('n');
                   $year_number = jdate('y');
                   $day_name = jdate('l');
 	
	$query="SELECT MAX(ph_code) maxId FROM dm_pish_havale 
	          WHERE
	           ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  ";
	          
	$lnk=mysql_query($query);
//	print $query;
	print mysql_error();
	$row=mysql_fetch_assoc($lnk);
	$maxId=$row['maxId']+1;
    $rahnama= '<span style="color:blue;"><span style="color:red;">  *  </span> در فيلد كد مشتري  ميتوانيد با كليد F1 به جستجو بپردازيد  </span>  ';
    echo $rahnama;
  $province_id = $_SESSION['dm_user_profile']['u_province_id'];
	?>
	<body onLoad="document.form2.code_customer.focus()">
	<table  align="center" class="nasi" style="border:1px;vertical-align:middle;">
		  
		<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			<td colspan="2">
				<table >				
					<tr style="height:50px;">
					<td style="width:10px;height:50px;vertical-align:middle;"></td><td colspan="2" style="width:50%;vertical-align:middle;"><b>&nbsp; شماره پيش حواله : &nbsp;</b> <?php echo $maxId ?></td>
					<td>&nbsp; &nbsp; &nbsp;</td>
						<td style="width:20%;vertical-align:middle;" colspan="2"></td><td style="width:50px;vertical-align:middle;"><b>تاریخ:</b></td><td style="width:50px;vertical-align:middle;"><?php echo "$year_number/$month_number/$day_number"?></td>
					</tr>
							
	          </table>
			</td>
			</tr>
			 <tr>
	           <td colspan="12"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>			
		<tr>
			<td>
				<table width=100%>
				<form action="" name="form2" >
				<tr>
						<td><center><b>كد مشتري:</b></center>  </td>
				
				
					                                                     
					    <td><input type="text" name="code_customer" id="code_customer"  onkeypress="searchCustomer(event,<?php echo $province_id ?>);"  ></input></td>
					   	<td><center><b>:شماره مجوز:</b></center>  </td>				     
					     <td ><?php echo getmojopComboBox('phm_id')  ?> </td>
					    
					   </form> 
					</tr>
					
				</table>
				
			</td>
		</tr>
		<tr>
		<td colspan="5">
				<hr></hr>
					<center><span ><B>اطلاعات مشتری</B></span></center>
						  <table width=100% border="1">
                            <tr>
                               <td colspan="8"><hr></hr></td>
                            </tr>
							<tr>
							    <td><B>شماره درخواست :</B></td>
							    <td><input name="cus_req_num" id="cus_req_num" type="text"  style="width:100px;" onkeyup="isNumber(this)"></td>
							    <td>&nbsp;</td>
							   	<td><B> تاريخ درخواست: </B></td><td><input id="cus_req_date" type="text" name="cus_req_date"  /></td>
							</tr>							
							<tr>
			      	        
						       <td align="left" colspan="9"><button name="subject" type="submit"   onclick="validateAndSave()" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"   > ذخيره</button></td>  
							    <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	                        </tr>
			                 <tr> 
				            
						</table>
			</td>
	</table> 
	</body>
	<br></br>
	<?php 
}

function getCustCombo($id='custCombo', $sCust=false){
	
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlCustComboChng(\'\', this.value)" ><option value="" style="width:80px;" > </option>';
	$lnk = mysql_query("SELECT * FROM dm_customer ORDER BY name_customer");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['customer_id'].'" >'.$row['name_customer'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}

function getCategoryCustComboZ($id='CategorycustCombo', $sCust=false){
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
function getNameProvinceComboz($id='NameProvinceCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" >';
	$lnk = mysql_query("SELECT * FROM dm_province ORDER BY province_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['province_id'].'" >'.$row['province_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}

function getNameCityComboz($id='NameProvinceCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" >';
	$lnk = mysql_query("SELECT * FROM dm_province ORDER BY province_name");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['province_id'].'" >'.$row['province_city_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}



function getLocationCombo($l,$id='LocationCombo', $sCust=false){
	
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlLocationComboChng(\'\', this.value)"  ><option value="" style="width:80px;" >.... </option>';
	$lnk = mysql_query("SELECT * FROM dm_location_goods where   l_id_province=".$_SESSION['dm_user_profile']['u_province_id']." ");

	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['l_id'].'" >'. $row['l_code'].'/'.$row['l_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}
function getLocationComboed($l,$id='LocationCombo', $sCust=false){
	
	$lnk1 = mysql_query("SELECT * FROM dm_location_goods where l_code=".$l." and l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	$row1=mysql_fetch_assoc($lnk1);
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlLocationComboChng(\'\', this.value)"  ><option value="'.$row1['l_id'].'" style="width:80px;" >'.$l.' </option>';
	$lnk = mysql_query("SELECT * FROM dm_location_goods where l_id_province=".$_SESSION['dm_user_profile']['u_province_id']." ");

	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['l_id'].'" >'. $row['l_code'].'/'.$row['l_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}



function getAllProdTypesMngr(){
	
	$lnk = mysql_query("dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id ORDER BY p_type, p_name");
	$prodInfArr = array();
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$prodInfArr[$row['p_type']][$row['p_id']] = $row;
		}
	}

	$prodsHtml = '<div>';
	foreach($prodInfArr as $keyType=>$valueType){
		$prodsHtml .= '<div id="prodsCntnr_'.$keyType.'" style="display:none;">';
		foreach($valueType as $keyProd=>$valueProd){
			$prodsHtml .= '<div >'.$valueProd['p_name'].'</div>';
		}
		$prodsHtml .= '</div>';
	}
	$prodsHtml .= '</div>';
	
	global $p_types;
	$typesHtml = '<div>';
	foreach($p_types as $key=>$value){
		$typesHtml .= '<div><span style="cursor:pointer" onclick="dspPrdType('.$key.')">'.$value['title'].'</span></div>';
		
		
	}
	$typesHtml .= '</div>';
	
	
	$out = '
		<table border="1" >
			<tr>
				<td>نوع کالا</td>
				<td>کالاها</td>
				<td></td>
			</tr>
			<tr>
				<td style="vertical-align:top;">'.$typesHtml.'</td>
				<td style="vertical-align:top;">'.$prodsHtml.'</td>
				<td style="vertical-align:top;"></td>
			</tr>
		</table>
	'; 
	return $out;
}
function regHavaleFrm(){
?>
<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="regHavale">   
		<table  bgcolor=#82a9c align="center" border="2">
		  	<tr align="center">
		        <td colspan="6" align="center" ><h2>مشخصات </h2></td>
	        </tr>
	      	
	      	<tr>
		        <td ><center>کد مشتری </center> </td>
		        <td><input name="havale_customer_code" type="text"  /></td>
		        <td ><center>اسم مشتری </center> </td>
		        <td><input name="havale_customer_name" type="text"  /></td>
	        </tr>
	      	<tr>
	      	
			      	<td colspan="3"><input type="submit" value="تاييد" ></td>
	      	</tr>
	    </table>
	</form> 
	<?php 
}



function dsFrmDetailHavale(){

$outHtml='<br>
<br>
<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="reghavaleDetail">   
		<table  bgcolor=#82a9c align="center" border="2">
		  	<tr align="center">
		        <td colspan="6" align="center" >محصول مورد نظر </td>
	        </tr>
	      	
	      	<tr>
		        <td ><center>اسم کالا </center> </td>
		        <td><input name="havale_detail_product" type="text"  /></td>
		        <td ><center>تعداد </center> </td>
		        <td><input name="havale_detail_number" type="text"  /></td>
	        </tr>
	      	<tr>
	            	
			      	<td colspan="3"><input type="submit" value="تاييد" ></td>
	      	</tr>
	    </table>
	</form>'; 
	
echo $outHtml;
}



function regMotCustomer(){
	
	$cm_req_num = isset($_REQUEST['cm_req_num']) ? $_REQUEST['cm_req_num'] : '';
	$cm_req_date = isset($_REQUEST['cm_req_date']) ? $_REQUEST['cm_req_date'] : '';
	$cm_name_customer = isset($_REQUEST['cm_name_customer']) ? $_REQUEST['cm_name_customer'] : '';
	$cm_code_economic_customer = isset($_REQUEST['cm_code_economic_customer']) ? ($_REQUEST['cm_code_economic_customer']) : '';
	$cm_code_postal_costumer = isset($_REQUEST['cm_code_postal_costumer']) ? $_REQUEST['cm_code_postal_costumer'] : '';
	$cm_name_city_customer = isset($_REQUEST['cm_name_city_customer']) ? ($_REQUEST['cm_name_city_customer']) : '';
	$cm_name_province_customer = isset($_REQUEST['cm_name_province_customer']) ? ($_REQUEST['cm_name_province_customer']) : '';
	$cm_cart_asnaf_customer = isset($_REQUEST['cm_cart_asnaf_customer']) ? ($_REQUEST['cm_cart_asnaf_customer']) : '';
	$cm_customer_category = isset($_REQUEST['cm_customer_category']) ? ($_REQUEST['cm_customer_category']) : '';
	$cm_customer_address_office  = isset($_REQUEST['cm_customer_address_office']) ? ($_REQUEST['cm_customer_address_office']) : '';
	$cm_customer_tel  = isset($_REQUEST['cm_customer_tel']) ? ($_REQUEST['cm_customer_tel']) : '';

	$query = array(
	    'cm_req_num' => $cm_req_num,
		'cm_req_date' => $cm_req_date,
		'cm_name_customer' => $cm_name_customer,
		'cm_code_economic_customer' => $cm_code_economic_customer,
		'cm_code_postal_costumer' => $cm_code_postal_costumer,
	    'cm_name_city_customer' => $cm_name_city_customer,
	    'cm_name_province_customer' => $cm_name_province_customer,	  
	    'cm_customer_address_office' => $cm_customer_address_office,
	    'cm_customer_category' => $cm_customer_category,
		'cm_customer_tel' => $cm_customer_tel,
	);
	
global $general;
	$query = inserterQMaker('dm_customer_mot', $query);
	//print $query;
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$cm_customer_id = mysql_insert_id();
	return $cm_customer_id;	
		
}
	

function dspPreHavaleFrm2($custId, $cm_req_num,$cm_req_date, $custType='norm',$phm_id)
{
	
  $_SESSION['codecus']='';
	
  $code_customer = isset($_REQUEST['cId']) ? $_REQUEST['cId'] : '';
 	
	?>
	<script type="text/javascript" >
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
	function addAProd2BillCheck(){
	//	alert(fObj('dts_id').value);
	
			if(fObj('p_code').value==''){
					
					alert('لطفا کد کالا را انتخاب کنید');
					return;
				}
			if(fObj('p_price_combo').value==''){
				
				alert('لطفا کد قيمت را انتخاب کنید');
				return;
			}
           if(fObj('LocationCombo').value==''){
				
				alert('لطفا کد محل را وارد کنید ');
				return;
			}
         
			if(fObj('phd_amount').value==''){
				
				alert('لطفا مقدار را وارد کنید');
				return;
			}
			if(fObj('phd_deli_name').value==''){
							
				alert('لطفا نام تحویل گیرنده را وارد کنید ');
				return;
						}
			if(fObj('dts_id').value==''){
				
				alert('لطفا نوع فروش را انتخاب کنید ');
				return;
			}
    if(fObj('dts_id').value=='2'){
				
    	if(fObj('ph_modat').value==''){
			
			alert('لطفا مدت  را وارد نمایید ');
			return;
		}
			}
    if(fObj('dts_id').value=='2'){
		
    	if(fObj('ph_zemanat').value==''){
			
			alert('لطفا نوع مدت دار را انتخاب کنید ');
			return;
		}
			}
 if(fObj('dts_id').value=='3'){
		
    	if(fObj('ph_tahator').value==''){
			
			alert('لطفا نوع تهاتر را انتخاب کنید ');
			return;
		}
			}
			addAProd2Bill();
			
				}
	function searchProd(e,val) {
		if(e.keyCode==112){
		window.open( 'searchProd.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" );
		}
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
	function formReset()
	{
	document.getElementById("formprod").reset();
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
		right: 300px;
		top: 550px;
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

     $_SESSION['check']=0;
	 $selectedItem=1; 
     $day_number = jdate('j');
     $month_number = jdate('n');
     $year_number = jdate('y');
     $day_name = jdate('l');
     
 $querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	
	$query="SELECT *   FROM dm_customer
	         WHERE code_customer=".$code_customer."
	         AND
	            customer_code_org=".$province_code."
	         ";
	$lnk=mysql_query($query);

	//print $query;
	print mysql_error();
	$rowcus=mysql_fetch_assoc($lnk);	 
	
	$query="SELECT MAX(ph_code) maxId FROM dm_pish_havale 
	         WHERE ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
         
	$lnk=mysql_query($query);
//	print $query;
	print mysql_error();
	$row=mysql_fetch_assoc($lnk);	 			
	$PhNum=$row['maxId']+1;
	$queryp="SELECT * FROM dm_province 
	              WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
	    $lnkp=mysql_query($queryp);
	    print mysql_error();
	    $rowp=mysql_fetch_assoc($lnkp);
	     $provinceName=$rowp['province_name'];
	   $rahnama= '<span style="color:blue;"><span style="color:red;">  *  </span> در فيلد كد كالا  ميتوانيد با كليد F1 به جستجو بپردازيد  </span>  ';
	      echo $rahnama;
	      
	      
	      $querymojavez="SELECT * FROM dm_op_mojavez  opm   
	               left join  dm_operation_acc  op_acc 
	                   on opm.phm_op_id=op_acc.g_id
	               
	               WHERE 
	            	  phm_id=".$phm_id; 
	$lnkmojavez = mysql_query($querymojavez); 
	$rowmojavez = mysql_fetch_assoc($lnkmojavez);
	$out='
	<div id="content">
		<input type="hidden" name="cId" id="cId" value="'.$custId.'">
		<input type="hidden" name="cType" id="cType" value="'.$custType.'">
		<input type="hidden" name="cm_req_num" id="cm_req_num" value="'.$cm_req_num.'">
		<input type="hidden" name="cm_req_date" id="cm_req_date" value="'.$cm_req_date.'">
	    <input type="hidden" name="ph_mojavez" id="ph_mojavez" value="'.$rowmojavez['phm_mojavez'].'">
	    <input type="hidden" name="phm_id"  id="phm_id"   value="'.$phm_id.'">
	      <input type="hidden" name="ph_operation_id"  id="ph_operation_id"   value="'.$rowmojavez['phm_op_id'].'">
			<table  align="center"  class="nasi"  width=70% >
			 <tr style="height: 50px;vertical-align:middle;background-color:'. $_SESSION['htablecolor'] . ';">
			         
					<td style="height: 50px;width:50%;vertical-align:middle;"><b>شماره  پيش حواله:</b>
					<b>'.$PhNum .'</b> </td>
					
					<td style="height: 50px;vertical-align:middle;" colspan="3"><b>تاریخ پیش حواله:</b><b>'. "$year_number/$month_number/$day_number".'</b>
					</td>
					<td colspan="2" align="left">
			</tr>
		    <tr>
	           <td colspan="8"><hr style="color:'. $_SESSION['htablecolor'] .';height:40%;"></hr></td>
	       </tr>
			 <tr style="height: 50px;vertical-align:middle;">
			       
					<td style="height: 50px;vertical-align:middle;"  ><b> شماره درخواست:</b>
					<b>'.$cm_req_num .'</b> </td>
					
					<td style="height: 50px;vertical-align:middle;" ><b> تاریخ درخواست:</b><b>'.$cm_req_date.'</b></td>
					<td width=2%>شماره مجوز</td>
	      		    <td style="font-weight:bold;">'.$rowmojavez['phm_mojavez'].' </td>
					
			</tr>
			<tr>
	             <td colspan="7"><hr>
	             </td>
			 </tr>
			 <tr>
			 
			     <td colspan="6" align="center" style="height: 40px;vertical-align:middle;font-size:20px;" ><b> مشخصات مشتري </b></td>			  
			  </tr>
			  <tr>
			  <td colspan="7"><hr></hr></td>
			  </tr>';
			 $out.='   
			 
			<tr>
			    
			    <td><b>نام مشتري :</b>
			    <b>'.$rowcus['name_customer'].'</b> </td>
			    <td><b>كد مشتري :</b>
			    <b>'.$rowcus['code_customer'].'</b> </td>
			   
		    </tr> 
		  
		    <tr>
		        <td width=2%>&nbsp;</td>
		         <td><b>شناسه اقتصادی / ملی مشتری:</b>
			     <b>'.$rowcus['code_economic_customer'].' </b></td>	
		    </tr> 
		     <tr>
		        <td width=2%>&nbsp;</td>
	      		<td style="font-weight:bold;color:blue;">نوع عمليات : &nbsp;
			  	
			  		'.$rowmojavez['g_acc_name'].'
				</td>
			
	      	 </tr>
		</form>';
		
		//	 <tr>
		 //       <td><a href="?pg=havaleMgmtPg&cmd=dspInfCusEdit&ha_mot_id='. $row['ha_mot_id'].'">ویرایش</a></td>
		       
		 //  </tr>	<tr>
	      	       			
			$out .='<tr>
			             <td colspan="7"><hr>
			             </td>
			         </tr>
			
		            <tr >
		                   <td colspan="4">&nbsp;</td> 
		                    <td >&nbsp;</td>    
				      </tr>
				   			    
				  ';
		echo $out;
		$queryp="SELECT * FROM dm_province 
	              WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
	    $lnkp=mysql_query($queryp);
	    print mysql_error();
	    $rowp=mysql_fetch_assoc($lnkp);
	     $provinceName=$rowp['province_name'];
		
		?>
<div align="center"><!--
		    <table align="center" width=80%>
					  <tr >
			              <td id="tableProduct" style="display:block;"><?php //  dspHavaleProdFrm() ?>
	
	--><form  id="formprod" name="formprod" method="post" action="" >
	   	
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="addedprod"> 
		
		<table   align="center" class="nasi" style="width:70%;margin-top:0px;">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		  	  
		      <td colspan="9"  style="height: 50px;vertical-align:middle;"  align="center" ><b> ريزكالاهاي قابل تحويل</b></td>
	        </tr>
	          <tr>
	           <td colspan="9"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	       
	      	<tr>
		       	<td width=10%;><center><b> کد کالاي مربوطه  :</b></center> </td>
		      
		       	
		       	<td><input type="text"  name="p_code"  id="p_code"  onkeypress="searchProd(event,<?php echo $_SESSION['dm_user_profile']['u_province_id']  ?>);" ></input><span id="p_code"></span> </td>
		       	
<!--		       	<td align="center" width="20%"><input type="text" name="p_code"  value="" id="inputString" onkeyup="lookup(this.value);"   onblur="fill();"></td>-->
<!--		        <div class="suggestionsBox" id="suggestions" style="display: none;">-->
<!--				<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />-->
<!--				<div class="suggestionList" id="autoSuggestionsList">-->
<!--				&nbsp;-->
<!--				</div>-->
<!--			</div>-->
		       	<!--		       	
		  	<td><?php echo getProdCombo()?></td>
				-->
<!--				<td><span style="color:red;">*</span><button type="button"  onclick="hndlProdComboChng();" class="button blue skew" style="font-size:10px; color:#FFFFFF">بررسی </button></td>				-->
<!--				<td width=15%><b>نام کالا : </b></td>-->
<!--		        <td ><span id="p_name" ></span></td>-->
					<td ><b>کد قیمت</b> </td>
	
	            <td><input name="p_price_combo" id="p_price_combo" ></input></td> 
	                
	        </tr>
	      	<tr>
		        <td ><center><b>مقدار :</b></center> </td>
		        <td><input name="phd_amount" id="phd_amount" type="text"  /></td> 
		         
		        <td ><center><b>واحد :</b></center> </td>
               <td>
			  		<?php echo getUnit_phTypesComboBox('phd_id_unit')?>
				</td>	       
		    </tr>
	        <tr>
	             <td ><center> <b>مانده </b> : </center> </td>
		        <td  ><input name="phd_amount_remined" id="phd_amount_remined" type="text"  onBlur="this.value=formatCurrency(this.value);" onkeyup="isNumber(this)"/></td>
	        </tr>
	       
	        <tr>
			    <td colspan="7"><hr></td>			             
		   </tr>
	      	
		  	<tr>
		        <td colspan="7" align="center" style="height: 40px;vertical-align:middle;"><b>محل هاي تحويل كالا</b></td>
	        </tr>
	        <tr>
	            <td  ><b>كد محل :</b></td>
		        <td ><?php echo getLocationCombo(); ?></td>
			    <td ><b> نام محل   :</b></td>
		        <td><span name="l_name" id="l_name" ></span></td>
	      	</tr>
	      	<tr>
	      	    <!--
	      	     <td >تحويل با </td>
	      	     <td><?php echo getDeliveryTypesComboBox('phd_deli_with')?></td>
		        
				 --><td width="20%" ><b>نام تحويل گيرنده: </b></td>
		         <td width="25%"><input name="phd_deli_name" id="phd_deli_name" type="text"  /></td>
		         <td colspan="2">&nbsp;</td>
		         <td colspan="2">&nbsp;</td>
		          <td >&nbsp;</td>
	        </tr>
	    <!--     <tr>   
		             <td >نوع فروش  </td>
                     <td><?php echo getselltypes('dts_id'); ?></td>
                     <td>&nbsp;</td>
                      <td id="row1" display="none" ><?php echo gettahator('ph_tahator'); ?></td> -->
                                     
<!--		    </tr>-->
<!--		    <tr id="row1">   -->
<!--		            -->
<!--                      <td>&nbsp;</td>-->
<!--                      <td>&nbsp;</td>                   -->
<!--		    </tr>-->
		 <!--     <tr id="row2"  display="none"  >
		     <td>نوع:</td>
                      <td><?php echo getzemanat('ph_zemanat'); ?></td> 
                      <td>به مدت</td>
                    <td>  <input name="ph_modat" id="ph_modat" type="text"  /></td>
                      
		    </tr>-->
		    <!--  <tr>   
		               <td><span id="ph_modat" ></span></td> 
                     
                                          
		    </tr> -->
	        <tr>	      	    		        
				 <td width="15%" align="right">&nbsp; </td>
		         <td width="15%" align="right">&nbsp; </td>
		         <td colspan="2">&nbsp;</td>
		         <td colspan="2">&nbsp;</td>
		          <td >&nbsp;</td>
	        </tr>
	      
	        </table>   
	      	
	      	<?php 
	      
	      	$display='1'; 
		//      	<td colspan="3"><input type="button" value="اضافه" onclick="addAProd2Bill()"><input type="submit" value="ثبت" ></td>
		      	?>
		      	<div style="align:center;">
		      	<div width="60%" align="center">
		        <span ><button type="button" value="اضافه" onclick="addAProd2BillCheck()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >اضافه</button></span>
                <span ><button type="button" onclick="window.open('printPh.php?PhNo=<?php echo $PhNum ?>&reqNo=<?php echo $cm_req_num ?>
				     &cus_name=<?php echo $rowcus['name_customer'] ?>&cus_economic=<?php echo $cInfo[$fieldPrefix.'code_economic_customer'] ?>&cus_postal=<?php echo $cInfo[$fieldPrefix.'code_postal_costumer'] ?>&cus_address_office=<?php echo $cInfo[$fieldPrefix.'customer_address_office'] ?>
				     &cus_tel=<?php echo $cInfo[$fieldPrefix.'customer_tel'] ?>&cus_type=<?php echo $Type ?>&cm_req_date=<?php echo $cm_req_date ?>&cus_category=<?php echo $cInfo[$fieldPrefix.'customer_category'] ?>&status=<?php echo 1 ?>&province_name=<?php echo $provinceName ?>&province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id']?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>&status=<?php echo 1 ?>','_blank')" 
				     class="button blue skew" style="font-size:10px; color:#FFFFFF;width:20%;" >   رویت پيش حواله	</button></span>			 
			    <span >
			    
			    
			    <button type="button" onclick="window.open('?pg=PfactorMgmtPg&cmd=dspPishHavale&ph_code=<?php echo $PhNum ?>&display=<?php echo $display ?>
				     &cus_name=<?php echo urlencode($rowcus['name_customer']) ?>&cus_economic=<?php echo $cInfo[$fieldPrefix.'code_economic_customer'] ?>&cus_postal=<?php echo $cInfo[$fieldPrefix.'code_postal_costumer'] ?>&cus_address_office=<?php echo $cInfo[$fieldPrefix.'customer_address_office'] ?>
				     &cus_tel=<?php echo $cInfo[$fieldPrefix.'customer_tel'] ?>&cus_type=<?php echo $cInfo[$fieldPrefix.'ph_customer_type'] ?>&cus_type=<?php echo $Type ?>&cm_req_date=<?php echo $cm_req_date ?>&cus_category=<?php echo $cInfo[$fieldPrefix.'customer_category'] ?>&status=<?php print $display  ?>&provinceName=<?php $provinceName ?>&province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>','_self')" 
				     class="button blue skew" style="font-size:10px; color:#FFFFFF;width:20%;"  onclick="this.disabled=true"; >   ايجاد پيش فاكتور	</button></span>
				     
				     <span ><button type="button" onclick="window.open('?pg=PfactorMgmtPg&cmd=moarefi&ph_code=<?php echo $PhNum ?>&display=<?php echo $display ?>
				     &cus_name=<?php echo $cInfo[$fieldPrefix.'name_customer'] ?>&cus_economic=<?php echo $cInfo[$fieldPrefix.'code_economic_customer'] ?>&cus_postal=<?php echo $cInfo[$fieldPrefix.'code_postal_costumer'] ?>&cus_address_office=<?php echo $cInfo[$fieldPrefix.'customer_address_office'] ?>
				     &cus_tel=<?php echo $cInfo[$fieldPrefix.'customer_tel'] ?>&cus_type=<?php echo $cInfo[$fieldPrefix.'ph_customer_type'] ?>&cus_type=<?php echo $Type ?>&cm_req_date=<?php echo $cm_req_date ?>&cus_category=<?php echo $cInfo[$fieldPrefix.'customer_category'] ?>&status=<?php print $display  ?>&provinceName=<?php $provinceName ?>&province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>','_self')" 
				     class="button blue skew" style="font-size:10px; color:#FFFFFF;width:20%;"  >   ايجاد معرفی نامه	</button></span>
				    <span> <input type="button" onclick="formReset()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:20%;" value="پاك كردن صفحه" /></span> 
<!--			     <span ><button type="button" onclick="window.open('?pg=PfactorMgmtPg&cmd=moarefinameh&ph_code=<?php echo $PhNum ?>&display=<?php echo $display ?>-->
<!--				     &cus_name=<?php echo $cInfo[$fieldPrefix.'name_customer'] ?>&cus_economic=<?php echo $cInfo[$fieldPrefix.'code_economic_customer'] ?>&cus_postal=<?php echo $cInfo[$fieldPrefix.'code_postal_costumer'] ?>&cus_address_office=<?php echo $cInfo[$fieldPrefix.'customer_address_office'] ?>-->
<!--				     &cus_tel=<?php echo $cInfo[$fieldPrefix.'customer_tel'] ?>&cus_type=<?php echo $cInfo[$fieldPrefix.'ph_customer_type'] ?>&cus_type=<?php echo $cInfo[$fieldPrefix.'customer_category']?>&cm_req_date=<?php echo $cm_req_date ?>&cus_category=<?php echo $cInfo[$fieldPrefix.'customer_category'] ?>&status=<?php print $display  ?>&province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>','_self')" -->
<!--				     class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;"  >   ايجاد معرفي نامه	</button></span>		   		-->
              
				      			      
	      	</div>
	      	</div>
	    </table>
	    <br></br>
	</form>
</div>
 <br>
				      <div id="addedProdsCntnr" style="direction: rtl;"></div>
				    
<!--			</div>-->
<!--			              </td>-->
<!--		            </tr>	        -->
<!--				    <tr>      -->
<!--				         <td id="Analyzetable" style="display:none;">جدول آنالیز</td>		   -->
<!--	             	</tr> -->
<!--		   </table> -->
		
		  <?php
//		  		  <input name="input" type="button" value="Create PDF" onclick="fObj('printWrapperPoster').value = fObj('printWrapper').innerHTML; fObj('printWrapperPosterForm').submit()" />
		  
}
function getselltypes($id='dts_id'){

//	<select id="'.$id.'" name="'.$id.'" onchange="hndltypesell(\'\', this.value)"><option value=""> انتخاب كنيد</option>
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndltypesell(\'\', this.value)"><option value=""> انتخاب كنيد</option>';
	$lnk = mysql_query("SELECT * FROM dm_type_sell where  1");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option id="dts_id"  value="'.$row['dts_id'].'" >'.  $row['dts_name'].'</option>';
			
		}
		}
	
	$out .= '</select>';
	return $out;
}
function gettahator($id='ph_tahator'){
	
$out = '<select id="ph_tahator"  name="ph_tahator" ><option value=""> انتخاب كنيد</option>';
				$lnk = mysql_query("SELECT * FROM dm_type_tahator  where  1");
				if(mysql_num_rows($lnk)>0){
					while($row=mysql_fetch_assoc($lnk)){
						$out .= '<option value="'.$row['dtt_id'].'" >'.$row['dtt_name'].'</option>';
						
					}
				}
				$out .= '</select>';
	return $out;
	
}
function getzemanat($id='ph_zemanat'){
	
 $out = '<select id="ph_zemanat"  name="ph_zemanat"  ><option value=""> انتخاب كنيد</option>';
						$lnk = mysql_query("SELECT * FROM dm_type_tazmin where 1");
						if(mysql_num_rows($lnk)>0){
							while($row=mysql_fetch_assoc($lnk)){
								$out .= '<option  id="ph_zemanat" value="'.$row['dtz_id'].'" >'.$row['dtz_name'].'</option>';
								
							}
						}
					$out .= '</select>';
	return $out;
}
function dspHavaleProdFrm(){
	
	

?>
	
	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="addedprod"> 
		  
		<table   border="2"  class="table" >
		  	<tr align="center">
		        <td colspan="6"  >جدول ریز کالاهای قابل تحویل</td>
	        </tr>
	      	<tr>
		       	<td ><center>کد کالا </center> </td>
			  	<td ><?php echo getProdCombo()?></td>
				<td >نام کالا </td>
		        <td><span id="p_name" ></span></td>
				<td >کد قیمت </td>
		        <td ><span id="p_price_combo" ></span></td>
		        
	        </tr>
	      	<tr>
		        <td ><center>مقدار </center> </td>
		        <td><input name="phd_amount" id="phd_amount" type="text"  /></td>
		        <td ><center>مانده جنسی </center> </td>
		        <td><input name="phd_amount_remined" id="phd_amount_remined" type="text" /></td>
	        </tr>
	      	
		  	<tr align="center">
		        <td colspan="6" align="center" >محل هاي تحويل كالا</td>
	        </tr>
	        <tr>
	            <td >كد محل </td>
		        <td><?php echo getLocationCombo(); ?></td>
			    <td >نام محل </td>
		        <td><span name="l_name" id="l_name" ></span></td>
	      	</tr>
	      	<tr>
	      	     <td style="vertical-align:bottom" align="right"><img src="images/corner4.png"  border="0"></img></td>
	      	     <td >تحويل با </td>
		         <td><input name="phd_deli_with" id="phd_deli_with" type="text"  /></td>
				 <td >نام تحويل گيرنده </td>
		         <td><input name="phd_deli_name" id="phd_deli_name" type="text"  /></td>
		         
	        </tr>   
	      	<tr>
	      	<?php 
	      
		//      	<td colspan="3"><input type="button" value="اضافه" onclick="addAProd2Bill()"><input type="submit" value="ثبت" ></td>
		      	?>
		     <td colspan="3"><input type="button" value="اضافه" onclick="addAProd2Bill()"><input type="button" onclick="window.open('printPh.php?Ph=<?php echo $PhNum ?>','_self')" value=" رویت حواله" >
		      	
	      	</tr>
	    </table>
	</form>
	  
	<?php
}

function dspInfCusEdit(){
	
	$ha_mot_id = isset($_REQUEST['ha_mot_id']) ? (int)($_REQUEST['ha_mot_id']) : 0;
	if($ha_mot_id<1) die('Invalid  id!');
	
	$lnk = mysql_query("SELECT * FROM dm_havale_motinf WHERE ha_mot_id=".$ha_mot_id);
	if(mysql_affected_rows()>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid id!');
	}
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="upInfCusHavale">   
		<input type="hidden" name="ha_mot_id" value="<?php echo $ha_mot_id; ?>">   
		<table  bgcolor=#82a9c align="center" border="2">
		  	<tr align="center">
		        <td colspan="6" align="center" ><h2>مشخصات مشتری </h2></td>
	        </tr>
	        <tr>
		       	<td ><center>شماره درخواست </center> </td>
			  	
		        <td><input name="ha_mot_Nreq" type="text" value="<?php echo $row['ha_mot_Nreq']; ?>" /></td>
				
				<td >تاریخ درخواست </td>
		        
		          <td><input name="ha_mot_Rdate" type="text" value="<?php echo $row['ha_mot_Rdate']; ?>" /></td>
	        </tr> 
	      	<tr>
		       	<td ><center>نام مشتری </center> </td>
			  	
		        <td><input name="ha_mot_customer" type="text" value="<?php echo $row['ha_mot_customer']; ?>" /></td>
				
				<td >شناسه اقتصادی/ملی مشتری </td>
		        
		          <td><input name="ha_mot_economic" type="text" value="<?php echo $row['ha_mot_economic']; ?>" /></td>
	        </tr> 
	        <tr>
		       	<td ><center>کدپستی </center> </td>
			  	
		        <td><input name="ha_mot_postcode" type="text" value="<?php echo $row['ha_mot_postcode']; ?>" /></td>
				
				<td >آدرس دفتر </td>
		        
		          <td><input name="ha_mot_address" type="text" value="<?php echo $row['ha_mot_address']; ?>" /></td>
	        </tr>  
			<tr>
			<td >تلفن </td>
		        
		          <td><input name="ha_mot_tel" type="text" value="<?php echo $row['ha_mot_tel']; ?>" /></td>
	      		<td colspan="3"><input type="submit" value="تایید" ></td>
	      	</tr>
	    </table>
	</form> 
	    
	<?php
		
 	
 }
 
function upInfCusHavale(){
	
	$ha_mot_id = isset($_POST['ha_mot_id']) ? (int)($_POST['ha_mot_id']) : 0;
	if($ha_mot_id<1) die('Inv Id');
	
	$ha_mot_Nreq = isset($_POST['ha_mot_Nreq']) ? $_POST['ha_mot_Nreq'] : '';
	$ha_mot_Rdate = isset($_POST['ha_mot_Rdate']) ? $_POST['ha_mot_Rdate'] : '';
	$ha_mot_customer = isset($_POST['ha_mot_customer']) ? $_POST['ha_mot_customer'] : '';
	$ha_mot_economic = isset($_POST['ha_mot_economic']) ? $_POST['ha_mot_economic'] : '';
	$ha_mot_postcode = isset($_POST['ha_mot_postcode']) ? $_POST['ha_mot_postcode'] : '';
	$ha_mot_address = isset($_POST['ha_mot_address']) ? $_POST['ha_mot_address'] : '';
    $ha_mot_tel = isset($_POST['ha_mot_tel']) ? $_POST['ha_mot_tel'] : '';
	$hcode=(91 * $h_code)+ $h_code;
	
	$query = "
		UPDATE dm_havale_motinf 
		SET 
			`ha_mot_Nreq` = '".$ha_mot_Nreq."',
			 
			`ha_mot_Rdate` = '".$ha_mot_Rdate."',
			`ha_mot_economic` = '".$ha_mot_economic."',
			`ha_mot_customer` = '".$ha_mot_customer."',

			`ha_mot_postcode` = '".$ha_mot_postcode."', 
			`ha_mot_address` = '".$ha_mot_address."',
			 
			`ha_mot_tel` = '".$ha_mot_tel."' 
		
		WHERE 
			ha_mot_id = ".$ha_mot_id." 
	";
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();	
}
  
function dspPreHavaleList(){
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
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodePhavale">
			<table border=0 >
			  <tr> 
			    <td>
			        شماره پیش حواله ویا شماره مجوز را وارد کنید 
			    </td>
			  <tr>
			  <div id="search">
			  
			     <td>
			     <div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;" /> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
			     </td>
                 
              </tr>
              </table>
		</form>
	';
	

	$outHtml .= '	
	<div align="center">
		<div align = "center" style="width:90%;height:500px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" class="list">
      			<tr class="rw0">
        			<th colspan="21" align="center" scope="row" style="height:50px;vertical-align:middle;font-size:20px;"><center> لیست پیش حواله ها</center> </th>
        		</tr>
      			<tr class="rw1" style="font-weight:bold;">
			        <td align="center">ردیف</td>
			        <td align="center">شماره پیش حواله</td>
			        <td align="center">تاریخ پیش حواله </td>
			        <td align="center">شماره مجوز </td>
			        <td align="center">نام مشتری </td>			 
			        <td align="center">وضعیت</td>
			        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			              
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
				ph_code LIKE '%".$_SESSION['srchStr']."%' 
				or
				ph_mojavez LIKE  '%".$_SESSION['srchStr']."%'
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_pish_havale ph
			left join dm_pish_havale_det phd
			on ph.ph_code=phd.phd_ph_code
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		
	 AND 
	  ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	  AND
	   phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	  AND
	  ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	  group by ph_code
	  
	  ORDER BY ph_code desc
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
//	print $genQuery;
	
	$_SESSION['srchStr'] = '';
	$lnk1 = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
		$queryd='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'311\' and t.um_can_delete =1';
                   // print $queryd;
			                    	
	   $lnkd = mysql_query($queryd);

	   if ((mysql_num_rows($lnkd)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
	   	
	   	$statusd=1;
	   }
		while($row = mysql_fetch_assoc($lnk1)){
			
			$gdate=$row['ph_reg_date'];
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
			$queryp="SELECT * FROM 
	                  dm_province  
		            WHERE
		               province_id=". $_SESSION['dm_user_profile']['u_province_id']."
		             ";		            	
			$lnkp=mysql_query($queryp);			
			$rowp=mysql_fetch_assoc($lnkp);
			$province_code=$rowp['province_code'];
		//	if($row['ph_customer_type']=='n'){
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$row['ph_customer_code']."'
                             AND                             
						    	customer_code_org='".$province_code."'	
						    	
								";						
    			$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
					//	$Type='معمولی';
						
//		$querychek = " SELECT *  FROM dm_havale h
//                     left join dm_pish_factor pf on h.h_pf_code=pf.pf_code
//                     left join  dm_pish_havale ph  on  ph.ph_code=pf.pf_ph_code
//                     left join dm_pish_havale_det phd  on phd.phd_ph_code=ph.ph_code					 
//				WHERE 
//				  phd_status= 1
//				AND	
//					phd_id_province='".$province_code."'
//                AND
//				    pf_id_province='".$province_code."'
//				AND
//				    ph_id_province='".$province_code."'	
//				AND
//				    h_id_province='".$province_code."' 
//				AND
//				    ph_code='".$row['ph_code']."'
//                      group by h_code					
//					";					 	    					   
//    			$lnkchek = mysql_query($querychek);
//			if(mysql_num_rows($lnkchek)>0)
if($row['phd_status']==1)
		{
$Type='حواله دارد';
			
		}else{
			
		$Type='حواله ندارد';	
			
		}			
						
			
//		}else{
//				$query = "
//					 	SELECT *  FROM dm_customer_mot 
//				 
//						WHERE 
//							cm_customer_id = '".$row['ph_customer_code']."' ";		
//								
//				$lnk = mysql_query($query);
//				sqlErr('for customer1');
//				$cusMainInfo = mysql_fetch_assoc($lnk);	
//						$cusName=$cusMainInfo['cm_name_customer'];
//						$Type='متفرقه';				
//	            	}
	            	
			$outHtml .= ' 
			<div id="phavale_'.$row['ph_id'].'" style="display:block;">
				<tr class='.$class.'>
						<td style="vertical-align:middle;" align="center" width="5%">'.$inx.'</td>
						<td style="vertical-align:middle;" align="center" width="15%">'.$row['ph_code'].'</td>
						<td style="vertical-align:middle;" align="center" width="15%">'.$jdate.'</td>
						<td style="vertical-align:middle;" align="center" width="15%">'.$row['ph_mojavez'].'</td>
						<td style="vertical-align:middle;" align="center" width="15%">'.$cusName.'</td>
						<td style="vertical-align:middle;" align="center"  width="15%">'.$Type.'</td>';
			 $query2='select *
								from dm_um_rel t
									     inner join dm_listmenu l on l.menu_id = t.um_menu_id
										where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												    l.menu_code = \'311\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_num_rows($lnk)==0){
			                    	$outHtml .= '<td  style="vertical-align:middle;"  width="5%" align="center"> <span style="cursor:pointer" onclick="Access(); ><img src="images/delete.PNG" width="100%" height="100%" title="حذف"  "></img></span>';
			                    	
			                    }else{
			                    	
			                    	
			   if ($statusd==1){
			                    	
									$outHtml .= '<td  style="vertical-align:middle;"   width="5%" align="center"> <span style="cursor:pointer" onclick="DeletePHavale(\'\', \''.$row['ph_id'].'\')" ><img src="images/delete.PNG" width="100%" height="100%" title="حذف"  "></img></span>';}
			                    	}
									$outHtml .= '<td  width="5%"><a href="?pg=havaleMgmtPg&cmd=ShowAPhavale&ph_code='.$row['ph_code'].'"><img src="images/display.png" width="40%" height="40%" title="مشاهده"></img> </a></td>
				</tr>
			</div>
			
			';
			$inx++;
		}
    }else{
    	$outHtml .= '<tr ><td colspan="5">هیچ اطلاعاتي موجود نیست</td></tr>';
    }
    $outHtml .= '</table></div ><br><div align="center" >'.getNavBar_ph().' </div>'.getRPPCombo_ph();
    return $outHtml;
    		
}
function getNavBar_ph(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=havaleMgmtPg&cmd=dspPreHavaleList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=havaleMgmtPg&cmd=dspPreHavaleList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=havaleMgmtPg&cmd=dspPreHavaleList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=havaleMgmtPg&cmd=dspPreHavaleList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=havaleMgmtPg&cmd=dspPreHavaleList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_ph(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=havaleMgmtPg&cmd=dspPreHavaleList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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
function ListMoarefieb(){
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
	$outHtml = '<br>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchMoarefieb"> 
			 <b>كد معرفي نامه مورد نظر را جستجو كنيد </b>
			<div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
		</form>
	';
		
	$outHtml .= '	
		<div align = "center" style="width:100%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" class="list" >
      			<tr class="rw1">
        			<td colspan="19" align="center" scope="row" style="height: 60px;vertical-align:middle;font-size:20px;">ليست معرفي نامه های ابطالی</td>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">رديف</td>
			        <td align="center">شماره معرفي نامه </td>
			        
			        <td align="center">شماره پيش حواله </td>
			        <td align="center">نوع مشتری&nbsp; </td>
			        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;  نام مشتری</td>			       		        
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
					pf_code LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_pish_factor 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		AND
	     	pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	    AND 
	       pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	     AND 
	       pf_type=". 1 ."
	      AND
	      pf_type_m=". 1 ."
	       ORDER BY pf_code ASC";

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
			
			$gdate=$row['pf_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				 
				 $query1 = "
						 	SELECT *  FROM dm_pish_havale 
					 
							WHERE 
								ph_code = ".$row['pf_ph_code']."
							AND 
							    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
						  AND 
	                           ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						";			
						$lnk1 = mysql_query($query1);
						sqlErr('for Display pfactor');
						$row1= mysql_fetch_assoc($lnk1);
						
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
		
		if($row1['ph_customer_type']=='n'){
						$querycu = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$row1['ph_customer_code']."' 
							  AND
			                    customer_code_org=".$province_code."";		
				
    			$lnkcu = mysql_query($querycu);
    		//	print $query;
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnkcu);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولی';
			
		}else{
				$query = "
					 	SELECT *  FROM dm_customer_mot 
				 
						WHERE 
							cm_customer_id = '".$row1['ph_customer_code']."' ";		
								
				$lnk = mysql_query($query);
				sqlErr('for customer1');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['cm_name_customer'];
						$Type='متفرقه';				
	            	}
			$outHtml .= '
			<div id="Pfactor_'.$row['pf_id'].'" >
				<tr class='.$class.'>
					<td align="center" width=5% style="vertical-align:middle;"> '.$inx.'</td>
					<td align="center" width=15%>'.$row['pf_code'].'</td>
					
					<td align="center" width=15%>'.$row['pf_ph_code'].'</td>
					<td align="center" width=10%>'.$Type.'</td>
					<td align="center" width=20%>'.$cusName.'</td>
					<td align="center"> <span style="cursor:pointer" onclick="DeletePfactor(\'\', \''.$row['pf_id'].'\')" ><font color=red><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img>
					</font></span></td>
					<td align="center"><a href="?pg=havaleMgmtPg&cmd=ShowAmoarefi&pf_id='.$row['pf_id'].'&m_status='. 1 .'"><img src="images/display.png" width="20" height="20" title="مشاهده كل اطلاعات" ></img></a></td>
					
				</tr></div>
			';
			$inx++;
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">اطلاعاتي موجود نيست</td></tr>';
    }
    $outHtml .= '</table></div><div align="center">'.getNavBar_Meb().' '.getRPPCombo_Meb().'</div>';
    echo $outHtml;
	
}
function getNavBar_Meb(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=pg=havaleMgmtPg&cmd=ListMoarefieb&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=pg=havaleMgmtPg&cmd=ListMoarefieb&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=pg=havaleMgmtPg&cmd=ListMoarefi&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=pg=havaleMgmtPg&cmd=ListMoarefieb&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=pg=havaleMgmtPg&cmd=ListMoarefieb&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_Meb(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=havaleMgmtPg&cmd=ListMoarefieb&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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

function ListMoarefi(){
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
	$outHtml = '<br>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchMoarefi"> 
			 <b>كد معرفي نامه مورد نظر را جستجو كنيد </b>
			<div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
		</form>
	';
		
	$outHtml .= '	
		<div align = "center" style="width:100%;height:400px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" class="list" >
      			<tr class="rw1">
        			<td colspan="19" align="center" scope="row" style="height: 60px;vertical-align:middle;font-size:20px;">ليست معرفي نامه ها</td>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">رديف</td>
			        <td align="center">شماره معرفي نامه </td>
			        
			        <td align="center">شماره پيش حواله </td>
			        <td align="center">نوع مشتري&nbsp; </td>
			        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;  نام مشتري</td>			       		        
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
					pf_code LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_pish_factor 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		AND
	     	pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	    AND 
	       pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	     AND 
	       pf_type=". 1 ."
	      AND
	      pf_type_m=". 0 ."
	       ORDER BY pf_code ASC
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
	//echo $resQuery;
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){

		while($row = mysql_fetch_assoc($lnk)){
				
			$gdate=$row['pf_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				 
				 $query1 = "
						 	SELECT *  FROM dm_pish_havale 
					 
							WHERE 
								ph_code = ".$row['pf_ph_code']."
							AND 
							    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
						  
						";			
						$lnk1 = mysql_query($query1);
						sqlErr('for Display pfactor');
						$row1= mysql_fetch_assoc($lnk1);
						
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
		
		//if($row1['ph_customer_type']=='n'){
						$querycu = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$row1['ph_customer_code']."' 
							  AND
			                    customer_code_org=".$province_code."";		
				
    			$lnkcu = mysql_query($querycu);
    		//	print $query;
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnkcu);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولی';
			
//		}else{
//				$query = "
//					 	SELECT *  FROM dm_customer_mot 
//				 
//						WHERE 
//							cm_customer_id = '".$row1['ph_customer_code']."' ";		
//								
//				$lnk = mysql_query($query);
//				sqlErr('for customer1');
//				$cusMainInfo = mysql_fetch_assoc($lnk);	
//						$cusName=$cusMainInfo['cm_name_customer'];
//						$Type='متفرقه';				
//	            	}
			$outHtml .= '
			<div id="Pfactor_'.$row['pf_id'].'" >
				<tr class='.$class.'>
					<td align="center" width=5% style="vertical-align:middle;"> '.$inx.'</td>
					<td align="center" width=15%>'.$row['pf_code'].'</td>
					
					<td align="center" width=15%>'.$row['pf_ph_code'].'</td>
					<td align="center" width=10%>'.$Type.'</td>
					<td align="center" width=20%>'.$cusName.'</td>
					<td align="center"> <span style="cursor:pointer" onclick="DeletePfactor(\'\', \''.$row['pf_id'].'\')" ><font color=red><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img>
					</font></span></td>
					<td align="center"><a href="?pg=havaleMgmtPg&cmd=ShowAmoarefi&pf_id='.$row['pf_id'].'"><img src="images/display.png" width="20" height="20" title="مشاهده كل اطلاعات" ></img></a></td>
					
				</tr></div>
			';
			$inx++;
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">اطلاعاتي موجود نيست</td></tr>';
    }
    $outHtml .= '</table></div><div align="center">'.getNavBar_M().' '.getRPPCombo_M().'</div>';
    echo $outHtml;
	
}
function getNavBar_M(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=pg=havaleMgmtPg&cmd=ListMoarefi&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=pg=havaleMgmtPg&cmd=ListMoarefi&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=pg=havaleMgmtPg&cmd=ListMoarefi&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=pg=havaleMgmtPg&cmd=ListMoarefi&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=pg=havaleMgmtPg&cmd=ListMoarefi&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_M(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=havaleMgmtPg&cmd=ListMoarefi&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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

function ShowAmoarefi(){
	
				
	$pf_id = isset($_REQUEST['pf_id']) ? $_REQUEST['pf_id'] : '';
	$m_status = isset($_REQUEST['m_status']) ? $_REQUEST['m_status'] : '';
	
	$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		    $province_code=$rowprov['province_code'];
	$query5 = "
				 SELECT *  FROM dm_customer 						 
								WHERE 
									code_customer = '".$havaleMainInfo['ph_customer_code']."'

									AND
			             customer_code_org=".$province_code."";
									
							//	print $query5;			   					
						$lnk5 = mysql_query($query5);
						$row5= mysql_fetch_assoc($lnk5);
	
	$query = "
	 	SELECT *  FROM dm_pish_factor 
 
		WHERE 
			pf_id = '".$pf_id."' 
		  
	";
//print 	$query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$row= mysql_fetch_assoc($lnk);
	
	$ph_code=$row['pf_ph_code'];
	$pf_code=$row['pf_code'];
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
       if($m_status==1){
       $sharh='معرفی‌نامه ابطال شده';
       }else{
       $sharh='	معرفی نامه';	
       }
	$outHtml  = '<div dir="rtl">
	                   <br>
						<table  style=" align="center"  width="100%" class="list" margin-top:20px" >
					  	<tr align="middle" class="rw1">
					      <td colspan="14"  style="height: 50px;vertical-align:middle;"  ><font size="5">'. $sharh .'</font-size></td>
				        </tr>
		';
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND
		   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		 AND 
	       ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	";
//print 	$query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		
		$gdate=$havaleMainInfo['ph_reg_date'];
		list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
		list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
		$ph_reg_date = $jyear."/".$jmonth."/".$jday;
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_code'];
		
	if($havaleMainInfo['ph_customer_type']=='n'){
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$havaleMainInfo['ph_customer_code']."' 
								AND
			             customer_code_org=".$province_code."";		
				
				$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولي';
			
		}else{
				$query = "
					 	SELECT *  FROM dm_customer_mot 
				 
						WHERE 
							cm_customer_id = '".$havaleMainInfo['ph_customer_code']."' ";		
								
				$lnk = mysql_query($query);
				sqlErr('for customer1');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['cm_name_customer'];
						$Type='متفرقه';				
	            	}
		
		$outHtml .= '
			<tr class="rw0" style="font-weight:bold;">
			<td colspan="2">تاريخ:'. "$ph_reg_date ".'</td>
			<td colspan="2">شماره معرفي نامه:'.$pf_code.'</td>
 		    <td colspan="2">پيش حواله به شماره : '.$havaleMainInfo['ph_code'].'</td><td > به نام :'.$cusName.'</td>
			</tr> 	
		';
		
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
		 AND 
	            phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	      AND 
	            phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
	
		if(mysql_error()) print mysql_error();
		if(mysql_affected_rows()>0){
			$outHtml .= '
		          <tr  class="rw1"><td colspan="13"><hr></td></tr>
				<tr class="rw1">
					<td colspan="12" align=center>
					 
					   <b> ريز معرفي نامه</b>
					</td>
				</tr>
						<tr class="rw0" style="font-weight:bold;height:20px;">
							<td >رديف</td>
							<td >نام کالا</td>
							<td>كد كالا</td>
							<td>كد قيمت</td>
							<td>مقدار خريد</td>
						    <td>قيمت واحد </td>
						    <td>قيمت با هزينه </td>
							<td colspan="2">قيمت كالا </td>
						</tr>
		</div>
			';
			$inx = 0;
			
			while($row= mysql_fetch_assoc($lnk)){
				$query2 = "
						SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
						 
								WHERE 
									p_code = ".$row['phd_pid']."
                               AND
                                   p_price_code=".$row['phd_price_code']."
                                   and
			          price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
                                   
                                   ";
		
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				$inx++;
				if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				
				$outHtml .= '
						<tr class="'.$class.'">
							<td  style="vertical-align:middle;">'.$inx.'</td>
							<td  style="vertical-align:middle;">'.$row2['p_name'].'</td>
							<td  style="vertical-align:middle;">'.$row2['p_code'].'</td>
							<td  style="vertical-align:middle;">'.$row['phd_price_code'].'</td>
							<td  style="vertical-align:middle;">'.$row['phd_amount'].'</td>';
				$query = "
		 	          SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
	 
			WHERE 
				p_code = ".$row['phd_pid']." 
			AND
			 p_price_code=".$row['phd_price_code']."
			and
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		";
	//			print  $query;
				$ln = mysql_query($query);
				
				if(mysql_error()) print mysql_error();
				$prod= mysql_fetch_assoc($ln);
				$price=$row['phd_amount']*$prod['p_unit'];
							
							$outHtml .= '<td >'.$prod['p_sellprice'].'</td>
							             <td >'.$prod['p_sellpriceh'].'</td>
											<td >'.$row['phd_price'].'</td>
								        
								         </tr>  
								          
					';
				$totalprice =$row['phd_price']+$totalprice;
				
			}
			
			$outHtml .= '
					<tr>
				     <td> جمع کل:'.$totalprice.'</td>
				     <td colspan="11">&nbsp;&nbsp;&nbsp;</td>
					</tr>';				
					 
	 $outHtml .=' <tr>	      	         
		              <td colspan="8" align="left"> <span> <button type="button" onclick=window.open("PrintMoarefi.php?PhNo='.$ph_code.'&reqNo='.urlencode($havaleMainInfo['cm_req_num']).'&cus_name='.urlencode($cusName).'&cus_economic='.urlencode( $code_economic_customer ).'&cus_postal='.  urlencode($cInfo[$fieldPrefix.'code_postal_costumer']) .'&cus_address_office='. urlencode($cInfo[$fieldPrefix.'customer_address_office']) .'&cus_tel='. urlencode($cInfo[$fieldPrefix.'customer_tel']) .'&cus_type='. $Type .'&cm_req_date='. urlencode($havaleMainInfo['cm_req_date']) .'&cus_category='. urlencode($cInfo[$fieldPrefix.'customer_category']) .'&status='. 1 .'&province_name='.urlencode($provinceName).'&province_id='.  $_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.  $_SESSION['dm_user_profile']['u_year_id'] .'&m_status='.  $m_status .'","_blank") value=" چاپ معرفي نامه"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ معرفي نامه</button></span> </td>					                          																				             																				
		              
	           	</tr>
	      	  </table>
	 </td>
	</tr>
	</table>
			</div>
			<br>';
						
		}

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره معرفي نامه نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</td>
	</tr>
	
			</table>
			';
	echo  $outHtml;
			
}
function ShowAPhavale(){
	
	
	$query = "
				select  * FROM dm_province
			 
					WHERE 
						province_id = ".$_SESSION['dm_user_profile']['u_province_id']." ";
		
			$lnk = mysql_query($query);
			$row = mysql_fetch_assoc($lnk);
			$province_name=$row['province_name'];
	
	$outHtml='<br><div>
	             <table  align="center"  class="list"   border="1">
		  	<tr class="rw1">
		       <td colspan="10"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">مشخصات پیش حواله</font></b></td>
	        </tr>
<tr>';
	
    $ph_code = isset($_REQUEST['ph_code']) ? (int)($_REQUEST['ph_code']) : 0;
	if($ph_code<1) die('Invalid  id!');
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
		$queryph = "
		SELECt * FROM dm_pish_havale
	 
			WHERE 
				ph_code = ".$ph_code." 
			AND 
				ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			AND
				ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
				
		
		";
	//	print $query;
		$lnkph = mysql_query($queryph);
	
	if(mysql_affected_rows()>0){
		$rowph = mysql_fetch_assoc($lnkph);
	$ph_customer_type=$rowph['ph_customer_type'];
		if($ph_customer_type='n'){
			$Type='معمولی';
			$query = "
				SELECt * FROM dm_customer
			 
					WHERE 
						code_customer = ".$rowph['ph_customer_code' ]."
                     AND 
                        customer_code_org=".$province_code."
						
						";
		
			$lnk = mysql_query($query);
			$rowcus = mysql_fetch_assoc($lnk);
			$name_customer=$rowcus['name_customer'];
//			print $query;
		}else {
			$Type='متفرقه';
				$query = "SELECt * FROM dm_customer_mot
			 
					    WHERE 
						   cm_customer_id = ".$rowph['ph_customer_code']." ";
		
			$lnk = mysql_query($query);
			$rowcus = mysql_fetch_assoc($lnk);
			$name_customer=$rowcus['cm_name_customer'];
		}
		
		
		
	}else{
		die('Invalid  id2!');
	}
	
	        $gdate=$rowph['ph_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
	$outHtml .= '<tr class="rw0" style="font-weight:bold;height:50px;vertical-align:middle;">
		             <td colspan="2" style="vertical-align:middle;"><b>&nbsp; شماره پيش حواله  : </b>'.$rowph['ph_code'].'</td>
		             <td colspan="3" style="vertical-align:middle;"><b>&nbsp; تاريخ پيش حواله:</b>'.$jdate.'</td>
		             <td style="vertical-align:middle;"><b>&nbsp; کد مشتری   :</b>&nbsp;'.$rowph['ph_customer_code' ].'</td>
		              <td style="vertical-align:middle;"><b>&nbsp; نام مشتری:</b>'.$name_customer.'</td>
		               <td colspan="3" style="vertical-align:middle;"><b>&nbsp; نوع مشتری :</b>'.$Type.'</td>
	             </tr>  
	';
	
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$rowph['ph_code']." 
			AND phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		";
//		print $query;
		$lnk = mysql_query($query);
		sqlErr('line1662');
		if(mysql_affected_rows()>0){
			$outHtml .= '<tr class="rw1"><td colspan="10"><hr></td></tr>
						<tr class="rw0"><td colspan="10" align="center"><b>ريز پيش حواله</b></td></tr>
						
						<tr class="rw1" style="font-weight:bold;height:50px;vertical-align:middle;">
							<td width=5% align="center" style="vertical-align:middle;">رديف</td>
							<td width=15% align="center" style="vertical-align:middle;">نام کالا</td>
							<td width=10% align="center" style="vertical-align:middle;">كد كالا</td>
							
							<td width=10% align="center" style="vertical-align:middle;">كد محل تحويل</td>
							<td width=15% align="center" style="vertical-align:middle;">نام محل تحويل</td>
							<td width=15% align="center" style="vertical-align:middle;">نام تحويل گيرنده</td>
							
							<td width=15% align="center" style="vertical-align:middle;">كد قيمت</td>
							<td  width=15% style="vertical-align:middle;">مقدار خريد</td>
							<td  >&nbsp;</td>
						</tr>	
			';
			$inx = 0;
			while($row= mysql_fetch_assoc($lnk)){
				
				$query2 = "select * from
						 	dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id
					 
							WHERE 
								p_code = ".$row['phd_pid']." 
							AND 
							    p_price_code=".$row['phd_price_code']."
							AND
							  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							";
							
				//print $query2;
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
			
			$query3 = "
			 	SELECT *  FROM dm_location_goods 
		 
				WHERE 
					l_id = ".$row['phd_l_id']." 
				AND

					l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				
			";
		//	print $query3;

			$lnk3 = mysql_query($query3);
			$row3= mysql_fetch_assoc($lnk3);
				$inx++;
				if(($inx)%2==1)
				$class="rw0";
				else
				 $class="rw1";
				 $amount=formatMoney($row['phd_amount']);
				$outHtml .= '
						<tr class='.$class.'>
							<td align="center" style="vertical-align:middle;">'.$inx.'</td>
							<td align="center" style="vertical-align:middle;">'.$row2['p_name'].'</td>
							<td align="center" style="vertical-align:middle;">'.$row2['p_code'].'</td>						
							<td align="center" style="vertical-align:middle;">'.$row3['l_code'].'</td>
							<td align="center" style="vertical-align:middle;">'.$row3['l_name'].'</td>
							<td align="center" style="vertical-align:middle;">'.$row['phd_deli_name'].'</td>							
							<td align="center" style="vertical-align:middle;">'.$row['phd_price_code'].'</td>
							<td style="vertical-align:middle;">'.$amount.'</td>
							<td style="vertical-align:middle;">&nbsp;</td>
						</tr>
						
					';
			}
		     $outHtml .= '</table> <button type="button" onclick=window.open("printPh.php?PhNo='. $ph_code .'&reqNo='. urlencode($rowph['cm_req_num']) .'&cm_req_date='. urlencode($rowph['cm_req_date']) .'&province_name='.urlencode($province_name)  .'&cus_category='. $cInfo[$fieldPrefix.'customer_category'].'&province_name='.urlencode($provinceName) .'&province_id='. $_SESSION['dm_user_profile']['u_province_id'] .'&year_id='. $_SESSION['dm_user_profile']['u_year_id'] .'&cus_name='. urlencode($name_customer) .'")  value=" رويت پيش حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
							رويت پيش حواله</button>				               
		    
		     </div>	                 
						 </div>';
	}

	echo $outHtml;
	
}

function ShowAhavale(){
	
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	
	$outHtml='<br><div><table  align="center" class="list">';
	$h_id = isset($_REQUEST['h_id']) ? (int)($_REQUEST['h_id']) : 0;
	if($h_id<1) die('Invalid  id!');
	$query = "
		 	SELECT *  FROM dm_havale
	 
			WHERE 
				h_id = ".$h_id." 
			
		";
	
	$lnk1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($lnk1);
	$h_code=$row1['h_code'];
	$hDate=$row1['h_reg_date'];
	
	        $gdate=$row1['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
	
				
			
	$query="select * from dm_pish_havale ph left join  dm_pish_factor pf
							on ph.ph_code=pf.pf_ph_code  left join dm_havale h 
							on h.h_pf_code=pf.pf_code
						where  
							 pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					     and
							  ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							 
						and h_id=".$h_id."
					AND
						    pf_type=". 0 ."";
					
			
		
		$lnk = mysql_query($query);
	//	print $query;
		$row = mysql_fetch_assoc($lnk);
		$ph_code=$row['ph_code'];
		    $gdate=$row['ph_reg_date'];
	
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$row1['h_customer_code']."' 
								  AND
			                    customer_code_org=".$province_code."";
					
				
				$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
											
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;				
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
		    "; 
		//print $query;
		$lnk = mysql_query($query);
		sqlErr('line1662');
		
		$gdate=$hDate;
	     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	     $hDate= $jyear."/".$jmonth."/".$jday;
		if(mysql_affected_rows()>0){
								$outHtml .= '
						<tr class="rw1">						
						<td colspan="2"><b>شماره حواله:</b>'.$h_code.'</td><td colspan="2"><b>تاريخ:</b>'. $hDate.'</td>
			 		    <td  colspan="2"><b> پيش حواله به شماره : </b>'.$ph_code.'</td><td colspan="6"><b> به نام :</b>'.$cusName.'</td>      
						</tr>'; 
														
					//retrieve detail of pishHavale
					$queryh = "
					 	SELECT *  FROM dm_havale 
				 
						WHERE 
							h_id = ".$h_id." 
					";
					$lnkh = mysql_query($queryh);
				//	print $query;
					sqlErr('for Display Havale');
					if(mysql_affected_rows()>0){
						$outHtml .= '
					
							    <tr class="rw0">
									<td colspan=12 align="center" style="font-weight:bold;font-size:20px;height: 50px;vertical-align:middle;">
									    <div>ريز حواله</div>
									</td>
							     </tr>
									<tr class="rw1" style="font-weight:bold;vertical-align:middle;">
										<td align="center">رديف</td>
										<td align="center">نام کالا</td>
										<td align="center">كد كالا</td>										
										<td align="center">كد محل تحويل</td>
										<td align="center">نام محل تحويل</td>
										<td align="center">نام تحويل گيرنده</td>
										<td align="center">كد قيمت</td>
										<td colspan="5">مقدار خريد</td>
									</tr>
					</div>
						';
						$inx = 0;
						while($rowh= mysql_fetch_assoc($lnkh)){
								$query = "select * from
					 	dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
				 
						WHERE 
							p_code = ".$rowh['h_p_code']." 
						ANd
						   p_price_code=".$rowh['h_price_code']."
						AND
						   price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ."
					";
				//	print $query;		
							$ln = mysql_query($query);
						$prod= mysql_fetch_assoc($ln);
							$inx++;
						if(($inx)%2==1)
							$class="rw0";
							else
							 $class="rw1";
							 
				$queryL = "
					 	SELECT *  FROM dm_location_goods 
				 
						WHERE 
							l_id = ".$rowh['h_l_code']." 
						
						
					";
//					print $queryL;		
							$lnkL = mysql_query($queryL);
						    $Loc= mysql_fetch_assoc($lnkL);
							 
							$amount=formatMoney($rowh['h_amount']);
						    
							$outHtml .= '
									<tr class="'. $class.'" style="vertical-align:middle;">
										<td align="center" width=5%>'.$inx.'</td>
										<td align="center" width=15%>'.$prod['p_name'].'</td>
										<td align="center" width=10%>'.$rowh['h_p_code'].'</td>										
										<td align="center" width=10%> '.$Loc['l_code'].'</td>
										<td align="center" width=15%>'.$Loc['l_name'].'</td>
										<td align="center" width=15%>'.$rowh['h_deli_name'].'</td>										
										<td  align="center" width=10%>'.$rowh['h_price_code'].'</td>
										<td colspan="5" width=10%>'.$amount.'</td>';
						
               $queryp="SELECT * FROM dm_province 
	              WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
				    $lnkp=mysql_query($queryp);
				    print mysql_error();
				    $rowp=mysql_fetch_assoc($lnkp);
				    $provinceName=$rowp['province_name'];
								$outHtml .= '<td style="background-color:'. $_SESSION['bgcolor'] .';">											         											          
											            <button type="button" onclick=window.open("printHavale2.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row1['h_price_code'].'&p_code='.$row1['h_p_code'].'&l_id='.$row1['h_l_code'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$h_id.'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
											              پرينت دوم</button>
											         </td>
											         <td style="background-color:'. $_SESSION['bgcolor'] .';">											         											          
											            <button type="button" onclick=window.open("printHavale3.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row1['h_price_code'].'&p_code='.$row1['h_p_code'].'&l_id='.$row1['h_l_code'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$h_id.'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
											             پرينت سوم</button>
											         </td> 
									
														
											         <td style="background-color:'. $_SESSION['bgcolor'] .';">											         											          
											            <button type="button" onclick=window.open("printHavale.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row1['h_price_code'].'&p_code='.$row1['h_p_code'].'&l_id='.$row1['h_l_code'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$h_id.'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
											              پرينت اول</button>
											         </td>
											         
											         </tr> 
											         <tr>
                                                            <td style="background-color:'. $_SESSION['bgcolor'] .';align:left;" colspan="70" align="left">											         											          
											            <button type="button" onclick=window.open("printHavalekoli.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row1['h_price_code'].'&p_code='.$row1['h_p_code'].'&l_id='.$row1['h_l_code'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$h_id.'") value=" رويت حواله" class="button blue skew" style="font-size:15px; color:#FFFFF8">
											              پرينت كلی</button>
											         </td>
											         </tr>
								';
							$totalprice =$row['h_price']+$totalprice;
							
						}
						$outHtml .= '																
							</table>						
							<div align="center"><a href="?pg=havaleMgmtPg&cmd=dspHavaleList"> <img src="images/back1.png"  title="بازگشت" ></img></a> </div>';									   							
											
					}
			
			
	}
	echo $outHtml;	
}

function EbtalHavale(){
	
	$h_id = isset($_REQUEST['h_id']) ? (int)($_REQUEST['h_id']) : 0;
	$query = "
		 	SELECT *  FROM dm_havale 
	 
			WHERE 
				h_id = ".$h_id."
		   AND
		        h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		     AND 
		        h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
		sqlErr('line1662');
		$row = mysql_fetch_assoc($lnk);
		if($row['h_status']=='1'){
			$out='<br><br><div align="center"> <font color="red"> حواله به شماره '.$h_id.'قبلا باطل شده است</font></div> 
	 <div align="left"><a href="?pg=havaleMgmtPg&cmd=dspHavaleList">بازگشت</a></div> ';
		}
		ELSE{
	$query = "
		UPDATE dm_havale 
		SET 
			`h_status` = '1'	
		WHERE 
			h_id = ".$h_id." 
		AND
		    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		 AND 
		    h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$out='<br><br><div align="center"> <font color="red"> حواله به شماره '.$h_id.'باطل شد</font></div> 
	 <div align="left"><a href="?pg=havaleMgmtPg&cmd=dspHavaleList">بازگشت</a></div> ';
	}
	return $out;
}

function dspHavaleFrm(){
	
                  $day_number = jdate('j');
                   $month_number = jdate('n');
                   $year_number = jdate('y');
                   $day_name = jdate('l');
	               $selectedItem=1;
	               ?>
	     
	 <table  align="center" class="nasi">
	           
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;height:30px;">
				     <td colspan="3" align="center" style="vertical-align:middle;"><b> صدور حواله </b> </td>
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				    <td colspan="3">&nbsp;</td>
				</tr>	 
				<tr>
					<td style="font-weight:bold;"> صدور حواله بر اساس <center><?php echo gethcreateTypeRadioHtml($selectedItem)?></center></td>	
					<td style="font-weight:bold;">تاریخ:<?php echo $year_number?>/<?php echo $month_number ?>/<?php echo $day_number ?></td>
				</tr>
					
				<tr id="hcreateph" style="display: block;">
					<form method="post" action="" >
		              	<input type="hidden" name="pg" value="havaleMgmtPg">   
		              	<input type="hidden" name="cmd" value="dspPHavale1">
		              	<td style="font-weight:bold;">&nbsp; شماره پيش حواله :</td>
						<td><input name="ph_code" type="text"/></td>
					    <td colspan="3" align="center"><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px; color:#FFFFFF"></td>
				    </form>
				</tr>	
				<tr id="hcreatepf" style="display:none;">
					<form method="post" action="" >
		              	<input type="hidden" name="pg" value="havaleMgmtPg">   
		              	<input type="hidden" name="cmd" value="dspPHavale2">
		              	<td style="font-weight:bold;">: شماره پيش فاكتور</td>
						<td><input name="pf_code" type="text"/></td>
					    <td colspan="3" align="center"><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px; color:#FFFFFF" ></td>
					    
				    </form>
				</tr>					 				 
  </table>

<?php 
	
}

function dspPHavale1(){
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');    
    $outHtml = dspHavaleFrm();
    
	$outHtml .= '<br><div> <table  class="list">';	
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
	 	
			WHERE 
				ph_code = '".$ph_code."'
			AND
			ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
			AND 
			ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";
				
//	print $query;
//	$_SESSION['shPhforPf']=$ph_id;
	$lnk = mysql_query($query);
	sqlErr('wererewr');
	if(mysql_affected_rows()>0){
		
						$havaleMainInfo = mysql_fetch_assoc($lnk);	
						$_SESSION['shPhforPf']=$havaleMainInfo['ph_code'];
						
						$querypf = "
							 	SELECT *  FROM dm_pish_factor 
							 	
									WHERE 
										pf_ph_code = '".$ph_code."'
									AND
									pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
									AND
									pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
									AND
									pf_type=". 0 ."
									"; 
				//		print $querypf;
				         $lnkpf = mysql_query($querypf);
				         $rowpf = mysql_fetch_assoc($lnkpf);
				         $pf_code=$rowpf['pf_code'];
			//chek mikonad aya sanadi vared shode ya na	         
				         if(mysql_affected_rows()>0){
						         		$querydpf = "
									 	SELECT *  FROM dm_pf_document 
									 	
											WHERE 
												 dpf_pf_code = '".$pf_code."'
											AND
											     dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											 AND 
											    dpf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."   
											     "; 
					//			print $querydpf;
						         $lnkdpf = mysql_query($querydpf);
						          $rowdpf = mysql_fetch_assoc($lnkdpf);	
						          if(mysql_affected_rows()>0){
						          	
						          	$query1 = "
										 	SELECT *  FROM dm_pish_havale_det 
									 
													WHERE 
														phd_ph_code = ".$ph_code." 
												AND
													    phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
												 AND 
													   phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."   
													     ";
//						          	print $query1;
										$lnk1 = mysql_query($query1);
										$total_price=0;
						           while($row1= mysql_fetch_assoc($lnk1)){		
									$total_price=$total_price+$row1['phd_price'];
											
									}	
																
					             $dpf_price=0;
						         while($rowdpf= mysql_fetch_assoc($lnkdpf)){		
									$dpf_price=$dpf_price+$rowdpf['dpf_price'];
											
									}
//						         echo	$dpf_price;
//						         if($dpf_price<$total_price){
								   
	                      	 $querydpf = "
									 	SELECT *  FROM dm_pf_document 
									 	
											WHERE 
												dpf_pf_code = '".$pf_code."'
											AND
											pf_id_province=".$_SESSION['dm_user_profile']['u_province_id'].""; 
						//		print $querypf;
						         $lnkpf = mysql_query($querypf);
						         $rowpf = mysql_fetch_assoc($lnkpf);
						         						         
								 $queryH="SELECT MAX(h_code) maxId FROM dm_havale 
								          WHERE 
								              h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
								              			    
								$lnkH=mysql_query($queryH);
								print mysql_error();
								$rowH=mysql_fetch_assoc($lnkH);
									$queryprov = "SELECT *  FROM dm_province
								           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
								  $lnkprov = mysql_query($query);
								  $rowprov= mysql_fetch_assoc($lnk);
								    $province_code=$rowprov['province_code'];
										 $querycus = "
									 	SELECT *  FROM dm_customer 
									 	
											WHERE 
												code_customer = '".$havaleMainInfo['ph_customer_code']."'
												AND
			                                  customer_code_org=".$province_code."
											"; 
						//		print $querypf;
						         $lnkcus = mysql_query($querycus);
						         $rowcus= mysql_fetch_assoc($lnkcus);
										$outHtml .= '
											<tr class="rw1" style="height:30px;vertical-align:middle;">						
											<td colspan="2" style="vertical-align:middle;"><b>شماره پيش نويس حواله:</b>'.$havaleMainInfo['ph_code'].'</td><td colspan="2" style="vertical-align:middle;"><b>شماره پيش فاكتور:</b>'. $pf_code.'</td>
								 		    <td colspan="10" style="vertical-align:middle;"><b> به نام :</b>'.$rowcus['name_customer'].'</td>      
											</tr>'; 
																			
										//retrieve detail of pishHavale
										$query = "
										 	SELECT *  FROM dm_pish_havale_det 
									 
											WHERE 
												phd_ph_code = ".$ph_code." 
											AND
											     phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
										     AND 
													   phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."   
													     ";
									//	print $query;
										$lnk = mysql_query($query);
										sqlErr('for Display pfactor1');
										if(mysql_affected_rows()>0){
											$outHtml .= '
										<div>
												    <tr class="rw0">
														<td colspan=15 align="center" style="font-weight:bold;font-size:20px;height: 50px;vertical-align:middle;">
														    <div>ريز اطلاعات</div>
														</td>
												     </tr>
														<tr class="rw1" style="font-weight:bold;vertical-align:middle;height:30px;">
															<td align="center" style="vertical-align:middle;">رديف</td>
															<td align="center" style="vertical-align:middle;">نام کالا</td>
															<td align="center" style="vertical-align:middle;">كد كالا</td>										
															<td align="center" style="vertical-align:middle;">كد محل تحويل</td>
															<td align="center" style="vertical-align:middle;">نام محل تحويل</td>
															<td align="center" style="vertical-align:middle;">نام تحويل گيرنده</td>
															<td align="center" style="vertical-align:middle;">كد قيمت</td>
															<td colspan="5" style="vertical-align:middle;">مقدار خريد</td>
														
														</tr>
										</div>
											';
											$inx = 0;
											while($row= mysql_fetch_assoc($lnk)){
													$query = "
										 	select * from dm_product product
												left join dm_price price
												on product.p_id=price.price_p_id 
									 
											WHERE 
												p_code = ".$row['phd_pid']." 
											ANd
											   p_price_code=".$row['phd_price_code']."
											   and
			                                 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
										";
					//					print $query;		
												$ln = mysql_query($query);
											$prod= mysql_fetch_assoc($ln);
												$inx++;
											if(($inx)%2==1)
												$class="rw0";
												else
												 $class="rw1";
												 
									$queryL = "
										 	SELECT *  FROM dm_location_goods 
									 
											WHERE 
												l_id = ".$row['phd_l_id']."
											AND 
												l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											
										";
					//					print $queryL;		
												$lnkL = mysql_query($queryL);
											    $Loc= mysql_fetch_assoc($lnkL);
												 
												$amount=formatMoney($row['phd_amount']);
											    
												$outHtml .= '
														<tr class="'. $class.'" style="vertical-align:middle;">
															<td align="center" width=5% style="vertical-align:middle;">'.$inx.'</td>
															<td align="center" width=15% style="vertical-align:middle;">'.$prod['p_name'].'</td>
															<td align="center" width=10% style="vertical-align:middle;">'.$prod['p_code'].'</td>										
															<td align="center" width=10% style="vertical-align:middle;"> '.$Loc['l_code'].'</td>
															<td align="center" width=15% style="vertical-align:middle;">'.$Loc['l_name'].'</td>
															<td align="center" width=15% style="vertical-align:middle;">'.$row['phd_deli_name'].'</td>										
															<td  align="center" width=10% style="vertical-align:middle;">'.$row['phd_price_code'].'</td>
															<td colspan="5" width=10% style="vertical-align:middle;">'.$amount.'</td>';
																																	
//															if($row['phd_status']==1){
//									                                      $outHtml .='  <td align="center">ثبت شده
//																	     </td>';
//															}else{
//									                                      	 $outHtml .='  <td align="center"><button type="button" value="ثبت و ايجاد حواله " onclick="addNewHavale(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$row['phd_price'].'\', \''.$row['phd_id'].'\', \''.$havaleMainInfo['ph_customer_code'].'\')"  class="button blue skew" style="font-size:10px; color:#FFFFFF" style="width:20px;">ثبت و ايجاد حواله</button>
//																	     </td>';
//									                                      }								
																     $outHtml .='  </tr>     
													';
												$totalprice =$row['phd_price']+$totalprice;
												
											}
								 echo ' <span> <button type="button" value="ثبت و ايجاد حواله "   onclick="addednewhavalekoli(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$row['phd_price'].'\',\''.$row['phd_id'].'\', \''.urlencode($havaleMainInfo['ph_customer_code']).'\')"  class="button blue skew"  style="font-size:10px; color:#FFFFFF;" >ثبت و ايجاد حواله</button></span>';				    
											
											$outHtml .= '</table>';																										
																							
										}
						        
						           }
						           else{
						          		         	$outHtml .= '<br><br><b><font color="red"> اطلاعات اسناد وارد نشده است</font></b>';		          
						          }
			         }else{
			         	$outHtml .= '<br><br><b><font color="red"> براي اين پيش حواله پيش فاكتوري ثبت نشده</font></b>';
			         }

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره پیش حواله نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</table><br>';
	return $outHtml;
}

 function dspPHavale2(){
 	
 	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
	
    $outHtml = dspHavaleFrm();
	$outHtml .= '<br><div> <table  class="list">';
	
	$pf_code = isset($_REQUEST['pf_code']) ? $_REQUEST['pf_code'] : '';
	$query = "
	 	SELECT *  FROM dm_pish_factor 
 
		WHERE 
			pf_code = '".$pf_code."' 
		AND
		    pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    AND
		  pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
		  AND
		  pf_type=". 0 ." 
	";
 //   print $query;
	$lnk = mysql_query($query);
	$row1 = mysql_fetch_assoc($lnk);
	if(mysql_affected_rows()>0){
	
		
		$querydpf = "
				 	SELECT *  FROM dm_pf_document 
				 	
						WHERE 
							 dpf_pf_code = '".$pf_code."'
						AND
						     dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id'].""; 
	//		print $querydpf;
	         $lnkdpf = mysql_query($querydpf);
	         $rowdpf = mysql_fetch_assoc($lnkdpf);
	         if(mysql_affected_rows()>0){
             $ph_code=$row1['pf_ph_code'];
						$query = "
						 	SELECT *  FROM dm_pish_havale 
					 
							WHERE 
								ph_code = '".$row1['pf_ph_code']."' 
							AND
							ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						";
						//print $query;
					//	$_SESSION['shPhforPf']=$ph_id;
						$lnk = mysql_query($query);
						sqlErr('wererewr');
						if(mysql_affected_rows()>0){
							
							$havaleMainInfo = mysql_fetch_assoc($lnk);
							
//							$_SESSION['shPhforPf']=$havaleMainInfo['ph_id'];
						$queryH="SELECT MAX(h_code) maxId FROM dm_havale
						         WHERE
						           h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						         AND 					          
							       h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						          ";
						$lnkH=mysql_query($queryH);
						print mysql_error();
						$rowH=mysql_fetch_assoc($lnkH);
						$queryprov = "SELECT *  FROM dm_province
					           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
										  $lnkprov = mysql_query($queryprov);
										  $rowprov= mysql_fetch_assoc($lnkprov);
										    $province_code=$rowprov['province_code'];
								//name customer					
						if($havaleMainInfo['ph_customer_type']=='n'){
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$havaleMainInfo['ph_customer_code']."'

								AND
			             customer_code_org=".$province_code."";	
				
    			$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولی';
			
		}else{
				$query = "
					 	SELECT *  FROM dm_customer_mot 
				 
						WHERE 
							cm_customer_id = '".$havaleMainInfo['ph_customer_code']."' ";		
								
				$lnk = mysql_query($query);
				sqlErr('for customer1');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['cm_name_customer'];
						$Type='متفرقه';				
	            	}
							
						$outHtml .= '
						<tr class="rw1">						
						<td colspan="2"> &nbsp;<b> شماره پيش نويس حواله:</b>'.$havaleMainInfo['ph_code'].'</td>
			 		    <td  colspan="2"><b> پيش فاكتور به شماره : </b>'.$pf_code.'</td><td colspan="12"><b> به نام :</b>'.$cusName.'</td>      
						</tr>'; 
														
					//retrieve detail of pishHavale
					$query = "
					 	SELECT *  FROM dm_pish_havale_det 
				 
						WHERE 
							phd_ph_code = ".$ph_code." 
						AND
						    phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						  AND 
						          
						  phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						          ";
	//				print $query;
					$lnk = mysql_query($query);
					sqlErr('for Display pfactor1');
					if(mysql_affected_rows()>0){
						$outHtml .= '
					<div>
							    <tr class="rw0">
									<td colspan=15 align="center" style="font-weight:bold;font-size:20px;height: 50px;vertical-align:middle;">
									    <div>ريز اطلاعات</div>
									</td>
							     </tr>
									<tr class="rw1" style="font-weight:bold;vertical-align:middle;">
										<td align="center">رديف</td>
										<td align="center">نام کالا</td>
										<td align="center">كد كالا</td>										
										<td align="center">كد محل تحويل</td>
										<td align="center">نام محل تحويل</td>
										<td align="center">نام تحويل گيرنده</td>
										<td align="center">كد قيمت</td>
										<td colspan="5">مقدار خريد</td>
									
									</tr>
					</div>
						';
						$inx = 0;
						while($row= mysql_fetch_assoc($lnk)){
								$query = "
					 	select * from dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
				 
						WHERE 
							p_code = ".$row['phd_pid']." 
						ANd
						   p_price_code=".$row['phd_price_code']."
						   and
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					";
			//		print $query;		
							$ln = mysql_query($query);
						$prod= mysql_fetch_assoc($ln);
							$inx++;
						if(($inx)%2==1)
							$class="rw1";
							else
							 $class="rw0";
							 
				$queryL = "
					 	SELECT *  FROM dm_location_goods 
				 
						WHERE 
							l_id = ".$row['phd_l_id']." 
						AND 
							l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						
					";
	//				print $queryL;		
							$lnkL = mysql_query($queryL);
						    $Loc= mysql_fetch_assoc($lnkL);
							 
							$amount=formatMoney($row['phd_amount']);
						    
							$outHtml .= '
									<tr class="'. $class.'" style="vertical-align:middle;">
										<td align="center" width=5%>'.$inx.'</td>
										<td align="center" width=15%>'.$prod['p_name'].'</td>
										<td align="center" width=10%>'.$prod['p_code'].'</td>										
										<td align="center" width=10%> '.$Loc['l_code'].'</td>
										<td align="center" width=15%>'.$Loc['l_name'].'</td>
										<td align="center" width=15%>'.$row['phd_deli_name'].'</td>										
										<td  align="center" width=10%>'.$row['phd_price_code'].'</td>
										<td colspan="5" width=10%>'.$amount.'</td>';
																							
//										$outHtml .= '	 <button type="button" onclick=window.open("printHavale.php?phd_id='.$phd_id.'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.$provinceName.'&name_customer='.$row5['name_customer'].'&price_code='.$row['h_price_code'].'&p_code='.$row['h_p_code'].'&l_id='.$rowL['l_id'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$h_id.'","_blank") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
//											              رويت حواله</button>'
//											         <td >
//											            <button type="button" onclick=window.open("printHavale.php?phd_id='.$row['phd_id'].'&ph_id='.$ph_id.'&h_id='.$rowH['maxId'].'","_blank") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">رويت حواله</button>
//											              
//											         </td>';
//											        if($row['phd_status']==1)
//									                                      $outHtml .='  <td align="center">ثبت شده
//																	     </td>';
//									                                      else{
//									                                      	 $outHtml .='  <td align="center"><button type="button" value="ثبت و ايجاد حواله " onclick="addNewHavale(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$row['phd_price'].'\', \''.$row['phd_id'].'\', \''.$havaleMainInfo['ph_customer_code'].'\')"  class="button blue skew" style="font-size:10px; color:#FFFFFF" style="width:20px;">ثبت و ايجاد حواله</button>
//																	     </td>';
//									                                      }		
											       $outHtml .= '  </tr> ';    
								
							$totalprice =$row['phd_price']+$totalprice;
							
						}
						$outHtml .= '</table>';
 echo '<span> <button type="button" value="ثبت و ايجاد حواله "   onclick="addednewhavalekoli(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$rowphd['phd_price'].'\',\''.$rowphd['phd_id'].'\', \''.urlencode($havaleMainInfo['ph_customer_code']).'\')"  class="button blue skew"  style="font-size:10px; color:#FFFFFF;" >ثبت و ايجاد حواله</button></span>';
						
						
					}
					
						}else{
						$outHtml .= '<br><br><b><font color="red"> خطا!اطلاعات پيش حواله وجود ندارد</font></b>';
							
						}
						$outHtml .= '</div>';
						$outHtml .='</table>';
	         }else{
	         	$outHtml .= '<br><br><b><font color="red"> اطلاعات اسناد وارد نشده</font></b>';
	         }
	}else{
						$outHtml .= '<br><br><b><font color="red"> شماره پیش فاكتور نادرست است</font></b>';
		
	}
	echo $outHtml;
}
function ebtalList(){
	
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
 	
                   $day_number = jdate('j');
                   $month_number = jdate('n');
                   $year_number = jdate('y');
                   $day_name = jdate('l');
  	
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
	$outHtml = '<br><table>
	     	  <tr><td>
					<form method="get" action="">
						<input type="hidden" name="pg" value="havaleMgmtPg">   
						<input type="hidden" name="cmd" value="searchCodeebtal"> 
						<b> كد ابطالی مورد نظر را جستجو كنيد </b>
						<div>  <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:60px;" /> 
						<button type="submit" name="Search" value="Search" >جستجو</button></div>
					</form></td>';
	$outHtml .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodeebtal"> 
			<b> كد مشتری مورد نظر را جستجو كنيد </b>
			<div>  <input type="text" name="search1"  value="'.$_SESSION['srchStr1'].'" style="width:60px;" />
			
			
			<button type="submit" name="Search1" value="Search1" >جستجو</button></div>
		</form>
		</td>
		
		
		';
	$outHtml .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodeebtal"> 
			<b> شماره حواله مورد نظر را وارد كنيد </b>
			<div>  <input type="text" name="search2"  value="'.$_SESSION['srchStr2'].'" style="width:60px;" />
			
			
			<button type="submit" name="Search1" value="Search1" >جستجو</button></div>
		</form>
		</td>
		</tr>
		</table>
		<br>';
	$outHtml .= '	
		<div align = "center">
		<div align = "center" style="width:90%;height:400px; overflow:auto">
			<table  align="center" cellpadding="0" cellspacing="0" class="list" border="0">
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;"><center> ليست حواله هاي ابطالي </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">ردیف </td>
			        <td align="center"> شماره ابطال </td>
			        <td align="center"> شماره حواله </td>
			        <td align="center"> شماره پيش نويس </td>
			        <td align="center"> شماره پيش فاكتور </td>
			        <td align="center"> مقدار ابطالی </td>
			        <td align="center"> تاريخ  ابطال  </td>
			        <td align="center">كد مشتری </td>
			        <td align="center" colspan="5">نام مشتری </td>		        		        
				</tr>';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['srchStr1'])) $_SESSION['srchStr1'] = '';
	if(!isset($_SESSION['srchStr2'])) $_SESSION['srchStr2'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	$srchQ = "";
if($_SESSION['srchStr']=='' AND $_SESSION['srchStr1']=='' AND $_SESSION['srchStr2']=='' ){
		
		
	} if($_SESSION['srchStr1']!=''  ) {
		$srchQ = " 
			AND(
					ebh_customer_code LIKE '%".$_SESSION['srchStr1']."%' 
				 
			)
		";
		
	}if($_SESSION['srchStr']!=''  ){
		
		$srchQ = " 
			AND(
					ebh_code LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
	}if($_SESSION['srchStr2']!=''  ){
		
		$srchQ = " 
			AND(
					(h.h_code LIKE '%".$_SESSION['srchStr2']."%' ) OR (h2.h_code LIKE '%".$_SESSION['srchStr2']."%' )
				 
			)
		";
	}
	$typeQ = '';
	
	$genQuery = "
			from dm_ebtal_h ebh 
			  left join dm_havale h 
			  on ebh.ebh_h_id=h.h_id and ebh.ebh_type=1   AND h.h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  
			  left join `dm_his_havale` his on ebh.ebh_h_id=his.his_id and ebh_type=0 
			  left join dm_havale h2 on h2.`h_id`=his.`his_h_id`  AND  h2.h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."   
			WHERE 
				1 
			".$srchQ." 
			".$typeQ." 
			AND
			 ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    AND
			 ebh_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
			 order by ebh_code";
		 		 			 	
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT ebh_id_province,
 
		  ebh_id_year,
		  ebh_code,
		  ebh_reg_date,
		  ebh_type,
		  ebh_h_id,
		  ebh_code,
		  ebh_customer_code,
		  ebh_id,
		  ebh_status_anbar,
		      
		  IFNULL(h.`h_code`,h2.`h_code`) as h_code,
		  IFNULL(h.`h_id`,h2.`h_id`) as h_id ,
		  IFNULL(h.`h_id_province`,h2.`h_id_province`) as h_id_province,
		  IFNULL(h.`h_code`,h2.`h_code`) as h_code	
	".$genQuery.$limitQ;

	//print($resQuery);
		$_SESSION['srchStr'] = '';
		$_SESSION['srchStr1'] = '';
		$_SESSION['srchStr2'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk)){
			
			if(($inx)%2==1)
				$class="rw1";
				else
				$class="rw0";
			
				$gdate=$row['ebh_reg_date'];
				//echo $gdate;
					
			$gdate=$row['ebh_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if($row['ebh_type']==0){				
				$queryh = "
					 	SELECT *  FROM dm_his_havale					 
					WHERE 
						his_id=".$row['ebh_h_id']."
					AND 
						his_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					";
				
					//echo $queryh;	
//	print $queryh;
					$lnkh = mysql_query($queryh);
					$rowh = mysql_fetch_assoc($lnkh);
					$h_id=$rowh['his_h_id'];
					
					$no=1;
				
			}else if($row['ebh_type']==1){
				$h_id=$row['ebh_h_id'];
				$type='ابطال كلی';
				$no=2;
			}
			
			
//			echo $h_id;
		    $query1 = "
			  SELECT *  FROM dm_havale	h
			      left join dm_pish_factor pf
			        on h.h_pf_code=pf.pf_code
			      left join dm_pish_havale ph
			        on ph.ph_code=pf.pf_ph_code				 
				WHERE 
					h_id=".$h_id."
				AND 
					    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				
					AND
						ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						AND
						pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";
	//print  $query1;
					$lnk1 = mysql_query($query1);
					$row1 = mysql_fetch_assoc($lnk1);
					
					//product
					$queryppr = " select * from   dm_product product                    
				left join dm_price price
				 on product.p_id=price.price_p_id 
					where 
					    p_code=".$rowh['his_p_code']."
					  and
					    p_price_code=".$rowh['his_p_pcode']." 
					  and
					    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					  
					  		   
		$lnkppr = mysql_query($queryppr);
	//	print $query;
	    $rowppr= mysql_fetch_assoc($lnkppr);
					
			//echo $queryppr;		
					
					
					
					if($no==1){
						$meghdarebtal=$rowh['his_eb_amount'];
					$type='ابطال جزئی';
						
					}else if($no==2){
						
						$meghdarebtal=$row1['h_amount'];
					}
								$querycus = "
								 	SELECT *  FROM dm_customer					 
									WHERE 
									code_customer=".$row1['h_customer_code']."									
									AND
		                      customer_code_org=".$province_code."";												
								$lnkcus = mysql_query($querycus);
								$rowcus = mysql_fetch_assoc($lnkcus);
							//	print $querycus;
										
			$outHtml .= '
			<span id="phavale_'.$row['h_id'].'" >
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['ebh_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row1['h_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row1['ph_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row1['pf_code'].'</td>
					<td  align="center" style="vertical-align:middle;">'.$meghdarebtal.'كيلوگرم</td>
					<td  align="center" style="vertical-align:middle;">'.$jdate.'</td>						
					<td align="center" style="vertical-align:middle;">'.$row1['h_customer_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcus['name_customer'].'</td>';
			//echo $row1['ph_reg_date'];
			//echo $rowppr['p_pakage_type'];
			if(($row['ebh_status_anbar']==1) or ($row['ebh_status_anbars']==1) or ($row1['ph_reg_date']<'2016-12-21') or ($rowppr['p_pakage_type']==6) or  ($rowppr['p_code']==50) or  ($rowppr['p_code']==51) or  ($rowppr['p_code']==2)){
					$outHtml .= '
					<td  align="center" style="vertical-align:middle;"><a href="?pg=havaleMgmtPg&cmd=ShowAebtal&ebh_id='.$row['ebh_id'].'"><img src="images/display.png" width="20" height="20" title="مشاهده كل اطلاعات" ></img> </a></td>';
			}else{
				
					//$outHtml .= '<td><input type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=ebtalpage&ebh_id='.$row['ebh_id'].'","_blank")  value="جزییات " this.style.display=\'none\'"    class="button blue skew" style="font-size:10px; color:#FFFFFF" width=70%  ></td>';
				
				$outHtml .= '
					<td  align="center" style="vertical-align:middle;"><a href="?pg=havaleMgmtPg&cmd=ebtalPage&ebh_id='.$row['ebh_id'].'"><img src="images/display.png" width="20" height="20" title="مشاهده كل اطلاعات" ></img> </a></td>';
				
			}
					if($_SESSION['dm_user_profile']['u_id']==3){
					$outHtml .= '<td><input type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=Ebtalafew_ht&phd_id='.$row1['h_phd_id'].'&h_id='.$row1['h_id'].'&his_id='.$row['ebh_h_id'].'","_parent") id="ebtal" value="تغییر " this.style.display=\'none\'"    class="button blue skew" style="font-size:10px; color:#FFFFFF" width=70%  ></td>';
					$outHtml .= '<td><input type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=delebtali&phd_id='.$row1['h_phd_id'].'&h_id='.$row1['h_id'].'&his_id='.$row['ebh_h_id'].'","_parent") id="ebtal" value="حذف" this.style.display=\'none\'"    class="button blue skew" style="font-size:10px; color:#FFFFFF" width=70%  ></td>';
					
					}
					$outHtml .= '</td>
				</tr></span>
			';
 //  		    <td ><a href="?pg=havaleMgmtPg&cmd=EbtalHavale&h_id='.$row['h_id'].'">ابطال </a></td>
			
			$inx++;
		}
		
		
		
		
			
		
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ ابطالي موجود نیست</td></tr>';
    }
    $outHtml .= '</table>
    </div>'.getNavBar_eb().' '.getRPPCombo_eb();
    echo $outHtml;
		
}

function getNavBar_eb(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=havaleMgmtPg&cmd=ebtalList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=havaleMgmtPg&cmd=ebtalList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=havaleMgmtPg&cmd=ebtalList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=havaleMgmtPg&cmd=ebtalList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=havaleMgmtPg&cmd=ebtalList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_eb(){
	$out = '
	
		<select onchange="window.open(\'?pg=havaleMgmtPg&cmd=ebtalList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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
 function dspHavaleList(){
 	
 	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
 	
                   $day_number = jdate('j');
                   $month_number = jdate('n');
                   $year_number = jdate('y');
                   $day_name = jdate('l');
  	
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
	$outHtml = '<br><table  width="100%">
	<tr><td>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodehavale"> 
			<b> كد حواله مورد نظر را جستجو كنيد </b>
			<div>  <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:60px;" /> 
			<button type="submit" name="Search" value="Search" >جستجو</button>
		</form></td>
		
	';
	$outHtml .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodehavale"> 
			<b> كد پيش حواله مورد نظر را جستجو كنيد </b>
			<div>  <input type="text" name="search1"  value="'.$_SESSION['srchStr1'].'" style="width:60px;" />
			
			
			<button type="submit" name="Search1" value="Search1" >جستجو</button></div>
		</form>
		</td>
		
		
		';
	$outHtml .= '<td>	
					<form method="get" action="">
						<input type="hidden" name="pg" value="havaleMgmtPg">   
						<input type="hidden" name="cmd" value="searchCodehavale"> 
						<b> كد مشتری مورد نظر را جستجو كنيد </b>
						<div>  <input type="text" name="search2"  value="'.$_SESSION['srchStr2'].'" style="width:60px;" />
						<button type="submit" name="Search1" value="Search1" >جستجو</button></div>
					</form>
					</td>
					</tr>
					</table>
					<br>';
	$outHtml .= '	
		<div align = "center">
		<div align = "center" style="width:85%;height:300px; overflow:auto">
			<table  align="center" cellpadding="0" cellspacing="0" class="list" border="0">
      			<tr class="rw1">
        			<th colspan="19" align="center" style="height: 50px;vertical-align:middle;"><center> ليست حواله </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">ردیف </td>
			        <td align="center"> شماره حواله</td>
			         <td align="center"> شماره پيش نويس حواله</td>
			        <td align="center">تاريخ  حواله </td>
			        <td align="center">كد مشتري </td>
			        <td align="center">نام مشتري </td>
			        <td align="center">دفعات چاپ شده </td>
			        <td colspan="5">وضعيت </td>			        		        
				</tr>
	';
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['srchStr1'])) $_SESSION['srchStr1'] = '';
	if(!isset($_SESSION['srchStr1'])) $_SESSION['srchStr2'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	$srchQ = "";
	if($_SESSION['srchStr']=='' AND $_SESSION['srchStr1']=='' AND  $_SESSION['srchStr2']==''){
		
		
	}

	
	if($_SESSION['srchStr1']!=''  ) 
		{
			$srchQ .= " 
				AND(
						ph_code LIKE '%".$_SESSION['srchStr1']."%' 
					 
				)";
		}
 if($_SESSION['srchStr']!=''  ) 
		{
			$srchQ .= " 
				AND(
						h_code LIKE '%".$_SESSION['srchStr']."%' 
					 
				)";
		}
 if($_SESSION['srchStr2']!=''  ) 
		{
			$srchQ .= " 
				AND(
						h_customer_code LIKE '%".$_SESSION['srchStr2']."%' 
					 
				)";
		}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_havale h
			left join dm_pish_factor pf on pf.pf_code=h.h_pf_code
          left join dm_pish_havale  ph on  ph.ph_code=pf.pf_ph_code 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		AND
		 h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		 AND
		 h_amount !=". 0  ."
		 AND
		 ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		 AND
		 pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		 AND
		 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		 
		 order by h_code desc";
		 		 	 	
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
		$_SESSION['srchStr1'] = '';
		$_SESSION['srchStr2'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_num_rows($lnk)!=0){
	
		while($row = mysql_fetch_assoc($lnk)){
	
			if(($inx)%2==1)
				$class="rw1";
				else
				$class="rw0";
			
			$gdate=$row['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
		    $query = "
					 	SELECT *  FROM dm_pish_factor					 
						WHERE 
						pf_code=".$row['h_pf_code']."
						AND 
						pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						AND
						   pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."  
						   AND
		                pf_type=". 0 ."";
						
							
					$lnk1 = mysql_query($query);
					$row1 = mysql_fetch_assoc($lnk1);
					$ph_code=$row1['pf_ph_code'];
								$querycus = "
								 	SELECT *  FROM dm_customer					 
									WHERE 
									code_customer=".$row['h_customer_code']."									
									AND
		                      customer_code_org=".$province_code."";												
								$lnkcus = mysql_query($querycus);
								$rowcus = mysql_fetch_assoc($lnkcus);
										
			$outHtml .= '
			<span id="phavale_'.$row['h_id'].'" >
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['h_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['ph_code'].'</td>
					<td  align="center" style="vertical-align:middle;">'.$jdate.'</div>					
					<td align="center" style="vertical-align:middle;">'.$row['h_customer_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcus['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['h_num_print'].'</td>
					
					';
			if($row['h_status']==1){
				 $outHtml .= ' <td align="center" style="vertical-align:middle;">ابطال شده</td>';
			}else if($row['h_status']==0){
				 $outHtml .= ' <td align="center" style="vertical-align:middle;">فعال</td>';
				
			}
				//	$outHtml .= '<td   align="left" style="vertical-align:middle;"> <span style="cursor:pointer" onclick="DeleteHavale(\'\', \''.$row['h_id'].'\')" ><font color=red><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></font></span></td>
					$outHtml .= '<td  align="center" style="vertical-align:middle;"><a href="?pg=havaleMgmtPg&cmd=ShowAhavale&h_id='.$row['h_id'].'"><img src="images/display.png" width="20" height="20" title="مشاهده كل اطلاعات" ></img> </a></td>
					<td>&nbsp;&nbsp;&nbsp;</td>
				</tr></span>
			';
 //  		    <td ><a href="?pg=havaleMgmtPg&cmd=EbtalHavale&h_id='.$row['h_id'].'">ابطال </a></td>
			
			$inx++;
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هیچ حواله اي موجود نیست</td></tr>';
    }
    $outHtml .= '</table>
    </div>'.getNavBar_h().' '.getRPPCombo_h();
    echo $outHtml;
		
}

function getNavBar_h(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=havaleMgmtPg&cmd=dspHavaleList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=havaleMgmtPg&cmd=dspHavaleList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=havaleMgmtPg&cmd=dspHavaleList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=havaleMgmtPg&cmd=dspHavaleList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=havaleMgmtPg&cmd=dspHavaleList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_h(){
	$out = '
	
		<select onchange="window.open(\'?pg=havaleMgmtPg&cmd=dspHavaleList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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

function ebtalHavaleFrm(){
	                
   $out='<form method="post" action="" >
			<input type="hidden" name="pg" value="havaleMgmtPg">   
		    <input type="hidden" name="cmd" value="ebtalHavale3">
	
	<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
		 <tr style="background-color:'. $_SESSION['htablecolor'] .';">
	 
				<td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ابطال حواله</font></b></td>				     
		 </tr>
		 <tr>
			    <td>&nbsp;</td>
		     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >شماره حواله مورد نظر را وارد كنيد:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="h_code" type="text"  / ></td>		        
		 </tr>
		  <tr>
			    <td>&nbsp;</td>
		     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >علت ابطال را انتخاب کنید:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" >'.  getebtalTypesComboBox('reb_id') .'</td>		        
		 </tr>
		 <tr>
			     <td colspan="2"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;</td>			          
		</tr>
		</form>
</table>
';
	
echo $out;

	
}
function ebtalHavale1(){

	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
      
    $outHtml = ebtalHavaleFrm();
	$outHtml .= '<div align = "center" style="width:100%;height:300px; overflow:auto">
	              <table border="1" class="list" >';
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	
	$query = "
	 	SELECT *  FROM dm_havale
 
		WHERE 
			h_pf_code in (SELECT pf_id FROM  dm_pish_factor
		WHERE pf_ph_code=".$ph_code." ) 
		AND h_status=". 0 ."
		AND h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		AND
		  pf_type=". 0 ."
	";
	//		AND pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	
	$lnk = mysql_query($query);
	$havale = mysql_fetch_assoc($lnk);
	
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND
			ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		AND
				ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	";
	$_SESSION['shPhforPf']=$ph_code;
	$lnk = mysql_query($query);
	sqlErr('wererewr');
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_code'];
		

		    $gdate=$havale['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
		$outHtml .= '<br>
			
			<tr class="rw1" >
			<td colspan="2" style="height: 60px;vertical-align:middle;" align="center">شماره حواله:</td><td colspan="2" style="height: 60px;vertical-align:middle;" align="center">'.$havale['h_code'].'</td><td style="height: 60px;vertical-align:middle;" align="center">تاریخ:</td><td style="height: 60px;vertical-align:middle;" align="center">'. $jdate.'</td>
 		    <td colspan="3" style="height: 60px;vertical-align:middle;" align="center">پیش حواله به شماره :</td><td style="height: 60px;vertical-align:middle;" align="center"> '.$havaleMainInfo['ph_code'].'</td><td style="height: 60px;vertical-align:middle;" align="center" colspan="2">: به نام</td><td colspan="13" style="height: 60px;vertical-align:middle;" > &nbsp;&nbsp;'.$havaleMainInfo['ph_customer_code'].'</td>
 		    
			</tr> ';
			
		
		
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
			AND
			   phd_status=". 0 ."
			  AND
	          phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
		";
		$lnk = mysql_query($query);
		sqlErr('for Display pfactor3');
		if(mysql_affected_rows()>0){
			
		$querych = "SELECT *  FROM dm_product product
						left join dm_price price
						on product.p_id=price.price_p_id 
					    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
							WHERE 
								p_code = ".$row2['p_code']." 
							AND
								p_price_code=".$row['phd_price_code']."
							AND
								price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
								
			$lnkch = mysql_query($querych);
		   sqlErr('for Display charge');
		  // print $querych;
		   $hazine=$row['phd_p_add'];

			$outHtml .= '
		
				<tr class="rw0">
					<td colspan=20 align=center>
					    ريز پيش فاكتور
					</td>
				</tr>
						<tr class="rw1">
							<td>رديف</td>
							<td>نام کالا</td>
							<td>كد كالا</td>
							<td>مقدار باقيمانده</td>
							<td>كد محل تحويل</td>
							<td>نام محل تحويل</td>
							<td>نام تحويل گيرنده</td>
							<td>تحويل با</td>
							<td>كد قيمت</td>
							<td>مقدار خريد</td>
						    <td>قيمت واحد </td>
						    <td>هزينه اضافی </td>
						    					     
							<td colspan="5">قيمت كالا </td>
						</tr>
		
			';
			$inx = 0;
			while($row= mysql_fetch_assoc($lnk)){
				 if(($inx)%2==1){
				$class="rw1";}
				else{
				 $class="rw0";}
				$query2 = "
						SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
						 
								WHERE 
									p_id = ".$row['phd_pid']." 
							";
			
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				$inx++;
				
				$outHtml .= '
						 <tr class='.$class.'>
							<td>'.$inx.'</td>
							<td>'.$row2['p_name'].'</td>
							<td>'.$row2['p_code'].'</td>
							<td>'.$row['phd_amount_remined'].'</td>
							<td>'.$row['phd_l_code'].'</td>
							<td>'.$row['phd_l_name'].'</td>
							<td>'.$row['phd_deli_name'].'</td>
							<td>'.$row['phd_deli_with'].'</td>
							<td>'.$row['phd_price_code'].'</td>
							<td>'.$row['phd_amount'].'</td>';
				$query = "
		     	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id  	 
					WHERE 
						p_id = ".$row['phd_code']." 
				";
				
				$ln = mysql_query($query);
				$prod= mysql_fetch_assoc($ln);
				$price=$row['phd_amount']*$prod['p_sellpriceh'];
							
								$outHtml .= '<td>'.$prod['p_sellprice'].'</td>
								               <td>'.$hazine.'</td>
											 <td>'.$price.'</td>
											 <td align=left >							           
									         </td>
									         <td>
									        
									            <button type="button" onclick=window.open("printHavale.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_id='.$havale['h_id'].'") value=" چاپ اول" class="button blue skew" style="font-size:10px; color:#FFFFFF" >رویت حواله </button></td>
									             <button type="button" onclick=window.open("printHavale2.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_id='.$havale['h_id'].'") value="چاپ دوم" class="button blue skew" style="font-size:10px; color:#FFFFFF" >رویت حواله </button></td>
									             <button type="button" onclick=window.open("printHavale3.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_id='.$havale['h_id'].'") value=" چاپ سوم" class="button blue skew" style="font-size:10px; color:#FFFFFF" >رویت حواله </button></td>
									             
									            
									         <td> <button type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=Ebtalafew_h&phd_id='.$havale['h_phd_id'].'&ph_code='.$ph_code.'&h_id='.$havale['h_id'].'&h_code='.$havale['h_code'].'&h_pre_date='.$havale['h_date'].'","_blank") value=" ابطال مقداري از حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ابطال مقداري از حواله </button>							           								        				            
									         </td>
								        </tr>     
					';
				$totalprice =$price+$totalprice;
				
			}
			$outHtml .= '
					
					<tr class="rw0">
					   <td colspan="6">&nbsp;&nbsp;</td>
						<td  align="center"><button type="button" value="ابطال حواله و ایجاد حواله جدید" onclick="Ebtal_createNewh(\'\', \''.$havale['h_id'].'\', \''.$havale['h_pf_code'].'\', \''.$havale['h_code'].'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ابطال حواله و ایجاد حواله جدید</button></td>
					    <td  align="center"><button type="button" value="ابطال حواله بدون ایجاد حواله جدید" onclick="EbtalHavaleNotNew(\'\', \''.$havale['h_id'].'\', \''.$havale['h_pf_code'].'\', \''.$havale['h_code'].'\', \''.$ph_code.'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF">ابطال حواله بدون ایجاد حواله جدید</button></td>
						<td colspan="7">&nbsp;&nbsp;</td>
					</tr>
								</table>
								<br><br>
			';
		}

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره پیش حواله نادرست است</font></b>';
		
	}
	$outHtml .= '</table>';
	$outHtml .='</div >';
	return $outHtml;
		
}
function  ebtalMoarefi(){
	
	 $out='<form method="post" action="" >
			<input type="hidden" name="pg" value="havaleMgmtPg">   
		    <input type="hidden" name="cmd" value="ebtalMoarefiname">
	
	<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
		 <tr style="background-color:'. $_SESSION['htablecolor'] .';">
	 
				<td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ابطال حواله</font></b></td>				     
		 </tr>
		 <tr>
			    <td>&nbsp;</td>
		     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >شماره معرفي نامه مورد نظر را وارد كنيد:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="pf_code" type="text"  / ></td>		        
		 </tr>
		 <tr>
			     <td colspan="2"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;</td>			          
		</tr>
		</form>
</table>
';
	
echo $out;
	
}
function ebtalMoarefiname(){
		
	$pf_code = isset($_REQUEST['pf_code']) ? $_REQUEST['pf_code'] : '';
		
	$query = "
	 	SELECT *  FROM dm_pish_factor 
			WHERE 
				pf_code = '".$pf_code."'
			AND 
			    pf_id_province= '".$_SESSION['dm_user_profile']['u_province_id']."'
			AND
			    pf_id_year= '".$_SESSION['dm_user_profile']['u_year_id']."'";
		  	
//print 	$query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$row= mysql_fetch_assoc($lnk);	
	$ph_code=$row['pf_ph_code'];
	$pf_id=$row['pf_id'];
	?><input name="pf_id" id="pf_id" type="hidden" value="<?php echo $pf_id ?>" />	<?php 
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
       
	$outHtml  = '<div dir="rtl">
	                   <br>
						<table  style=" align="center"  width="100%" class="list" margin-top:20px" >
					  	<tr align="middle" class="rw1">
					      <td colspan="14"  style="height: 50px;vertical-align:middle;"  ><font size="5"> معرفي نامه</font-size></td>
				        </tr>
		';
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND
		   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		 AND 
	       ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	";
//print 	$query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_code'];
		$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		    $province_code=$rowprov['province_code'];
	if($havaleMainInfo['ph_customer_type']=='n'){
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$havaleMainInfo['ph_customer_code']."' 
								AND
			             customer_code_org=".$province_code."";		
				
				$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولي';
			
		}else{
				$query = "
					 	SELECT *  FROM dm_customer_mot 
				 
						WHERE 
							cm_customer_id = '".$havaleMainInfo['ph_customer_code']."' ";		
								
				$lnk = mysql_query($query);
				sqlErr('for customer1');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['cm_name_customer'];
						$Type='متفرقه';				
	            	}
		
		$outHtml .= '
			<tr class="rw0" style="font-weight:bold;">
			<td colspan="2">تاريخ:'. "$year_number/$month_number/$day_number".'</td>
			<td colspan="2">شماره معرفي نامه:'.$pf_code.'</td>
 		    <td colspan="2">پيش حواله به شماره : '.$havaleMainInfo['ph_code'].'</td><td > به نام :'.$cusName.'</td>
			</tr> 	
		';
		
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
				WHERE 
					phd_ph_code = ".$ph_code." 
			    AND 
		            phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		        AND 
		            phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
	
		if(mysql_error()) print mysql_error();
		if(mysql_affected_rows()>0){
			$outHtml .= '
		          <tr  class="rw1"><td colspan="13"><hr></td></tr>
				<tr class="rw1">
					<td colspan="12" align=center>
					 
					   <b> ريز معرفي نامه</b>
					</td>
				</tr>
						<tr class="rw0" style="font-weight:bold;height:20px;">
							<td >رديف</td>
							<td >نام کالا</td>
							<td>كد كالا</td>
							<td>كد قيمت</td>
							<td>مقدار خريد</td>
						    <td>قيمت واحد </td>
							<td colspan="2">قيمت كالا </td>
						</tr>
		</div>
			';
			$inx = 0;
			
			while($row= mysql_fetch_assoc($lnk)){
				$query2 = "
						SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
						 
								WHERE 
									p_id = ".$row['phd_pid']." 
							";
			
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				$inx++;
				if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				
				$outHtml .= '
						<tr class="'.$class.'">
							<td  style="vertical-align:middle;">'.$inx.'</td>
							<td  style="vertical-align:middle;">'.$row2['p_name'].'</td>
							<td  style="vertical-align:middle;">'.$row2['p_code'].'</td>
							<td  style="vertical-align:middle;">'.$row['phd_price_code'].'</td>
							<td  style="vertical-align:middle;">'.$row['phd_amount'].'</td>';
				$query = "
		 	          SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
	 
			WHERE 
				p_code = ".$row['phd_pid']." 
			AND p_price_code=".$row['phd_price_code']."
			and
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		";
	//			print  $query;
				$ln = mysql_query($query);
				
				if(mysql_error()) print mysql_error();
				$prod= mysql_fetch_assoc($ln);
				$price=$row['phd_amount']*$prod['p_unit'];
							
							$outHtml .= '<td >'.$prod['p_sellprice'].'</td>
											<td >'.$row['phd_price'].'</td>
								        
								         </tr>  
								          
					';
				$totalprice =$price+$totalprice;
				
			}
			
			$outHtml .= '
					
					<tr>
					
				     <td> جمع کل:'.$totalprice.'</td>
				     <td colspan="11">&nbsp;&nbsp;&nbsp;</td>
					</tr>';				
					 
	 $outHtml .=' <tr>	      	         
		               <td colspan="8" align="left"> <span> <button type="button" onclick=window.open("PrintMoarefi.php?PhNo='.$ph_code.'&reqNo='.urlencode($havaleMainInfo['cm_req_num']).'&cus_name='.urlencode($cusName).'&cus_economic='.urlencode( $code_economic_customer ).'&cus_postal='.  $cInfo[$fieldPrefix.'code_postal_costumer'] .'&cus_address_office='. urlencode($cInfo[$fieldPrefix.'customer_address_office']) .'&cus_tel='. $cInfo[$fieldPrefix.'customer_tel'] .'&cus_type='. $Type .'&cm_req_date='. $havaleMainInfo['cm_req_date'] .'&cus_category='. $cInfo[$fieldPrefix.'customer_category'] .'&status='. 1 .'&province_name='.urlencode($provinceName).'&province_id='.  $_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.  $_SESSION['dm_user_profile']['u_year_id'] .'","_blank") value=" چاپ معرفي نامه"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ معرفي نامه</button></span> </td>
		                 <td  align="center"><button type="button" value="ابطال معرفي نامه" onclick="EbtalM(\'\', \''.$pf_id.'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF">ابطال معرفي نامه</button></td>					                          																				             																				
		             					     				           
	      	</tr>
	      	</table>
	 </td>
	</tr>
	</table>
			</div>
			<br>';
						
		}

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره معرفي نامه نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</td>
	</tr>
	
			</table>
			';
	echo  $outHtml;
}
function done(){
	
	echo 'انجام شد';
	
	
}
function ebtalMPage(){
	
	$ebh_id = isset($_REQUEST['ebh_id']) ? $_REQUEST['ebh_id'] : '';
	$pf_id = isset($_REQUEST['pf_id']) ? $_REQUEST['pf_id'] : '';
		$pf_id = isset($_REQUEST['pf_id']) ? $_REQUEST['pf_id'] : '';
	$query5 = "
				 SELECT *  FROM dm_ebtal_m 						 
								WHERE 
									ebh_id = '".$ebh_id."' "; 
									
							//	print $query5;			   					
						$lnk5 = mysql_query($query5);
						$row5= mysql_fetch_assoc($lnk5);
	
	$query = "
	 	SELECT *  FROM dm_pish_factor 
 
		WHERE 
			pf_id = '".$pf_id."' 
			
		  
	";
//print 	$query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$row= mysql_fetch_assoc($lnk);
	
	$ph_code=$row['pf_ph_code'];
	$pf_code=$row['pf_code'];
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
       
	$outHtml  = '<div dir="rtl">
	                   <br>
						<table  style=" align="center"  width="100%" class="list" margin-top:20px" >
					  	<tr align="middle" class="rw1">
					      <td colspan="14"  style="height: 50px;vertical-align:middle;"  ><font size="5">  ابطال معرفي نامه</font-size></td>
				        </tr>
		';
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND
		   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		 AND 
	       ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	";
//print 	$query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_code'];
		$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		    $province_code=$rowprov['province_code'];
	if($havaleMainInfo['ph_customer_type']=='n'){
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$havaleMainInfo['ph_customer_code']."' 
								AND
			             customer_code_org=".$province_code."";		
				
				$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولي';
			
		}else{
				$query = "
					 	SELECT *  FROM dm_customer_mot 
				 
						WHERE 
							cm_customer_id = '".$havaleMainInfo['ph_customer_code']."' ";		
								
				$lnk = mysql_query($query);
				sqlErr('for customer1');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['cm_name_customer'];
						$Type='متفرقه';				
	            	}
		
		$outHtml .= '
			<tr class="rw0" style="font-weight:bold;">
			<td colspan="2">تاريخ:'. "$year_number/$month_number/$day_number".'</td>
			<td colspan="2">شماره معرفي نامه:'.$pf_code.'</td>
 		    <td colspan="2">پيش حواله به شماره : '.$havaleMainInfo['ph_code'].'</td><td > به نام :'.$cusName.'</td>
			</tr> 	
		';
		
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
		 AND 
	            phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	      AND 
	            phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
	
		if(mysql_error()) print mysql_error();
		if(mysql_affected_rows()>0){
			$outHtml .= '
		          <tr  class="rw1"><td colspan="13"><hr></td></tr>
				<tr class="rw1">
					<td colspan="12" align=center>
					 
					   <b> ريز معرفي نامه</b>
					</td>
				</tr>
						<tr class="rw0" style="font-weight:bold;height:20px;">
							<td >رديف</td>
							<td >نام کالا</td>
							<td>كد كالا</td>
							<td>كد قيمت</td>
							<td>مقدار خريد</td>
						    <td>قيمت واحد </td>
							<td colspan="2">قيمت كالا </td>
						</tr>
		</div>
			';
			$inx = 0;
			
			while($row= mysql_fetch_assoc($lnk)){
				$query2 = "
						SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
						 
								WHERE 
									p_id = ".$row['phd_pid']." 
							";
			
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				$inx++;
				if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				
				$outHtml .= '
						<tr class="'.$class.'">
							<td  style="vertical-align:middle;">'.$inx.'</td>
							<td  style="vertical-align:middle;">'.$row2['p_name'].'</td>
							<td  style="vertical-align:middle;">'.$row2['p_code'].'</td>
							<td  style="vertical-align:middle;">'.$row['phd_price_code'].'</td>
							<td  style="vertical-align:middle;">'.$row['phd_amount'].'</td>';
				$query = "
		 	          SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
	 
			WHERE 
				p_code = ".$row['phd_pid']." 
			AND
			  p_price_code=".$row['phd_price_code']."
			and
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		";
	//			print  $query;
				$ln = mysql_query($query);
				
				if(mysql_error()) print mysql_error();
				$prod= mysql_fetch_assoc($ln);
				$price=$row['phd_amount']*$prod['p_unit'];
							
							$outHtml .= '<td >'.$prod['p_sellprice'].'</td>
											<td >'.$row['phd_price'].'</td>
								        
								         </tr>  
								          
					';
				$totalprice =$price+$totalprice;
				
			}
													 
	 $outHtml .=' <tr>	      	         
		               <td colspan="8" align="left"> <span> <button type="button" onclick=window.open("printebtalm.php?pf_id='.$pf_id.'&PhNo='.$ph_code.'&reqNo='.$havaleMainInfo['cm_req_num'].'&cus_name='.urlencode($cusName).'&cus_economic='.urlencode( $code_economic_customer ).'&cus_postal='.  $cInfo[$fieldPrefix.'code_postal_costumer'] .'&cus_address_office='. urlencode($cInfo[$fieldPrefix.'customer_address_office']) .'&cus_tel='. $cInfo[$fieldPrefix.'customer_tel'] .'&cus_type='. $Type .'&cm_req_date='. $havaleMainInfo['cm_req_date'] .'&cus_category='. $cInfo[$fieldPrefix.'customer_category'] .'&status='. 1 .'&province_name='.urlencode($provinceName).'&province_id='.  $_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.  $_SESSION['dm_user_profile']['u_year_id'] .'","_blank") value=" چاپ ابطالي"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ ابطالي</button></span> </td>					                          																				             																				
		             					     				           
	      	</tr>
	      	</table>
	 </td>
	</tr>
	</table>
			</div>
			<br>';
						
		}

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره معرفي نامه نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</td>
	</tr>
	
			</table>
			';
	echo  $outHtml;
	
}
function ShowAebtal(){

	$ebh_id = isset($_REQUEST['ebh_id']) ? $_REQUEST['ebh_id'] : '';
	$queryeb = "SELECT *  FROM dm_ebtal_h
 
		WHERE 
			 ebh_id=".$ebh_id.""; 
	 
	//print $queryeb;
	$lnkeb = mysql_query($queryeb);
	$roweb = mysql_fetch_assoc($lnkeb);
	//echo $roweb['ebh_type'];
	if($roweb['ebh_type']==1){
		//yani kole havale ebtal shode
					$h_id=$roweb['ebh_h_id'];
					$querypro="SELECT * FROM dm_province WHERE 
				            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
				$lnkpro = mysql_query($querypro); 
				$rowpro = mysql_fetch_assoc($lnkpro);
				$province_code=$rowpro['province_code'];
				
				$outHtml='<br><div><table  align="center" class="list">';	
				$query = "
					 	SELECT *  FROM dm_havale
				 
						WHERE 
							h_id = ".$h_id." 
						
					";
			//	print $query;
				$lnk1 = mysql_query($query);
				$row1 = mysql_fetch_assoc($lnk1);
				$h_code=$row1['h_code'];
				$hDate=$row1['h_reg_date'];
				
				        $gdate=$row1['h_reg_date'];
						list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
						list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
						$jdate = $jyear."/".$jmonth."/".$jday;
				
				$query="select * from dm_pish_havale ph left join  dm_pish_factor pf
							on ph.ph_code=pf.pf_ph_code  and  pf.pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."

							left join dm_havale h 
							on h.h_pf_code=pf.pf_code AND pf. pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							where  
							
							  h_id=".$h_id."
							AND
		                        pf_type=". 0 ."
		                   AND
		                        pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							   AND
							    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							   ";
											
						
					$lnk = mysql_query($query);
				//	print $query;
					$row = mysql_fetch_assoc($lnk);
					$ph_code=$row['ph_code'];
					    $gdate=$row['ph_reg_date'];
				
									$query = "
									 	SELECT *  FROM dm_customer 
								 
										WHERE 
											code_customer = '".$row1['h_customer_code']."' 
											  AND
						                    customer_code_org=".$province_code."";
												
							$lnk = mysql_query($query);
							sqlErr('for customer');
							$cusMainInfo = mysql_fetch_assoc($lnk);	
									$cusName=$cusMainInfo['name_customer'];
														
						list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
						list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
						$jdate = $jyear."/".$jmonth."/".$jday;				
					$query = "
					 	SELECT *  FROM dm_pish_havale_det 
				 
						WHERE 
							phd_ph_code = ".$row['ph_code']." 
							
					";
				//	print $query;
					$lnk = mysql_query($query);
					sqlErr('line16622');
					$gdate=$hDate;
				     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
				     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
				     $hDate= $jyear."/".$jmonth."/".$jday;
				    
				     $gdate=$roweb['ebh_reg_date'];
				     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
				     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
				     $ebh_date= $jyear."/".$jmonth."/".$jday;
					if(mysql_affected_rows()>0){
							$outHtml .= '
									<tr class="rw1">
									    <td colspan="12" align="center"> اين حواله كاملا ابطال شده است</td>
									</tr>
									<tr class="rw0">
									    <td colspan="4"><b>ابطال شماره:</b>'.$roweb['ebh_code'].'</td><td colspan="4"><b>تاريخ:</b>'. $ebh_date.'</td>
									    <td colspan="2">&nbsp;</td>	
									<tr class="rw1">					
										<td colspan="2"><b>شماره حواله:</b>'.$h_code.'</td><td colspan="2"><b>تاريخ:</b>'. $hDate.'</td>
							 		    <td  colspan="2"><b> پيش حواله به شماره : </b>'.$ph_code.'</td><td colspan="6"><b> به نام :</b>'.$cusName.'</td>      
									</tr>'; 
																	
								//retrieve detail of pishHavale
								$queryh = "
								 	SELECT *  FROM dm_havale 
							 
									WHERE 
										h_id = ".$h_id." 
								";
								$lnkh = mysql_query($queryh);
						//		print $query;
								sqlErr('for Display Havale');
								if(mysql_affected_rows()>0){
									$outHtml .= '
								
										    <tr class="rw0">
												<td colspan=12 align="center" style="font-weight:bold;font-size:20px;height: 50px;vertical-align:middle;">
												    <div>ريز حواله</div>
												</td>
										     </tr>
												<tr class="rw1" style="font-weight:bold;vertical-align:middle;">
													<td align="center">رديف</td>
													<td align="center">نام کالا</td>
													<td align="center">كد كالا</td>										
													<td align="center">كد محل تحويل</td>
													<td align="center">نام محل تحويل</td>
													<td align="center">نام تحويل گيرنده</td>
													<td align="center">كد قيمت</td>
													<td colspan="5">مقدار خريد</td>
													
												</tr>
								</div>
									';
									$inx = 0;
									while($rowh= mysql_fetch_assoc($lnkh)){
											$query = "select * from
								 	dm_product product
										left join dm_price price
										on product.p_id=price.price_p_id 
							 
									WHERE 
										p_code = ".$rowh['h_p_code']." 
									ANd
									   p_price_code=".$rowh['h_price_code']."
									AND
									   price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ."
								";
			//					print $query;		
										$ln = mysql_query($query);
									$prod= mysql_fetch_assoc($ln);
										$inx++;
									if(($inx)%2==1)
										$class="rw0";
										else
										 $class="rw1";
										 
							$queryL = "
								 	SELECT *  FROM dm_location_goods 
							 
									WHERE 
										l_id = ".$rowh['h_l_code']." 						
									
								";
			//					print $queryL;		
										$lnkL = mysql_query($queryL);
									    $Loc= mysql_fetch_assoc($lnkL);
										 
										$amount=formatMoney($rowh['h_amount']);
									    
										$outHtml .= '
												<tr class="'. $class.'" style="vertical-align:middle;">
													<td align="center" width=5%>'.$inx.'</td>
													<td align="center" width=15%>'.$prod['p_name'].'</td>
													<td align="center" width=10%>'.$rowh['h_p_code'].'</td>										
													<td align="center" width=10%> '.$Loc['l_code'].'</td>
													<td align="center" width=15%>'.$Loc['l_name'].'</td>
													<td align="center" width=15%>'.$rowh['h_deli_name'].'</td>										
													<td  align="center" width=10%>'.$rowh['h_price_code'].'</td>
													<td colspan="5" width=10%>'.$amount.'</td>';
									
			               $queryp="SELECT * FROM dm_province 
				              WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
							    $lnkp=mysql_query($queryp);
							    print mysql_error();
							    $rowp=mysql_fetch_assoc($lnkp);
							    $provinceName=$rowp['province_name'];
										                                                          
													$outHtml .= '
																	
														         <td style="background-color:'. $_SESSION['htablecolor'] .';">											         											          
														           <div><button type="button" onclick=window.open("ebtal.php?phd_id='.$row['phd_id'].'&customer_code='.$row1['h_customer_code'].'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row1['h_price_code'].'&p_code='.$row1['h_p_code'].'&l_id='.$Loc['l_id'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$row1['h_id'].'&ebh_code='.$roweb['ebh_code'].'")  value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
														              چاپ ابطال حواله</button></div>
														         </td>
														         </tr>     
											';
										$totalprice =$row['h_price']+$totalprice;
										
									}
									$outHtml .= '																
										</table>						
										<div align="center"><a href="?pg=havaleMgmtPg&cmd=ebtalList"> <img src="images/back1.png"  title="بازگشت" ></img></a> </div>';	   														
								}
									
				}
				return $outHtml;	
	}else if($roweb['ebh_type']==0){
		//yani ebtal joze
	    $query2 = "
			 	SELECT *  FROM dm_his_havale 		 
				WHERE 
					his_id = '".$roweb['ebh_h_id']."'
					AND
					his_id_province = '".$_SESSION['dm_user_profile']['u_province_id'] ."'"; 
										
//	    print $query2;		    									
					$lnk2 = mysql_query($query2);
					sqlErr('for dm_his_havale');
					$row2 = mysql_fetch_assoc($lnk2);
					$h_id=$row2['his_h_id'];
					
					$his_id=$row2['his_id'];
					$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	
	$outHtml='<br><div><table  align="center" class="list">';	
	$query = "
		 	SELECT *  FROM dm_havale
	 
			WHERE 
				h_id = ".$h_id." 
			
		";
//	print $query;
	$lnk1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($lnk1);
	$h_code=$row1['h_code'];
	$hDate=$row1['h_reg_date'];
	
	        $gdate=$row1['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
	
			$query="select * from dm_pish_havale ph left join  dm_pish_factor pf
							on ph.ph_code=pf.pf_ph_code  left join dm_havale h 
							on h.h_pf_code=pf.pf_code
							where 
							 
							  h_id=".$h_id."
							
							AND
							  ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						    AND
							  pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
		                      pf_type=". 0 ."	";
			
		$lnk = mysql_query($query);
		$row = mysql_fetch_assoc($lnk);
		$ph_code=$row['ph_code'];
		    $gdate=$row['ph_reg_date'];
	
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$row1['h_customer_code']."' 
								  AND
			                    customer_code_org=".$province_code."";
//					print $query;				
				$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
											
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;				
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$row['ph_code']." 
				 
		";
		$lnk = mysql_query($query);
		sqlErr('line1662');
		$gdate=$hDate;
	     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	     $hDate= $jyear."/".$jmonth."/".$jday;
	    
	     $gdate=$roweb['ebh_reg_date'];
	     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	     $ebh_date= $jyear."/".$jmonth."/".$jday;
		if(mysql_affected_rows()>0){
								$outHtml .= '
						
						<tr class="rw0">
						    <td colspan="4"><b>ابطال شماره:</b>'.$roweb['ebh_code'].'</td><td colspan="4"><b>تاريخ:</b>'. $ebh_date.'</td>
						    <td colspan="9">&nbsp;</td>	
						<tr class="rw1">					
							<td colspan="2"><b>شماره حواله:</b>'.$h_code.'</td><td colspan="2"><b>تاريخ:</b>'. $hDate.'</td>
				 		    <td  colspan="2"><b> پيش حواله به شماره : </b>'.$ph_code.'</td><td colspan="6"><b> به نام :</b>'.$cusName.'</td>
				 		    <td colspan="8">&nbsp;</td>
				 		          
						</tr>'; 
														
					//retrieve detail of pishHavale
					$queryh = "
					 	SELECT *  FROM dm_havale 
				 
						WHERE 
							h_id = ".$h_id." 
					";
					$lnkh = mysql_query($queryh);
			//		print $query;
					sqlErr('for Display Havale');
					if(mysql_affected_rows()>0){
						$outHtml .= '
					
							    <tr class="rw0">
									<td colspan=17 align="center" style="font-weight:bold;font-size:20px;height: 50px;vertical-align:middle;">
									    <div>ريز حواله</div>
									</td>
							     </tr>
									<tr class="rw1" style="font-weight:bold;vertical-align:middle;">
										<td align="center">رديف</td>
										<td align="center">نام کالا</td>
										<td align="center">كد كالا</td>										
										<td align="center">كد محل تحويل</td>
										<td align="center">نام محل تحويل</td>
										<td align="center">نام تحويل گيرنده</td>
										<td align="center">كد قيمت</td>
										<td colspan="5">مقدار خريد</td>
										<td colspan="5">مقدار ابطالي</td>
										<td colspan="5">مقدار صادره</td>
									</tr>
					</div>
						';
						$inx = 0;
						while($rowh= mysql_fetch_assoc($lnkh)){
								$query = "select * from
					 	dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
				 
						WHERE 
							p_code = ".$rowh['h_p_code']." 
						ANd
						   p_price_code=".$rowh['h_price_code']."
						AND
						   price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ."
					";
//					print $query;		
							$ln = mysql_query($query);
						$prod= mysql_fetch_assoc($ln);
							$inx++;
						if(($inx)%2==1)
							$class="rw0";
							else
							 $class="rw1";
							 
				$queryL = "
					 	SELECT *  FROM dm_location_goods 
				 
						WHERE 
							l_id = ".$rowh['h_l_code']." 						
						
					";
//					print $queryL;		
							$lnkL = mysql_query($queryL);
						    $Loc= mysql_fetch_assoc($lnkL);
							 
							$amount=formatMoney($row2['his_pre_amount']);
							if($row2['his_eb_amount']==0){
								$his_eb_amount=$row2['his_pre_amount'];
							}else{
								$his_eb_amount=$row2['his_eb_amount'];
								
							}
							$amountN=$row2['his_pre_amount']-$row2['his_eb_amount'];
						    
							$outHtml .= '
									<tr class="'. $class.'" style="vertical-align:middle;">
										<td align="center" width=5%>'.$inx.'</td>
										<td align="center" width=15%>'.$prod['p_name'].'</td>
										<td align="center" width=10%>'.$rowh['h_p_code'].'</td>										
										<td align="center" width=10%> '.$Loc['l_code'].'</td>
										<td align="center" width=15%>'.$Loc['l_name'].'</td>
										<td align="center" width=15%>'.$rowh['h_deli_name'].'</td>										
										<td  align="center" width=10%>'.$rowh['h_price_code'].'</td>
										<td colspan="5" width=10%>'.$amount.'</td>
										<td colspan="5" width=10%>'.$his_eb_amount.'</td>
										<td colspan="5" width=10%>'.$amountN.'</td>';
										
						
               $queryp="SELECT * FROM dm_province 
	              WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
				    $lnkp=mysql_query($queryp);
				    print mysql_error();
				    $rowp=mysql_fetch_assoc($lnkp);
				    $provinceName=$rowp['province_name'];
							
										$outHtml .= '<tr>
														
											          <div align="center"><button type="button" onclick=window.open("ebtal1.php?customer_code='.$rowh['h_customer_code'].'&phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_code='.$row1['h_code'].'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row1['h_price_code'].'&p_code='.$row1['h_p_code'].'&l_id='.$row1['h_l_code'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$h_id.'&his_id='.$roweb['ebh_h_id'].'&ebh_code='. $roweb['ebh_code'].'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
											              رويت ابطال</button></div>
											         </tr>';     
								
							$totalprice =$row['h_price']+$totalprice;
							
						}
						$outHtml .= '																
							</table>						
							<div align="center"><a href="?pg=havaleMgmtPg&cmd=ebtalList"> <img src="images/back1.png"  title="بازگشت" ></img></a> </div>';		   																

					
					
					}
						
	}
	return $outHtml;
					
				
	}
}
function ebtalHavale2(){

	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
     
    $outHtml = ebtalHavaleFrm();
	$outHtml .= '<div align = "center" style="width:100%;height:300px; overflow:auto">
	 <table border="1"  class="list" >';
	$pf_code = isset($_REQUEST['pf_code']) ? $_REQUEST['pf_code'] : '';
	
	$query = "
	 	SELECT *  FROM dm_pish_factor
 
		WHERE 
			 pf_code=".$pf_code." 
			 AND
		   pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."  
		   AND
		   pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		   AND
		  pf_type=". 0 ."
	";
	$lnk = mysql_query($query);
	$row = mysql_fetch_assoc($lnk);
	$ph_code=$row['pf_ph_code'];
	
	$query = "
	 	SELECT  *  FROM dm_havale
 
		WHERE 
			h_pf_code in (SELECT pf_id FROM  dm_pish_factor
		WHERE pf_ph_code=".$ph_code." )
		AND h_status=". 0 ."
		AND h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		AND h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	";
	$lnk = mysql_query($query);
	$havale = mysql_fetch_assoc($lnk);
	
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND
				ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		
	";
	$_SESSION['shPhforPf']=$ph_code;
	$lnk = mysql_query($query);
	sqlErr('wererewr');
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_id'];
		
		    $gdate=$havale['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
	
		$outHtml .= '<br>
			<tr class="rw1" >
			<td colspan="2" style="height: 60px;vertical-align:middle;" align="center">شماره حواله:</td><td colspan="2" style="height: 60px;vertical-align:middle;" align="center">'.$havale['h_code'].'</td><td style="height: 60px;vertical-align:middle;" align="center">تاريخ:</td><td style="height: 60px;vertical-align:middle;" align="center">'. $jdate.'</td>
 		    <td colspan="3" style="height: 60px;vertical-align:middle;" align="center">پيش حواله به شماره :</td><td style="height: 60px;vertical-align:middle;" align="center"> '.$havaleMainInfo['ph_code'].'</td><td style="height: 60px;vertical-align:middle;" align="center" colspan="2">: به نام</td><td colspan="13" style="height: 60px;vertical-align:middle;" > &nbsp;&nbsp;'.$havaleMainInfo['ph_customer_code'].'</td>
			</tr> 
		';
		
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
		 AND
	          phd_id_year=".$_SESSION['dm_user_profile']['u_year_id'].""; 
			
		
		$lnk = mysql_query($query);
		sqlErr('for Display pfactor4');
		if(mysql_affected_rows()>0){
			$outHtml .= '
		
				<tr class="rw0">
					<td colspan=15 align=center>
					    <div>ريز پيش فاكتور</div>
					</td>
				</tr>
						<tr class="rw1">
							<td>رديف</td>
							<td>نام کالا</td>
							<td>كد كالا</td>
							<td>مقدار باقيمانده</td>
							<td>كد محل تحويل</td>
							<td>نام محل تحويل</td>
							<td>نام تحويل گيرنده</td>
							<td>تحويل با</td>
							<td>كد قيمت</td>
							<td>مقدار خريد</td>
						    <td>قيمت واحد </td>
							<td colspan="3">قيمت كالا </td>
						</tr>
		</div>
			';
			$inx = 0;
			while($row= mysql_fetch_assoc($lnk)){
			 if(($inx)%2==1){
				$class="rw1";}
			else{
				 $class="rw0";}
				$query2 = "
						SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id  
						 
								WHERE 
									p_id = ".$row['phd_pid']." 
							";
			
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				$inx++;
				
				$outHtml .= '
						 <tr class='.$class.'>
							<td>'.$inx.'</td>
							<td>'.$row2['p_name'].'</td>
							<td>'.$row2['p_code'].'</td>
							<td>'.$row['phd_amount_remined'].'</td>
							<td>'.$row['phd_l_code'].'</td>
							<td>'.$row['phd_l_name'].'</td>
							<td>'.$row['phd_deli_name'].'</td>
							<td>'.$row['phd_deli_with'].'</td>
							<td>'.$row['phd_price_code'].'</td>
							<td>'.$row['phd_amount'].'</td>';
				$query = "
		 	    SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id  	 
			WHERE 
				p_id = ".$row['phd_code']." 
		";
				
				$ln = mysql_query($query);
				$prod= mysql_fetch_assoc($ln);
				$price=$row['phd_amount']*$prod['p_sellpriceh'];
							
							$outHtml .= '<td>'.$prod['p_sellprice'].'</td>
											<td>'.$price.'</td>
																		           
								         </td>
								       

								        <td> <button type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=Ebtalafew_h&phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_id='.$havale['h_id'].'&h_code='.$havale['h_code'].'","_blank") value=" ابطال مقداري از حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ابطال مقداري از حواله </button></td>						
								           
								         </tr>     
					';
				$totalprice =$price+$totalprice;
				
			}
			$outHtml .= '
					
					<tr class="rw0">
					   <td colspan="6">&nbsp;&nbsp;</td>
						<td  align="center"><button type="button" value="ابطال حواله و ايجاد حواله جديد" onclick="Ebtal_createNewh(\'\', \''.$havale['h_id'].'\', \''.$havale['h_pf_code'].'\', \''.$havale['h_code'].'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ابطال حواله و ايجاد حواله جديد</button></td>
					    <td  align="center"><button type="button" value="ابطال حواله بدون ايجاد حواله جديد" onclick="EbtalHavaleNotNew(\'\', \''.$havale['h_id'].'\', \''.$havale['h_pf_code'].'\', \''.$havale['h_code'].'\', \''.$ph_code.'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF">ابطال حواله بدون ايجاد حواله جديد</button></td>
						<td colspan="7">&nbsp;&nbsp;</td>
					</tr>
								</table>
								<br><br>';	
		}

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره پیش فاكتور نادرست است</font></b>';
		
	}
	$outHtml .= '</div >';
	$outHtml .='</table>';
	return $outHtml;
		
}
function ebtalPage(){

	
	$ebh_id = isset($_REQUEST['ebh_id']) ? $_REQUEST['ebh_id'] : '';	
	//print $ebh_id;
	$queryeb="SELECT * FROM dm_ebtal_h WHERE 
	            	  ebh_id=".$ebh_id; 
	$lnkeb = mysql_query($queryeb); 
	$roweb = mysql_fetch_assoc($lnkeb);
	$his_id=$roweb['ebh_h_id'];
	$ebh_code=$roweb['ebh_code'];
	$queryh="SELECT * FROM dm_his_havale WHERE 
	            	  his_id=".$his_id; 
	$lnkh = mysql_query($queryh); 
	$rowh = mysql_fetch_assoc($lnkh);
//	print $queryh;
	$h_id=$rowh['his_h_id'];
 	
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];	
	$outHtml='<br><div><table  align="center" class="list">';
	
	$query = "
		 	SELECT *  FROM dm_havale
	 
			WHERE 
				h_id = ".$h_id." 
			
		";
//	print $query;
	$lnk1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($lnk1);
	$h_code=$row1['h_code'];
	$hDate=$row1['h_reg_date'];
	$phd_id=$row1['h_phd_id'];
	
	//detail anbar
	
		$query1="SELECT * FROM sell.dm_pish_havale_det WHERE phd_id=".$phd_id."   ";
										        
			$lnk1 = mysql_query($query1);
			$row1 = mysql_fetch_assoc($lnk1);
				
	$query2="SELECT * FROM sell.dm_location_goods WHERE l_id=".$row1['phd_l_id']."
										           ";
										
									//	print $querych;
										$lnk2 = mysql_query($query2);
										$row2 = mysql_fetch_assoc($lnk2);	
										$phd_pid=$row1['phd_pid'];
										$phd_id_province=$row1['phd_id_province'] ; 
										$l_code= $row2['l_code'];
										
$querydad="SELECT * FROM dm_anbar_det WHERE dad_phd_id=".$phd_id." 
			 ";
								        
			$lnkdad = mysql_query($querydad);
			//$rowdad = mysql_fetch_assoc($lnkdad);
			//$dad_anbar_id=$rowdad['dad_anbar_id'];
			//echo $querydad;
			$dad_anbar_id='';
			while($rowdad = mysql_fetch_assoc($lnkdad))
			{
				
				$dad_anbar_id .= ' or mojody_kala.id='.$rowdad['dad_anbar_id'].' ';
				
			}								
				?>
	
	<style>
	
	table.list{
       width:100%;
       margin-top:5px;
       padding-top:20px;
       border:0px solid #BBB;
       margin-top:20px;
      
     
}

.wrapper {
	background-color: #CCFFFF;
	width: 400px;
	height: 20px;
	overflow: auto;
}

.md_developer table.list{
       margin:2px 0 0 0;
       
}


table.list tr.frstRw{
       background-color:#EEF;
       
}

table.list tr.frstRw td{
       text-align:center;
       vertical-align:middle;
       
}

table.list tr td.tls{/*Tools*/
       text-align:center;
       vertical-align:middle;
      
}

table.list tr td.chk{/*CheckBox Column*/
       text-align:center;
       vertical-align:middle;
}

table.list tr.rw1, r1{
       background-color:#FFFFFF ;
       vertical-align:middle;
}
table.list textarea, select, input.chk{
 border:1px solid #DDD;
 width:50%;

}
table.list tr.rw0, r0{
       background-color:#BBF0F7 ;
       vertical-align:middle;
}
/*baraye hover table*/
table.list tr.rw1:hover,table.list tr.rw0:hover{
       background-color:#B1C9D5;
}

table.list tr.gry{
       background-color:#DDD;
}
table.list{
       width:100%;
       margin-top:5px;
       border:0px solid #BBB;
       -moz-border-radius: 20px; 
         
}
				                      
	}

	</style>
	
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
		
	$outHtml= '	<form method="get" action=".php">
					<input type="hidden" name="pg1" value="prodMgmtPg">   
					<input type="hidden" name="cmd1" value="">
					<input type="hidden" name="province_id" value="'.$_SESSION['province_id'].'">
		<div align = "center">
		<div align = "center" style="height:400px; overflow:auto">
		<table width="1312" border="1" align="center" bgcolor="#99CCCC"  cellpadding="0" cellspacing="0" dir="rtl"  class="list"  >
  <tr>
    <td height="24" colspan="4" bordercolor="#000000" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر مورد نظر </div></td>
    <td height="24" colspan="3" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر فروخته شده </div></td>
    <td colspan="3" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر موجود در سردخانه </div></td>
    <td width="69" rowspan="2" bgcolor="#99CCCC"><span class="style1">وزن کارتن </span></td>
    <td colspan="3" bgcolor="#99CCCC"><div align="center" class="style1">تاریخ تولید </div></td>
    <td width="80" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">تولید کننده </div></td>
    <td width="71" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">کشور</div></td>
    <td width="67" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">زیر انبار </div></td>
    <td width="48" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">ردیف</div></td>
  </tr>
  <tr>
  <td width="106" bgcolor="#99CCCC">&nbsp;</td>
    <td width="106" bgcolor="#99CCCC"><div align="center" class="style1">وزن خالص </div></td>
    <td width="90" bgcolor="#99CCCC"><div align="center" class="style1">وزن ناخالص </div></td>
    <td width="71" bgcolor="#99CCCC"><div align="center">&nbsp</div></td>
    <td width="90" bgcolor="#99CCCC"><div align="center" class="style1">&nbsp</div></td>
    <td width="86" bgcolor="#99CCCC"><div align="center" class="style1">خالص</div></td>
    <td width="65" bgcolor="#99CCCC"><div align="center" class="style1">&nbsp</div></td>
    <td width="95" bgcolor="#99CCCC"><div align="center" class="style1">موجودی خالص </div></td>
    <td width="80" bgcolor="#99CCCC"><div align="center" class="style1">موجودی ناخالص </div></td>
    <td width="46" bgcolor="#99CCCC"><div align="center" class="style1">تعداد</div></td>
    <td width="44" bgcolor="#99CCCC"><div align="center" class="style1">روز</div></td>
    <td width="46" bgcolor="#99CCCC"><div align="center" class="style1">ماه</div></td>
    <td width="49" bgcolor="#99CCCC"><div align="center" class="style1">سال</div></td>
  </tr>
				</form>
	';
	   

//		print 	$queryp;
	
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
					p_code = '".$_SESSION['srchStr']."' 
				OR 
					p_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";		
	}
	$typeQ = '';
	
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because:3 ".
			mysql_error());	
	$genQuery = "
		
		 mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton From mojody_kala
          INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON mojody_kala.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	      WHERE mojody_kala.code_kala='". $row1['phd_pid'] ."' AND mojody_kala.code_ostan='". $row1['phd_id_province'] ."'  AND  mojody_kala.code_anbar='". $row2['l_code'] ."'  AND mojody_kala.year='1398' AND mojody_kala.deleted=0 
	     
	       and mojody_kala.id= 123654 $dad_anbar_id
					
		".$srchQ." 
		".$typeQ."
		
		 order by sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc ";	
	
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
			
	".$genQuery.$limitQ;
	//print($resQuery);
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
	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
	mysql_query("SET NAMES 'utf8'",$myconn);
	mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because:2 ".
	mysql_error());	
		$query22 = "
				 SELECT *  FROM dm_product product
					left join dm_price price
					on product.p_id=price.price_p_id  
			 
					WHERE 
						p_code = '". $row1['phd_pid'] ."'
					AND
					    p_price_code = '". $row1['phd_price_code'] ."' 
					    and
                  price_id_province=".$row1['phd_id_province']."";
				
//						print $query2;
						
			$lnk22 = mysql_query($query22);
			$row22= mysql_fetch_assoc($lnk22);		
				
			mysql_close() ;	
			
			
			if($row22['p_pakage_type']==8){
				//ghoti	
				$no=1;
			
				
			}else{
				
				$no=2;
			}
				
		$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
	mysql_query("SET NAMES 'utf8'",$myconn);
	mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because:1 ".
	mysql_error());			
				

 /*****ماه شمسی*****/
  $mahshamsiArr = array (
  0 =>'انتخاب کنيد',
  1 =>'فروردین',  
  2 =>'اردیبهشت',
  3 =>'خرداد',
  4 =>'تیر',
  5 =>'مرداد',
  6 =>'شهریور',
  7 =>'مهر',
  8 =>'آبان',
  9 =>'آذر',
  10 =>'دی',
  11 =>'بهمن',
  12 =>'اسفند'
  );
				
	$tedad_karton=mojodyMojazTedad($row['id'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);
    $mojody_khales=mojodyMojazKhales($row['id'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);				
	//fieldhaye feresttadani
	
    
		$dad_anbar_id=$row['id'];
		$dad_phd_id=$phd_id;
		$vaznkarton=$row['vazn_karton_this'];
	
		
			$queryanbar="SELECT * FROM dm_anbar_det WHERE dad_anbar_id=".$dad_anbar_id."
			
			              and  dad_phd_id=".$dad_phd_id."";
			
			
		    	$lnkanbar = mysql_query($queryanbar);
		    	$rowanbar=mysql_fetch_assoc($lnkanbar);
		
 //print $queryanbar;
    	if(mysql_num_rows($lnkanbar)>0){ 
			
	    		$Display2='none';
	    		$Display1='block';	    		
	    	}else{
	    	
	    	    $Display2='block';
	    		$Display1='none';		
	    		
	    	}
		
				$queryu="SELECT * FROM sell.dm_anbar_det WHERE dad_anbar_id=".$row['id']."  
			and dad_phd_id=".$phd_id."
			 ";
	//echo $queryu;		
				
             $lnku = mysql_query($queryu);
			$rowu = mysql_fetch_assoc($lnku); 
			
			
			if($no==1){
				$tedad1=$rowu['dad_tedad'];
				
				
			}else{
				
				$tedad1=$rowu['dad_vazn_kh'];
				
			}
				
			$outHtml .= '
				<tr>
				    <td>
				    <span id="ezaf_'.$dad_anbar_id.'"   style="cursor:pointer;display:block;"         onclick="ebtalAdetanbar(\'\', \''.$phd_id.'\', \''.$dad_anbar_id.'\', \''.$ebh_id.'\', \''.$his_id.'\', \''.$row22['p_pakage_type'].'\') " this.style.display=\'none\'"><img src="images/ok.png" border="0" align="center" style="height:20px;width=20px;"></img></span>
				   
				    </td>
				    <td>"'.$rowanbar['dad_vazn_kh'].'"</td>
				    <td>"'.$rowanbar['dad_vazn_n'].'"</td>
				    <td>&nbsp</td>
				    <td>&nbsp</td>   
				    <td><input name="dad_tedad_'.$dad_anbar_id.'"   style="width:100px;"  id="dad_tedad_'.$dad_anbar_id.'"  value="'.$tedad1.'"  type="text"  /></td>
				    <td>&nbsp</td>
				    <td>'.round($mojody_khales,3).'</td>
				    <td>'.round($mojody_nakhales,3).'</td>
				    <td>'.$tedad_karton.'</td>
				    <td>'.$row['vazn_karton_this'].'</td>
				    <td>'.$row['rouz_tolid_shamsi'].'</td>
				    <td>'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
				    <td>'.$row['sal_tolid_shamsi'].'</td>
				    <td>'.$row['name_tolidkonande'].'</td>
				    <td>'.$row['name_keshvar'].'</td>
				    <td>'.$row['name_ziranbar'].'</td>
				    <td>'.$inx.'</td>
				  
			  </tr>';
		}
			
		
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست.</td></tr>';
    }
    $outHtml .= '</table>';
    //$outHtml .= '</table></div><br><table align="center">'.getNavBar_prodanbar().' </div> '.getRPPCombo_prodanbar();
    echo $outHtml;
    
    
   //baraye jozeyat
if($row22['p_category']==7)
{
$outhtml='';
	$outhtml='
	<br>
	<br>
	<table id="hcss" align="center"  dir="rtl"   width=85% >
                 
                   
                    <tr> 
                         <td colspan="8" ><center><b> ضمیمه حواله</b></center></td>
                        
                    </tr>
                    
                    <tr> 
                         <td colspan="8" ><center>&nbsp;</center></td>
                        
                    </tr>
                    <tr >  
                     <td  width=15%><b>شماره حواله:</b></td>
				         <td  width=10%><b>'.$h_code.'</b></td>
                     <td  width=10%><b>شماره ابطال:</b></td>
				         <td  width=10%>'.$ebh_code.'</td>
                     </tr>
                     
                    <tr> 
                         <td colspan="8">&nbsp;&nbsp;&nbsp;</td>
                        
                    </tr>
                    </table><br><br>';
	$queryhava="SELECT * FROM sell.dm_havale WHERE h_phd_id=".$row1['phd_id']." 
			 ";
			//print $queryhava;					        
			$lnkhava = mysql_query($queryhava);
			$rowhava = mysql_fetch_assoc($lnkhava);

$querydad="SELECT * FROM sell.dm_ebtal_hdet WHERE deh_phd_id=".$row1['phd_id']."

and deh_amount !=0

"; 
			 
								        
			$lnkdad = mysql_query($querydad);
			//$rowdad = mysql_fetch_assoc($lnkdad);
			//$dad_anbar_id=$rowdad['dad_anbar_id'];
			//echo $querydad;
			$dad_anbar_id='';
			while($rowdad = mysql_fetch_assoc($lnkdad))
			{
				
				$dad_anbar_id .= ' or mojody_kala.id='.$rowdad['deh_anbar_id'].' ';
				
			}
						
		//echo 	$querydad;
		$query222="SELECT * FROM sell.dm_location_goods WHERE l_id=".$rowhava['h_l_code']."
										           ";
										
									//	print $querych;
										$lnk222 = mysql_query($query222);
										$row222 = mysql_fetch_assoc($lnk222);			
										$l_code= $row222['l_code'];	
			
				
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
			
	$queryanbar = "
		select 
		 mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton From mojody_kala
          INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON mojody_kala.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	      WHERE mojody_kala.code_kala='". $rowhava['h_p_code'] ."' AND mojody_kala.code_ostan='". $rowhava['h_id_province'] ."'  AND  mojody_kala.code_anbar='". $l_code ."'  AND mojody_kala.year='1397' AND mojody_kala.deleted=0
	      and mojody_kala.id= 123654 $dad_anbar_id
		 order by sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc ";

	
	$outhtml .='  <table width="763" border="1" align="center">
    <tr>
      <td width="115" rowspan="2"><div align="center">مقدار فروخته شده </div></td>
      <td width="100" rowspan="2"><div align="center">وزن کارتن </div></td>
      <td colspan="3"><div align="center">تاریخ تولید </div></td>
      <td width="97" rowspan="2"><div align="center">تولید کننده </div></td>
       <td width="97" rowspan="2"><div align="center">کشور </div></td>
      <td width="97" rowspan="2"><div align="center">زیر انبار </div></td>
      <td width="86" rowspan="2"><div align="center">ردیف</div></td>
    </tr>
    <tr>
      <td width="71">روز</td>
      <td width="63">ماه</td>
      <td width="82">سال</td>
    </tr>';
//echo $queryanbar;
$inx=1;
			$lnkanbar = mysql_query($queryanbar);
			while($rowanbar = mysql_fetch_assoc($lnkanbar))
			{
			
				
				$queryu="SELECT * FROM sell.dm_ebtal_hdet WHERE deh_anbar_id=".$rowanbar['id']."

and deh_amount !=0

"; 
			
		
	//echo $queryu;		
				
             $lnku = mysql_query($queryu);
			$rowu = mysql_fetch_assoc($lnku); 
//			if($rowu['dad_no']==8){
//				
//				$vazn_karton=$rowu['dad_tedad'];
//				
//			}else{
//				
//				$vazn_karton=$rowu['dad_vazn_kh'];
//			}
				
			$outhtml .=' <tr>
				      
						    <td>'.$rowu['deh_amount'].'</td>
						    <td>'.$rowanbar['vazn_karton_this'].'</td>
						    <td>'.$rowanbar['rouz_tolid_shamsi'].'</td>
						    <td>'.$mahshamsiArr[$rowanbar['mah_tolid_shamsi']].'</td>
						    <td>'.$rowanbar['sal_tolid_shamsi'].'</td>
						    <td>'.$rowanbar['name_tolidkonande'].'</td>
						    <td>'.$rowanbar['name_keshvar'].'</td>
						    <td>'.$rowanbar['name_ziranbar'].'</td>
			                 <td>'.$inx.'</td>
					    </tr>';
					    
        $inx++;    
			}

$outhtml .=' 
                    
                    <table>';
echo $outhtml;

} 
    
    
    

	
}
function ebtalHavale3(){
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');     
    $outHtml = ebtalHavaleFrm();	
	$h_code = isset($_REQUEST['h_code']) ? $_REQUEST['h_code'] : '';
	$reb_id = isset($_REQUEST['reb_id']) ? $_REQUEST['reb_id'] : '';
	
	$queryh = "
			  SELECT *  FROM dm_havale 
			 
				WHERE 
						h_code = '".$h_code."'
                AND
                        h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
												
				//print $query;
				$lnkh = mysql_query($queryh);
	            $rowh= mysql_fetch_assoc($lnkh);
	
	$query = "
			  SELECT *  FROM dm_his_havale 
			 
				WHERE 
						his_h_code = '".$h_code."'
                AND
                        his_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
						
										
				//print $query;
				$lnk = mysql_query($query);
				if(mysql_error()) print mysql_error();
				//$row= mysql_fetch_assoc($lnk);
				if(mysql_num_rows($lnk)>0){
					$rowebtt= mysql_fetch_assoc($lnk);
					echo '<span style="color:red;font-size:200%;vertical-align:middle;"><center>اين حواله قبلا   به مقدار  '.$rowebtt['his_eb_amount'].' کيلوگرم ابطال شده است</centetr></span>';
				    echo '<span style="color:green;font-size:100%;vertical-align:middle;"><center>شما مجاز هستید حداکثر مقدار  '.$rowh['h_mande_havale'].' ابطال نمایید</centetr></span>';
					
				}
$queryre = "
			  SELECT *  FROM dm_reason_eb 
			 
				WHERE 
						reb_id = '".$reb_id."' ";				
			//	print $query1;
				$lnkre = mysql_query($queryre);
				if(mysql_error()) print mysql_error();
				$rowre= mysql_fetch_assoc($lnkre);
	$queryh = "
		 	SELECT *  FROM dm_havale 
	 
			WHERE 
				 h_code = '".$h_code."'
		    AND
		         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		         
		    
		    ";
	//		print $query; 
	$lnkh = mysql_query($queryh);
	if(mysql_affected_rows()>0){
			$outHtml .= '<div> <table border="1" class="list" >';
							
				if(mysql_error()) print mysql_error();
				$havale= mysql_fetch_assoc($lnkh);
				$pf_code=$havale['h_pf_code'];
				
				$query1 = "
						  SELECT *  FROM dm_pish_factor 
						 
							WHERE 
									pf_code = '".$pf_code."' 
							AND
								  pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							 
							AND
		                           pf_type=". 0 ."
							";
			//	print $query1;
				$lnk1 = mysql_query($query1);
				if(mysql_error()) print mysql_error();
				$row1= mysql_fetch_assoc($lnk1);
				$ph_code=$row1['pf_ph_code'];
				$_SESSION['shomarePishHavale']=$ph_code;
			    //retrieve mainInfo pishhavale	
				$query = "
				 	SELECT *  FROM dm_pish_havale 
			 
					WHERE 
						ph_code = '".$ph_code."' 
					AND
				     	ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					
				";
			//	print $query;
//				$_SESSION['shPhforPf']=$ph_code;
				$lnk = mysql_query($query);
				sqlErr('wererewr');
	//			if(mysql_affected_rows()>0){
					
					$havaleMainInfo = mysql_fetch_assoc($lnk);	
					$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
//					$_SESSION['shPhforPf']=$havaleMainInfo['ph_id'];
//	if($havaleMainInfo['ph_customer_type']=='n'){
											$query = "
											 	SELECT *  FROM dm_customer 
										 
												WHERE 
													code_customer = '".$havale['h_customer_code']."'
                                                 AND
			                                       customer_code_org=".$province_code."";	
					
					    			$lnk = mysql_query($query);					    	
									sqlErr('for customer');
									$cusMainInfo = mysql_fetch_assoc($lnk);	
											$cusName=$cusMainInfo['name_customer'];
											$Type='معمولی';
//								
//							}else{
//								$query = "
//										 	SELECT *  FROM dm_customer_mot 
//									 
//											WHERE 
//												cm_customer_id = '".$havaleMainInfo['ph_customer_code']."' ";		
//													
//									$lnk = mysql_query($query);
//									sqlErr('for customer1');
//									$cusMainInfo = mysql_fetch_assoc($lnk);	
//											$cusName=$cusMainInfo['cm_name_customer'];
//											$Type='متفرقه';				
//						            	
//							}
					
					    $gdate=$havale['h_reg_date'];
						list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
						list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
						$jdate = $jyear."/".$jmonth."/".$jday;
						
					$outHtml .= '<br>
						<div>
						<tr class="rw1" style="font-weight:bold;">
						    <td>&nbsp;</td>
							<td >شماره حواله:'.$havale['h_code'].'</td><td colspan="2">تاریخ:'. $jdate.'</td>
				 		    <td colspan="2">پیش حواله به شماره : '.$havaleMainInfo['ph_code'].'</td><td colspan="2"> به نام :'.$cusName.'</td>
				 		    <td > به علت :'.$rowre['reb_reason'].'</td>
						</tr> 
						</div>';
					//retrieve detail of pishHavale
					
						$outHtml .= '
					<div>
							<tr class="rw0" style="font-weight:bold;">
								<td colspan=13 align=center>
								    <div>ريز پيش فاكتور</div>
								</td>
							</tr>
									<tr class="rw1" style="font-weight:bold;">
										<td align="center" width=3%>رديف</td>
										<td  align="center" width=10%>نام کالا</td>
										<td align="center" width=5%>كد كالا</td>										
										<td align="center" width=7%>كد محل تحويل</td>
										<td align="center" width=15%>نام محل تحويل</td>
										<td align="center" width=10%> تحويل گيرنده</td>
								        <td align="center" width=5%>كد قيمت</td>
										<td  width=5%> مقدار خريد </td>
										<td  width=5%>  &nbsp; </td>
									    
									</tr>
					</div>
						';
						$inx = 0;
						$queryh = "
									 	SELECT *  FROM dm_havale 
								 
										WHERE 
											 h_code = '".$h_code."'
									    AND
									         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
									    
									   ";
									//	print $queryh; 
								$lnkh = mysql_query($queryh);
					$h_id=$havale['h_id'];
					
						while($havale= mysql_fetch_assoc($lnkh)){
												
							$query2 = "
										 SELECT *  FROM dm_product product
											left join dm_price price
											on product.p_id=price.price_p_id  
									 
											WHERE 
												p_code = ".$havale['h_p_code']." 
											AND
											    p_price_code = ".$havale['h_price_code']." 
											    and
			                  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
										";
//						print $query2;
						
										$lnk2 = mysql_query($query2);
										$row2= mysql_fetch_assoc($lnk2);
										$query3 = "
										 	SELECT *  FROM dm_location_goods 
									 
											WHERE 
												l_id = ".$havale['h_l_code']." 
											AND 
												l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											
										";
					//	print $query3;
						
										$lnk3 = mysql_query($query3);
										$row3= mysql_fetch_assoc($lnk3);
							$inx++;
												
							$outHtml .= '
									<tr class="rw0">
										<td align="center">'.$inx.'</td>
										<td align="center">'.$row2['p_name'].'</td>
										<td align="center">'.$havale['h_p_code'].'</td>										
										<td align="center">'.$row3['l_code'].'</td>
										<td align="center">'.$row3['l_name'].'</td>
										<td align="center">'.$havale['h_deli_name'].'</td>									
										<td align="center">'.$havale['h_price_code'].'</td>
										<td align="center">'.$havale['h_amount'].'</td>';						
									$queryp="SELECT * FROM dm_province 
						                     WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
									    $lnkp=mysql_query($queryp);
									    print mysql_error();
									    $rowp=mysql_fetch_assoc($lnkp);
									    $provinceName=$rowp['province_name'];
					    $queryh = "
					 	SELECT *  FROM dm_havale 
				 
						WHERE 
							 h_code = '".$h_code."'
					    AND
					         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					   
					    ";
				//		print $query; 
				$lnkh = mysql_query($queryh);
	$h_id=$havale['h_id'];
		
		$havale= mysql_fetch_assoc($lnkh);
										$outHtml .= '																							
											      <td width=15%>
												         
												          <input type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=Ebtalafew_h&phd_id='.$havale['h_phd_id'].'&ph_id='.$ph_id.'&h_id='.$havale['h_id'].'&h_code='.$havale['h_code'].'&ph_code='.$ph_code.'&p_code='.$row2['p_code'].'&p_price_code='. $havale['h_price_code'].'&l_code='.$havale['h_l_code'].'&deli_name='.urlencode($havale['h_deli_name']).'&pre_amount='.$havale['h_mande_havale'].'&pre_amount1='.$havale['h_amount'].'&ebh_reb_id='.$reb_id.'","_parent") id="ebtal" value=" ابطال حواله" this.style.display=\'none\'"    class="button blue skew" style="font-size:10px; color:#FFFFFF" width=40%  >';
										if($_SESSION['dm_user_profile']['u_id']==3){
											
										//$outHtml .= '<input type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=Ebtalafew_ht&phd_id='.$havale['h_phd_id'].'&ph_id='.$ph_id.'&h_id='.$havale['h_id'].'&h_code='.$havale['h_code'].'&ph_code='.$ph_code.'&p_code='.$row2['p_code'].'&p_price_code='. $havale['h_price_code'].'&l_code='.$havale['h_l_code'].'&deli_name='.urlencode($havale['h_deli_name']).'&pre_amount='.$havale['h_amount'].'&ebh_reb_id='.$reb_id.'","_parent") id="ebtal" value="تغییر ابطال حواله" this.style.display=\'none\'"    class="button blue skew" style="font-size:10px; color:#FFFFFF" width=40%  ></td>';
											
										}
											      $outHtml .= '	 </td>
										         </tr> ';																						         				
						}
	//							<td colspan="4" align="center"><input type="button" value="ابطال حواله و ایجاد حواله جدید" onclick="Ebtal_createNewh(\'\', \''.$havale['h_code'].'\', \''.$havale['h_pf_code'].'\', \''.$ph_code.'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF"></td>
	//<tr>								   
										//    <td colspan="10" align="center"><input type="button" value="ابطال حواله بدون ایجاد حواله جدید"  onclick="EbtalHavaleNotNew(\'\', \''.$h_id.'\', \''.$havale['h_pf_code'].'\',\''.$ph_code.'\', \''.$reb_id.'\')"class="button blue skew" style="font-size:10px;width:20%; color:#FFFFFF"></td>									 
									//	</tr>
					
						$outHtml .= '	
																				                                                                                                                                              
										
										</table>
										<br><br>';
															
			$outHtml .= '</div >';
			$outHtml .='</table>';}
			else{
				$outHtml .='<div>شماره حواله نادرست است</div>';
			}
	return $outHtml;
		
}
function createNewH(){
	
	$h_code=$_REQUEST['h_code'];
    $pf_code=$_REQUEST['pf_code'];
   
    $query = "
		 	SELECT *  FROM dm_havale 
	 
			WHERE 
				h_code = ". $h_code ." 
			AND
				 h_status=". 0 ."
		     AND
		        h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		      AND
		         h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		"; 
//	print $query;
		$lnk = mysql_query($query);
		$row= mysql_fetch_assoc($lnk);
    	
//	print_r($_REQUEST);
	   $day_number = jdate('j');
       $month_number = jdate('n');
       $year_number = jdate('y');
       $day_name = jdate('l');
	    $jdate=$row['h_reg_date'];
		$jdate .= '/\/';
		list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
		$h_reg_date = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
       
  //  print $row['h_code'];
	$outHtml='<div><br>
	              <table  width=70% class="list"  >
	                 <tr class="rw1" style="font-weight:bold;height:40px;vertical-align:middle;" >
		                  <td colspan="2">شماره حواله جديد:'.$row['h_code'].'</td>
		                  <td colspan="7">تاریخ:'. $h_reg_date.'</td>	
		              </tr>';
	
	$query2 = "
		 	SELECT *  FROM dm_pish_factor 
	 
			WHERE 
				pf_code = ".$pf_code." 
			AND
			   pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			  AND
				pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
				AND
		  pf_type=". 0 ."
		";
		$lnk2 = mysql_query($query2);
	    $row2= mysql_fetch_assoc($lnk2);
//	print $query2;
	$query1 = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$row2['pf_ph_code']." 
			AND 
			   phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		   AND
	          phd_id_year=".$_SESSION['dm_user_profile']['u_year_id'].""; 
		
	    $ph_code=$row2['pf_ph_code'];
//print $query1;	    
		$lnk1 = mysql_query($query1);
		
		sqlErr('for Display pfactor6');
			$outHtml .= '
			
		
				<tr class="rw0"  style="font-weight:bold;">
					<td colspan=13 align=center>
					    <div>&nbsp;</div>
					</td>
				</tr>
						<tr class="rw1" style="font-weight:bold;">
							<td align="center" width=5%>رديف</td>
							<td align="center" width=20%>نام کالا</td>
							<td align="center" width=5%>كد كالا</td>
							
							<td align="center" width=10%>كد محل تحويل</td>
							<td align="center" width=20%>نام محل تحويل</td>
							<td align="center" width=15%>نام تحويل گيرنده</td>
						
							<td align="center" width=7%>كد قيمت</td>
							<td align="center" width=15%>مقدار</td>
							<td>&nbsp;</td>
							
						</tr>
			';
			$inx = 0;
			while($row= mysql_fetch_assoc($lnk1)){
					$queryL = "
					 	SELECT *  FROM dm_location_goods 
				 
						WHERE 
								l_code = ".$row['phd_l_id']." 
						AND 
						        l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	                    ";
					
					$lnkL = mysql_query($queryL);
					$rowL= mysql_fetch_assoc($lnkL);
				$query2 = "
						SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
						 
								WHERE 
										p_code = ".$row['phd_pid']." 
			                    AND
			                   p_price_code=".$row['phd_price_code']." 
			                   
			                   and
			           price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			                   
			                   ";
						
			
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				
				$inx++;
		        	if(($inx)%2==1)
				$class="rw0";
				else
				 $class="rw1";
				$outHtml.= '
						<tr class="'.$class.'">
							<td align="center">'.$inx.'</td>
							<td align="center">'.$row2['p_name'].'</td>
							<td align="center">'.$row2['p_code'].'</td>
							<td align="center">'.$row['phd_l_id'].'</td>
							<td align="center">'.$rowL['l_name'].'</td>
							<td align="center">'.$row['phd_deli_name'].'</td>							
							<td align="center">'.$row['phd_price_code'].'</td>
							<td align="center">'.$row['phd_amount'].'</td>';
				$query4 = "
					 	SELECT *  FROM dm_pish_havale 
				 
						WHERE 
							ph_code = ".$ph_code." 
						AND
						   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						   
						 AND
			             	ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						   ";
		
				$lnk4 = mysql_query($query4);
			    $havaleMainInfo= mysql_fetch_assoc($lnk4);
			    
				$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
					  $lnkprov = mysql_query($queryprov);
					  $rowprov= mysql_fetch_assoc($lnkprov);
					  
		    $province_code=$rowprov['province_code'];
			if($havaleMainInfo['ph_customer_type']=='n'){
								$query = "
								 	SELECT *  FROM dm_customer 
							 
									WHERE 
										code_customer = '".$havaleMainInfo['ph_customer_code']."' 
										AND
			                       customer_code_org=".$province_code."";		
						
		    			$lnk = mysql_query($query);
						sqlErr('for customer');
						$cusMainInfo = mysql_fetch_assoc($lnk);	
								$cusName=$cusMainInfo['name_customer'];
								$Type='معمولی';
					
				}else{
						$query = "
							 	SELECT *  FROM dm_customer_mot 
						 
								WHERE 
									cm_customer_id = '".$havaleMainInfo['ph_customer_code']."' ";		
										
						$lnk = mysql_query($query);
						sqlErr('for customer1');
						$cusMainInfo = mysql_fetch_assoc($lnk);	
								$cusName=$cusMainInfo['cm_name_customer'];
								$Type='متفرقه';				
			            	
				}

$queryp="SELECT * FROM dm_province 
     WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
    $lnkp=mysql_query($queryp);
    print mysql_error();
    $rowp=mysql_fetch_assoc($lnkp);
    $provinceName=$rowp['province_name'];
							$outHtml .= '
								         <td>
								          <button type="button" onclick=window.open("printHavale.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row['phd_price_code'].'&p_code='.$row['phd_pid'].'&l_id='.$row['phd_l_id'].'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
                                              چاپ اول      </button>
								         </td>
								         <td>
								          <button type="button" onclick=window.open("printHavale2.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row['phd_price_code'].'&p_code='.$row['phd_pid'].'&l_id='.$row['phd_l_id'].'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
                                              چاپ دوم      </button>
								         </td>
								         <td>
								          <button type="button" onclick=window.open("printHavale3.php?phd_id='.$row['phd_id'].'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row['phd_price_code'].'&p_code='.$row['phd_pid'].'&l_id='.$row['phd_l_id'].'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
                                              چاپ سوم      </button>
								         </td>
								         </tr> ';    
					
			
			}
			$outHtml .= '
					</table>';
								
			 
	echo $outHtml;
}	
function EbtalMessage(){
	
	$h_code=$_REQUEST['h_code'];
    $h_id=$_REQUEST['h_id'];
    $ebh_id=$_REQUEST['ebh_id'];
    $querye="SELECT * FROM dm_ebtal_h WHERE 
	            	 ebh_id=".$ebh_id; 
    
    
	$lnke = mysql_query($querye); 
	$rowe = mysql_fetch_assoc($lnke);
	$ebh_code=$rowe['ebh_code'];
    	if($h_id<1) die('Invalid  id!');
    
    $outHtml1 ='<br>
     <br>
     <div align="center"><a href="?pg=havaleMgmtPg&cmd=ebtalHavaleFrm"> <img src="images/back1.png"  title="بازگشت" ></img></a> </div>';
    
    echo $outHtml1;
    	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	
	$outHtml='<br><div><table  align="center" class="list">';
	
	$query = "
		 	SELECT *  FROM dm_havale
	 
			WHERE 
				h_id = ".$h_id." 			
		";
//	print $query;
	$lnk1 = mysql_query($query);
	$row1 = mysql_fetch_assoc($lnk1);
	$h_code=$row1['h_code'];
	$hDate=$row1['h_reg_date'];
	
	        $gdate=$row1['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			
			$query="select * from dm_pish_havale ph left join  dm_pish_factor pf
							on ph.ph_code=pf.pf_ph_code  left join dm_havale h 
							on h.h_pf_code=pf.pf_code
							where  pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
							and
							 pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
							 
							and h_id=".$h_id."
							AND
		                    pf_type=". 0 ."
							
							";

		$lnk = mysql_query($query);
		$row = mysql_fetch_assoc($lnk);
		$ph_code=$row['ph_code'];
		    $gdate=$row['ph_reg_date'];
	
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$row1['h_customer_code']."' 
								  AND
			                    customer_code_org=".$province_code."";
					
				
				$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
											
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;				
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$row['ph_code']." 
		 AND
	          phd_id_year=".$_SESSION['dm_user_profile']['u_year_id'].""; 
		$lnk = mysql_query($query);
		sqlErr('line1662');
		$gdate=$hDate;
	     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	     $hDate= $jyear."/".$jmonth."/".$jday;
		if(mysql_affected_rows()>0){
								$outHtml .= '
					<tr class="rw0">						
						<td colspan="12"><b>ابطال شماره:</b>'.$ebh_code.'</td>
			 		    
					</tr>
					<tr class="rw1">						
						<td colspan="2"><b>شماره حواله:</b>'.$h_code.'</td><td colspan="2"><b>تاريخ:</b>'. $hDate.'</td>
			 		    <td  colspan="2"><b> پيش حواله به شماره : </b>'.$ph_code.'</td><td colspan="6"><b> به نام :</b>'.$cusName.'</td>      
					</tr>'; 
														
					//retrieve detail of pishHavale
					$queryh = "
					 	SELECT *  FROM dm_havale 
				 
						WHERE 
							h_id = ".$h_id." 
					";
					$lnkh = mysql_query($queryh);
			//		print $query;
					sqlErr('for Display Havale');
					if(mysql_affected_rows()>0){
						$outHtml .= '
					
							    <tr class="rw0">
									<td colspan=12 align="center" style="font-weight:bold;font-size:20px;height: 50px;vertical-align:middle;">
									    <div>ريز حواله</div>
									</td>
							     </tr>
									<tr class="rw1" style="font-weight:bold;vertical-align:middle;">
										<td align="center">رديف</td>
										<td align="center">نام کالا</td>
										<td align="center">كد كالا</td>										
										<td align="center">كد محل تحويل</td>
										<td align="center">نام محل تحويل</td>
										<td align="center">نام تحويل گيرنده</td>
										<td align="center">كد قيمت</td>
										<td colspan="5">مقدار خريد</td>
									</tr>
					</div>
						';
						$inx = 0;
						while($rowh= mysql_fetch_assoc($lnkh)){
								$query = "select * from
					 	dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
				 
						WHERE 
							p_code = ".$rowh['h_p_code']." 
						ANd
						   p_price_code=".$rowh['h_price_code']."
						AND
						   price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ."
					";
//					print $query;		
							$ln = mysql_query($query);
						$prod= mysql_fetch_assoc($ln);
							$inx++;
						if(($inx)%2==1)
							$class="rw0";
							else
							 $class="rw1";
							 
				$queryL = "
					 	SELECT *  FROM dm_location_goods 
				 
						WHERE 
							l_id = ".$rowh['h_l_code']." 
						
						
					";
//					print $queryL;		
							$lnkL = mysql_query($queryL);
						    $Loc= mysql_fetch_assoc($lnkL);
							 
							$amount=formatMoney($rowh['h_amount']);
						    
							$outHtml .= '
									<tr class="'. $class.'" style="vertical-align:middle;">
										<td align="center" width=5%>'.$inx.'</td>
										<td align="center" width=15%>'.$prod['p_name'].'</td>
										<td align="center" width=10%>'.$rowh['h_p_code'].'</td>										
										<td align="center" width=10%> '.$Loc['l_code'].'</td>
										<td align="center" width=15%>'.$Loc['l_name'].'</td>
										<td align="center" width=15%>'.$rowh['h_deli_name'].'</td>										
										<td  align="center" width=10%>'.$rowh['h_price_code'].'</td>
										<td colspan="5" width=10%>'.$amount.'</td>';
						
               $queryp="SELECT * FROM dm_province 
	              WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
				    $lnkp=mysql_query($queryp);
				    print mysql_error();
				    $rowp=mysql_fetch_assoc($lnkp);
				    $provinceName=$rowp['province_name'];
							
										$outHtml .= '
														
											         <td style="background-color:'. $_SESSION['htablecolor'] .';">											         											          
											            <button type="button" onclick=window.open("ebtal.php?phd_id='.$row['phd_id'].'&customer_code='.$row1['h_customer_code'].'&ph_code='.$ph_code.'&ebh_code='.$ebh_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&price_code='.$row1['h_price_code'].'&p_code='.$row1['h_p_code'].'&l_id='.$row1['h_l_code'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$h_id.'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
											              چاپ ابطال حواله</button>
											         </td>
											         </tr>     
								';
							$totalprice =$row['h_price']+$totalprice;
							
						}
						$outHtml .= '																
							</table>';						
							
											
					}
			
			
	}
	echo $outHtml;	
   
}
function delebtali(){
	
		$phd_id=$_REQUEST['phd_id'];
	
	  $h_id=$_REQUEST['h_id'];
	
      $his_id=$_REQUEST['his_id'];	
      $h_code=$_REQUEST['h_code'];
      
      
     $query="SELECT * FROM dm_havale WHERE h_id=".$h_id."";
				$lnk = mysql_query($query);
				$row = mysql_fetch_assoc($lnk);	
				
				
				$queryupdate = "
								UPDATE dm_havale 
								SET 

									`h_amount` = ".$row['h_pre_amount'].",
									`h_price` = ".$row['h_price_pre']."					 
								WHERE 
									h_id = ".$h_id."";
									
							$lnkupdate = mysql_query($queryupdate);
						//print $queryupdate;
						if(mysql_error()) print mysql_error();	
						//print $queryupdate;
					$quer = "
								UPDATE dm_pish_havale_det 
								SET 

									`phd_amount` = ".$row['h_pre_amount'].",
									`phd_price` = ".$row['h_price_pre']."					 
								WHERE 
									phd_id = ".$phd_id."";
									
							$lnku = mysql_query($quer);
						//print $queryupdate;
						if(mysql_error()) print mysql_error();	
						//print $queryupdate;	
						$query = "
								DELETE FROM dm_his_havale
							 
									WHERE 
										his_id = ".$his_id." 
								";
								$lnk = mysql_query($query);
								if(mysql_error()) print mysql_error();
								//print $query;	
						$query1 = "
								DELETE FROM dm_ebtal_h
							 
									WHERE 
										ebh_h_id = ".$his_id." 
								";
								$lnk1 = mysql_query($query1);
								if(mysql_error()) print mysql_error();
								//print $query1;
						echo 'انجام شد';
	
}
function Ebtalafew_ht(){
	
	?>
	<script type="text/javascript" >
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
	function addAProd2BillCheck(){
				
	
          
			if(fObj('phd_amount').value==''){
				
				alert('لطفا مقدار را وارد کنيد');
				return;
			}
      if(fObj('phd_jari').value==''){
				
				alert('لطفا مقدار را وارد کنيد');
				return;
			}
			
		
//			addAProd2Bill();
	          EditAndEbtalCheckk();
			
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
		right: 300px;
		top: 550px;
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
	
	$phd_id=$_REQUEST['phd_id'];
	
	$h_id=$_REQUEST['h_id'];
	
    $his_id=$_REQUEST['his_id'];	
    $h_code=$_REQUEST['h_code'];	
	//$_SESSION['shomarePishHavale']=$ph_code;
	$query = "
			SELECT *  FROM dm_pish_factor 
				 
				WHERE 
						pf_ph_code = ".$ph_code." 
				AND     pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				AND
						pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
				AND
		  pf_type=". 0 ."
				";
					
						$lnk = mysql_query($query);
						$row= mysql_fetch_assoc($lnk);
		

   $queryl = "
			SELECT *  FROM dm_location_goods 
					 
				WHERE 
					 l_code = ".$l_code."
				AND
					 l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."			
								"; 
							
					$lnkl = mysql_query($queryl);
				$rowl= mysql_fetch_assoc($lnkl);	
				$query = "
						SELECT * FROM dm_pish_havale_det 
						
						   WHERE 
							phd_id = ".$phd_id." 
					";
//	print $query;
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);
	$phd_price=$row['phd_price'];
	$phd_id_unit=$row['phd_id_unit'];
	$phd_p_price=$row['phd_p_price'];
//	print	$phd_price;					
?>
			   	
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="addedprod"> 
		<input type="hidden" name="phd_id"            id="phd_id"                  value="<?php echo $phd_id ?>"> 
		<input type="hidden" name="h_id"              id="h_id"                    value="<?php echo $h_id ?>">  
		<input type="hidden" name="his_id"              id="his_id"                    value="<?php echo $his_id ?>">  
		<br></br>
		<br></br>
		<table   align="center" class="nasi" style="width:80%;margin-top:0px;">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		  	  
		      <td colspan="9"  style="height: 50px;vertical-align:middle;"  align="center" ><b> تغییر حواله ابطالی شماره <?php echo  $h_code ?></b></td>
	        </tr>
	        <tr>
	           <td colspan="9"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	    <!--    	<tr>
		       	<td width=10%;><center><b> کد کالاي مربوطه  :</b></center> </td>
		       	<td><input type="text"  id="p_code"  onkeypress="searchProd(event,<?php echo $_SESSION['dm_user_profile']['u_province_id']   ?>);"  value="<?php echo  $p_code   ?>"></input></td>
				<td ><b>کد قيمت</b> </td>
	            <td><input  id="p_price_combo"   value="<?php echo $p_price_code ?>"></input></td>		       
	         </tr>-->
	      	 <tr>
		         <td ><center><b><font color="red"> مقدار ابطالی :</font></b></center> </td>
		         <td><input name="phd_amount" id="phd_amount" type="text"  /></td> 		         
		         <td ><center><b><font color="red"> مقدار حواله جاری :</font></b></center> </td>
		         <td><input name="phd_jari" id="phd_jari" type="text"  /></td> 		                
		    </tr>
	       
	        <tr>
			    <td colspan="7"><hr></td>			             
		    </tr>	      	
	      	
	      
	        </table> 
	        
	      	<?php 
	      
	      	$display='1'; 
		//      	<td colspan="3"><input type="button" value="اضافه" onclick="addAProd2Bill()"><input type="submit" value="ثبت" ></td>
		      	?>
		   
		     		    <span ><button type="button" value="اضافه" onclick="addAProd2BillCheck()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >ثبت</button></span>      	
<!--		        <span ><button type="button" value="اضافه" onclick="addAProd2BillCheck()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >اضافه</button></span>-->
                            				      			      
<div id="addedProdsCntnr" style="direction: rtl;"></div>
 <br>
 <?php
	
	
	
}
function Ebtalafew_h(){
	
	?>
	<script type="text/javascript" >
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
	function addAProd2BillCheck(){
				
			if(fObj('p_code').value==''){
					
					alert('لطفا کد کالا را انتخاب کنيد');
					return;
				}
			if(fObj('p_price_combo').value==''){
				
				alert('لطفا کد قيمت را انتخاب کنيد');
				return;
			}
           if(fObj('LocationCombo').value==''){
				
				alert('لطفا کد محل را وارد کنيد ');
				return;
			}
			if(fObj('phd_amount').value==''){
				
				alert('لطفا مقدار را وارد کنيد');
				return;
			}
			if(fObj('phd_deli_name').value==''){
							
			    alert('لطفا نام تحويل گيرنده را وارد کنيد ');
					return;
						}
			if(fObj('phd_deli_name').value==''){
				
				alert('لطفا نام تحويل گيرنده را وارد کنيد ');
				return;
			}
//			addAProd2Bill();
	          EditAndEbtalCheck();
			
				}
	function searchProd(e,val) {
		if(e.keyCode==112){
		window.open( 'searchProd.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" );
		}
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
		right: 300px;
		top: 550px;
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
	$ph_code=$_REQUEST['ph_code'];
	$phd_id=$_REQUEST['phd_id'];
	$h_code=$_REQUEST['h_code'];
	$h_id=$_REQUEST['h_id'];
	$p_code=$_REQUEST['p_code'];	
    $p_price_code=$_REQUEST['p_price_code'];	
    $l_code=$_REQUEST['l_code'];	
    $deli_name=$_REQUEST['deli_name'];	
    //meghdar mande
    $pre_amount=$_REQUEST['pre_amount'];
    //meghdar pre
    $pre_amount1=$_REQUEST['pre_amount1'];
    $h_pre_date=$_REQUEST['h_pre_date'];
    $ebh_reb_id=$_REQUEST['ebh_reb_id'];	
	//$_SESSION['shomarePishHavale']=$ph_code;
	$query = "
			SELECT *  FROM dm_pish_factor 
				 
				WHERE 
						pf_ph_code = ".$ph_code." 
				AND     pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				AND
						pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
				AND
		  pf_type=". 0 ."
				";
					
						$lnk = mysql_query($query);
						$row= mysql_fetch_assoc($lnk);
		$queryph = "
			SELECT *  FROM dm_pish_havale
				 
				WHERE 
						ph_code = ".$ph_code." 
						
				AND    
				 ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				
				";
					
						$lnkph = mysql_query($queryph);
						$rowph= mysql_fetch_assoc($lnkph);

   $queryl = "
			SELECT *  FROM dm_location_goods 
					 
				WHERE 
					 l_code = ".$l_code."
				AND
					 l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."			
								"; 
							
					$lnkl = mysql_query($queryl);
				$rowl= mysql_fetch_assoc($lnkl);	
				$query = "
						SELECT * FROM dm_pish_havale_det 
						
						   WHERE 
							phd_id = ".$phd_id." 
					";
//	print $query;
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);
	$phd_price=$row['phd_price'];
	$phd_id_unit=$row['phd_id_unit'];
	$phd_p_price=$row['phd_p_price'];
//	print	$phd_price;					
?>
<input type="hidden" name="phm_id"           id="phm_id"                 value="<?php echo $rowph['ph_phm_id'] ?>">
			   	
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="addedprod"> 
		<input type="hidden" name="ph_code"           id="ph_code"                 value="<?php echo $ph_code ?>">
		<input type="hidden" name="phd_id"            id="phd_id"                  value="<?php echo $phd_id ?>"> 
		<input type="hidden" name="p_code_pre"        id="p_code_pre"              value="<?php echo $p_code ?>"> 	
		<input type="hidden" name="p_price_code_pre"  id="p_price_code_pre"        value="<?php echo $p_price_code ?>"> 		
		<input type="hidden" name="l_code_pre"        id="l_code_pre"              value="<?php echo $l_code ?>"> 		
		<input type="hidden" name="phd _amount_pre"   id="phd_amount_pre"          value="<?php echo $pre_amount1 ?>"> 
		<input type="hidden" name="phd_deli_name_pre" id="phd_deli_name_pre"       value="<?php echo $phd_deli_name ?>"> 
		<input type="hidden" name="phd_price_pre"     id="phd_price_pre"           value="<?php echo $phd_price ?>"> 
		<input type="hidden" name="phd_id_unit_pre"   id="phd_id_unit_pre"         value="<?php echo $phd_id_unit ?>"> 
		<input type="hidden" name="h_code"            id="h_code"                  value="<?php echo $h_code ?>"> 
		<input type="hidden" name="h_id"              id="h_id"                    value="<?php echo $h_id ?>">  
		<input type="hidden" name="h_pre_date"        id="h_pre_date"              value="<?php echo $h_pre_date ?>"> 
		<input type="hidden" name="ebh_reb_id"        id="ebh_reb_id"              value="<?php echo $ebh_reb_id ?>">
	   <input type="hidden" name="phd_p_price"        id="phd_p_price_pre"             value="<?php echo $phd_p_price ?>">				 
		<br></br>
		<br></br>
		<table   align="center" class="nasi" style="width:80%;margin-top:0px;">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		  	  
		      <td colspan="9"  style="height: 50px;vertical-align:middle;"  align="center" ><b> ريزكالاهاي قابل تحويل</b></td>
	        </tr>
	        <tr>
	           <td colspan="9"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	<tr>
		       	<td width=10%;><center><b> کد کالاي مربوطه  :</b></center> </td>
		       	<td><input type="text"  id="p_code"  onkeypress="searchProd(event,<?php echo $_SESSION['dm_user_profile']['u_province_id']   ?>);"  value="<?php echo  $p_code   ?>"></input></td>
				<td ><b>کد قيمت</b> </td>
	            <td><input  id="p_price_combo"   value="<?php echo $p_price_code ?>"></input></td>		       
	         </tr>
	      	 <tr>
		        <td ><center><b><font color="red"> مقدار ابطالی :</font></b></center> </td>
		        <td><input name="phd_amount" id="phd_amount" type="text" value="<?php echo $pre_amount ?>" onkeyup="isNumber(this)"/></td> 		         
		        <td ><center><b>واحد :</b></center> </td>
                <td>
			  		<?php echo getUnit_phTypesComboBox('phd_id_unit')?>
				</td>	       
		    </tr>
	       
	        <tr>
			    <td colspan="7"><hr></td>			             
		    </tr>	      	
	      	<tr>
	      	    <!--
	      	     <td >تحويل با </td>
	      	     <td><?php echo getDeliveryTypesComboBox('phd_deli_with')?></td>
		        
				 --><td width="20%" ><b>نام تحويل گيرنده: </b></td>
		         <td width="25%"><input name="phd_deli_name"  value="<?php echo $deli_name ?>" id="phd_deli_name" type="text"  /></td>
		         <td colspan="2">&nbsp;</td>
		         <td colspan="2">&nbsp;</td>
		          <td >&nbsp;</td>
	        </tr>
	        <tr>
	         
				 <td width="15%" align="right">&nbsp; </td>
		         <td width="15%" align="right">&nbsp; </td>
		         <td colspan="2">&nbsp;</td>
		         <td colspan="2">&nbsp;</td>
		          <td >&nbsp;</td>
	        </tr>
	      
	        </table> 
	        
	      	<?php 
	      
	      	$display='1'; 
		//      	<td colspan="3"><input type="button" value="اضافه" onclick="addAProd2Bill()"><input type="submit" value="ثبت" ></td>
		      	?>
		   
		     		    <span ><button type="button" value="اضافه" onclick="addAProd2BillCheck()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >ثبت</button></span>      	
<!--		        <span ><button type="button" value="اضافه" onclick="addAProd2BillCheck()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >اضافه</button></span>-->
                            				      			      
<div id="addedProdsCntnr" style="direction: rtl;"></div>
 <br>
 <?php
}

function dspPreFactorFrm()
{
	
$query = " SELECT *  FROM dm_pish_havale_det 			 
			 WHERE 
					phd_p_price = 0 
			 AND 
				phd_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'  ";	
						   								 	    					   
    			$lnk = mysql_query($query);
				if(mysql_num_rows($lnk)>0){
				
			while($row = mysql_fetch_assoc($lnk))
			{
				 $queryp="SELECT * FROM dm_product product
							left join dm_price price
						on product.p_id=price.price_p_id
						WHERE p_code=".$row['phd_pid']."
						 AND 
							    p_price_code=".$row['phd_price_code']."
						 AND
								  price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ." ";
							
					$lnkp = mysql_query($queryp);
					$rowp = mysql_fetch_assoc($lnkp);
					$phd_price=$rowp['p_sellprice'] * $row['phd_amount'];
					$phd_priceh=$rowp['p_sellpriceh'] * $row['phd_amount'];
					$query = "
							UPDATE dm_pish_havale_det 
							SET 
								`phd_price` = '".$phd_price."',
								`phd_p_price` = ".$rowp['p_sellprice'].", 
								`phd_priceh` = '".$phd_priceh."',
								`phd_p_priceh` = ".$rowp['p_sellpriceh']."  			 
								 			 					 
							WHERE 
								phd_id_province = ".$_SESSION['dm_user_profile']['u_province_id']." 
                             AND
							 
							     phd_id=".$row['phd_id']."";
	
						$lnk = mysql_query($query);
					
								
				}
				                          }
	
                  $day_number = jdate('j');
                   $month_number = jdate('n');
                   $year_number = jdate('y');
                   $day_name = jdate('l');
	               $selectedItem=1;
	               ?>
	    <body onLoad="document.f1.userid.focus()"> 
	 <table  align="center"  class="nasi" onload="FocusOnInput()">
	           <tr  style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">       	
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				     <td colspan="3" align="center"><b> صدور و يا تغيير پیش فاکتور </b> </td>
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				    <td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td><b> صدور و يا تغيير بر اساس </b><center><?php echo getpfcreateTypeRadioHtml($selectedItem)?></center></td>	
					<td>تاريخ:<?php echo $year_number?>/<?php echo $month_number ?>/<?php echo $day_number ?>&nbsp;</td>	
				</tr>	
				<tr id="pfcreateph" style="display: block;">
					<form method="post" action="" >
		              	<input type="hidden" name="pg"  value="PfactorMgmtPg" >   
		                <input type="hidden" name="cmd" value="dspPishFactor" >		                
		              	<td>&nbsp; <b> شماره پيش حواله :</b> </td>		              	
						<td><input name="ph_code" type="text"/></td>
					    <td colspan="3" align="center"><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px;width=20px; color:#FFFFFF" ></td>
				    </form>
				</tr>	
				<tr id="pfcreatepf" style="display:none;">
					<form method="post" action="" >
		              	<input type="hidden" name="pg" value="havaleMgmtPg">   
		              	<input type="hidden" name="cmd" value="dspPishHavale1">		            
		              	<td>: شماره پيش فاكتور </td>
					    <td><input name="pf_code" type="text"/></td>
					    <td colspan="3" align="center" ><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px; color:#FFFFFF" ></td>					    
				    </form>
				</tr>			 
  </table>
  </body>
  <?php 
	
}
function dspPishHavale1(){
	
	?>
	<script type="text/javascript" >
	function addDocument2PfCheck(ph_code){
		
		if(fObj('DocCombo').value==''){
			
			alert('لطفا کد سند را انتخاب کنيد');
			return;
		}
		
		if(fObj('dpf_sarresid').value==''){
			
			alert('لطفا تاریخ سررسيد را وارد کنيد');
			return;
		}
       if(fObj('dpf_price').value==''){
			
			alert('لطفا مبلغ را وارد کنيد');
			return;
		}
       addDocument2Pf();
    	}
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
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);	
	}
	function formReset()
	{
	document.getElementById("formpardakht").reset();
	}
	</script>
	
	<?php 
		
	$pf_code = isset($_REQUEST['pf_code']) ? $_REQUEST['pf_code'] : '';
	
	$queryp="SELECT * FROM dm_province 
        WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
		$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$provinceName=$rowp['province_name'];
		$province_code=$rowp['province_code'];
		
    $day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');    
	
	if($month_number<9){
	$month_number ='0'.$month_number;	
	}
	if($day_number<9){
	$day_number ='0'.$day_number;	
	}
	$query="SELECT *  FROM dm_pish_factor 
	          WHERE pf_code = ".$pf_code."
	          AND
	          pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	          AND
				pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
	          AND
		        pf_type=". 0 ."
		       ";
			$lnk=mysql_query($query);
		//	print $query;
			print mysql_error();
			$rowpf=mysql_fetch_assoc($lnk);
			$ph_code=$rowpf['pf_ph_code'];
			$gdate=$rowpf['pf_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
		?>	<input type="hidden"  id="ph_code" value="<?php echo $ph_code ?>" ></input> <?php 
			if(mysql_affected_rows()>0){
				
				  $queryph = "SELECT * FROM dm_pish_havale ph
				              left join dm_operation_acc opr
					 	      on ph.ph_operation_id=opr.g_id
				  			 WHERE 	
							   ph_code=".$ph_code."	  
						      AND
					            ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
	  
		        $lnkph = mysql_query($queryph);
		        $rowph=mysql_fetch_assoc($lnkph);
//customer information
          					
		if($rowph['ph_customer_type']=='n'){
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$rowph['ph_customer_code']."'

							AND
		                      customer_code_org=".$province_code."";	
			 	
    			$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولی';
			
		}else{
				$query = "
					 	SELECT *  FROM dm_customer_mot 
				 
						WHERE 
							cm_customer_id = '".$rowph['ph_customer_code']."' ";		
								
				$lnk = mysql_query($query);
				sqlErr('for customer1');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['cm_name_customer'];
						$Type='متفرقه';				
	            	}
			     $outHtml = dspPreFactorFrm();
				$outHtml .= '<br><table class="list" style="font-weight:bold;width:80%;" align="center">	            	
				          <tr class="rw1" style="font-weight:bold;height:30px;">
							<td colspan="3"> تاريخ پيش فاكتور:'. $jdate.'</td>
							<td colspan="6">پيش حواله به شماره : '.$rowph['ph_code'].'</td>
							</tr>';  	
						
						$outHtml .= '
							<tr class="rw0" style="font-weight:bold;">
							<td colspan="3"> شماره پيش فاكتور :'.$pf_code.'</td><td colspan="3"> به نام :'.$cusName.'</td>
							<td colspan="3"> نوع عمليات :'.$rowph['g_acc_name'].'</td>
							</tr>'; 	
						
				//retrieve detail of pishHavale
		$queryphd = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code."
			AND 
	        phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
	         AND
	          phd_id_year=".$_SESSION['dm_user_profile']['u_year_id'].""; 
			
		$lnkphd = mysql_query($queryphd);
		sqlErr('for Display pfactor');
	///	$rowphd= mysql_fetch_assoc($lnkphd);
		$p_code=$rowphd['phd_pid'];
		$p_price_code=$rowphd['phd_price_code'];
//		print $queryphd;
			$outHtml .= '
						<tr class="rw1">
					<td colspan=12 align=center>
					   ريز پيش فاكتور
					</td>
				   </tr>
						<tr class="rw0">
							<td align="center" width=5%>رديف</td>
							<td align="center" width=20%>نام کالا</td>
							<td align="center" width=15%>كد كالا</td>													
							<td align="center" width=15%>كد قيمت</td>
							<td align="center" width=20%>مقدار خريد</td>
						    <td align="center" width=15%>قيمت واحد </td>
						    <td align="center" width=15%>محل تحويل </td>
						    <td align="center" width=15%>هزينه اضافی هر واحد </td>
							<td width=15%>قيمت كالا </td>
							<td width="15%">&nbsp; </td>					      
						</tr>';
					
	$inx=0;				 
					while($rowphd=mysql_fetch_assoc($lnkphd)){
							
						$p_code=$rowphd['phd_pid'];
						    $p_price_code=$rowphd['phd_price_code'];					  						
							$query1 = "
								 	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id  
							 
									WHERE 
										p_code = ".$p_code."
									AND 
									    p_price_code=".$p_price_code." 
									    AND 
									    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								";
//	print $query1;				
						$lnk1 = mysql_query($query1);
						sqlErr('for Display pfactor');
						$row1= mysql_fetch_assoc($lnk1);
	$querych = "SELECT *  FROM dm_product product
						left join dm_price price
						on product.p_id=price.price_p_id 
					    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
							WHERE 
								p_code = ".$p_code." 
							AND
								p_price_code=".$p_price_code."
							AND
								price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					//	print $querych;		
			$lnkch = mysql_query($querych);
		   sqlErr('for Display charge');
		 
      $hazine=$rowphd['phd_p_add'];
	  	
	$queryl = "SELECT *  FROM dm_location_goods
						
							WHERE 
								l_id = ".$rowphd['phd_l_id']." 
							
							AND
							   l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					//	print $querych;		
			$lnkl = mysql_query($queryl);
			$rowl= mysql_fetch_assoc($lnkl);
								$inx++;
								if(($inx)%2==1)
								$class="rw1";
							else
								 $class="rw0";
								 
								$phd_price=formatMoney($rowphd['phd_price']);
								$amount=formatMoney($rowphd['phd_amount']);
								$phd_priceh=formatMoney($rowphd['phd_priceh']);
								
								$outHtml .= '
										<tr class="'.$class.'">
  										    <td align="center">'.$inx.'</td>
											<td align="center">'.$row1['p_name'].'</td>
											<td align="center">'.$row1['p_code'].'</td>								
											<td align="center">'.$rowphd['phd_price_code'].'</td>
											<td align="center">'.$amount.'</td>															
											<td align="center">'.$row1['p_sellprice'].'</td>
											<td align="center">'.$rowl['l_name'].'</td>
											<td align="center">'.$hazine.'</td>
											 <td align="center">ريال'.$phd_priceh.'</td>';
							if($rowphd['phd_status']==1){
								 $sanad=1;}
////mikhad check kone aya mitone etelaate asnado pak kone ya na								
//								         $outHtml .= '<td align="center">ثبت شده </td>';
//							}else{
//										 $outHtml .= '<td align="center"><button type="button" value="ثبت و ايجاد حواله " onclick="addNewHavale(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$rowphd['phd_price'].'\', \''.$rowphd['phd_id'].'\', \''.$havaleMainInfo['ph_customer_code'].'\')"  class="button blue skew" style="font-size:10px; color:#FFFFFF" style="width:20px;">ثبت و ايجاد حواله</button></td>';}				
					
								$totalprice =$totalprice+$rowphd['phd_priceh'];
							}
							$totalprice=formatMoney($totalprice);
						
							$outHtml .= '
											<tr>
												<td colspan="4"> جمع کل:'.$totalprice.'</td>																																
											</tr>
											<tr>
										';										                            
			$outHtml .= '</tr></table>';
									
			 $outHtml .= '
	     <table   align="center" class="list" width=80% style="font-weight:bold;width:80%;" align="center">
	         <tr class="rw1">
	             <td colspan="15" align="center"> اطلاعات اسنادي که قبلا وارد شده </td>
	         </tr>
		
			';
			$query = "
		 	SELECT *  FROM dm_pf_document 
	 
			WHERE 
				dpf_pf_code = ".$pf_code."  AND dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		";
			$lnk = mysql_query($query);
	//print $query;	
		if(mysql_error()) print mysql_error();
		if($doc=mysql_affected_rows()>0){
			
			$outHtml .= ' <tr class="rw0">
			                 <td align="center">رديف</td>
			                 <td align="center">كد سند</td>
			                 <td align="center">نام سند</td>
			                 <td align="center">نام بانك</td>
			                 <td align="center">تاریخ سررسيد</td>
			                 <td align="center">مقدار</td>
			                 <td align="center">حذف</td>
			             </tr>
			             ';
			$inx=0;
			$jdpf_price=0;	 
			while($doc= mysql_fetch_assoc($lnk)){
						global $d_documentTypes;
			            global $d_bankTypes;
						
						$query1 = "
								 	SELECT *  FROM dm_documentk 
							 
									WHERE 
										d_id = ".$doc['dpf_d_id']." 
								";
						$lnk1 = mysql_query($query1);
					    $doc1 = mysql_fetch_assoc($lnk1);
					   // print $query1;
					      $querybank = "
				 	SELECT *  FROM dm_doc_det_b
			 
					WHERE 
						doc_b_id = ".$doc['dpf_bank']." 
				";
		$lnkbank = mysql_query($querybank);
	    $bank = mysql_fetch_assoc($lnkbank);
					    
		//            print $querybank;
			 $query11 = "	SELECT *  FROM dm_doc_p
			 
					WHERE 
						docp_id = ".$doc1['d_pardakht_t']." 
				";
		$lnk11 = mysql_query($query11);
	    $doc11 = mysql_fetch_assoc($lnk11);		
					
		                $dpf_price=formatMoney($doc['dpf_price']);
					$inx++;
						 
					   if(($inx)%2==1)
						$class="rw1";
						else
						 $class="rw0";
						 
					$outHtml .='<tr class="'.$class.'" id="Dcntr_'.$doc['dpf_id'].'">
									  <td align="center">'.$inx.'</td>
									  <td align="center">'.$doc1['d_code'].'</td>
									  <td  >'.$doc11['docp_name'].'</td>
							          <td  >'.$bank['doc_b_name'].'</td>
									  <td align="center">'.$doc['dpf_sarresid'].'</td>
									  <td align="center">'.$dpf_price.'</td>';
					$jdpf_price=$jdpf_price+$doc['dpf_price'];
			      if($sanad==1){ $outHtml .='<td>نداریم</td></tr>';}
			else{
				
							  $outHtml .='<td><span style="cursor:pointer;color:red;size=20%;" onclick="delADocFromBill(\'\', \''.$doc['dpf_id'].'\')" ><img src="images/delete.PNG" width="20" height="20" title="حذف"  ></img></span></td>
						</tr>';}
					$outHtml .='<tr class="'.$class.'" ><td colspan="5">&nbsp;</td><td align="center"> جمع کل :'.$jdpf_price.'<td></tr>';			  
							  
			}
					$outHtml .='</table>';
					
					
												
		}else{
			$outHtml .='<tr class="rw1"><td align="center" style="color:red;">اطلاعات اسناد وارد نشده است</td></tr></table>';
		}	
		
		global $d_documentTypes;
		   $outHtml .= '
				 			
							<form method="post" action=""  id="formpardakht>
				   	
							<input type="hidden" name="pg" value="havaleMgmtPg">   
							<input type="hidden" name="cmd" value="addNewHavale()"> 
							<table    align="center" class="nasi">
							<tr style="background-color:'. $_SESSION['htablecolor']  .';" border="1">
						        <td colspan="10"  style="height: 50px;vertical-align:middle;"  ><font size="5">اطلاعات پرداخت پيش فاكتور</font></td>
	                       </tr>
	                        <tr>
	                             <td colspan="8"><hr style="color:'. $_SESSION['htablecolor']  .';height:40%;"></hr></td>
	                       </tr> 
					       <div id="pardakht" >';
						     $outHtml .= '<td ><center><b> کد سند: </b></center> </td>
							  	<td>'. getDocCombo().'</td>
								
								<td><b> &nbsp; </b></td>
						        <td>&nbsp; </td>				
					        </tr>
					      	<tr>
						        <td ><center> شماره فیش: </center> </td>
						        <td><input name="dpf_num" id="dpf_num" type="text"/></td>
						        <td ><center>نام بانک :</center> </td>
				              <td>

						  		'.getbankTypesComboBox1('dpf_bank').'
							</td> 
				                       
					        </tr>
					        <tr>
<!--					        <td ><center>نوع :</center> </td>
					        <td>'.getTypesatf('dpf_type').'</td>  -->
						       
						         <td ><center>نام شعبه :</center> </td>
						        <td><input name="dpf_branch" id="dpf_branch" type="text"/></td>	
						       
					        </tr>
					      	<tr>
					      	 <td align="center">
			                         تاريخ سررسيد <font color="red">  (مانند:92/01/01)</font></td>
						        <td><input name="dpf_sarresid" value="' .  $year_number.'/'.$month_number.'/'.$day_number.'" id="dpf_sarresid" type="text"  /></td>  
						        <td ><center>مبلغ: </center> </td>
						         <td><input name="dpf_price" id="dpf_price" type="text"  onBlur="this.value=formatCurrency(this.value);" /></td> 
						        
						    </tr> 
						     <tr>
						     <tr>
						    <td>استان فی ما بین</td>
						     <td>'.getProvincesanad('dpf_prov_sanad').'</td>
						    
						    
						    </tr>
						    <tr>
	                             <td colspan="8"><hr style="color:'. $_SESSION['htablecolor']  .';height:40%;"></hr></td>
	                       </tr>
	                       </table>		    <div>
						        
						    <div align="center">
						        
							   	<span><button type="button" value="اضافه كردن سند" onclick="addDocument2PfCheck('.$ph_code.')" class="button blue skew" style="font-size:10px; color:#FFFFFF">اضافه كردن سند</button></span>
					            <span> <button type="button" onclick=window.open("PrintPf.php?pf_code='.$pf_code.'&ph_code='.$ph_code.'&h_code='.$h_code.'&f_code='.$f_code.'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($row5['name_customer']).'&province_id='.$_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.$_SESSION['dm_user_profile']['u_year_id'] .'","_blank") value=" چاپ پيش فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ پيش فاكتور</button></span> 
					            <span> <button type="button" value="ثبت و ايجاد حواله "   onclick="addednewhavalekoli(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$rowphd['phd_price'].'\',\''.$rowphd['phd_id'].'\', \''.urlencode($havaleMainInfo['ph_customer_code']).'\')"  class="button blue skew"  style="font-size:10px; color:#FFFFFF;" >ثبت و ايجاد حواله</button></span>
					            <span> <input type="button" onclick="formReset()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:20%;" value="پاك كردن صفحه" /></span> 
					            
					         </div>   			   					    				    
					</form>
					<br>
				 </div>
				 <div id="addedDocCntnr" style="direction: rtl;"></div>';
		           	
			}else{
				
				$outHtml =dspPreFactorFrm().'شماره پیش فاکتور اشتباه است';
			}
	echo $outHtml;
		
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

function getDocCombo($id='DocCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlDocComboChng(\'\', this.value)" ><option value="" style="width:80px;" >........</option>';
	$lnk = mysql_query("SELECT * FROM  dm_documentk   where 1 ");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['d_id'].'"  >'.$row['d_code'].'</option>';
		}
	}
	$out .= '</select>';
	return $out;
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
	$out .= '</select>';
	return $out;
}
function EditHavaleFrm(){
	$out='	<body onLoad="document.f1.ph_code.focus()">
   <form method="post" action="" name=f1 >
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="EditHavale">
		
	<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
		 <tr style="background-color:'. $_SESSION['htablecolor'] .';">
				     <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">تغییر  حواله</font></b></td>
		 </tr>
		 <tr>
			    <td>&nbsp;</td>
		     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >شماره  حواله :</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="h_code" type="text"  / ></td>		        
		 </tr>
		 <tr>
			    <td>&nbsp;</td>
		     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >نام تحويل گيرنده:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="h_deli_name" type="text"  / ></td>		        
		 </tr>
		 <tr>
			     <td colspan="2"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;</td>			          
		</tr>
		</form>
</table>
</body>
';
	
return $out;
	
	
	
}
function EditPishHavaleFrm(){
	
$out='	<body onLoad="document.f1.ph_code.focus()">
   <form method="post" action="" name=f1 >
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="EditPishHavale">
		
	<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
		 <tr style="background-color:'. $_SESSION['htablecolor'] .';">
				     <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">تغییر پیش حواله</font></b></td>
		 </tr>
		 <tr>
			    <td>&nbsp;</td>
		     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >شماره  پیش حواله مورد نظر را وارد كنيد:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="ph_code" type="text"  / ></td>		        
		 </tr>
		 <tr>
			     <td colspan="2"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;</td>			          
		</tr>
		</form>
</table>
</body>
';
	
return $out;	
	
}

function EditHavale(){
	
	$h_code = isset($_REQUEST['h_code']) ? $_REQUEST['h_code'] : '';
	$h_deli_name = isset($_REQUEST['h_deli_name']) ? $_REQUEST['h_deli_name'] : '';
	$query = "
		 	SELECT *  FROM dm_havale h
		 	 left join dm_pish_factor pf on h.h_pf_code=pf.pf_code
		 	 left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code
	         left join dm_pish_havale_det phd on phd.phd_ph_code=ph.ph_code and phd.phd_id=h.h_phd_id
			WHERE 
				
			    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
		     AND
		        phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		     AND
		        h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		     AND
		       pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		     AND
			     h_code=".$h_code." 
             
			     
			     ";
			    
			   		//print $query;
			   		
				$lnk = mysql_query($query);
				$row= mysql_fetch_assoc($lnk);
				sqlErr('for Display edit ph');
				if(mysql_affected_rows()>0){
				
				$query2 = "
						UPDATE dm_pish_havale_det  
						SET 
							`phd_deli_name` = '". $h_deli_name ."'
															 
						WHERE 
							  
							 phd_id=".$row['phd_id']."";
							
					$lnk2 = mysql_query($query2);
					if(mysql_error()) print mysql_error();
					//print $query2;
                             
                               $query3 = "
						UPDATE dm_havale  
						SET 
							`h_deli_name` = '". $h_deli_name ."'
															 
						WHERE 
							  
							 h_id=".$row['h_id']."";
							
					$lnk3 = mysql_query($query3);
					if(mysql_error()) print mysql_error();
					//print $query3;
                               
							
						}
									
	
	
}
function EditPishHavale(){
	
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	
	$query = "
		 	SELECT *  FROM dm_pish_havale
	 
			WHERE 
				ph_code = ".$ph_code."
			AND 
			    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
		    AND
			     ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";
		
				
						$lnk = mysql_query($query);
						sqlErr('for Display edit ph');
						if(mysql_affected_rows()>0){
						$row= mysql_fetch_assoc($lnk);
						
						$query1 = "
							 	SELECT *  FROM dm_pish_havale_det
						 
								WHERE 
								phd_ph_code = ".$ph_code."
								AND 
								    phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
							    
							";
//						print $query1;
						    $gdate=$row['cm_req_date'];	
						    list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
					        list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
					         $cm_req_date = $jyear."/".$jmonth."/".$jday;  
									
								$lnk1 = mysql_query($query1);
								
								sqlErr('for Display edit phd');
								if(mysql_affected_rows()>0){
									
									
						$queryphd = "
							 	SELECT *  FROM dm_pish_havale_det
						 
								WHERE 
								phd_ph_code = ".$ph_code."
								AND 
								    phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
							    
							";
						$lnkphd = mysql_query($queryphd);
						$rowphd= mysql_fetch_assoc($lnkphd);
						$querycus = "
							 	SELECT *  FROM dm_customer
						 
								WHERE 
								code_customer = ".$row['ph_customer_code']."
								AND 
								    customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']." 
							    
							";
						$lnkcus = mysql_query($querycus);
						$rowcus= mysql_fetch_assoc($lnkcus);
						$date = explode('/', $cm_req_date);
                        $cm_req_date=$date[2].'/'.$date[1].'/'.$date[0] ;
									$inx=0;
									$outHtml = '<div align="center"> <table  border="1" class="list" style="width:80%;">
												<tr class="rw1" style="height:30px;vertical-align:middle;font-weight:bold;"> 								                 
											          <td colspan="2"> پيش حواله : '.$ph_code.'</td>
											          <td colspan="2"> مشتری : '.$row['ph_customer_code'].'/'.$rowcus['name_customer'].'</td>
											          <td > شماره درخواست: '.$row['cm_req_num'].'</td>
											          <td > تاریخ  درخواست: '.$cm_req_date.'</td>
											          <td > شماره مجوز: '.$row['ph_mojavez'].'</td>';
									               
					                       if($rowphd['phd_status']==1)
					                       {
												     $query='select *	
														 	           from dm_um_rel t
																	     inner join dm_listmenu l on l.menu_id = t.um_menu_id
																	where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
																	      l.menu_code = \'200001\' ';
														  $lnk = mysql_query($query);
													//	  print $query;
														  if ( mysql_num_rows($lnk)>0 ){
											              $outHtml .= ' <td><span style="cursor:pointer;"><a href="?pg=havaleMgmtPg&cmd=editmasterphFrm&ph_code='.$ph_code.'&cm_req_num='.$row['cm_req_num'].'&cm_req_date='.$cm_req_date.'&ph_customer_code='.$row['ph_customer_code'].'&ph_mojavez='.$row['ph_mojavez'].'"><img src="images/edit.png" width="20" height="20" title="    ویرایش"  ></img></a></span>';
													   				  }else{
											     	
											     	
										        $outHtml .= ' <td><span style="cursor:pointer;"><img src="images/edit.png" width="40" height="20" title="ویرایش نداریم"  ></img></span></td>';}
											     } else{
										        
										        $outHtml .= ' <td><span style="cursor:pointer;"><a href="?pg=havaleMgmtPg&cmd=editmasterphFrm&ph_code='.$ph_code.'&cm_req_num='.$row['cm_req_num'].'&cm_req_date='.$cm_req_date.'&ph_customer_code='.$row['ph_customer_code'].'&ph_mojavez='.$row['ph_mojavez'].'"><img src="images/edit.png" width="20" height="20" title="    ویرایش"  ></img></a></span>';
										               }
										       
										        
										          $outHtml .= '</tr></table>';
								   $outHtml .=' <table  border="1" class="list" style="width:80%;">
									              <tr class="rw0">
											        <td colspan=13 align=center style="height:30px;vertical-align:middle;font-weight:bold;">  ريز پيش حواله</td>													
											      </tr>
												  <tr class="rw1" style="height:30px;vertical-align:middle;font-weight:bold;">
													<td align="center"  width=5%>رديف</td>									
													<td align="center" width=10%>كد كالا</td>													
													<td align="center" width=10%>كد قيمت</td>
													<td align="center" width=20%>مقدار خريد</td>
												    <td align="center" width=5%>واحد</td>
												    <td align="center" width=5%>کد محل تحویل </td>
												    <td align="center" width=20%>نام تحویل گیرنده </td>	
												    <td align="center" colspan="3">&nbsp; </td>	 
												    
												  </tr>';
											
									while($row1= mysql_fetch_assoc($lnk1)){
										$inx++;
										if(($inx)%2==1)
										$class="rw1";
										else
										 $class="rw0";
										 $queryunit = "
											 	SELECT *  FROM dm_prod_det_u
										 
												WHERE 
													unit_prod_id = ".$row1['phd_id_unit']."";											
													
													$lnkunit = mysql_query($queryunit);
													sqlErr('for Display unit');
				                                    $rowunit= mysql_fetch_assoc($lnkunit);

				                  $queryLOC = "
											 	SELECT *  FROM dm_location_goods
										 
												WHERE 
													l_id = ".$row1['phd_l_id']."";											
													
													$lnkLOC = mysql_query($queryLOC );
													sqlErr('for dm_location_goods');
				                                    $loc= mysql_fetch_assoc($lnkLOC);                  
				                                    
							$outHtml .= '
						      <tr class="'.$class.'" id="phd_'.$row1['phd_id'].'">
							        <td align="center">'.$inx.'</td>
							        <td align="center">'.$row1['phd_pid'].'</td>
							        <td align="center">'.$row1['phd_price_code'].'</td>
							        <td align="center">'.$row1['phd_amount'].'</td>
							        <td align="center">'.$rowunit['unit_prod_name'].'</td>
							        <td align="center">'.$loc['l_code'].'</td>
							        <td align="center">'.$row1['phd_deli_name'].'</td>';
							if($row1['phd_status']==1){
								 if (($_SESSION['dm_user_profile']['u_id']==3)){
								 	
								 	
								 	 $outHtml .= '<td align="center"><span  style="cursor:pointer;"   onclick="Deletephd(\'\', \''.$row1['phd_id'].'\') " this.style.display=\'none\'"><img src="images/delete.PNG" border="0" align="center" style="height:20px;width=20px;" title="حذف"></img></span></td>';
								
						                   	  $outHtml .= ' <td align="center"><span   style="cursor:pointer;"    onclick=window.open("?pg=havaleMgmtPg&cmd=Editphprod&phd_id='.$row1['phd_id'].'&ph_id='.$row['ph_id'].'&ph_code='.$ph_code.'&p_code='.$row1['phd_pid'].'&p_price_code='. $row1['phd_price_code'].'&l_code='.$loc['l_code'].'&deli_name='.urlencode($row1['phd_deli_name']).'&phd_amount='.$row1['phd_amount'].'","_self") " this.style.display=\'none\'"><img src="images/edit.png" border="0" align="center" style="height:20px;width=20px;" title="ویرایش"></img></span></td>';
						                   	  	if(($row1['phd_pid']==50) or ($row1['phd_pid']==51) or ($row1['phd_pid']==2)){
								
										}else{
											
											if(($row1['phd_pid']==50) or ($row1['phd_pid']==51) or ($row1['phd_pid']==2) ){
												
											}else{
						                   	  $outHtml .= ' <td align="center"><a href="adddetprod.php?phd_id='.$row1['phd_id'].'" target="_blank">جزییات انبار  </a></td>';}
										}
								}else{
								 

									
							$outHtml .= '<td align="center"><span   style="cursor:pointer;"    this.style.display=\'none\'"><img src="images/delete.PNG" border="0" align="center" style="height:20px;width=20px;" title="حذف"></img></span></td>';


										$outHtml .= ' <td align="center"><span   style="cursor:pointer;"    this.style.display=\'none\'"><img src="images/edit.png" border="0" align="center" style="height:20px;width=20px;" title="ويرايش"></img></span></td>';
											
							                    $outHtml .= ' <td align="center"><span   style="cursor:pointer;"    this.style.display=\'none\'"><img src="images/edit.jpg" border="0" align="center" style="height:20px;width=20px;" title="ويرايش"></img></span></td>';
							                   
								 
							                   }
								 
							       
									}else{
//													$query2='select *
//												from dm_um_rel t
//												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
//												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
//												      l.menu_code = \'3311\' and t.um_can_delete=1';
//								                    $lnk2 = mysql_query($query2);
//								                    $row2 = mysql_fetch_assoc($lnk2);
//								                    if(mysql_num_rows($lnk2)==0){
									 	    $outHtml .= '<td align="center"><span  style="cursor:pointer;"   onclick="Deletephd(\'\', \''.$row1['phd_id'].'\') " this.style.display=\'none\'"><img src="images/delete.PNG" border="0" align="center" style="height:20px;width=20px;" title="حذف"></img></span></td>';
								
						                   	  $outHtml .= ' <td align="center"><span   style="cursor:pointer;"    onclick=window.open("?pg=havaleMgmtPg&cmd=Editphprod&phd_id='.$row1['phd_id'].'&ph_id='.$row['ph_id'].'&ph_code='.$ph_code.'&p_code='.$row1['phd_pid'].'&p_price_code='. $row1['phd_price_code'].'&l_code='.$loc['l_code'].'&deli_name='.urlencode($row1['phd_deli_name']).'&phd_amount='.$row1['phd_amount'].'","_self") " this.style.display=\'none\'"><img src="images/edit.png" border="0" align="center" style="height:20px;width=20px;" title="ویرایش"></img></span></td>';
						                   	  
						                   	  if(($row1['phd_pid']==50) or ($row1['phd_pid']==51) or ($row1['phd_pid']==2) ){
						                   	  	
						                   	  }else{
						                   	  $outHtml .= ' <td align="center"><a href="adddetprod.php?phd_id='.$row1['phd_id'].'" target="_blank">جزییات انبار  </a></td>';
						                   	  }
							
							          }
							         
							        $outHtml .= ' 
											       
											      </tr>';
							         								
									}
									$outHtml .= '</table>
								                     <div><input type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=createNewProd&ph_code='.$ph_code.'","_self") value=" ايجاد كالاي جديد"  class="button blue skew" style="font-size:10px; color:#FFFFFF;width:100px;"   >
													 <input type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=editnewopr&ph_code='.$ph_code.'","_self") value=" تغيير كد عمليات"  class="button blue skew" style="font-size:10px; color:#FFFFFF;width:100px;"   ></div>';
									
								echo $outHtml;
								}else{
								echo 'کالایی برای این پیش حواله ایجاد نشده است
								                    <div><input type="button" onclick=window.open("?pg=havaleMgmtPg&cmd=createNewProd&ph_code='.$ph_code.'","_self") value=" ايجاد كالاي جديد"  class="button blue skew" style="font-size:10px; color:#FFFFFF;width:100px;"   ></div>';
																}
								
								}else{
									echo 'چنین پیش حواله ای وجود ندارد   ';
								}
	

	
}
function editmasterphFrm(){
	?>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#cm_req_date1").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	
	  function validatecusAndSave(){
			
			if(fObj('ph_customer_code').value==''){
				
				alert('لطفا کد مشتری را انتخاب کنید');
				return;
			}
		if(fObj('cm_req_num').value==''){
				
				alert('لطفا شماره درخواست را انتخاب کنید');
				return;
			}
			 if(fObj('cm_req_date1').value==''){
				
				alert('لطفا تاریخ درخواست را انتخاب کنید');
				return;
			}
			 if(fObj('ph_mojavez').value==''){
					
					alert('لطفا شماره مجوز را انتخاب کنید');
					return;
				}
		 checkvalidcusData();

//			window.open('?pg=havaleMgmtPg&cmd=dspPreHavaleFrm2&cType=norm&cId='+fObj('code_customer').value+'&cm_req_date='+fObj('cus_req_date').value+'&cus_req_num='+fObj('cus_req_num').value+'&cus_code='+fObj('code_customer').innerHTML, '_self')
		}
			  
	  </script>
	<?php 
		$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
		$cm_req_num = isset($_REQUEST['cm_req_num']) ? $_REQUEST['cm_req_num'] : '';		
		$ph_customer_code = isset($_REQUEST['ph_customer_code']) ? $_REQUEST['ph_customer_code'] : '';
		$ph_mojavez = isset($_REQUEST['ph_mojavez']) ? $_REQUEST['ph_mojavez'] : '';
		$cm_req_date = !empty($_REQUEST['cm_req_date']) ? $_REQUEST['cm_req_date'] : '';		
		
	$out='
		<input type="hidden" name="ph_code" id="ph_code" type="text" value="'.$ph_code.'" / >
	<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
		 <tr style="background-color:'. $_SESSION['htablecolor'] .';">
				     <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ویرایش اطلاعات پیش حواله</font></b></td>
		 </tr>
		 <tr>    
		     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >کد مشتری:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="ph_customer_code" id="ph_customer_code" type="text"  value="'.$ph_customer_code.'"/ ></td>
		        <td style="height: 50px;vertical-align:middle;font-weight:bold;" >شماره درخواست:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="cm_req_num" id="cm_req_num" type="text" value="'.$cm_req_num.'" / ></td>  
		 </tr>
		  <tr> 
		     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >تاریخ درخواست:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="cm_req_date1" id="cm_req_date1" type="text" value="'.$cm_req_date.'" / ></td>
		        <td style="height: 50px;vertical-align:middle;font-weight:bold;" >شماره مجوز:</td>
		        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="ph_mojavez" id="ph_mojavez" type="text" value="'.$ph_mojavez.'" / ></td>
		       
		        
		 </tr>
	
		 <tr>
			     <td colspan="2"> <button name="subject" type="button" value="CSS" class="button blue skew"  onclick="validatecusAndSave()" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;</td>
			          
		</tr>
		
</table>
';
	return $out;
}
function Editphprod(){
	?>
	<script type="text/javascript" >
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
	function addAProd2BillCheck(){
				
			if(fObj('p_code').value=='' || fObj('p_code').value==0){
					
					alert('لطفا کد کالا را انتخاب کنيد');
					return;
				}
			if(fObj('p_price_combo').value==''){
				
				alert('لطفا کد قيمت را انتخاب کنيد');
				return;
			}
          
			if(fObj('phd_amount').value==''){
				
				alert('لطفا مقدار را وارد کنيد');
				return;
			}
			if(fObj('phd_deli_name').value==''){
							
			    alert('لطفا نام تحويل گيرنده را وارد کنيد ');
					return;
						}
			if(fObj('phd_deli_name').value==''){
				
				alert('لطفا نام تحويل گيرنده را وارد کنيد ');
				return;
			}

//			addAProd2Bill();
	          EditphprodCheck();
			
				}
	function searchProd(e,val) {
		if(e.keyCode==112){
		window.open( 'searchProd.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" );
		}
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
		right: 300px;
		top: 550px;
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
	$ph_code=$_REQUEST['ph_code'];
	$phd_id=$_REQUEST['phd_id'];
	$p_code=$_REQUEST['p_code'];	
    $p_price_code=$_REQUEST['p_price_code'];	
    $l_code=$_REQUEST['l_code'];	
    $deli_name=$_REQUEST['deli_name'];	
    $phd_amount=$_REQUEST['phd_amount'];	
	//$_SESSION['shomarePishHavale']=$ph_code;
	$query = "
					SELECT *  FROM dm_pish_factor 
						 
					WHERE 
									pf_ph_code = ".$ph_code." 
					AND            pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					AND
			                    	pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
				
						$lnk = mysql_query($query);
						$row= mysql_fetch_assoc($lnk);			
   $queryl = "
			SELECT *  FROM dm_location_goods 
					 
				WHERE 
						l_code = ".$l_code."
				AND 
						l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								
								"; 							
					$lnkl = mysql_query($queryl);
				$rowl= mysql_fetch_assoc($lnkl);	
	//			print $queryl;
				$query = "
						SELECT * FROM dm_pish_havale_det 
						
						   WHERE 
							phd_id = ".$phd_id." 
					";
//	print $query;
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);
	$phd_price=$row['phd_price'];
	$phd_id_unit=$row['phd_id_unit'];
	$queryph = "
				SELECT * FROM dm_pish_havale
						
				WHERE 
					ph_code = ".$row['phd_ph_code']."
				AND
				    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				AND
					ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
					
//	print $query;
	$lnkph = mysql_query($queryph);
	$rowph= mysql_fetch_assoc($lnkph);
//	print	$phd_price;					
?>		   	
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="addedprod"> 
		<input type="hidden" name="ph_code"     id="ph_code"      value="<?php echo $ph_code ?>">
		<input type="hidden" name="phd_id"      id="phd_id"       value="<?php echo $phd_id ?>">
		<input type="hidden" name="phd_operation_id"      id="phd_operation_id"       value="<?php echo $rowph['ph_operation_id'] ?>"> 
		 
		<br></br>
		<br></br>
		<table   align="center" class="nasi" style="width:80%;margin-top:0px;">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		  	  
		      <td colspan="9"  style="height: 50px;vertical-align:middle;"  align="center" ><b> ريزكالاهاي قابل تحويل</b></td>
	        </tr>
	        <tr>
	            <td colspan="9"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	<tr>
		       	<td width=10%;><center><b> کد کالاي مربوطه  :</b></center> </td>
		       	<td><input type="text"  id="p_code"  onkeypress="searchProd(event,<?php echo $_SESSION['dm_user_profile']['u_province_id']  ?>);"  value="<?php echo $p_code ?>"></input></td>
				<td ><b>کد قيمت</b> </td>
	            <td><input  id="p_price_code"   value="<?php echo $p_price_code ?>"></input></td>		       
	         </tr>
	      	 <tr>
		        <td ><center><b>مقدار :</b></center> </td>
		        <td><input name="phd_amount" id="phd_amount" type="text" value="<?php echo $phd_amount ?>"   /></td> 		         
		        <td ><center><b>واحد :</b></center> </td>
                <td>
			  		<?php echo getUnit_phTypesComboBox('phd_id_unit')?>
				</td>	       
		    </tr>
	       
	        <tr>
			    <td colspan="7"><hr></td>			             
		    </tr>	      	
		  	<tr>
		        <td colspan="7" align="center" style="height: 40px;vertical-align:middle;"><b>محل هاي تحويل كالا</b></td>
	        </tr>
	        <tr>
	            <td  ><b>كد محل :</b></td>
		        <td ><?php echo getLocationComboed($l_code); ?></td>
			    <td ><b> نام محل   :</b></td>
		        <td><span  id="l_name" ><?php echo  $rowl['l_name'] ?></span></td>
			  					  			  		
	      	</tr>
	      	<tr>
	      	    <!--
	      	     <td >تحويل با </td>
	      	     <td><?php echo getDeliveryTypesComboBox('phd_deli_with')?></td>
		        
				 --><td width="20%" ><b>نام تحويل گيرنده: </b></td>
		         <td width="25%"><input name="phd_deli_name"  id="phd_deli_name"  value="<?php echo $deli_name ?>" id="phd_deli_name" type="text"  /></td>
		       
							
		          <td >&nbsp;</td>
	        </tr>
	        <tr>
	         
				 <td width="15%" align="right">&nbsp; </td>
		         <td width="15%" align="right">&nbsp; </td>
		         <td colspan="2">&nbsp;</td>
		         <td colspan="2">&nbsp;</td>
		          <td >&nbsp;</td>
	        </tr>
	      
	        </table> 
	        
	      	<?php 
	      
	      	$display='1'; 
	      	 echo 	'<div align="center"><a href="?pg=havaleMgmtPg&cmd=EditPishHavale&ph_code='.$ph_code.'"> <img src="images/back1.png"  title="بازگشت" ></img></a> </div>';									   							
	      	
	      	
		//      	<td colspan="3"><input type="button" value="اضافه" onclick="addAProd2Bill()"><input type="submit" value="ثبت" ></td>
		      	?>
		   
		     		    <span ><button type="button" value="ثبت" onclick="addAProd2BillCheck()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >ثبت</button></span>      	
<!--		        <span ><button type="button" value="اضافه" onclick="addAProd2BillCheck()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >اضافه</button></span>-->
                            				      			      
<div id="addedProdsCntnr" style="direction: rtl;"></div>
 <br>
 <?php
	
	
}
function editnewopr(){
	
 $rahnama= '<span style="color:blue;"><span style="color:red;">  *  </span> با تغيير كد عمليات همه ي كالاهاي اين پيش نويس حواله تغيير ميكنند  </span>  ';
    echo $rahnama;
	$ph_code=$_REQUEST['ph_code'];
	$phd_id=$_REQUEST['phd_id'];
	$p_code=$_REQUEST['p_code'];	
    $p_price_code=$_REQUEST['p_price_code'];	
    $l_code=$_REQUEST['l_code'];	
    $deli_name=$_REQUEST['deli_name'];	
    $phd_amount=$_REQUEST['phd_amount'];	
	//$_SESSION['shomarePishHavale']=$ph_code;
	$query = "
					SELECT *  FROM dm_pish_factor 
						 
					WHERE 
							pf_ph_code = ".$ph_code." 
					AND     pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					AND
			                pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
				
			
						$lnk = mysql_query($query);
						$row= mysql_fetch_assoc($lnk);			
   $queryl = "
			SELECT *  FROM dm_location_goods 
					 
				WHERE 
						l_code = ".$l_code."
				AND 
						l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								
								"; 							
					$lnkl = mysql_query($queryl);
				$rowl= mysql_fetch_assoc($lnkl);	
	//			print $queryl;
				$query = "
						SELECT * FROM dm_pish_havale_det 
						
						   WHERE 
							phd_id = ".$phd_id." 
					";
//	print $query;
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);
	$phd_price=$row['phd_price'];
	$phd_id_unit=$row['phd_id_unit'];
	$queryph = "
				SELECT * FROM dm_pish_havale
						
				WHERE 
					ph_code = ".$row['phd_ph_code']."
				AND
				    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				AND
					ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
					
//	print $query;
	$lnkph = mysql_query($queryph);
	$rowph= mysql_fetch_assoc($lnkph);
//	print	$phd_price;					
?>		   <form  action="">
		<input type="hidden" name="pg" value="havaleMgmtPg">   
		<input type="hidden" name="cmd" value="editopr"> 
		<input type="hidden" name="ph_code"     id="ph_code"      value="<?php echo $ph_code ?>">
		<input type="hidden" name="l_id"        id="l_id"      value="<?php echo $row['phd_l_id'] ?>">
		<input type="hidden" name="p_code"      id="p_code"      value="<?php echo $row['phd_pid'] ?>">
		<input type="hidden" name="p_price_code"      id="p_price_code"      value="<?php echo $row['phd_price_code'] ?>">
		 
		<br></br>
		<br></br>
		<table   align="center" class="nasi" style="width:80%;margin-top:0px;">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		  	  
		      <td colspan="10"  style="height: 50px;vertical-align:middle;"  align="center" ><b> تغيير نوع عمليات </b></td>
	        </tr>
	        <tr>
	            <td colspan="9"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	
	
	      	<tr>
	      	   
		         <td style="font-weight:bold;" colspan="5">نوع عمليات </td>
			  	
			    	<td colspan="4"><?php echo getmojopComboBox('phm_id') ?></td>
							
		          <td >&nbsp;</td>
	        </tr>
	        <tr>
	         
				 <td width="15%" align="right">&nbsp; </td>
		         <td width="15%" align="right">&nbsp; </td>
		         <td colspan="2">&nbsp;</td>
		         <td colspan="2">&nbsp;</td>
		          <td >&nbsp;</td>
	        </tr>
	      
	        </table> 
	        
	      	<?php 
	      
	      	$display='1'; 
		//      	<td colspan="3"><input type="button" value="اضافه" onclick="addAProd2Bill()"><input type="submit" value="ثبت" ></td>
		      	?>
		   
		      <span ><button type="submit" value="ثبت"  class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >ثبت</button></span>      	
                            				      			      
  </form>	
 <?php
	
}
function createNewProd(){
	
	$ph_code=$_REQUEST['ph_code'];	
	$_SESSION['shomarePishHavale']=$ph_code;
	
	$query="SELECT * FROM dm_pish_havale WHERE ph_code=".$ph_code."
	and
	ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					            ";
										
										//print $query;
										$lnk = mysql_query($query);
										$row = mysql_fetch_assoc($lnk);
										//echo $row['ph_phm_id']
	
	
	
	?>
	
	<script type="text/javascript" >
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
	function addAProd2BillCheck(){
				
			if(fObj('p_code').value==''){
					
					alert('لطفا کد کالا را انتخاب کنید');
					return;
				}
			if(fObj('p_price_combo').value==''){
				
				alert('لطفا کد قيمت را انتخاب کنید');
				return;
			}
           if(fObj('LocationCombo').value==''){
				
				alert('لطفا کد محل را وارد کنید ');
				return;
			}
			if(fObj('phd_amount').value==''){
				
				alert('لطفا مقدار را وارد کنید');
				return;
			}
			if(fObj('phd_deli_name').value==''){
							
				alert('لطفا نام تحویل گیرنده را وارد کنید ');
				return;
						}
			if(fObj('phd_deli_name').value==''){
				
				alert('لطفا نام تحویل گیرنده را وارد کنید ');
				return;
			}
			addAProd2Bill();
			
				}
	function searchProd(e,val) {
		if(e.keyCode==112){
		
			window.open( 'searchProd.php?province_id='+val, "myWindow", 
			"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" ); 

		}
				                      
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
		right: 300px;
		top: 550px;
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

		<input type="hidden" name="phm_id"      id="phm_id"      value="<?php echo $row['ph_phm_id'] ?>">

				   			
		<table   align="center" class="nasi" style="width:70%;margin-top:0px;">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		  	  
		      <td colspan="9"  style="height: 50px;vertical-align:middle;"  align="center" ><b> ريزكالاهاي قابل تحويل</b></td>
	        </tr>
	          <tr>
	           <td colspan="9"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td width=10%;><center><b> کد کالاي مربوطه  :</b></center> </td>
		       	<td><input type="text"  id="p_code"  onkeypress="searchProd(event,<?php echo $_SESSION['dm_user_profile']['u_province_id']  ?>);"   ></input></td>

				<td ><b>کد قیمت</b> </td>
	            <td><input  id="p_price_combo" ></input></td>		       
	        </tr>
	      	<tr>
		        <td ><center><b>مقدار :</b></center> </td>
		        <td><input name="phd_amount" id="phd_amount" type="text" /></td> 
		         
		        <td ><center><b>واحد :</b></center> </td>
               <td>
			  		<?php echo getUnit_phTypesComboBox('phd_id_unit')?>
				</td>	       
		    </tr>
	        <tr>
	             <td ><center> <b>مانده </b> : </center> </td>
		        <td  ><input name="phd_amount_remined" id="phd_amount_remined" type="text"  onBlur="this.value=formatCurrency(this.value);" onkeyup="isNumber(this)"/></td>
	        </tr>
	        <tr>
			    <td colspan="7"><hr></td>			             
		   </tr>
	      	
		  	<tr>
		        <td colspan="7" align="center" style="height: 40px;vertical-align:middle;"><b>محل هاي تحويل كالا</b></td>
	        </tr>
	        <tr>
	            <td  ><b>كد محل :</b></td>
		        <td ><?php echo getLocationCombo(); ?></td>
			    <td ><b> نام محل   :</b></td>
		        <td><span name="l_name" id="l_name" ></span></td>
	      	</tr>
	      	<tr>
	      	    <!--
	      	     <td >تحويل با </td>
	      	     <td><?php echo getDeliveryTypesComboBox('phd_deli_with')?></td>
		        
				 --><td width="20%" ><b>نام تحويل گيرنده: </b></td>
		         <td width="25%"><input name="phd_deli_name" id="phd_deli_name" type="text"  /></td>
		         <td colspan="2">&nbsp;</td>
		         <td colspan="2">&nbsp;</td>
		          <td >&nbsp;</td>
	        </tr>
	        <tr>
	      	     <td >تحويل با </td>
	      	     <td><?php echo getDeliveryTypesComboBox('phd_deli_with')?></td>
		        
				 <td width="15%" align="right">&nbsp; </td>
		         <td width="15%" align="right">&nbsp; </td>
		         <td colspan="2">&nbsp;</td>
		         <td colspan="2">&nbsp;</td>
		          <td >&nbsp;</td>
	        </tr>
	      
	        </table>   
	      	
	      	
	  
		        <span ><button type="button" value="اضافه" onclick="addAProd2BillCheck()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:15%;" >اضافه</button></span>	  	   
				   <div id="addedProdsCntnr" style="direction: rtl;"></div>
     <div align="center"><a href="?pg=havaleMgmtPg&cmd=EditPishHavale&ph_code=<?php echo $ph_code ?>"> <img src="images/back1.png"  title="بازگشت" ></img></a> </div>';
<?php 	
	
}

function getNavBar_prodanbar(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp; </td>				      
		<td><a href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp; </td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
		';		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp; </td>
		<td><a href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="بعدي"></img></a></td>
	';	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_prodanbar(){
	$out = '<div align="center">
	<span style="align:center;">	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\') " style="width:50px; >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
		</div>
	';
		return $out;
}
    //موجودی کارتن
function mojodyKarton($c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailkartonCondition='';
  if($c_ziranbar) $detailkartonCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailkartonCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailkartonCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailkartonCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailkartonCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailkartonCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailkartonCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(tedad_karton_aval) FROM mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $tedadKartonAval=$row[0];	
  $q_varede="SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKartonVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(tedad_karton_h_d) FROM havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKartonSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(tedad_karton_tadil) FROM tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $kartonTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(tedad_karton_tadil) FROM tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar  AND year=$sal AND code_kala='$c_kala'  $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $kartonTadilKasry=$row_tadil_kasry[0];
  $tedadKarton=$tedadKartonAval+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
  return $tedadKarton;
}
//موجودی ناخالص
function mojodyNakhales($c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailnakhalesCondition='';
  if($c_ziranbar) $detailnakhalesCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailnakhalesCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailnakhalesCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailnakhalesCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailnakhalesCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailnakhalesCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailnakhalesCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(mojody_nakhales_aval) FROM mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyNakhalesAval=$row[0];	
  $q_varede="SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameNaKhalesVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(vazn_nakhales_h_d) FROM havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameNaKhalesSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(meghdar_nakhales_tadil) FROM tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $nakhalesTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(meghdar_nakhales_tadil) FROM tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $nakhalesTadilKasry=$row_tadil_kasry[0];
  $nakhales=$mojodyNakhalesAval+$jameNaKhalesVarede-$jameNaKhalesSadere+$nakhalesTadilEzafe-$nakhalesTadilKasry;
  $nakhales=round($nakhales,3);
  return $nakhales;
}
//موجودی خالص
function mojodyKhales($c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailkhalesCondition='';
  if($c_ziranbar) $detailkhalesCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailkhalesCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailkhalesCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailkhalesCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailkhalesCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailkhalesCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailkhalesCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(mojody_khales_aval) FROM mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyKhalesAval=$row[0];	
  $q_varede="SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKhalesVadere=$row_varede[0]; 
  $q_sadere="SELECT SUM(vazn_khales_h_d) FROM havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition  AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKhalesSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(meghdar_khales_tadil) FROM tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $khalesTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(meghdar_khales_tadil) FROM tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $khalesTadilKasry=$row_tadil_kasry[0];
  $khales=$mojodyKhalesAval+$jameKhalesVadere-$jameKhalesSadere+$khalesTadilEzafe-$khalesTadilKasry;
  $khales=round($khales,3);
  return $khales;
}
?>