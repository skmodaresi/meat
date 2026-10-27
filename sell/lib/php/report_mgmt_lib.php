<?php
require_once __DIR__ . '/../../../mysql_compat.php';

function dspReportProdFrmnew(){
	?>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	      $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#firstDate1").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#EndDate1").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	     
			
			function searchProd(e,val) {
		if(e.keyCode==112){
		window.open( 'searchproduct.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" );
		}
						                      
				}
			
	    function searchprice_code(e,val) {
	    	if(e.keyCode==112){
	    	
	    		window.open( 'searchprice_code.php?province_id='+val, "myWindow", 
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
	
               $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              ?>
	
 
	
   <table border="1" align="center" class="nasi" id="mOrh_H" style="display:block;-moz-border-radius:17px ;" width="60%" >
					<tr>
						<td>گزارش بر اساس : </td>
					</tr>
					<tr>
					<td>
						
						<right><?php echo getReportTypeRadioHtmlnew($selectedItem)?></right></td>
							
					</tr>
					<tr>
						<td>
						
						<form method="post" action="" target="_blank">
							 <table id="dateReport" align="center" style="display: none;-moz-border-radius:17px ;" width="90%">
							   <input type="hidden" name="pg" value="reportMgmtPg" />   
		                       <input type="hidden" name="cmd" value="reph_datenew" /> 
							   <input name="province_id" type="hidden" id="province_id" value="<?php echo $_SESSION['dm_user_profile']['u_province_id']?>" type="text"/>
							   <input name="year_id"     type="hidden"id="year_id" value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" type="text"/> 	
							 
										<tr >
											   <td>از تاريخ:</td><td><input name="firstDate1" id="firstDate" type="text" /></td>
											   <td>تا تاريخ:</td><td><input name="EndDate1" id="EndDate" type="text" /></td>
										</tr>
										<tr>
										       <td>کد  کالا : </td><td><input type="text"   name="p_codeh"    id="p_code"   ></input></td>
										       <td>کد  قيمت : </td><td><input type="text"  name="p_price_codeh" id="p_price_code"   ></input></td>
										       
										</tr>
										<tr>
										       <td>نوع عمليات: </td><td><?php echo getOperationComboBoxx('ph_operation_id')?></td>										     
										       <td>بسته بندی کالا : </td><td><?php echo getPkgTypesComboBoxr('p_pakage_type')?></td>
										</tr>
										<tr>
										       <td>دسته بندی کالا : </td><td><?php echo getCategoryTypesComboBoxr('p_category')?></td>										     
										       <td ><center>نوع کالا </center> </td><td><?php echo getTypesComboBoxr('p_type')?></td>
										</tr>
										<tr>										
										      <td>نام محل مورد نظر:</td><td><?php echo getlocationNameCombo('l_id')?></td>
										      <td>نام تحویل گیرنده:</td><td><input name="phd_deli_name" type="text"  /></td>
										      
										</tr>
										<tr>  
										       <td>کد مشتری: </td><td><input type="text"  id="code_customer"  name="code_customer1"  ></input></td>
										       <td>نوع دسته بندی:</td><td><?php echo getCatCustomerNameCombo('category_id')?></td>
										</tr>
										<tr>  
										       <td>نام شهر: </td><td><?php echo getcityNameCombo('city_id')?></td>
										       <td>شماره مجوز:</td><td><input name="ph_mojavez_hd" type="text"  /></td>
										       
										</tr>
										<tr>  
										      
										       
										 </tr>							
										<tr>
											  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
										</tr>
							</table>
						</form>
						</td>
					</tr>
					<tr>
						<td>
						
							 <form method="post" action="" target="_blank">
							 <table id="numberReport" align="center" style="display: block;-moz-border-radius:17px ;" width="90%">
							   <input type="hidden" name="pg" value="reportMgmtPg" />   
		                       <input type="hidden" name="cmd" value="reph_date" /> 
							   <input name="province_id" type="hidden" id="province_id" value="<?php echo $_SESSION['dm_user_profile']['u_province_id']?>" type="text"/>
							   <input name="year_id"     type="hidden"id="year_id" value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" type="text"/> 	
							 
										<tr >
											   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate1" type="text" /></td>
											   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate1" type="text" /></td>
										</tr>
										<tr>
										       <td>کد  کالا : </td><td><input type="text"   name="p_codeh"    id="p_code"   ></input></td>
										       <td>کد  قيمت : </td><td><input type="text"  name="p_price_codeh" id="p_price_code"   ></input></td>
										       
										</tr>
										<tr>
										       <td>نوع عمليات: </td><td><?php echo getOperationComboBoxx('ph_operation_id')?></td>										     
										       <td>بسته بندی کالا : </td><td><?php echo getPkgTypesComboBoxr('p_pakage_type')?></td>
										</tr>
										<tr>
										       <td>دسته بندی کالا : </td><td><?php echo getCategoryTypesComboBoxr('p_category')?></td>										     
										       <td ><center>يارانه </center> </td><td><?php echo getSubsidiesTypesComboBoxZ('p_Subsidies')?></td>
										</tr>
										<tr>										
										      <td>نام محل مورد نظر:</td><td><?php echo getlocationNameCombo('l_id')?></td>
										      <td>نام تحویل گیرنده:</td><td><input name="phd_deli_name" type="text"  /></td>
										      
										</tr>
										<tr>  
										       <td>کد مشتری: </td><td><input type="text"  id="code_customer"  name="code_customer1"  ></input></td>
										       <td>نوع دسته بندی:</td><td><?php echo getCatCustomerNameCombo('category_id')?></td>
										</tr>
										<tr>  
										       <td>نام شهر: </td><td><?php echo getcityNameCombo('city_id')?></td>
										       <td>شماره مجوز:</td><td><input name="ph_mojavez_hd" type="text"  /></td>
										       
										</tr>
										<tr>  
										      
										       
										 </tr>							
										<tr>
											  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
										</tr>
							</table>
						</form>
						</td>
							
					 </tr>   					 
  </table>
		<?php 
	}
function dspReportrizFrm(){
	
	
	?>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	     $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#firstDatem").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#EndDatem").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
			
			function searchProd(e,val) {
		if(e.keyCode==112){
		window.open( 'searchproduct.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" );
		}
						                      
				}
			
	    function searchprice_code(e,val) {
	    	if(e.keyCode==112){
	    	
	    		window.open( 'searchprice_code.php?province_id='+val, "myWindow", 
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
	
               $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              ?>
	
	
   <table border="1" align="center" class="nasi"  style="display:block;-moz-border-radius:17px ;" width="60%" >
					
					 <tr style="background-color:<?php $_SESSION['htablecolor'] ?>;font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">صورت ریز حواله های صادره در طی سال</font></td>
			   </tr>
					<tr>
						<td colspan="2"> <hr></hr></td>
					</tr>	
					<tr>
						<td>
						
						<form method="post" action="" target="_blank">
							 <table id="dateReport" align="center" style="display: block;-moz-border-radius:17px ;" width="90%">
							   <input type="hidden" name="pg" value="reportMgmtPg" />   
		                       <input type="hidden" name="cmd" value="repriz_date" /> 
							   <input name="province_id" type="hidden" id="province_id" value="<?php echo $_SESSION['dm_user_profile']['u_province_id']?>" type="text"/>
							   <input name="year_id"     type="hidden"id="year_id" value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" type="text"/> 	
							 
										<tr>
											   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
											   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
										</tr>
										<tr>
										       <td>کد  کالا : </td><td><input type="text"   name="p_codeh"    id="p_code"   ></input></td>
										       <td>کد  قيمت : </td><td><input type="text"  name="p_price_codeh" id="p_price_code"   ></input></td>
										       
										</tr>
										<tr>
										       <td>نوع عمليات: </td><td><?php echo getOperationComboBoxx('ph_operation_id')?></td>										     
										       <td>بسته بندی کالا : </td><td><?php echo getPkgTypesComboBoxr('p_pakage_type')?></td>
										</tr>
										<tr>
										       <td>دسته بندی کالا : </td><td><?php echo getCategoryTypesComboBoxr('p_category')?></td>										     
										       <td ><center>يارانه </center> </td><td><?php echo getSubsidiesTypesComboBoxZ('p_Subsidies')?></td>
										</tr>
										<tr>										
										      <td>نام محل مورد نظر:</td><td><?php echo getlocationNameCombo('l_id')?></td>
										      <td>نام تحویل گیرنده:</td><td><input name="phd_deli_name" type="text"  /></td>
										      
										</tr>
										<tr>  
										       <td>کد مشتری: </td><td><input type="text"  id="code_customer"  name="code_customer1"  ></input></td>
										       <td>نوع دسته بندی:</td><td><?php echo getCatCustomerNameCombo('category_id')?></td>
										</tr>
										
										
										<tr>  
										      
										       
										 </tr>							
										<tr>
											  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
										</tr>
							</table>
					
		<?php 	
}

function dspReportProdFrm(){
	?>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	     $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#firstDatem").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کلیک بر روی عکس
	        $("#EndDatem").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
			
			function searchProd(e,val) {
		if(e.keyCode==112){
		window.open( 'searchproduct.php?province_id='+val, "myWindow", 
		"left=20,top=20,width=500,height=500,toolbar=1,resizable=0" );
		}
						                      
				}
			
	    function searchprice_code(e,val) {
	    	if(e.keyCode==112){
	    	
	    		window.open( 'searchprice_code.php?province_id='+val, "myWindow", 
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
	
               $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              ?>
	<table border="0" align="center"  width="30%" >
	   <tr>
	       <td>&nbsp;</td>
	   </tr>
	   <tr>
			<td>گزارش بر اساس: <?php echo getHorMTypeRadioHtml($selectedItem)?></td>	
	   </tr>
	  </table>
   <table border="1" align="center"  style="-moz-border-radius:17px;display:none;" class="nasi" id="mOrh_M" width="60%" >  
					<tr>
						<td>گزارش بر اساس معرفي نامه: <center><?php echo getReportMTypeRadioHtml($selectedItem)?></center></td>	
					</tr>
					<tr>
						<td>
						<form action="">						
							 <table id="dateReportM"  align="left" style="display:none;-moz-border-radius:17px ;" width="90%">
							   <input type="hidden" name="pg" value="reportMgmtPg" />   
		                       <input type="hidden" name="cmd" value="repM_date" /> 
							   <input name="province_id" type="hidden" id="province_id"  value="<?php echo $_SESSION['dm_user_profile']['u_province_id']?>" type="text"/>
							   <input name="year_id"     type="hidden"id="year_id"  value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" type="text"/> 	
							 
										<tr>
											   <td>از تاريخ:</td><td><input name="firstDatem" id="firstDatem" type="text" class="required" /></td>
											   <td>تا تاريخ:</td><td><input name="EndDatem" id="EndDatem" type="text" /></td>
										</tr>
										<tr>
										       <td>کد  کالا : </td><td><input type="text"  id="p_code" name="p_code"  onkeypress="searchProd(event);" ></input></td>
										       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code" onkeypress="searchprice_code(event,<?php echo $province_id ?>);" ></input></td>
										       
										</tr>
										<tr>
										       <td>نوع کالا : </td><td><?php echo getTypesComboBoxr('p_type')?></td>										     
										       <td>بسته بندی کالا : </td><td><?php echo getPkgTypesComboBoxr('p_pakage_type')?></td>
										</tr>
										<tr>
										       <td>دسته بندی کالا : </td><td><?php echo getCategoryTypesComboBoxr('p_category')?></td>										     
										       <td ><center>يارانه </center> </td><td><?php echo getSubsidiesTypesComboBoxZ('p_Subsidies')?></td>
										</tr>
										<tr>										
										      <td>نام محل مورد نظر:</td><td><?php echo getlocationNameCombo('l_id')?></td>
										      <td>نام تحویل گیرنده:</td><td><input name="phd_deli_name" type="text"  /></td>
										      
										</tr>
										<tr>  
										       <td>کد مشتری: </td><td><input type="text"  id="code_customer"  name="code_customer"   onkeypress="searchCustomer(event);"  ></input></td>
										       <td>نوع دسته بندی:</td><td><?php echo getCatCustomerNameCombo('category_id')?></td>
										</tr>
										<tr>  
										       <td>نام شهر: </td><td><?php echo getcityNameCombo('city_id')?></td>
										       <td>شماره مجوز:</td><td><input name="ph_mojavez" type="text"  /></td>
										       
										</tr>
																	
										<tr>
											  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
										</tr>
							</table>
						</form>
						</td>
					</tr>
					<tr>
						<td>
						<form method="post" action="" target="_blank">
							<table id="numberReportM" align="left" style="display:block;-moz-border-radius:17px ;" width="90%" > 
							   <input type="hidden" name="pg" value="reportMgmtPg" />   
		                       <input type="hidden" name="cmd" value="repM_num" /> 
							   <input name="province_id"  type="hidden" id="province_id"  value="<?php echo $_SESSION['dm_user_profile']['u_province_id']?>" type="text"/>
							   <input name="year_id"      type="hidden"id="year_id"  value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" type="text"/> 	 	
									<tr >
										   <td>از شماره:</td><td><input  name="firstNumber1"  id="firstNumber"  type="text"/></td>
										   <td>تا شماره:</td><td><input  name="EndNumber1"    id="EndNumber"    type="text"/></td>
									</tr>
									<tr>
										       <td>کد  کالا : </td><td><input type="text"  name="p_code"  id="p_code"   ></input></td>
										       <td>کد  قيمت : </td><td><input type="text"  name="p_price_code"  id="p_price_code"  onkeypress="searchProd(event);" ></input></td>
										       
										</tr>
										<tr>
										       <td>نوع عمليات: </td><td><?php echo getOperationComboBoxx('ph_operation_id')?></td>										     
										       <td>بسته بندی کالا : </td><td><?php echo getPkgTypesComboBoxr('p_pakage_type')?></td>
										</tr>
										<tr>
										       <td>دسته بندی کالا : </td><td><?php echo getCategoryTypesComboBoxr('p_category')?></td>										     
										       <td ><center>يارانه </center> </td><td><?php echo getSubsidiesTypesComboBoxZ('p_Subsidies')?></td>
										</tr>
										<tr>										
										      <td>نام محل مورد نظر:</td><td><?php echo getlocationNameCombo('l_id')?></td>
										      <td>نام تحویل گیرنده:</td><td><input name="phd_deli_name" type="text"  /></td>
										      
										</tr>
										<tr>  
										       <td>کد مشتری: </td><td><input type="text"  id="code_customer"  onkeypress="searchCustomer(event);"  ></input></td>
										       <td>نوع دسته بندی:</td><td><?php echo getCatCustomerNameCombo('category_id')?></td>
										</tr>
										<tr>  
										       <td>نام شهر: </td><td><?php echo getcityNameCombo('city_id')?></td>
										      <td>شماره مجوز:</td><td><input name="ph_mojavez" type="text"  /></td>
										       
										</tr>							
										<tr>
											  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
										</tr>
							</table>
						</form>
						</td>
							
					 </tr>   
					 
  </table>
	
   <table border="1" align="center" class="nasi" id="mOrh_H" style="display:block;-moz-border-radius:17px ;" width="60%" >
					<tr>
						<td>گزارش بر اساس حواله: <center><?php echo getReportTypeRadioHtml($selectedItem)?></center></td>	
					</tr>
					<tr>
						<td>
						
						<form method="post" action="" target="_blank">
							 <table id="dateReport" align="center" style="display: none;-moz-border-radius:17px ;" width="90%">
							   <input type="hidden" name="pg" value="reportMgmtPg" />   
		                       <input type="hidden" name="cmd" value="reph_date" /> 
							   <input name="province_id" type="hidden" id="province_id" value="<?php echo $_SESSION['dm_user_profile']['u_province_id']?>" type="text"/>
							   <input name="year_id"     type="hidden"id="year_id" value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" type="text"/> 	
							 
										<tr >
											   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
											   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
										</tr>
										<tr>
										       <td>کد  کالا : </td><td><input type="text"   name="p_codeh"    id="p_code"   ></input></td>
										       <td>کد  قيمت : </td><td><input type="text"  name="p_price_codeh" id="p_price_code"   ></input></td>
										       
										</tr>
										<tr>
										       <td>نوع عمليات: </td><td><?php echo getOperationComboBoxx('ph_operation_id')?></td>										     
										       <td>بسته بندی کالا : </td><td><?php echo getPkgTypesComboBoxr('p_pakage_type')?></td>
										</tr>
										<tr>
										       <td>دسته بندی کالا : </td><td><?php echo getCategoryTypesComboBoxr('p_category')?></td>										     
										       <td ><center>يارانه </center> </td><td><?php echo getSubsidiesTypesComboBoxZ('p_Subsidies')?></td>
										</tr>
										<tr>										
										      <td>نام محل مورد نظر:</td><td><?php echo getlocationNameCombo('l_id')?></td>
										      <td>نام تحویل گیرنده:</td><td><input name="phd_deli_name" type="text"  /></td>
										      
										</tr>
										<tr>  
										       <td>کد مشتری: </td><td><input type="text"  id="code_customer"  name="code_customer1"  ></input></td>
										       <td>نوع دسته بندی:</td><td><?php echo getCatCustomerNameCombo('category_id')?></td>
										</tr>
										<tr>  
										       <td>نام شهر: </td><td><?php echo getcityNameCombo('city_id')?></td>
										       <td>شماره مجوز:</td><td><input name="ph_mojavez_hd" type="text"  /></td>
										       
										</tr>
										<tr>  
										       <td>ترتیب بر اساس </td><td><?php echo getsortCombo('sort_id')?></td>
										       <td>نوع </td><td><?php echo getselltypes1('phd_tahator')?></td>
										     
										       
										</tr>
										<tr>  
										      
										       
										 </tr>							
										<tr>
											  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
										</tr>
							</table>
						</form>
						</td>
					</tr>
					<tr>
						<td>
						<form method="post" action="" target="_blank">
							<table id="numberReport" align="center" style="display:block;-moz-border-radius: 17px;" width="90%" > 
							   <input type="hidden" name="pg" value="reportMgmtPg" />   
		                       <input type="hidden" name="cmd" value="reph_num" /> 
							   <input name="province_id" type="hidden" id="province_id" value="<?php echo $_SESSION['dm_user_profile']['u_province_id']?>" type="text"/>
							   <input name="year_id"     type="hidden"id="year_id" value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" type="text"/> 	
									 <tr>
										   <td>از شماره:</td><td><input name="firstNumber" id="firstNumber" type="text"/></td>
										   <td>تا شماره:</td><td><input name="EndNumber" id="EndNumber" type="text"/></td>
									 </tr>
									 <tr>
										   <td>کد  کالا : </td><td><input type="text"  name="p_codehn"  id="p_code"  onkeypress="searchProd(event);" ></input></td>
										   <td>کد  قيمت : </td><td><input type="text"  name="p_price_codehn"  id="p_price_code"  onkeypress="searchProd(event);" ></input></td>
										       
										</tr>
										<tr>
										  <td>نوع عمليات: </td><td><?php echo getOperationComboBoxx('ph_operation_id')?></td>										     
									       <td>بسته بندی کالا : </td><td><?php echo getPkgTypesComboBoxr('p_pakage_type')?></td>
										</tr>
										<tr>
									       <td>دسته بندی کالا : </td><td><?php echo getCategoryTypesComboBoxr('p_category')?></td>										     
									       <td ><center>يارانه </center> </td><td><?php echo getSubsidiesTypesComboBoxZ('p_Subsidies')?></td>
										</tr>
										<tr>										
										      <td>نام محل مورد نظر:</td><td><?php echo getlocationNameCombo('l_id')?></td>
										      <td>نام تحویل گیرنده:</td><td><input name="phd_deli_name" type="text"  /></td>
										      
										</tr>
										<tr>  
										       <td>کد مشتری: </td><td><input type="text"  name="code_customer" id="code_customer"  onkeypress="searchCustomer(event);"  ></input></td>
										       <td>نوع دسته بندی:</td><td><?php echo getCatCustomerNameCombo('category_id')?></td>
										</tr>
										<tr>  
										       <td>نام شهر: </td><td><?php echo getcityNameCombo('city_id')?></td>
										       <td>شماره مجوز:</td><td><input name="ph_mojavez_hn" type="text"  /></td>
										       
										</tr>							
										<tr>
											  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
										</tr>
							</table>
						</form>
						</td>
							
					 </tr>   					 
  </table>
		<?php 
	}
function dspRepebtalkfrm(){
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
              
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
	
$out='<form action="" target="_blank">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="repebtali" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش حواله های ابطالی</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				<tr>
				       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
				       <td>بسته بندي کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
				</tr>
				<tr>
				       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				</tr>										
				<tr>  
				       <td>کد مشتري: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندي:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتري:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
				</tr>
				<tr>  
			       <td>نام شهر: </td><td>'.getcityNameCombo('city_id').'</td>
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;	
	
}
function dspRepebtalfrm(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
              
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
	
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="repebtali" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش حواله های ابطالی</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code1"  name="p_code1"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code1"  name="p_price_code1"  ></input></td>
				       
				</tr>
				<tr>
				       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
				       <td>بسته بندي کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
				</tr>
				<tr>
				       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				</tr>										
				<tr>  
				       <td>کد مشتري: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندي:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتري:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
				</tr>
				<tr>  
			       <td>نام شهر: </td><td>'.getcityNameCombo('city_id').'</td>
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;	
	}
	
function dspRepinspectFrm(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
	
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="repinspect" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش حواله براي اداره كل بازرسي و نظارت بر قيمت ها</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				<tr>
				       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
				       <td>بسته بندی کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
				</tr>
				<tr>
				       <td>دسته بندی کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				</tr>										
				<tr>  
				       <td>کد مشتری: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندی:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتري:</td><td>'. getPersonalityTypesComboBox('personality_customer').'</td>															
				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;
	
}
function reph_num(){
		 $firstNumber = !empty($_REQUEST['firstNumber']) ? $_REQUEST['firstNumber'] :'1' ;
		 $EndNumber = !empty($_REQUEST['EndNumber']) ? $_REQUEST['EndNumber'] : '1000000000000000000000';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '2';		 
		 $p_code = !empty($_REQUEST['p_codehn']) ? $_REQUEST['p_codehn'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_codehn']) ? $_REQUEST['p_price_codehn'] : '-2' ;
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $ph_mojavez1 = !empty($_REQUEST['ph_mojavez1']) ? $_REQUEST['ph_mojavez1'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_operation_id = !empty($_REQUEST['ph_operation_id']) ? $_REQUEST['ph_operation_id'] : '-2';
		 
		 $_SESSION['firstNumber']=$firstNumber;
		 $_SESSION['EndNumber']=$EndNumber;
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez1']=$ph_mojavez1;
         $_SESSION['category_id']=$category_id;
         $_SESSION['ph_operation_id']=$ph_operation_id;
	    		           				  	
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
	         ?>
			  <div align="left"> <a href="report/printhnum.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstNumber=<?php echo $firstNumber ?>&EndNumber=<?php echo $EndNumber ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &ph_mojavez=<?php echo $ph_mojavez1 ?>&category_id=<?php echo $category_id ?> &ph_operation_id=<?php echo $ph_operation_id ?>
			  " target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php  
			$outHtml = ' '; 
//	$outHtml = '<br>	
//		<form method="get" action="">
//			<input type="hidden" name="pg" value="havaleMgmtPg">   
//			<input type="hidden" name="cmd" value="searchCodeebtal"> 
//			<b> كد  مورد نظر را جستجو كنيد </b>
//			<div>  <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:60px;" /> 
//			<button type="submit" name="Search" value="Search" >جستجو</button></div>
//		</form>
//		<br>
//	';
	
	$outHtml .= '	
		<div align = "center">
		<div align = "center" style="width:90%;height:300px; overflow:auto">
			<table  align="center" cellpadding="0" cellspacing="0" class="list" border="1" >
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش حواله </center> </th>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="13" style="height: 50px;vertical-align:middle;"> از شماره &nbsp; : '.$firstNumber.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا شماره    :
        			 '.$EndNumber.'  </td>
        			
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			         <td align="center">رديف </td>			      
			        <td align="center"> شماره حواله</td>
			        <td align="center"> شماره پيش نويس</td>
			        <td align="center"> تاريخ حواله</td>
			        <td align="center"> شماره مجوز</td>
			        <td align="center"> نام کالا</td>
			        <td align="center">مقدار اولیه خرید</td>
			         <td align="center">مقدار ابطالی</td>
			         <td align="center">مقدار جاری</td>
			        <td align="center"> مبلغ قابل پرداخت</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			        <td align="center">دسته بندي مشتري</td>
			        <td align="center">نام شهر</td>	
			        <td align="center">وضعيت</td>		    		        		        
				</tr>';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		
		
	}
	$typeQ = '';
	
	$province_id=$_SESSION['dm_user_profile']['u_province_id'];
	$genQuery = "  from ( select h_code , ph_code , p_code, p_price_code, h_reg_date ,
 ph_mojavez , p_name , p_sellprice , h_amount ,
  l_name , h_customer_code , case when h.`h_status` = 1 
  then 'ابطال کلي' else case when his.his_h_id is null 
  then 'ابطال نشده' else 'ابطال جزئي' end end as STATUS_EBTAL ,
   case when h.`h_status` = 1 then h.`h_amount` else 
   case when his.his_h_id is null then 0 else his.`his_eb_amount` 
   end end as MEGHDAR_EBTAL , case when h.`h_status` = 1 
   then h.`h_amount` else case when his.his_h_id is null 
   then h.`h_amount` else SUM( his.`his_eb_amount`) + h.`h_amount` end 
   end as MEGHDAR_PRE , case when h.`h_status` = 1 then 0 else 
   case when his.his_h_id is null then h.h_price else h.h_price 
   end end as SUM_price from dm_havale h 
   left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
   and ( h.h_code between '".$firstNumber."' AND  '".$EndNumber."'   )    
   left join dm_price price on p.p_id=price.price_p_id 
   and price.`p_price_code`=h.`h_price_code` 
   left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type 
   left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
   left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
   left join dm_location_goods l on l.l_id=h.h_l_code 
   left join dm_pish_factor pf on h.h_pf_code=pf.pf_code 
   and pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']." left join dm_pish_havale ph 
   on ph.ph_code=pf.pf_ph_code and ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
   left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
   left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1 
   and ebt.ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
   
  left join dm_ebtal_h ebt2 
  on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 
 and ebt2.ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
  and (
   h.h_code between '".$firstNumber."' AND  '".$EndNumber."'  )
    where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
  and ph_id_province=".$province_id." )    
  
  or

   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
  ph_id_province=".$province_id." )
and ( h.h_code between '".$firstNumber."' AND  '".$EndNumber."'  )


  )
  ".$typeQ." " ;
       
if ($p_code != -2){
		
		$genQuery .= "  AND h_p_code= ". $p_code ." ";
	}
if ($p_price_code != -2){
		
		$genQuery .= " AND p_price_code = ". $p_price_code ." ";
	}
if ($p_type != -2){
		
		$genQuery .= " AND p_type = ". $p_type ." ";
	}
if ( $p_category != -2){
		
		$genQuery .= " AND  p_category = ".$p_category ." ";
	}
if ($l_id != -2){
		
		$genQuery .= " AND  h_l_code = ".$l_id ." ";
	}

if ($p_pakage_type != -2){
		
		$genQuery .= " AND   p_pakage_type = ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$genQuery .= " AND   p_subsidies = ". $p_subsidies ." ";
	}	
	
	if ($ph_mojavez1 != -2){
		 
		$genQuery .= "  AND   ph_mojavez = '". $ph_mojavez1 ."' ";
	}
		
	$genQuery .= " group by `h_code` 
         ) as c 
          
          left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id."
          ";
	if ($code_customer != -2){
		
		$genQuery .= " AND  h_customer_code= ". $code_customer ." ";
	}
	
	$genQuery .= "left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id  ";
         
	if ($code_customer != -2 AND $city_id != -2 AND $category_id != -2){
	
		$genQuery .= " where  h_customer_code= ". $code_customer ."  AND   customer_cusid_city= ". $city_id ." AND   category_id= ". $category_id ."";
	}else if( $code_customer != -2 AND $category_id != -2){
		$genQuery .= " where  h_customer_code= ". $code_customer ." AND   category_id= ". $category_id ." ";
		
	}else if ($city_id != -2 AND  $category_id != -2){
		 
		$genQuery .= " where   customer_cusid_city= ". $city_id ." AND category_id= ". $category_id ." ";
	}else if ($city_id != -2){
				$genQuery .= " where   customer_cusid_city= ". $city_id ."  ";
		
	}else if ($category_id != -2){
				$genQuery .= " where   category_id= ". $category_id ."  ";
		
	}else if ($code_customer != -2){
				$genQuery .= " where   h_customer_code= ". $code_customer ." ";
		
	}
	$genQuery .=" ORDER BY h_code asc";
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		select c.* ,cus2.* 
		,cuscat.category_name  
	".$genQuery.$limitQ;
	//print($resQuery);
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$amount=0;
	$amountebtal=0;
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk)){
			
			if(($inx)%2==1)
				$class="rw1";
				else
				$class="rw0";
			
				$gdate=$row['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;			
		
								 	$querycus="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['h_customer_code']."
									    AND
									     customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']."";									     	     											
								$lnkcus = mysql_query($querycus);
								$rowcus = mysql_fetch_assoc($lnkcus);
								
								$querycity="SELECT * FROM dm_city 
									    WHERE
									      city_id=".$rowcus['customer_cusid_city']."
									   ";									     	     											
								$lnkcity = mysql_query($querycity);
								$rowcity = mysql_fetch_assoc($lnkcity);
					
							//	print $querycity;
						$asli=$row['MEGHDAR_PRE']- $row['MEGHDAR_EBTAL'];
		$inx1=farsinum($inx);	
		$inx1 =urlencode($inx1);
	    $h_code=farsinum($row['h_code']);
	    $ph_code=farsinum($row['ph_code']);
		$jdate=farsinum($jdate);
		$asli =urlencode($asli);
		$asli=formatMoney($asli);
		$asli=farsinum($asli);
		$SUM_price=formatMoney($row['SUM_price']);
		$SUM_price=farsinum($SUM_price);
		$ph_mojavez=farsinum($row['ph_mojavez']);
		$h_customer_code=farsinum($row['h_customer_code']);
		$MEGHDAR_PRE=formatMoney($row['MEGHDAR_PRE']);
		$MEGHDAR_PRE=farsinum($MEGHDAR_PRE);
		
	    $MEGHDAR_EBTAL=farsinum($row['MEGHDAR_EBTAL']);
			$outHtml .= '
			<tr class='.$class.'>
				    <td align="center" style="vertical-align:middle;">'.$inx1.'</td>
			        <td align="center" style="vertical-align:middle;">'.$h_code.'</td>
			         <td align="center" style="vertical-align:middle;">'.$ph_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td align="center" style="vertical-align:middle;">'.$ph_mojavez.'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['p_name'].'</div>	
					<td align="center" style="vertical-align:middle;">'.$MEGHDAR_PRE.'</td>		
					<td align="center" style="vertical-align:middle;">'.$MEGHDAR_EBTAL.'</td>		
					<td align="center" style="vertical-align:middle;">'.$asli.'كيلوگرم</td>
		           <td align="center" style="vertical-align:middle;">'.$SUM_price.'ريال</td>';											
      $outHtml .= '<td align="center" style="vertical-align:middle;"> '.$row['l_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$h_customer_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcus['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['category_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['STATUS_EBTAL'].'</td>
					
					
					
				</tr>';
           $MEGHDAR =$row['MEGHDAR_PRE']-$row['MEGHDAR_EBTAL'];
           $amount=$amount+$MEGHDAR;
           $amountebtal=$amountebtal+$row['MEGHDAR_EBTAL'];
        $inx++;	
			
		}
		$amount =urlencode($amount);
		$amount=formatMoney($amount);
		$amount=farsinum($amount);
		$amountebtal =urlencode($amountebtal);
		$amountebtal=formatMoney($amountebtal);
		$amountebtal=farsinum($amountebtal);
		
		
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
    $outHtml .= '</table>
    </div>'.getNavBar_rhn().' '.getRPPCombo_rhn();
  //  echo $outHtml;
}

function getNavBar_rhn(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reph_num&firstNumber='.$_SESSION['firstNumber'].'&EndNumber='.$_SESSION['EndNumber'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&ph_mojavez1='.$_SESSION['ph_mojavez1'].'
		&category_id='.$_SESSION['category_id'].'
		&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=reph_num&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'&firstNumber='.$_SESSION['firstNumber'].'&EndNumber='.$_SESSION['EndNumber'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&ph_mojavez1='.$_SESSION['ph_mojavez1'].'&category_id='.$_SESSION['category_id'].'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=reportMgmtPg&cmd=reph_num&cmd2=setPg&pgNum='.($stNum+$inx).'&firstNumber='.$_SESSION['firstNumber'].'&EndNumber='.$_SESSION['EndNumber'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
			&category_id='.$_SESSION['category_id'].'&ph_mojavez1='.$_SESSION['ph_mojavez1'].'
			&city_id='.$_SESSION['city_id'].'
			" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reph_num&firstNumber='.$_SESSION['firstNumber'].'&EndNumber='.$_SESSION['EndNumber'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&category_id='.$_SESSION['category_id'].'&ph_mojavez1='.$_SESSION['ph_mojavez1'].'
		&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&cmd=reph_num&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'&firstNumber='.$_SESSION['firstNumber'].'&EndNumber='.$_SESSION['EndNumber'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&ph_mojavez1='.$_SESSION['ph_mojavez1'].'&category_id='.$_SESSION['category_id'].'
		" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_rhn(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=reph_num&firstNumber='.$_SESSION['firstNumber'].'&EndNumber='.$_SESSION['EndNumber'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&category_id='.$_SESSION['category_id'].'
		&ph_mojavez1='.$_SESSION['ph_mojavez1'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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
function reph_datenew(){
	     $firstDate = !empty($_REQUEST['firstDate1']) ? $_REQUEST['firstDate1'] : '';
		 $EndDate = !empty($_REQUEST['EndDate1']) ? $_REQUEST['EndDate1'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_codeh']) ? $_REQUEST['p_codeh'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer1']) ? $_REQUEST['code_customer1'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_codeh']) ? $_REQUEST['p_price_codeh'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $phd_deli_name = !empty($_REQUEST['phd_deli_name']) ? $_REQUEST['phd_deli_name'] : '-2';
		 $ph_operation_id = !empty($_REQUEST['ph_operation_id']) ? $_REQUEST['ph_operation_id'] : '-2';
 		
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
         $_SESSION['category_id']=$category_id;
         $_SESSION['phd_deli_name']=$phd_deli_name;
                 
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef = $EndDate;
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;
 if($mfirstDate==$mEndDate){
		 	
	
//$mEndDate = strtotime ( '+1 day' , strtotime ( $mEndDate ) ) ;
//$mEndDate = date ( 'Y-m-d' , $mEndDate );
		 }
	//echo $mEndDate;
//	echo $mfirstDate;
// $gdate=$firstDate;
//	list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//	$firstDate = $jyear."/".$jmonth."/".$jday;			
								  		  	
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
	          ?>
			  <div align="left"> <a href="report/printhdatenew.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>&phd_deli_name=<?php echo $phd_deli_name ?>&ph_operation_id=<?php echo $ph_operation_id ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
			$outHtml = '';   
	
}
function repriz_date(){
	
         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_codeh']) ? $_REQUEST['p_codeh'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer1']) ? $_REQUEST['code_customer1'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_codeh']) ? $_REQUEST['p_price_codeh'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $phd_deli_name = !empty($_REQUEST['phd_deli_name']) ? $_REQUEST['phd_deli_name'] : '-2';
		 $ph_operation_id = !empty($_REQUEST['ph_operation_id']) ? $_REQUEST['ph_operation_id'] : '-2';
		 $sort_id = !empty($_REQUEST['sort_id']) ? $_REQUEST['sort_id'] : '1';
 		
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
         $_SESSION['category_id']=$category_id;
         $_SESSION['phd_deli_name']=$phd_deli_name;
         $_SESSION['sort_id']=$sort_id;
                 
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef = $EndDate;
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;
 if($mfirstDate==$mEndDate){
		 	
	
		 }
		
								  		  	
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
	          ?>
			  <div align="left"> <a href="report/printrizdate.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>&phd_deli_name=<?php echo $phd_deli_name ?>&ph_operation_id=<?php echo $ph_operation_id ?>&sort_id=<?php echo $sort_id ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
			$outHtml = '';   
	
	
}	
function reph_date(){


		 $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_codeh']) ? $_REQUEST['p_codeh'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer1']) ? $_REQUEST['code_customer1'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_codeh']) ? $_REQUEST['p_price_codeh'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $phd_deli_name = !empty($_REQUEST['phd_deli_name']) ? $_REQUEST['phd_deli_name'] : '-2';
		 $ph_operation_id = !empty($_REQUEST['ph_operation_id']) ? $_REQUEST['ph_operation_id'] : '-2';
		 $sort_id = !empty($_REQUEST['sort_id']) ? $_REQUEST['sort_id'] : '1';
		 $phd_tahator = !empty($_REQUEST['phd_tahator']) ? $_REQUEST['phd_tahator'] : '-2';
 		
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
         $_SESSION['category_id']=$category_id;
         $_SESSION['phd_deli_name']=$phd_deli_name;
         $_SESSION['sort_id']=$sort_id;
         $_SESSION['phd_tahator']=$phd_tahator;
                 
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef = $EndDate;
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;
 if($mfirstDate==$mEndDate){
		 	
	
//$mEndDate = strtotime ( '+1 day' , strtotime ( $mEndDate ) ) ;
//$mEndDate = date ( 'Y-m-d' , $mEndDate );
		 }
	//echo $mEndDate;
//	echo $mfirstDate;
// $gdate=$firstDate;
//	list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//	$firstDate = $jyear."/".$jmonth."/".$jday;			
								  		  	
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
	          ?>
			  <div align="left"> <a href="report/printhdate.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>&phd_deli_name=<?php echo $phd_deli_name ?>&ph_operation_id=<?php echo $ph_operation_id ?>&sort_id=<?php echo $sort_id ?>&phd_tahator=<?php echo $phd_tahator ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
			$outHtml = '';   

	
		
}

function getNavBar_rhdate(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&cmd2=setPg&pgNum=1&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
		&city_id='.$_SESSION['city_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'
		&category_id='.$_SESSION['category_id'].'" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'
		&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
			&ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'
			&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&category_id='.$_SESSION['category_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&cmd=reph_num&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	//return $out;
}

function getRPPCombo_rhdate(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
		
		
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
function repM_date(){
	
	
         $firstDate = !empty($_REQUEST['firstDatem']) ? $_REQUEST['firstDatem'] : '';
		 $EndDate = !empty($_REQUEST['EndDatem']) ? $_REQUEST['EndDatem'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez']) ? $_REQUEST['ph_mojavez'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '';
		 $_SESSION['firstDatef']=$firstDate;
		 $_SESSION['EndDatef']=$EndDate;
		 $firstDatef=$firstDate;
		 $EndDatef=$EndDate;			  
         $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
        
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
		 
         
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
    $mfirstDate= $firstDate; 
    $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
// $gdate=$firstDate;
//	list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//	$firstDate = $jyear."/".$jmonth."/".$jday;			
								  		  	
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
	
	       ?>
			  <div align="left"> <a href="report/printmdate.php?province_id=<?php echo $province_id ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $EndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>&code_customer=<?php echo $code_customer ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php    
	
		
	$outHtml .= '	
		<div align = "center">
		<div align = "center" style="width:70%;height:200px; overflow:auto">
			<table  align="center" cellpadding="0" cellspacing="0" class="list" border="1" >
      			<tr class="rw1">
        			<th colspan="21" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش معرفي نامه </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">رديف </td>
			        <td align="center"> شماره معرفي نامه</td>
			        <td align="center"> تاريخ معرفي نامه</td>
			        <td align="center"> نام کالا</td>
			        <td align="center"> نوع كالا</td>
			        <td align="center">محل انبار</td>
			        <td align="center">نام مشتری </td>
			        <td align="center">كد مشتری</td>			    		        		        
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
					pf_code LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
//	$genQuery = "
//			From dm_pish_factor pf 
//			  left join dm_pish_havale ph
//                    on ph.ph_code=pf.pf_ph_code
//		      left join dm_pish_havale_det  ph_det
//					on  ph_det.phd_ph_code=ph.ph_code
//			  left join  dm_location_goods l
//					on l.l_id=ph_det.phd_l_id
//			  left join  dm_product prod
//					on  ph_det.phd_pid=prod.p_code
//			  left join dm_price price 
//				    on  prod.p_id = price.price_p_id   
//			  inner join dm_prod_det_t  prod_t
//				   on prod_t.type_prod_id=prod.p_type     
//			  inner join dm_prod_det_p prod_p
//				  on prod_p.pack_prod_id=prod.p_pakage_type    
//			  inner join dm_prod_det_c prod_c
//				 on prod_c.cat_prod_id=prod.p_category
//		WHERE 
//			1 
//			".$srchQ." 
//			".$typeQ." 
//	   	AND
//		    pf_reg_date between  ('".$firstDate."')  AND  ('".$EndDate."')                                                                              
//        AND
//            pf_id_province=".$province_id."
//        AND
//            ph_id_province=".$province_id."
//        AND
//            price_id_province=".$province_id."
//         AND
//            pf_id_year=".$year_id." 
//         AND
//            l_id_province=".$province_id."
//          AND
//          pf_type=". 1 ."  
//            
//            ";
//	if ($p_code != -2){
//		
//		$genQuery .= " AND h_p_code=". $p_code ."";
//	}
//if ($p_price_code != -2){
//		
//		$genQuery .= " AND p_price_code=". $p_price_code ."";
//	}
//if ($p_type != -2){
//		
//		$genQuery .= " AND p_type=". $p_type ."";
//	}
//if ( $p_category != -2){
//		
//		$genQuery .= " AND  p_category=".$p_category ."";
//	}
//if ($l_id != -2){
//		
//		$genQuery .= " AND  h_l_code=".$l_id ."";
//	}
//if ($code_customer != -2){
//		
//		$genQuery .= " AND  h_customer_code=".$code_customer ."";
//	}
//if ($p_pakage_type != -2){
//		
//		$genQuery .= " AND   p_pakage_type=".$p_pakage_type ."";
//	}
//if ($p_subsidies != -2){
//		
//		$genQuery .= " AND   p_subsidies=". $p_subsidies ."";
//	}	
//	$countQuery = "
//		SELECT 
//			COUNT(*) elmCount  
//	".$genQuery;
	//$lnk = mysql_query($countQuery);
	//$cntRow = mysql_fetch_assoc($lnk);
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
	
	///print($resQuery);
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk)){
			
			if(($inx)%2==1)
				$class="rw1";
				else
				$class="rw0";
			
				$gdate=$row['pf_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;												
							$querycus = "
								 	SELECT *  FROM dm_customer	customer
								 	left join 	dm_customer_category category
								 	on 	
								 	customer.customer_category=category.category_id		 
								WHERE 
									code_customer=".$row['ph_customer_code']."									
								AND
		                            customer_code_org=".$province_id."";												
								$lnkcus = mysql_query($querycus);
								$rowcus = mysql_fetch_assoc($lnkcus);
					
							//	print $querycus;
																	
			$outHtml .= '
			
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pf_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['p_name'].'</div>					
					<td align="center" style="vertical-align:middle;">'.$row['type_prod_name'].'</td>
				    <td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcus['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcus['code_customer'].'</td>
				</tr>';			
 //  		    <td ><a href="?pg=havaleMgmtPg&cmd=EbtalHavale&h_id='.$row['h_id'].'">ابطال </a></td>			
			$inx++;
		}
				
		
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
    $outHtml .= '</table>
    </div>'.getNavBar_rmdate().' '.getRPPCombo_rmdate();
  //  echo $outHtml;
		
}

function getNavBar_rmdate(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=repM_date&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=repM_date&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=havaleMgmtPg&cmd=repM_date&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=repM_date&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&cmd=repM_date&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_rmdate(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=repM_date&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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
function repM_num(){
	

	
	     $firstNumber = isset($_REQUEST['firstNumber']) ? $_REQUEST['firstNumber'] : '';
		 $EndNumber = isset($_REQUEST['EndNumber']) ? $_REQUEST['EndNumber'] : '';
		// echo $firstNumber;
	   //  echo $EndNumber;
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez']) ? $_REQUEST['ph_mojavez'] : '';
		 $_SESSION['firstDatef']=$firstDate;
		 $_SESSION['EndDatef']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;		  
		 

// $gdate=$firstDate;
//	list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//	$firstDate = $jyear."/".$jmonth."/".$jday;			
								  		  	

	 ?>
			  <div align="left"> <a href="report/printmnum.php?province_id=<?php echo $province_id ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstNumber=<?php echo $firstNumber ?>&EndNumber=<?php echo $EndNumber ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
	           
	
  //  echo $outHtml;
		
}

function getNavBar_rmnum(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=repM_num&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=repM_num&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=havaleMgmtPg&cmd=repM_date&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=repM_num&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&cmd=repM_num&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_rmnum(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=repM_num&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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
function repinspect(){
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['category_id']=$category_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
        $firstDatef  =$firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       
		$EndDatef=$EndDate;
		 
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

// $gdate=$firstDate;
//	list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//	$firstDate = $jyear."/".$jmonth."/".$jday;			
								  		  	
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
	          ?>
			  <div align="left"> <a href="report/printinspect.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&EndDatef=<?php echo $EndDatef ?>&firstDatef=<?php echo $firstDatef ?>
			  
			  
			  &category_id=<?php echo $category_id ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php  
			$outHtml = '';   
//	$outHtml = '<br>	
//		<form method="get" action="">
//			<input type="hidden" name="pg" value="havaleMgmtPg">   
//			<input type="hidden" name="cmd" value="searchCodeebtal"> 
//			<b> كد  مورد نظر را جستجو كنيد </b>
//			<div>  <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:60px;" /> 
//			<button type="submit" name="Search" value="Search" >جستجو</button></div>
//		</form>
//		<br>';
?>
		<form action="lib/php/exporttoexcel.php" method="post"    
   onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'> 
  <?php  
	
 //   echo $outHtml;
		
}
function getNavBar_rins(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=repinspect&cmd2=setPg&pgNum=1&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
		" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=repinspect&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
		&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=reportMgmtPg&cmd=repinspect&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
			&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=repinspect&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
		&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&cmd=repinspect&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
		&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_rins(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=repinspect&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
		
		
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
function repfinance(){
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	$EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
	          ?>
		<!--	  <div align="left"> <a href="report/printfinance1.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>" target="_blank"><img src="images/print.png" width="100" height="100" title="print"  > </img></a></div> -->
			<!--<?php  
			
			  ?>
			  <div align="left"> <a href="report/printNewFinance.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>" target="_blank">فرم جديد دارائی</a></div>
			<?php
			  ?>-->
			  <div align="left"> <a href="report/finance1.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>" target="_blank">ايجاد فايل دارايی</a></div>
			   
			<!--<?php
		if($_SESSION['dm_user_profile']['u_id']==3)
			{
				 ?>
			  <div align="left"> <a href="report/finance1.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>" target="_blank">ایجاد فایل دارایی جدید</a></div>
		   
			<?php	
			}
//			$querypro="SELECT * FROM dm_province 
//									    WHERE
//									      province_id=".$_SESSION['dm_user_profile']['u_province_id']."
//									    ";									     	     											
//								$lnkpro = mysql_query($querypro);
//								$rowpro = mysql_fetch_assoc($lnkpro);
							//	print $querycus;
							 
			$outHtml = '';   

   ?>-->-->
		<form action="lib/php/exporttoexcel.php" method="post"    
   onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'> 
  <?php  
//	$outHtml .= '
//	
//		<div align = "center">
//		<div align = "center" style="width:100%;height:400px; overflow:auto;direction:rtl;">
//			<table   id="ReportTable" align="center" cellpadding="0" cellspacing="0" class="list" border="1" style="direction:rtl;">
//      			<tr class="rw1">
//        			<td colspan="15" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش حواله براي اداره دارائي </center> </td>
//        		</tr>
//        		<tr class="rw1">
//        			<td   colspan="15" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
//        			&nbsp;&nbsp;&nbsp;
//        			&nbsp;&nbsp;&nbsp;
//        			  تا تاريخ    :
//        			 '.$EndDatef.'  </td>
//        			
//        		</tr>
//        		<tr class="rw1">
//        			<td   colspan="6" style="height: 50px;vertical-align:middle;"> كد اقتصادي فروشنده  : '.$rowpro['province_ecode'].'  </td>
//        			
//        			<td   colspan="9" style="height: 50px;vertical-align:middle;">  آدرس فروشنده   :
//        			<p> '.$rowpro['province_address'].'</p>  </td>
//        			
//        		</tr>
//      			<tr class="rw0" style="font-weight:bold;">
//			        <td align="center">رديف </td>
//			        <td align="center"> کد خریدار</td>
//			        <td align="center"> نام خریدار</td>
//			         <td align="center"> كد كالا</td>
//			        <td align="center">كد قيمت</td>
//			        <td align="center"> مقدار کالا</td>
//			        <td align="center"> دسته کالا</td>
//			        <td align="center">مقدار ابطال شده</td>
//			        <td align="center">مقدار صادره </td>
//			          <td align="center">مبلغ قابل پرداخت </td>			        
//			        <td align="center">كد ملى/اقتصادي خریدار</td>
//			        <td align="center">تلفن خریدار</td>
//			        <td align="center">شهر</td>
//			         <td align="center">كدپستى خريدار</td>
//			        <td align="center">آدرس خریدار</td>
//			        	    		        		        
//				</tr>';
		
//	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
//	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
//	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
//	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
//	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
//	if($_SESSION['srchStr']==''){
//		$srchQ = "";
		
//	}else{
//		
//		
//	}
	//$typeQ = '';
//	$province_id=$_SESSION['dm_user_profile']['u_province_id'];
//	$genQuery = "
//			 from dm_havale h 
//      left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$province_id." 
//
//      left join dm_price price on p.p_id=price.price_p_id and price.`p_price_code`=h.`h_price_code`
//      left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type 
//      left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
//      left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
//      left join dm_location_goods l on l.l_id=h.h_l_code 
//      left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province=".$province_id."
//      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code and ph_id_province=".$province_id." 
//      left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
//      left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1 and ebt.ebh_id_province=".$province_id." and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."' ) 
//      left join dm_ebtal_h ebt2 on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 and ebt2.ebh_id_province=".$province_id." and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
//        where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
//  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
//  and ph_id_province=".$province_id." )and(  ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
//  
//  or
//
//   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
//  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
//  ph_id_province=".$province_id." )
//and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
//
//
//  )
//        ".$srchQ." 
//		".$typeQ."
//		         ";
//
//   if ($p_code != -2){
//		
//		$genQuery .= "  AND h_p_code= ". $p_code ." ";
//	}
//if ($p_price_code != -2){
//		
//		$genQuery .= " AND p_price_code= ". $p_price_code ." ";
//	}
//if ($p_type != -2){
//		
//		$genQuery .= " AND p_type= ". $p_type ." ";
//	}
//if ( $p_category != -2){
//		
//		$genQuery .= " AND  p_category= ".$p_category ." ";
//	}
//if ($l_id != -2){
//		
//		$genQuery .= " AND  h_l_code= ".$l_id ." ";
//	}
//
//if ($p_pakage_type != -2){
//		
//		$genQuery .= " AND   p_pakage_type= ".$p_pakage_type ." ";
//	}
//if ($p_subsidies != -2){
//		
//		$genQuery .= " AND   p_subsidies= ". $p_subsidies ." ";
//	}	
//	if ($city_id != -2){
//		 
//		$genQuery .= "  AND   customer_cusid_city= ". $city_id ." ";
//	}
//	$genQuery .= "	group by `h_code` )  ";
//	$genQuery .= " as c left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id." 
//        left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id";					 
//	if ($code_customer != -2){
//		
//		$genQuery .= " AND  h_customer_code= ".$code_customer ." ";
//	}
//	$genQuery .= " group by  cus2.code_customer , p_code, p_price_code
//         ORDER BY  cus2.code_customer ,p_name, p_price_code asc";
//	$countQuery = "
//		SELECT 
//			COUNT(*) elmCount from (  
//	".$genQuery;
////	print $genQuery;
//	$lnk = mysql_query($countQuery);
//	$cntRow = mysql_fetch_assoc($lnk);
//	$_SESSION['elmCount'] = $cntRow['elmCount'];
//	
//	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
//	if($pageCount != (int)($pageCount)) $pageCount++;
//	$pageCount = (int) $pageCount;
//	$_SESSION['pageCount'] = $pageCount; 
//	
//	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
//	
//	$resQuery = "
//		 select cus2.code_customer ,p_name, p_price_code,`cat_prod_name`
//        ,h_customer_code
//		 ,sum(shavale)   shavale
//		 ,sum(sebtal)  sebtal
//		 ,`name_customer`
//		 ,`code_economic_customer`
//		 ,`customer_tel`
//		 ,p_code
//		 
//		 ,`customer_cusid_city`
//		 ,`customer_address_office`
//		 ,sum(SUM_price)  sprice
//		 ,code_postal_costumer
//      
//
// from ( select h_code , ph_code , h_reg_date , ph_mojavez , p_name ,p_code, p_sellprice , h_amount , l_name,p_price_code ,cat_prod_name
//  , h_customer_code , case when h.`h_status` = 1 then 'ابطال کلي' else case when his.his_h_id is null
//   then 'ابطال نشده' else 'ابطال جزئي' end end as STATUS_EBTAL , case when h.`h_status` = 1 then h.`h_amount`
//    else case when his.his_h_id is null then 0 else his.`his_eb_amount` end end as sebtal ,
//     case when h.`h_status` = 1 then h.`h_amount` else case when his.his_h_id is null then h.`h_amount`
//      else SUM( his.`his_eb_amount`) + h.`h_amount` end end as shavale , case when h.`h_status` = 1 
//      then 0 else case when his.his_h_id is null then h.h_price else h.h_price end end as SUM_price 
//      
//	".$genQuery.$limitQ;
////	print($resQuery);
//		$_SESSION['srchStr'] = '';
//	$lnk = mysql_query($resQuery);
//	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
//	$amount=0;
//	$ebtal=0;
//	if(mysql_affected_rows()>0){
//		
//	
//		while($row = mysql_fetch_assoc($lnk)){
//
//			if(($inx)%2==1)
//				$class="rw1";
//				else
//				$class="rw0";
//			
//				$gdate=$row['h_reg_date'];
//			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//			$jdate = $jyear."/".$jmonth."/".$jday;												
//								$querycus="SELECT * FROM dm_customer 
//									    WHERE
//									      code_customer=".$row['h_customer_code']."
//									    AND
//									     customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']."";									     	     											
//								$lnkcus = mysql_query($querycus);
//								$rowcus = mysql_fetch_assoc($lnkcus);
//					          $querycity="SELECT * FROM dm_city 
//									    WHERE
//									      city_id=".$row['customer_cusid_city']."
//									    ";									     	     											
//								$lnkcity = mysql_query($querycity);
//								$rowcity = mysql_fetch_assoc($lnkcity);
//								if($row['shavale']> $row['sebtal']){
//									$mande=$row['shavale']-$row['sebtal'];
//								}else{
//									
//									$mande=$row['sebtal']-$row['shavale'];
//								}
//							
//			$outHtml .= '
//			
//				<tr class='.$class.'>
//					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
//					<td align="center" style="vertical-align:middle;">'.$row['code_customer'].'</td>
//					<td  align="center" style="vertical-align:middle;">'.$row['name_customer'].'</div>
//					<td  align="center" style="vertical-align:middle;">'.$row['p_code'].'</td>	
//					<td  align="center" style="vertical-align:middle;">'.$row['p_price_code'].'</td>							
//					<td align="center" style="vertical-align:middle;">'.$row['shavale'].'كيلوگرم</td>				  
//					<td align="center" style="vertical-align:middle;">'.$row['cat_prod_name'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$row['sebtal'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$mande.'</td>
//					<td align="center" style="vertical-align:middle;">'.$row['sprice'].'ريال</td>
//					<td align="center" style="vertical-align:middle;">'.$row['code_economic_customer'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$row['customer_tel'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$row['code_postal_costumer'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$row['customer_address_office'].'</td>
//					
//				</tr>';			
// //  		    <td ><a href="?pg=havaleMgmtPg&cmd=EbtalHavale&h_id='.$row['h_id'].'">ابطال </a></td>			
//			$inx++;
//			$amount=$amount+$mande;
//			$ebtal=$ebtal+$row['sebtal'];
//			
//		//	echo $amount;
//		}
//	//	echo '<div> جمع صادره:'.$amount.'كيلوگرم</div>' ;		
//		//echo '<div> جمع ابطالی:'.$ebtal.'كيلوگرم</div>' ;		
//    		
//		
//    }else{
//    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست</td></tr>';
//    }
//    $outHtml .= '</table>
//                
//    </div>'.getNavBar_rf().' '.getRPPCombo_rf();
//    $outHtml .= '
//     <table width="600px" cellpadding="2" cellspacing="2" border="0">  
//	    <tr>  
//	      <td>&nbsp;</td>  
//	    </tr>  
//	    <tr>  
//	      <td align="center"><input type="hidden" id="datatodisplay" name="datatodisplay">  
//	        <input type="submit" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:100px;" value="خروجی در اکسل">  
//	      </td>  
//	    </tr>  
//  </table>  
//</form> ';
    echo $outHtml;
		
}
//function getNavBar_rf(){
//	$out = '
//		<table style="direction:ltr" >
//			<tr>
//			
//	';
//	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
//	
//	$stNum = $_SESSION['crntPage']-5;
//	if($stNum<1) $stNum=1;
//	$out .= '
//		<td><a href="?pg=reportMgmtPg&cmd=repfinance&cmd2=setPg&pgNum=1&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
//		" ><img src="images/first.gif" title="ابتدا"></img></a></td>
//	    <td>&nbsp;&nbsp;</td>		    
//		<td><a href="?pg=reportMgmtPg&cmd=repfinance&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
//		&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
//		 <td>&nbsp;&nbsp;</td>  
//	';
//	$inx = 0;
//	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
//		$out .= '
//			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=reportMgmtPg&cmd=repfinance&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&city_id='.$_SESSION['city_id'].'city_id
//			&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
//			<td>&nbsp;</td> 
//		';
//		
//		$inx++;
//	}
//	$out .= '
//		<td><a href="?pg=reportMgmtPg&cmd=repfinance&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
//		&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
//		<td>&nbsp;&nbsp;</td> 
//		<td><a href="?pg=reportMgmtPg&cmd=repfinance&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
//		&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
//	';
//	
//	$out .= '
//			</tr>
//		</table>
//	';	
//	return $out;
//}

//function getRPPCombo_rf(){
//	$out = '
//	
//		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=repfinance&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
//		
//		
//			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
//			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
//			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
//			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
//			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
//			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
//			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
//		</select>
//		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
//	';
//	return $out;
//}	
function  repebtali(){	
  $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code1']) ? $_REQUEST['p_code1'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer1']) ? $_REQUEST['code_customer1'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code1']) ? $_REQUEST['p_price_code1'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 		
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
         $_SESSION['category_id']=$category_id;
                 
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef = $EndDate;
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;
 if($mfirstDate==$mEndDate){
		 	
	
//$mEndDate = strtotime ( '+1 day' , strtotime ( $mEndDate ) ) ;
//$mEndDate = date ( 'Y-m-d' , $mEndDate );
		 }
	//echo $mEndDate;
//	echo $mfirstDate;
// $gdate=$firstDate;
//	list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//	$firstDate = $jyear."/".$jmonth."/".$jday;			
								  		  	
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
	          ?>
			  <div align="left"> <a href="report/printebtali.php?province_id=<?php echo $province_id ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
			$outHtml = '';   
////	$outHtml = '<br>	
////		<form method="get" action="">
////			<input type="hidden" name="pg" value="havaleMgmtPg">   
////			<input type="hidden" name="cmd" value="searchCodeebtal"> 
////			<b> كد  مورد نظر را جستجو كنيد </b>
////			<div>  <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:60px;" /> 
////			<button type="submit" name="Search" value="Search" >جستجو</button></div>
////		</form>
////		<br>';
//		
//	$outHtml .= '	
//		<div align = "center">
//		<div align = "center" style="width:90%;height:300px; overflow:auto">
//			<table  align="center" cellpadding="0" cellspacing="0" class="list" border="1" >
//      			<tr class="rw1">
//        			<th colspan="21" align4="center" style="height: 50px;vertical-align:middle;"><center> گزارش حواله هاي ابطالی </center> </th>
//        		</tr>
//        		<tr class="rw1">
//        			<td   colspan="17" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
//        			&nbsp;&nbsp;&nbsp;
//        			&nbsp;&nbsp;&nbsp;
//        			  تا تاريخ    :
//        			 '.$EndDatef.'  </td>
//        			
//        		</tr>
//      			<tr class="rw0" style="font-weight:bold;">
//			        <td align="center">رديف </td>			      
//			        <td align="center"> شماره حواله</td>
//			         <td align="center"> شماره پيش نويس</td>
//			        <td align="center"> تاريخ حواله</td>
//			        <td align="center"> شماره مجوز</td>
//			        <td align="center">نام کالا</td>
//			        <td align="center">قيمت واحد </td>
//			        <td align="center"> مقدار اولیه خرید</td>
//			        <td align="center">مقدار ابطالی</td>
//			        <td align="center"> مقدار جاری</td>
//			        <td align="center"> مبلغ قابل پرداخت</td>
//			        <td align="center">محل انبار</td>
//			        <td align="center">کد مشتري </td>
//			        <td align="center">نام مشتري</td>
//			         <td align="center">دسته بندي مشتري</td>
//			        <td align="center">نام شهر</td>	
//			        <td align="center">وضعیت</td>	
//			       				    		        		        
//				</tr>';
//		
//	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
//	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
//	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
//	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
//	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
//	if($_SESSION['srchStr']==''){
//		$srchQ = "";
//		
//	}else{
//		
//		
//	}
//	$typeQ = '';
//		$province_id=$_SESSION['dm_user_profile']['u_province_id'];
//	$genQuery = "  from ( select h_code , ph_code , p_code, p_price_code, h_reg_date ,
// ph_mojavez , p_name , p_sellprice , h_amount ,
//  l_name , h_customer_code , case when h.`h_status` = 1 
//  then 'ابطال کلی' else case when his.his_h_id is null 
//  then 'ابطال نشده' else 'ابطال جزئی' end end as STATUS_EBTAL ,
//   case when h.`h_status` = 1 then h.`h_amount` else 
//   case when his.his_h_id is null then 0 else his.`his_eb_amount` 
//   end end as MEGHDAR_EBTAL , case when h.`h_status` = 1 
//   then h.`h_amount` else case when his.his_h_id is null 
//   then h.`h_amount` else SUM( his.`his_eb_amount`) + h.`h_amount` end 
//   end as MEGHDAR_PRE , case when h.`h_status` = 1 then 0 else 
//   case when his.his_h_id is null then h.h_price else h.h_price 
//   end end as SUM_price from dm_havale h 
//   left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."     
//   left join dm_price price on p.p_id=price.price_p_id 
//   and price.`p_price_code`=h.`h_price_code` 
//   left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type 
//   left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
//   left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
//   left join dm_location_goods l on l.l_id=h.h_l_code 
//   left join dm_pish_factor pf on h.h_pf_code=pf.pf_code 
//   and pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']." left join dm_pish_havale ph 
//   on ph.ph_code=pf.pf_ph_code and ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
//   left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
//   left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1 
//   and ebt.ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
//   and (ebt.ebh_reg_date between '".$mfirstDate."' AND  '".$mEndDate."'
//   )
//  left join dm_ebtal_h ebt2 
//  on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 
// and ebt2.ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
//  and (ebt2.ebh_reg_date between '".$mfirstDate."' AND  '".$mEndDate."'
// )
//    where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
//  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
//  and ph_id_province=".$province_id." )and(  ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' )
//  
//  or
//
//   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
//  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
//  ph_id_province=".$province_id." )
//and (ebt2.ebh_reg_date between '".$mfirstDate."' AND  '".$mEndDate."' )
//
//
//  )
//  
//			".$typeQ." 
//	                                                                               
//        " ;
//if ($p_code != -2){
//		
//		$genQuery .= "  AND p_code= ". $p_code ." ";
//	}
//if ($p_price_code != -2){
//		
//		$genQuery .= " AND p_price_code= ". $p_price_code ." ";
//	}
//if ($p_type != -2){
//		
//		$genQuery .= " AND p_type= ". $p_type ." ";
//	}
//if ( $p_category != -2){
//		
//		$genQuery .= " AND  p_category= ".$p_category ." ";
//	}
//if ($l_id != -2){
//		
//		$genQuery .= " AND  h_l_code= ".$l_id ." ";
//	}
//
//if ($p_pakage_type != -2){
//		
//		$genQuery .= " AND   p_pakage_type= ".$p_pakage_type ." ";
//	}
//if ($p_subsidies != -2){
//		
//		$genQuery .= " AND   p_subsidies= ". $p_subsidies ." ";
//	}	
//	
//	if ($ph_mojavez != -2){
//		 
//		$genQuery .= "  AND   ph_mojavez= ". $ph_mojavez ." ";
//	}
//	
//	
//	$genQuery .= " group by `h_code` 
//         ) as c 
//          
//          left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$_SESSION['dm_user_profile']['u_province_id']."
//          ";
//	if ($code_customer != -2){
//		
//		$genQuery .= " AND  h_customer_code= ".$code_customer ." ";
//	}if ($city_id != -2){
//		 
//		$genQuery .= "  AND   customer_cusid_city= ". $city_id ." ";
//	}
//	
//	$genQuery .= "left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id  ";
//         
//	if ($category_id != -2){
//		 
//		$genQuery .= "  AND   category_id= ". $category_id ." ";
//	}
//if ($code_customer != -2){
//		
//		$genQuery .= " where  h_customer_code= ". $code_customer ." ";
//	}
//	$genQuery .=" ORDER BY h_code asc";
//	$countQuery = "
//		SELECT 
//			COUNT(*) elmCount  
//	".$genQuery;
//	
//	$lnk = mysql_query($countQuery);
//	$cntRow = mysql_fetch_assoc($lnk);
//	$_SESSION['elmCount'] = $cntRow['elmCount'];
//	
//	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
//	if($pageCount != (int)($pageCount)) $pageCount++;
//	$pageCount = (int) $pageCount;
//	$_SESSION['pageCount'] = $pageCount; 
//	
//	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
//	
//	$resQuery = "
//		select c.* ,cus2.* 
//		,cuscat.category_name  
//	".$genQuery.$limitQ;
////	print($resQuery);
//		$_SESSION['srchStr'] = '';
//	$lnk = mysql_query($resQuery);
//	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
//	$amount=0;
//	$amountebtal=0;
//	if(mysql_affected_rows()>0){
//
//		while($row = mysql_fetch_assoc($lnk)){
//			
//			
//			if(($inx)%2==1){
//				$class="rw1";
//				if( $row['h_status']==1){
//					$class="rw3";
//				}
//			}
//				else{
//				$class="rw0";
//				}
//			
//				$gdate=$row['h_reg_date'];
//			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//			$jdate = $jyear."/".$jmonth."/".$jday;												
//								$querycus="SELECT * FROM dm_customer 
//									    WHERE
//									      code_customer=".$row['h_customer_code']."
//									    AND
//									     customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']."";									     	     											
//								$lnkcus = mysql_query($querycus);
//								$rowcus = mysql_fetch_assoc($lnkcus);
//									$querycity="SELECT * FROM dm_city 
//									    WHERE
//									      city_id=".$rowcus['customer_cusid_city']."
//									    ";									     	     											
//								$lnkcity = mysql_query($querycity);
//								$rowcity = mysql_fetch_assoc($lnkcity);
//					
//							$asli=$row['MEGHDAR_PRE'] - $row['MEGHDAR_EBTAL'];
//							$asli =urlencode($asli);
//							$inx1 =urlencode($inx);
//                            $inx1=farsinum($inx1);
//			$outHtml .= '
//			
//				<tr class='.$class.'>
//					<td align="center" style="vertical-align:middle;">'.$inx1.'</td>';
//
//$h_code=farsinum($row['h_code']);
//$ph_mojavez=farsinum( $row['ph_mojavez']);
//$ph_code =urlencode($row['ph_code']);
//$ph_cod=farsinum($ph_code);
//$p_sellprice=farsinum($row['p_sellprice']);
//$asli=farsinum($asli);
//$SUM_price=farsinum($row['SUM_price']);
//$h_customer_code=farsinum($row['h_customer_code']);
//$MEGHDAR_PRE=farsinum($row['MEGHDAR_PRE']);
//$MEGHDAR_EBTAL=farsinum($row['MEGHDAR_EBTAL']);
//$jdate=farsinum($jdate);
//
//
//		$outHtml .= '<td align="center" style="vertical-align:middle;">'.$h_code.'</td>
//		             <td align="center" style="vertical-align:middle;">'.$ph_cod.'</td>
//					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
//				    <td align="center" style="vertical-align:middle;">'.$ph_mojavez.'</td>
//					<td  align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>
//					<td  align="center" style="vertical-align:middle;">'.$p_sellprice.'ريال</td>
//					<td align="center" style="vertical-align:middle;">'.$MEGHDAR_PRE.'</td>	
//					<td align="center" style="vertical-align:middle;">'.$MEGHDAR_EBTAL.'</td>									
//					<td align="center" style="vertical-align:middle;">'.$asli.'كيلوگرم</td>
//		            <td align="center" style="vertical-align:middle;">'.$SUM_price.'ريال</td>';
//
//  $outHtml .= '<td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$h_customer_code.'</td>
//					<td align="center" style="vertical-align:middle;">'.$rowcus['name_customer'].'</td>
//				   <td align="center" style="vertical-align:middle;">'.$row['category_name'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>
//					<td align="center" style="vertical-align:middle;">'.$row['STATUS_EBTAL'].'</td>
//				
//					
//					
//				</tr>';			
// //  		    <td ><a href="?pg=havaleMgmtPg&cmd=EbtalHavale&h_id='.$row['h_id'].'">ابطال </a></td>	
//       
//  
//		 $MEGHDAR =$row['MEGHDAR_PRE']-$row['MEGHDAR_EBTAL'];
//           $amount=$amount+$MEGHDAR;
//           $amountebtal=$amountebtal+$row['MEGHDAR_EBTAL'];
//			$inx++;
//			  
//		}
////		
////		 $amountebtal =urlencode($amountebtal);
////         $amountebtal=farsinum($amountebtal);
////         $amount =urlencode($amount);
////         $amount=farsinum($amount);	
//		
//    }else{
//    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست</td></tr>';
//    }
//    $outHtml .= '</table>
//    </div>'.getNavBar_ebt().' '.getRPPCombo_ebt();
//    echo $outHtml;
		
}

function getNavBar_ebt(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&cmd2=setPg&pgNum=1&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
		&city_id='.$_SESSION['city_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'
		&category_id='.$_SESSION['category_id'].'" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'
		&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
			&ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'
			&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&category_id='.$_SESSION['category_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&cmd=reph_num&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_ebt(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
		
		
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
function dspReportProddayFrm(){
	
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
              
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
	
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="repfinance" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش حواله براي اداره دارائي</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				<tr>
				       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
				       <td>بسته بندي کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
				</tr>
				<tr>
				       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				</tr>										
				<tr>  
				       <td>کد مشتري: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندي:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتري:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
				</tr>
				<tr>  
			       <td>نام شهر: </td><td>'.getcityNameCombo('city_id').'</td>
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;	
}
function dspReptajamokFrm1(){
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=reptajamok1">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">  گزارش تجمعي فروش کالا بر اساس کالاها</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				<tr>
				       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>
				       <td>ترتیب بر اساس </td><td>'. getsortCombo1('sort_id').'</td>										     
				</tr>';
			//	<tr>
			//	       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
			//	       <td>بسته بندي کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
			//	</tr>
			//	<tr>
				//       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				//       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				//</tr>';										
				//<tr>  
				//       <td>کد مشتري: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				//       <td>نوع دسته بندي:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
			//	</tr>';
//				 <tr>
//					 <td>نوع مشتري:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
//				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
//				</tr>
//				<tr>  
//			       <td>نام شهر: </td><td>'.getcityNameCombol('city_id').'</td>
//			         <td>نام استان: </td>
//				</tr>';

$lnk = mysql_query("SELECT * FROM  dm_province");
		if(mysql_num_rows($lnk)>0){
			$i=1;
			$out .= '	
	         <tr style="overflow:auto;">
	           <td>'.$i.'</td>
				<td>همه استان ها</td>
				<td><input type="checkbox"  name="check_all_box" id="check_all_box" onclick="check_all()"    value="'. 600 .'" /></td>
			</tr></div>';
			$i=2;
			$out .= '	
	         <tr style="overflow:auto;">';
			$i=1;
			while($row=mysql_fetch_assoc($lnk)){
				
	           $out .= ' <td>'.$i.'</td>
				<td>'. $row['province_name'].'</td>
				<td><input type="checkbox"  name="prov_list['.$i.']" id="checkbox'.$i.'"  value="'.$row['province_id'].'" /></td>';
		 $out .= '</tr></div>';
				$i++;		
			}
		}
			
	$out .='</table>';
$out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
</form>';

return $out;
	
}
function dspRepnahade()
{
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=repnahade">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش فروش نهاده</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>از ساعت:</td><td><input name="firstHour"  type="text" /></td>
				</tr>
				<tr>
					   
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
					   <td>تا ساعت:</td><td><input name="EndHour"  type="text" /></td>
				</tr>
				';

$out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
				<tr>
				 <td colspan="5" align="center">&nbsp;</td>
				</tr>
</form>';

return $out;
	
	
	
	
	
	
}
function dspRepmeatahen(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=repmeatahen">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش فروش گوشت قرمز و گوشت مرغ</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				';

       $out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
				<tr>
				 <td colspan="5" align="center">&nbsp;</td>
				</tr>
</form>';

return $out;
	
	
	
}

function dspRepgosht(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=repgosht">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش فروش گوشت قرمز</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				';

$out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
				<tr>
				 <td colspan="5" align="center">&nbsp;</td>
				</tr>
</form>';

return $out;
	
	
	
	
}
function dspRepchi(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=repchi">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش فروش گوشت مرغ</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				';

$out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
				<tr>
				 <td colspan="5" align="center">&nbsp;</td>
				</tr>
</form>';

return $out;
	
	
	
	
}

function dspRepfaravarde(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=repfaravarde">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش فروش فراورده</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>از ساعت:</td><td><input name="firstHour"  type="text" /></td>
				</tr>
				<tr>
					   
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
					   <td>تا ساعت:</td><td><input name="EndHour"  type="text" /></td>
				</tr>';
				

$out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
				<tr>
				 <td colspan="5" align="center">&nbsp;</td>
				</tr>
</form>';

return $out;
	
	
	
	
}
function dspReptajamokhFrm(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=reptajamokh">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش تجمعى فروش كالا</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>از ساعت:</td><td><input name="firstHour"  type="text" /></td>
				</tr>
				<tr>
					   
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
					   <td>تا ساعت:</td><td><input name="EndHour"  type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				<tr>
				       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				</tr>';
			//	<tr>
			//	       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
			//	       <td>بسته بندي کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
			//	</tr>
			//	<tr>
				//       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				//       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				//</tr>';										
				//<tr>  
				//       <td>کد مشتري: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				//       <td>نوع دسته بندي:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
			//	</tr>';
//				 <tr>
//					 <td>نوع مشتري:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
//				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
//				</tr>
//				<tr>  
//			       <td>نام شهر: </td><td>'.getcityNameCombol('city_id').'</td>
//			         <td>نام استان: </td>
//				</tr>';

$lnk = mysql_query("SELECT * FROM  dm_province");
		if(mysql_num_rows($lnk)>0){
			$i=1;
			$out .= '	
	         <tr style="overflow:auto;">
	           <td>'.$i.'</td>
				<td>همه استان ها</td>
				<td><input type="checkbox"  name="check_all_box" id="check_all_box" onclick="check_all()"    value="'. 600 .'" /></td>
			</tr></div>';
			$i=2;
			$out .= '	
	         <tr style="overflow:auto;">';
			$i=1;
			while($row=mysql_fetch_assoc($lnk)){
				
	           $out .= ' <td>'.$i.'</td>
				<td>'. $row['province_name'].'</td>
				<td><input type="checkbox"  name="prov_list['.$i.']" id="checkbox'.$i.'"  value="'.$row['province_id'].'" /></td>';
		 $out .= '</tr></div>';
				$i++;		
			}
		}
			
	$out .='</table>';
$out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
</form>';

return $out;
	
	
	
}
		
function dspReptajamokFrm(){
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=reptajamok">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش تجمعى فروش كالا</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				<tr>
				       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>
				       										     
			
 <td>تعداد خط در صفحه پرینت : </td><td><input type="text"   name="pnum"  ></input></td>
				<tr>';
			//	       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
			//	       <td>بسته بندي کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
			//	</tr>
			//	<tr>
				//       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				//       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				//</tr>';										
				//<tr>  
				//       <td>کد مشتري: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				//       <td>نوع دسته بندي:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
			//	</tr>';
//				 <tr>
//					 <td>نوع مشتري:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
//				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
//				</tr>
//				<tr>  
//			       <td>نام شهر: </td><td>'.getcityNameCombol('city_id').'</td>
//			         <td>نام استان: </td>
//				</tr>';

$lnk = mysql_query("SELECT * FROM  dm_province");
		if(mysql_num_rows($lnk)>0){
			$i=1;
			$out .= '	
	         <tr style="overflow:auto;">
	           <td>'.$i.'</td>
				<td>همه استان ها</td>
				<td><input type="checkbox"  name="check_all_box" id="check_all_box" onclick="check_all()"    value="'. 600 .'" /></td>
			</tr></div>';
			$i=2;
			$out .= '	
	         <tr style="overflow:auto;">';
			$i=1;
			while($row=mysql_fetch_assoc($lnk)){
				
	           $out .= ' <td>'.$i.'</td>
				<td>'. $row['province_name'].'</td>
				<td><input type="checkbox"  name="prov_list['.$i.']" id="checkbox'.$i.'"  value="'.$row['province_id'].'" /></td>';
		 $out .= '</tr></div>';
				$i++;		
			}
		}
			
	$out .='</table>';
$out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
</form>';

return $out;
	
}
function dspReptajamokFrmm(){
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
	   
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
	    </script>

              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
              
	
$out='<div align = "center" style="width:100%;height:400px; overflow:auto">
    <form method="POST" id="form1" name="form_check" action="?pg=reportMgmtPg&cmd=reptajamokm">
       <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش تجمعى فروش كالا</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				
				<tr>
					 <td ><center>نوع کالا </center> </td><td>'. getTypesComboBoxr('p_type').'</td>
					   <td>کد مشتری:</td><td><input name="code_customer" id="code_customer" type="text" /></td>
				</tr>
				<tr>';



			
	
$out .='							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr></table>
</form>';

return $out;
	
}
function dspReptajamocusFrm(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
              </script>
              
	<?php
	 //<td >شهر  </td>
                //     <td><span id="city_id" ></span></td> 
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
	
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="reptajamocus" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش تجمعى بر اساس مشتری</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>       
				</tr>
														
				<tr>  
				       <td>کد مشتری: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندی:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتری:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
				     <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     	 				
				</tr>
				<tr>
				<tr>  
				      <td>نوع عمليات: </td><td>'. getOperationComboBoxx('ph_operation_id').'</td>	
				      <td>شماره مجوز:</td><td><input name="ph_mojavez_hd" type="text"  /></td>
				       
				</tr>
				<tr>										
				      <td>نام محل مورد نظر:</td><td>'. getlocationNameCombo('l_id') .'</td>
				      <td>نام تحویل گیرنده:</td><td><input name="phd_deli_name" type="text"  /></td>
				      
				</tr>
				<tr>  
					 
		             <td >استان  </td>
                     <td>'. getProvinceCombox1('customer_cusid_province').'</td>
                     
                                        
		         </tr>
			  						
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;	
		
}
function dspReptajamomonthFrm(){
	
	$out='<form action="report/printmonth.php" target="_blank">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="reptajamo" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"  id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 
	    <input name="u_id"     type="hidden"  id="u_id"  value="'. $_SESSION['dm_user_profile']['u_id'] .'" type="text"/>	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش روزانه بر اساس ماه</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				
														
				
				
				<tr>  
				  <td>ماه عملکرد: </td><td>'.getmonth('month_num').'</td>
			       <td>دهه: </td><td>'.getdahe('dahe_num').'</td>
			       
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;	
	
}
function dspReptajamoFrm(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
	
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="reptajamo" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش تجمعى فروش كالا</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				<tr>
				       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
				       <td>بسته بندي کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
				</tr>
				<tr>
				       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				</tr>										
				<tr>  
				       <td>کد مشتري: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندي:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتري:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
				</tr>
				<tr>  
			       <td>نام شهر: </td><td>'.getcityNameCombol('city_id').'</td>
			         <td>نام استان: </td><td>'.getNameProvinceCombol('province_id').'</td>
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;	
	
}
function dspReptajamoFrm1(){
	
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	$(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
              
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
	
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="reptajamo1" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش تجمعى فروش كالا</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاريخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
				</tr>
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>
				       
				</tr>
				<tr>
				       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
				       <td>بسته بندي کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
				</tr>
				<tr>
				       <td>دسته بندي کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				</tr>										
				<tr>  
				       <td>کد مشتري: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندي:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتري:</td><td>'. gettypeCustomerNameCombo('personality_customer').'</td>															
				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
				</tr>
				<tr>  
			       <td>نام شهر: </td><td>'.getcityNameCombol('city_id').'</td>
			         <td>نام استان: </td><td>'.getNameProvinceCombol('province_id').'</td>
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;	
	
}
function repnahade(){
	
	
	    $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		 $firstHour = !empty($_REQUEST['firstHour']) ? $_REQUEST['firstHour'] : '15';     
		 $EndHour = !empty($_REQUEST['EndHour']) ? $_REQUEST['EndHour'] : '15';	
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/printnahade.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="firstHour"    value="<?php echo $firstHour ?>" ></input>
      <input type="hidden" name="EndHour"   value="<?php echo $EndHour ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
   </tr>
   </table> 

     </form>
   

			 
			<?php 
	
	
}
function repmeatahen(){
	
	    $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/printman.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
   </tr>
   </table> 

     </form>
   			 
			<?php 	
		
}
function repchi(){
	
       $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/printhen.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
   </tr>
   </table> 

     </form>
   

			 
			<?php 	
	
	
	
}
function repgosht(){
	
       $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/printgosht.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
   </tr>
   </table> 

     </form>
   

			 
			<?php 	
	
	
	
}
function repfaravarde(){
	
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		 	
	    $firstHour = !empty($_REQUEST['firstHour']) ? $_REQUEST['firstHour'] : '15';     
		 $EndHour = !empty($_REQUEST['EndHour']) ? $_REQUEST['EndHour'] : '15';	
		 
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/prinfaravarde.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="u_id"    value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>		 
	  <input type="hidden" name="firstHour"    value="<?php echo $firstHour ?>" ></input>
      <input type="hidden" name="EndHour"   value="<?php echo $EndHour ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
   </tr>
   </table> 

     </form>
   

			 
			<?php 
	
	
}

function reptajamokh(){
	
	
	   $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
		  $EndDatef = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		 $firstHour = !empty($_REQUEST['firstHour']) ? $_REQUEST['firstHour'] : '7';     
		 $EndHour = !empty($_REQUEST['EndHour']) ? $_REQUEST['EndHour'] : '7';	
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/printtajamokh.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
      <input type="hidden" name="firstHour"    value="<?php echo $firstHour ?>" ></input>
      <input type="hidden" name="EndHour"   value="<?php echo $EndHour ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
   </tr>
   </table> 

     </form>
   

			 
			<?php 	
	
	
	
	
}
function reptajamok(){
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		 $pnum = !empty($_REQUEST['pnum']) ? $_REQUEST['pnum'] : '';
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         $_SESSION['pnum']=$pnum;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/printtajamok.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="pnum"   value="<?php echo $pnum ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
        
      
 
   

     </form>
   

			 
			
     <form action="report/excelprinttajamok.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
  
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/icon-excel.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
  
     </form>
     <form action="report/pprinttajamok.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
 
  
    
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/display.png) no-repeat ;height:90px;
width:90px;" value="" />
      
      </td>
      
   </tr>
     </form>
   
   </table> 

   
   

			 
			<?php 	
			
			
			
			
}
function reptajamokm(){
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '-2';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		  $name_customer = !empty($_REQUEST['name_customer']) ? $_REQUEST['name_customer'] : '-2';
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/printtajamokm.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="name_customer"  value="<?php echo $name_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"       value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
   </tr>
   </table> 

     </form>
   

			 
			<?php 	
}
function reptajamok1(){
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '';
		 $sort_id = !empty($_REQUEST['sort_id']) ? $_REQUEST['sort_id'] : '';
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         $_SESSION['sort_id']=$sort_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
  ?>
     <form action="report/printtajamok1.php" target ="_blank" method="get">
 <?php 

 $i=1;
 foreach($_REQUEST['prov_list'] as $check) {
 	      
  //  echo $check;
 ?>
           <input type="hidden" name="prov_list[<?php echo $i ?>] "  value="<?php echo $check ?>" />
  <?php 
     $i++;	
    }
    ?>
      <input type="hidden" name="province_id"    value="<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>" ></input>
      <input type="hidden" name="firstDate"      value="<?php echo $mfirstDate ?>" ></input>
      <input type="hidden" name="EndDate"        value="<?php echo $mEndDate ?>" ></input>
      <input type="hidden" name="year_id"        value="<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>" ></input>
      <input type="hidden" name="p_code"         value="<?php echo $p_code ?>" ></input>
      <input type="hidden" name="p_type"         value="<?php echo $p_type ?>" ></input>
      <input type="hidden" name="p_category"     value="<?php echo $p_category ?>" ></input>
      <input type="hidden" name="l_id"           value="<?php echo $l_id ?>" ></input>
      <input type="hidden" name="code_customer"  value="<?php echo $code_customer ?>" ></input>
      <input type="hidden" name="p_price_code"   value="<?php echo $p_price_code ?>" ></input>
      <input type="hidden" name="p_pakage_type"  value="<?php echo $p_pakage_type ?>" ></input>
      <input type="hidden" name="city_id"        value="<?php echo $city_id ?>" ></input>
      <input type="hidden" name="EndDatef"       value="<?php echo $EndDatef ?>" ></input>
      <input type="hidden" name="firstDatef"     value="<?php echo $firstDatef ?>" ></input>
      <input type="hidden" name="province_id"    value="<?php echo $province_id ?>" ></input>
       <input type="hidden" name="sort_id"       value="<?php echo $sort_id ?>" ></input>
      <input type="hidden" name="u_id"   value="<?php echo $_SESSION['dm_user_profile']['u_id'] ?>" ></input>
  <table align="left">
   <tr>
      <td style="width:400px;">
          <input type="submit" name="Submit"  align="left" style="background:url(images/Print.png) no-repeat ;height:108px;
width:102px;" value="" />
      
      </td>
      
   </tr>
   </table> 

     </form>
   
			<?php 	
}
function reptajamocus(){
	
         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 
		 $province_id = !empty($_REQUEST['customer_cusid_province']) ? $_REQUEST['customer_cusid_province'] : '-2';
		 
		  $ph_operation_id = !empty($_REQUEST['ph_operation_id']) ? $_REQUEST['ph_operation_id'] : '-2';
		  $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		  $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '-2';
		  $phd_deli_name = !empty($_REQUEST['phd_deli_name']) ? $_REQUEST['phd_deli_name'] : '-2';
		 
		 
		 
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	$EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
	          ?>
			  <div align="left"> <a href="report/printtajamocus.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&firstDatef=<?php echo $firstDatef ?>
			  &EndDatef=<?php echo $EndDatef ?>
			  &province_id=<?php echo $province_id ?>
			  
			  &ph_operation_id=<?php echo $ph_operation_id ?>&ph_mojavez=<?php echo $ph_mojavez ?>&l_id=<?php echo $l_id ?>&phd_deli_name=<?php echo $phd_deli_name ?> " target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php  
			$querypro="SELECT * FROM dm_province 
									    WHERE
									      province_id=".$province_id."
									    ";									     	     											
								$lnkpro = mysql_query($querypro);
								$rowpro = mysql_fetch_assoc($lnkpro);
							//	print $querycus;
			$outHtml = '';   
//	$outHtml = '<br>	
//		<form method="get" action="">
//			<input type="hidden" name="pg" value="havaleMgmtPg">   
//			<input type="hidden" name="cmd" value="searchCodeebtal"> 
//			<b> كد  مورد نظر را جستجو كنيد </b>
//			<div>  <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:60px;" /> 
//			<button type="submit" name="Search" value="Search" >جستجو</button></div>
//		</form>
//		<br>';
   ?>
		<form action="lib/php/exporttoexcel.php" method="post"    
   onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'> 
  <?php  
	$outHtml .= '
	
		<div align = "center">
		<div align = "center" style="width:100%;height:400px; overflow:auto">
			<table   id="ReportTable" align="center" cellpadding="0" cellspacing="0" class="list" border="1" >
      			<tr class="rw1">
        			<td colspan="13" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش تجمعى فروش كالا </center> </td>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="13" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </td>
        			
        		</tr>
        		<tr class="rw1">
        			<td   colspan="6" style="height: 50px;vertical-align:middle;"> كد اقتصادي فروشنده  : '.$rowpro['province_ecode'].'  </td>
        			
        			<td   colspan="7" style="height: 50px;vertical-align:middle;">  آدرس فروشنده   :
        			 '.$rowpro['province_address'].'  </td>
        			
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">رديف </td>
			        <td align="center"> كد كالا</td>
			        <td align="center"> كد قيمت</td>
			        <td align="center"> نام كالا</td>
			        <td align="center"> دسته کالا</td>
			        <td align="center">مقدار خريد</td>
			        <td align="center">مقدار ابطال شده</td>
			        <td align="center">مقدار صادره </td>
			        <td align="center">مبلغ قابل پرداخت </td>	      	        
			        <td align="center">شهر</td>			        	    		        		        
				</tr>';
		
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		
		
	}
	$typeQ = '';
	
	$genQuery = "
			  from dm_havale h 
      left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$province_id." 
      left join dm_price price on p.p_id=price.price_p_id and price.`p_price_code`=h.`h_price_code`
      left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type 
      left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
      left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
      left join dm_location_goods l on l.l_id=h.h_l_code 
      left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province=".$province_id."
      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code and ph_id_province=".$province_id." 
      left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
      left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1 and ebt.ebh_id_province=".$province_id." and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."' ) 
      left join dm_ebtal_h ebt2 on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 and ebt2.ebh_id_province=".$province_id." and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
        where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
  and ph_id_province=".$province_id." )and(  ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
  
  or

   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
  ph_id_province=".$province_id." )
and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')


  )
	
".$srchQ." 
".$typeQ." 
	                                                                               
        " ;
		
		
          
if ($p_code != -2){
		
		$genQuery .= "  AND h_p_code= ". $p_code ." ";
	}
if ($p_price_code != -2){
		
		$genQuery .= " AND p_price_code= ". $p_price_code ." ";
	}
if ($p_type != -2){
		
		$genQuery .= " AND p_type= ". $p_type ." ";
	}
if ( $p_category != -2){
		
		$genQuery .= " AND  p_category= ".$p_category ." ";
	}
if ($l_id != -2){
		
		$genQuery .= " AND  h_l_code= ".$l_id ." ";
	}

if ($p_pakage_type != -2){
		
		$genQuery .= " AND   p_pakage_type= ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$genQuery .= " AND   p_subsidies= ". $p_subsidies ." ";
	}	
	
	$genQuery .= "	group by `h_code` )  ";
	$genQuery .= " as c ";					 
	if ($code_customer != -2 AND $city_id != -2){
		
		$genQuery .= " where  h_customer_code= ". $code_customer ."  AND   customer_cusid_city= ". $city_id ." ";
	}else if( $code_customer != -2){
		$genQuery .= " where  h_customer_code= ". $code_customer ."";
		
	}else if ($city_id != -2){
		 
		$genQuery .= " where   customer_cusid_city= ". $city_id ." ";
	}
	$genQuery .= " group by  p_name, p_price_code
         ORDER BY  p_name, p_price_code asc";

	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		select p_name, p_price_code,`cat_prod_name` ,sum(shavale) shavale ,sum(sebtal) sebtal ,sum(SUM_price) sprice ,p_code from ( select h_code , ph_code , h_reg_date , ph_mojavez , p_name , p_code, p_sellprice , h_amount , l_name,p_price_code ,cat_prod_name , h_customer_code , case when h.`h_status` = 1 then 'ابطال کلي' else case when his.his_h_id is null then 'ابطال نشده' else 'ابطال جزئي' end end as STATUS_EBTAL , case when ebt2.ebh_reg_date between '2012-06-30' AND '2012-06-30' or ebt.ebh_reg_date between '2012-03-20' AND '2012-08-13' then case when h.`h_status` = 1 then h.`h_amount` 
		else case when his.his_h_id is null then 0 else his.`his_eb_amount` 
		end end else 0 end as sebtal , 
		CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."' then 
		case when h.`h_status` = 1 then h.`h_amount` else
		 case when his.his_h_id is null then h.`h_amount` 
		 else SUM( his.`his_eb_amount`) + h.`h_amount` 
		 end end else 0 end as shavale , case when h.`h_status` = 1 then 0 else 
		 case when his.his_h_id is null then h.h_price else h.h_price end end as SUM_price 
	".$genQuery.$limitQ;
	//print($resQuery);
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$amount=0;
	$ebtal=0;
	if(mysql_affected_rows()>0){
		
	
		while($row = mysql_fetch_assoc($lnk)){

			if(($inx)%2==1)
				$class="rw1";
				else
				$class="rw0";
			
				$gdate=$row['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;												
								$querycus="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['h_customer_code']."
									    AND
									     customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']."";									     	     											
								$lnkcus = mysql_query($querycus);
								$rowcus = mysql_fetch_assoc($lnkcus);
					          $querycity="SELECT * FROM dm_city 
									    WHERE
									      city_id=".$row['customer_cusid_city']."
									    ";									     	     											
								$lnkcity = mysql_query($querycity);
								$rowcity = mysql_fetch_assoc($lnkcity);
		                       if($row['shavale']> $row['sebtal']){
									$mande=$row['shavale']-$row['sebtal'];
								}else{
									
									$mande=$row['sebtal']-$row['shavale'];
								}
         $inx1 =urlencode($inx);
	     $inx1=farsinum($inx1);
	     
	        $shavale=formatMoney($shavale);
	        $shavale=farsinum($shavale);
			$sebtal=formatMoney($row['sebtal']);
	        $sebtal=farsinum($sebtal);					
			$mande1 =urlencode($mande);
			$mande1=formatMoney($mande1);
	        $mande1=farsinum($mande1);	
	        $sumprice=formatMoney($row['sumprice']);
	        $sumprice=farsinum($sumprice);
	        	$shavale =urlencode($row['shavale']);
	         $shavale=formatMoney($shavale);
	        $shavale=farsinum($shavale);
	        	
	        $p_code=farsinum($row['p_code']);	
	        $p_price_code=farsinum($row['p_price_code']);				
			$outHtml .= '
			
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$p_code.'</td>
					<td  align="center" style="vertical-align:middle;">'. $p_price_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>		
					<td align="center" style="vertical-align:middle;">'.$row['cat_prod_name'].'</td>				
					<td align="center" style="vertical-align:middle;">'.$shavale.'كيلوگرم</td>				  
					
					<td align="center" style="vertical-align:middle;">'. $sebtal.'</td>
					<td align="center" style="vertical-align:middle;">'.$mande1.'</td>
					<td align="center" style="vertical-align:middle;">'.$sumprice.'ريال</td>

					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>					
				</tr>';			
 //  		    <td ><a href="?pg=havaleMgmtPg&cmd=EbtalHavale&h_id='.$row['h_id'].'">ابطال </a></td>			
			$inx++;
			$amount=$amount+$mande;
			$ebtal=$ebtal+$row['sebtal'];
			
		//	echo $amount;
		}
			$amount = urlencode($amount);
		 	
		    $amount=formatMoney($amount);	
	        	$amount=farsinum($amount);
	        $ebtal =urlencode($ebtal);
		    $ebtal=formatMoney($ebtal);	
	        $ebtal=farsinum($ebtal);	
	//	echo '<div> مقدار کل جاری:'.$amount.'كيلوگرم</div>' ;		
	//	echo '<div> مقدار کل ابطالی:'.$ebtal.'كيلوگرم</div>' ;		
    		
		
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
    $outHtml .= '</table>
                
    </div>'.getNavBar_rfjc().' '.getRPPCombo_rfjc();
    $outHtml .= '
     <table width="600px" cellpadding="2" cellspacing="2" border="0">  
	    <tr>  
	      <td>&nbsp;</td>  
	    </tr>  
	    <tr>  
	      <td align="center"><input type="hidden" id="datatodisplay" name="datatodisplay">  
	        <input type="submit" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:100px;" value="خروجی در اکسل">  
	      </td>  
	    </tr>  
  </table>  
</form> ';
  //  echo $outHtml;
	
}
function getNavBar_rfjc(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reptajamocus&cmd2=setPg&pgNum=1&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&province_id='.$_SESSION['province_id'].'
		" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=reptajamocus&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&province_id='.$_SESSION['province_id'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=reportMgmtPg&cmd=repfinance&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&city_id='.$_SESSION['city_id'].'&province_id='.$_SESSION['province_id'].'
			&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reptajamocus&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&province_id='.$_SESSION['province_id'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&cmd=reptajamocus&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_rfjc(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=reptajamocus&province_id='.$_SESSION['province_id'].'&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
		
		
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


function reptajamo1(){

	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	$EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
	       
            ?>
		  	  <div align="left"> <a href="report/printtajamo1.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>
			  &province_id=<?php echo $province_id ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			 
			<?php
			
}

function repmonth(){
	
 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';	
 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
 $month_num = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
 
	
	
}

function reptajamo(){
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '-2';
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['province_id']=$province_id;
         
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       $firstDatef = $firstDate;
      
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	$EndDatef= $EndDate ;
      
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
 $mfirstDate= $firstDate; 
 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
 if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	$mEndDate= $EndDate;

 $_SESSION['firstDatef']=$firstDatef;
 $_SESSION['EndDatef']=$EndDatef;	
								  		  	
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
	          ?>
			  <div align="left"> <a href="report/printtajamo.php?province_id=<?php echo $_SESSION['dm_user_profile']['u_province_id'] ?>&firstDate=<?php echo $mfirstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $_SESSION['dm_user_profile']['u_year_id'] ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>
			  &province_id=<?php echo $province_id ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
    
}
function getNavBar_rfj(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reptajamo&cmd2=setPg&pgNum=1&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&province_id='.$_SESSION['province_id'].'
		" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=reptajamo&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&province_id='.$_SESSION['province_id'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=reportMgmtPg&cmd=repfinance&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&city_id='.$_SESSION['city_id'].'&province_id='.$_SESSION['province_id'].'
			&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reptajamo&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&province_id='.$_SESSION['province_id'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&cmd=reptajamo&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_rfj(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=reptajamo&province_id='.$_SESSION['province_id'].'&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'&firstDatef='.$_SESSION['firstDatef'].'&EndDatef='.$_SESSION['EndDatef'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
		
		
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


function  dspfrmmo(){
	
		?>
    <style type="text/css">
       
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	    $(function() {
		    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	      
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="repmojavez" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			    <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش مجوزها</font></td>
			    </tr>
			    <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			    </tr>
	           
				<tr>
					  <td>از تاريخ :</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					  <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
					   
				</tr>
				<tr>
			        <td>شماره مجوز: </td><td><input type="text"   id="phm_mojavez"  name="phm_mojavez"   ></input></td>
			    
			       									     				       				       
				</tr>
				
										
				<tr>
				 <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				
				</tr>
	</table>

</form>';

return $out;
	
	
}
function dsppffrm(){
	
		?>
    <style type="text/css">
       
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	    $(function() {
		    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	      
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="reppf" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="4">گزارش پيش فاكتور ها</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					  <td>از تاريخ :</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					  <td>تا تاريخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
					   
				</tr>
				<tr>
			        <td>کد مشتری: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
			      <td> وضعيت : </td><td>
				       <div> <input type="radio"   checked="checked" name="status" value="'. 1 .'"  > حواله صادر شده</div>
				       <div> <input type="radio"  name="status"  value="'. 2 .'"  > حواله صادر نشده</div>
				       <div> <input type="radio"  name="status"  value="'. 3 .'"  > همه پيش فاكتورها</div>
				       
				     </td>
			       									     				       				       
				</tr>
				
										
				<tr>
				 <td colspan="5" align="center"><button type="submit" value="تهيه گزارش " ">تهيه گزارش</button></td>
				
				</tr>
	</table>

</form>';

return $out;
	
	
}
//<tr>
//				  <td>
//				دسته بندي کالا
//				</td>
//                <td>
//			  		'. getCategoryTypesComboBox('p_category').'
//				</td>
//					 			        									     				       				       
//				</tr>
function dspRephourfrm(){
	
		?>
    <style type="text/css">
       
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	    $(function() {
		    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#EndDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	   
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="rephour" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="3">گزارش فروش بر اساس ساعت</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاریخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>
					   <td>از ساعت:(مانند 15)</td><td><input name="firstHour" id="firstHour" type="text" /></td>
					    
				</tr>
				<tr>
					   <td>تا تاریخ:</td><td><input name="EndDate" id="EndDate" type="text" /></td>
					   <td>تا ساعت:</td><td><input name="EndHour" id="EndHour" type="text" /></td>
					   
				</tr>
				
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>  
				</tr>
				<tr>
				       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
				       <td>بسته بندی کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
				</tr>
				<tr>
				       <td>دسته بندی کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				</tr>										
				<tr>  
				       <td>کد مشتری: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندی:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتري:</td><td>'. getPersonalityTypesComboBox('personality_customer').'</td>															
				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;
	
	
	
}
function dspRepdayfrm(){
	
		?>
    <style type="text/css">
       
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
	        $("#firstDate").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    });
	   
              </script>
              
	<?php
	           $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
              $selectedItem=1;
$out='<form action="">
       <input type="hidden" name="pg" value="reportMgmtPg" />   
       <input type="hidden" name="cmd" value="repday" /> 
	   <input name="province_id" type="hidden" id="province_id"  value="'. $_SESSION['dm_user_profile']['u_province_id'].'" type="text"/>
	   <input name="year_id"     type="hidden"id="year_id"  value="'. $_SESSION['dm_user_profile']['u_year_id'] .'" type="text"/> 	
	 <table border="1" align="center" class="nasi"   width="80%">
	 
			  <tr style="background-color:'.  $_SESSION['htablecolor'] .';font-weight:bold;">
				       <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="3">گزارش فروش روزانه</font></td>
			   </tr>
			   <tr>
			            <td colspan="8"><hr style="color:'.  $_SESSION['htablecolor'] .';height:40%;"></hr></td>
			   </tr>
	           
				<tr>
					   <td>از تاریخ:</td><td><input name="firstDate" id="firstDate" type="text" /></td>					    
				</tr>
				
				<tr>
				       <td>کد  کالا : </td><td><input type="text"  id="p_code"  name="p_code"  ></input></td>
				       <td>کد  قيمت : </td><td><input type="text"  id="p_price_code"  name="p_price_code"  ></input></td>  
				</tr>
				<tr>
				       <td>نوع کالا : </td><td>'. getTypesComboBoxr('p_type').'</td>										     
				       <td>بسته بندی کالا : </td><td>'. getPkgTypesComboBoxr('p_pakage_type').'</td>
				</tr>
				<tr>
				       <td>دسته بندی کالا : </td><td>'. getCategoryTypesComboBoxr('p_category').'</td>										     
				       <td ><center>يارانه </center> </td><td>'. getSubsidiesTypesComboBoxZ('p_Subsidies').'</td>
				</tr>										
				<tr>  
				       <td>کد مشتری: </td><td><input type="text"  id="code_customer" name="code_customer"   ></input></td>
				       <td>نوع دسته بندی:</td><td>'. getCatCustomerNameCombo('category_id').'</td>
				</tr>
				<tr>
					 <td>نوع مشتري:</td><td>'. getPersonalityTypesComboBox('personality_customer').'</td>															
				     <td>نام محل مورد نظر:</td><td>'.  getlocationNameCombo('l_id').'</td>								      
				</tr>							
				<tr>
					  <td colspan="5" align="center"><button type="submit" value="تهیه گزارش " ">تهیه گزارش</button></td>
				</tr>
	</table>

</form>';

return $out;
	
}
function repmojavez(){
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';     
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
		
		 $phm_mojavez = !empty($_REQUEST['phm_mojavez']) ? $_REQUEST['phm_mojavez'] : '-2';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_codeh']) ? $_REQUEST['p_codeh'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_codeh']) ? $_REQUEST['p_price_codeh'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '2';
		
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
         $_SESSION['category_id']=$category_id;
         $_SESSION['p_category']=$p_category;
        $u_province_id =$_SESSION['dm_user_profile']['u_province_id'];
                 
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;

		
       	 $EndDatef = $EndDate;
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
	 $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	

		
 $mfirstDate= $firstDate; 

	          ?>
			  <div align="left"> <a href="report/printmojavez.php?province_id=<?php echo $u_province_id ?>&firstDate=<?php echo $firstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $year_id ?>
			 &EndDate=<?php echo $EndDate ?> &phm_mojavez=<?php echo $phm_mojavez ?>&p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&status=<?php echo $status ?>&EndDatef=<?php echo $EndDatef ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>&status=<?php echo $status ?>&p_category=<?php echo $p_category ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
}
function reppf(){
	
	     $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';     
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '-2';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_codeh']) ? $_REQUEST['p_codeh'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_codeh']) ? $_REQUEST['p_price_codeh'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '2';
		
		// echo $status;
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
         $_SESSION['category_id']=$category_id;
         $_SESSION['p_category']=$p_category;
                 
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef = $EndDate;
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
 $mfirstDate= $firstDate; 
 
 
 
  $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
 $mEndDate= $EndDate; 
	
	          ?>
			  <div align="left"> <a href="report/printrpf.php?province_id=<?php echo $province_id ?>&firstDate=<?php echo $firstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&status=<?php echo $status ?>&EndDatef=<?php echo $EndDatef ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>&status=<?php echo $status ?>&p_category=<?php echo $p_category ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
}
function rephour(){
	
	  $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';     
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
		  $EndDate1 = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer1']) ? $_REQUEST['code_customer1'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_codeh']) ? $_REQUEST['p_price_codeh'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $firstHour = !empty($_REQUEST['firstHour']) ? $_REQUEST['firstHour'] : '24';     
		 $EndHour = !empty($_REQUEST['EndHour']) ? $_REQUEST['EndHour'] : '24';	
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
         $_SESSION['category_id']=$category_id;
                 
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef = $EndDate;
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
	

if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
 $mfirstDate= $firstDate; 
	//echo $EndDate1;

	
	
	    $jdate=$EndDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
	

if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$EndDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
	
//	echo $EndDate;
	
	
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
	          ?>
			  <div align="left"> <a href="report/printhour.php?province_id=<?php echo $province_id ?>&firstDate=<?php echo $firstDate ?>&EndDate=<?php echo $EndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef?>
			  &EndDate=<?php echo $EndDate  ?>&ph_mojavez=<?php echo $ph_mojavez?>
			  &EndHour=<?php echo $EndHour ?>&firstHour=<?php echo$firstHour?>&category_id=<?php echo $category_id ?>" target="_blank">
			  <img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
			$outHtml = '';   
	
	
}
function repday(){
	
         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] : '';     
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '';
         $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer1']) ? $_REQUEST['code_customer1'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_codeh']) ? $_REQUEST['p_price_codeh'] : '-2';
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 	
		 $_SESSION['firstDate']=$firstDate;
		 $_SESSION['EndDate']=$EndDate;
		 
		 $_SESSION['p_code']=$p_code;
		 $_SESSION['p_type']=$p_type;
		 $_SESSION['p_category']=$p_category;
		 $_SESSION['l_id']=$l_id;
		 $_SESSION['code_customer']=$code_customer;
		 $_SESSION['p_price_code']=$p_price_code;
	     $_SESSION['p_pakage_type']=$p_pakage_type; 
         $_SESSION['p_subsidies']=$p_subsidies;
         $_SESSION['city_id']=$city_id;
         $_SESSION['ph_mojavez']=$ph_mojavez;
         $_SESSION['category_id']=$category_id;
                 
		 $date = explode('/', $firstDate);
         $firstDate=$date[2].'/'.$date[1].'/'.$date[0] ;
         $firstDatef = $firstDate;
         $date = explode('/', $EndDate);
         $EndDate=$date[2].'/'.$date[1].'/'.$date[0] ;
       	 $EndDatef = $EndDate;
    $jdate=$firstDate;
    $jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$firstDate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
 $mfirstDate= $firstDate; 
	
								  		  	
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
	          ?>
			  <div align="left"> <a href="report/printrday.php?province_id=<?php echo $province_id ?>&firstDate=<?php echo $firstDate ?>&EndDate=<?php echo $mEndDate ?>&year_id=<?php echo $year_id ?>
			  &p_code=<?php echo $p_code ?>&p_type=<?php echo $p_type ?>&p_category=<?php echo $p_category ?>&l_id=<?php echo $l_id ?>&code_customer=<?php echo $code_customer ?>&p_price_code=<?php echo $p_price_code ?>&p_pakage_type=<?php echo $p_pakage_type ?>&p_subsidies=<?php echo $p_subsidies ?>&city_id=<?php echo $city_id ?>&u_id=<?php echo $_SESSION['dm_user_profile']['u_id'] ?>
			  &firstDatef=<?php echo $firstDatef ?>&EndDatef=<?php echo $EndDatef ?>&EndDate=<?php echo $EndDate  ?>&ph_mojavez=<?php echo $ph_mojavez ?>&category_id=<?php echo $category_id ?>" target="_blank"><img src="images/Print.png" width="100" height="100" title="print"  > </img></a></div>
			<?php 
			$outHtml = '';   

		
	$outHtml .= '	
		<div align = "center">
		<div align = "center" style="width:90%;height:300px; overflow:auto">
			<table  align="center" cellpadding="0" cellspacing="0" class="list" border="1" >
      			<tr class="rw1">
        			<th colspan="21" align4="center" style="height: 50px;vertical-align:middle;"><center> گزارش فروش روزانه </center> </th>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="16" style="height: 50px;vertical-align:middle;"> در تاريخ &nbsp; : '.$firstDatef.' </td>         			         			
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">رديف </td>			      
			        <td align="center"> شماره حواله</td>
			        <td align="center"> تاريخ حواله</td>
			        <td align="center"> شماره مجوز</td>
			        <td align="center">نام کالا</td>
			        <td align="center">قيمت واحد </td>
			        <td align="center"> مقدار اولیه خرید</td>
			        <td align="center">مقدار ابطالی</td>
			        <td align="center"> مقدار جاری</td>
			        <td align="center"> مبلغ قابل پرداخت</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			         <td align="center">دسته بندي مشتري</td>
			        <td align="center">نام شهر</td>	
			        <td align="center">وضعیت</td>	
			       				    		        		        
				</tr>';
		
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		
		
	}
	$typeQ = '';
		
	$genQuery = "  from ( select h_code , ph_code , p_code, p_price_code, h_reg_date ,
 ph_mojavez , p_name , p_sellprice , h_amount ,
  l_name , h_customer_code , case when h.`h_status` = 1 
  then 'ابطال کلی' else case when his.his_h_id is null 
  then 'ابطال نشده' else 'ابطال جزئی' end end as STATUS_EBTAL ,
   case when h.`h_status` = 1 then h.`h_amount` else 
   case when his.his_h_id is null then 0 else his.`his_eb_amount` 
   end end as MEGHDAR_EBTAL , case when h.`h_status` = 1 
   then h.`h_amount` else case when his.his_h_id is null 
   then h.`h_amount` else SUM( his.`his_eb_amount`) + h.`h_amount` end 
   end as MEGHDAR_PRE , case when h.`h_status` = 1 then 0 else 
   case when his.his_h_id is null then h.h_price else h.h_price 
   end end as SUM_price from dm_havale h 
   left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."     
   left join dm_price price on p.p_id=price.price_p_id 
   and price.`p_price_code`=h.`h_price_code` 
   left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type 
   left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
   left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
   left join dm_location_goods l on l.l_id=h.h_l_code 
   left join dm_pish_factor pf on h.h_pf_code=pf.pf_code 
   and pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']." left join dm_pish_havale ph 
   on ph.ph_code=pf.pf_ph_code and ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
   left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
   left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1 
   and ebt.ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
   and (ebt.ebh_reg_date between '".$mfirstDate."' AND  '".$mEndDate."'
   or h.h_reg_date between '".$mfirstDate."' AND  '".$mEndDate."' )
  left join dm_ebtal_h ebt2 
  on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 
 and ebt2.ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
  and (ebt2.ebh_reg_date between '".$mfirstDate."' AND  '".$mEndDate."'
  or h.h_reg_date between '".$mfirstDate."' AND  '".$mEndDate."')
    where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
  and ph_id_province=".$province_id." )and(  ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
  
  or

   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
  ph_id_province=".$province_id." )
and (ebt2.ebh_reg_date between '".$mfirstDate."' AND  '".$mEndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')


  )
  
			".$typeQ." 
	                                                                               
        " ;
if ($p_code != -2){
		
		$genQuery .= "  AND p_code= ". $p_code ." ";
	}
if ($p_price_code != -2){
		
		$genQuery .= " AND p_price_code= ". $p_price_code ." ";
	}
if ($p_type != -2){
		
		$genQuery .= " AND p_type= ". $p_type ." ";
	}
if ( $p_category != -2){
		
		$genQuery .= " AND  p_category= ".$p_category ." ";
	}
if ($l_id != -2){
		
		$genQuery .= " AND  h_l_code= ".$l_id ." ";
	}

if ($p_pakage_type != -2){
		
		$genQuery .= " AND   p_pakage_type= ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$genQuery .= " AND   p_subsidies= ". $p_subsidies ." ";
	}	
	
	if ($ph_mojavez != -2){
		 
		$genQuery .= "  AND   ph_mojavez= ". $ph_mojavez ." ";
	}
	
	
	$genQuery .= " group by `h_code` 
         ) as c 
          
          left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$_SESSION['dm_user_profile']['u_province_id']."
          ";
	if ($code_customer != -2){
		
		$genQuery .= " AND  h_customer_code= ".$code_customer ." ";
	}if ($city_id != -2){
		 
		$genQuery .= "  AND   customer_cusid_city= ". $city_id ." ";
	}
	
	$genQuery .= "left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id  ";
         
	if ($category_id != -2){
		 
		$genQuery .= "  AND   category_id= ". $category_id ." ";
	}
if ($code_customer != -2){
		
		$query .= " where  h_customer_code= ". $code_customer ." ";
	}
	$genQuery .=" ORDER BY h_code asc";
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$genQuery .= "	AND
		     h_reg_date between   '".$mfirstDate."' AND  '".$mEndDate."' ";
	$genQuery .= " group by  `h_code` ORDER BY h_code asc";
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
			h_code ,
			h_reg_date ,
			ph_mojavez ,
			p_name ,
			p_sellprice ,
			h_amount ,
			l_name ,
			h_customer_code ,
			name_customer ,
			category_name   
	".$genQuery.$limitQ;
	//print($resQuery);
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	$amount=0;
	$amountebtal=0;
	if(mysql_affected_rows()>0){

		while($row = mysql_fetch_assoc($lnk)){
			
			
			if(($inx)%2==1){
				$class="rw1";
				if( $row['h_status']==1){
					$class="rw3";
				}
			}
				else{
				$class="rw0";
				}
			
				$gdate=$row['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;												
								$querycus="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['h_customer_code']."
									    AND
									     customer_code_org=".$_SESSION['dm_user_profile']['u_province_id']."";									     	     											
								$lnkcus = mysql_query($querycus);
								$rowcus = mysql_fetch_assoc($lnkcus);
									$querycity="SELECT * FROM dm_city 
									    WHERE
									      city_id=".$rowcus['customer_cusid_city']."
									    ";									     	     											
								$lnkcity = mysql_query($querycity);
								$rowcity = mysql_fetch_assoc($lnkcity);
					
							$asli=$row['MEGHDAR_PRE'] - $row['MEGHDAR_EBTAL'];
							$asli =urlencode($asli);
							$inx1 =urlencode($inx);
                            $inx1=farsinum($inx1);
			$outHtml .= '
			
				<tr class='.$class.'>
					<td align="center" style="vertical-align:middle;">'.$inx1.'</td>';
//			if( $row['h_status']==0){
//				$outHtml .= '<td align="center" style="vertical-align:middle;">فعال</td>';
//			}else{
//				$outHtml .= '<td align="center" style="vertical-align:middle;">ابطال كلي</td>';
//				
//			}
$h_code=farsinum( $row['h_code']);
$ph_mojavez=farsinum( $row['ph_mojavez']);
$p_sellprice=farsinum($row['p_sellprice']);
$asli=farsinum($asli);
$SUM_price=farsinum($row['SUM_price']);
$h_customer_code=farsinum($row['h_customer_code']);
$MEGHDAR_PRE=farsinum($row['MEGHDAR_PRE']);
$MEGHDAR_EBTAL=farsinum($row['MEGHDAR_EBTAL']);
$jdate=farsinum($jdate);


		$outHtml .= '<td align="center" style="vertical-align:middle;">'.$h_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
				    <td align="center" style="vertical-align:middle;">'.$ph_mojavez.'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>
					<td  align="center" style="vertical-align:middle;">'.$p_sellprice.'ريال</td>
					<td align="center" style="vertical-align:middle;">'.$MEGHDAR_PRE.'</td>	
					<td align="center" style="vertical-align:middle;">'.$MEGHDAR_EBTAL.'</td>									
					<td align="center" style="vertical-align:middle;">'.$asli.'كيلوگرم</td>
		            <td align="center" style="vertical-align:middle;">'.$SUM_price.'ريال</td>';

  $outHtml .= '<td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$h_customer_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcus['name_customer'].'</td>
				    <td align="center" style="vertical-align:middle;">'.$row['category_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['STATUS_EBTAL'].'</td>
													
				</tr>';			
 //  		    <td ><a href="?pg=havaleMgmtPg&cmd=EbtalHavale&h_id='.$row['h_id'].'">ابطال </a></td>	
       
  
		 $MEGHDAR =$row['MEGHDAR_PRE']-$row['MEGHDAR_EBTAL'];
           $amount=$amount+$MEGHDAR;
           $amountebtal=$amountebtal+$row['MEGHDAR_EBTAL'];
			$inx++;
			  
		}
		$outHtml .= '</tr>';
		 $amountebtal =urlencode($amountebtal);
         $amountebtal=farsinum($amountebtal);
         $amount =urlencode($amount);
         $amount=farsinum($amount);
		echo '<div>مقدارجاری:'.$amount.'كيلوگرم </div>' ;		
		echo '<div>مقدار ابطالی:'.$amountebtal.'كيلوگرم</div>' ;	
			while($row = mysql_fetch_assoc($lnk)){
 $outHtml .= '<tr><td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td</tr>';
				
				
			}
		
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
    $outHtml .= '</table>
    </div>'.getNavBar_rday().' '.getRPPCombo_rday();
//    echo $outHtml;
		
}

function getNavBar_rday(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&cmd2=setPg&pgNum=1&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'
		&city_id='.$_SESSION['city_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'
		&category_id='.$_SESSION['category_id'].'" ><img src="images/first.gif" title="ابتدا"></img></a></td>
	    <td>&nbsp;&nbsp;</td>		    
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'
		&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		 <td>&nbsp;&nbsp;</td>  
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
			&ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'
			&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td> 
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&category_id='.$_SESSION['category_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td> 
		<td><a href="?pg=reportMgmtPg&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'
		&cmd=reph_num&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_rday(){
	$out = '
	
		<select onchange="window.open(\'?pg=reportMgmtPg&cmd=reph_date&firstDate='.$_SESSION['firstDate'].'&EndDate='.$_SESSION['EndDate'].'&p_code='.$_SESSION['p_code'].'&p_price_code='.$_SESSION['p_price_code'].'&p_type='.$_SESSION['p_type'].'&p_category='.$_SESSION['p_category'].'&l_id='.$_SESSION['l_id'].'&p_pakage_type='.$_SESSION['p_pakage_type'].'&p_subsidies='.$_SESSION['p_subsidies'].'&city_id='.$_SESSION['city_id'].'&ph_mojavez='.$_SESSION['ph_mojavez'].'&category_id='.$_SESSION['category_id'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
		
		
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
