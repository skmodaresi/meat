function fObj($id,$parent){var e;if(typeof($parent)=='object'){e=$parent.document.getElementById($id);}else{e=document.getElementById($id);}if(e){return(e);}else{return(false);}}

function altrO(id){
	if(fObj(id).style.display=='none'){
		fObj(id).style.display='block';
	}else{
		fObj(id).style.display='none';
	}
}

function mngCType(inp1){
	if(inp1==1){
		fObj('custInfCntnr').style.display = 'block';
		fObj('custComboCntnr').style.display = 'block';
		fObj('motCustCntnr').style.display = 'none';
		
	}else if(inp1==2){
		fObj('custInfCntnr').style.display = 'none';
		fObj('custComboCntnr').style.display = 'none';
		fObj('motCustCntnr').style.display = 'block';
	}
}
function mngrType(inp1){
	if(inp1==1){
		fObj('dateReport').style.display = 'none';		
		fObj('numberReport').style.display ='block';
		
	}else if(inp1==2){
		fObj('dateReport').style.display = 'block';	
		fObj('numberReport').style.display ='none';
	}
}
function mngrMType(inp1){
	if(inp1==1){
		fObj('dateReportM').style.display = 'none';		
		fObj('numberReportM').style.display ='block';
		
	}else if(inp1==2){
		fObj('dateReportM').style.display = 'block';	
		fObj('numberReportM').style.display ='none';
	}
}
function HorMType(inp1){
	if(inp1==2){
		fObj('mOrh_H').style.display = 'none';		
		fObj('mOrh_M').style.display ='block';
		
	}else if(inp1==1){
		fObj('mOrh_H').style.display = 'block';	
		fObj('mOrh_M').style.display ='none';
	}
}
function hcreateType(inp1){
	if(inp1==1){
		fObj('hcreateph').style.display = 'block';	
		fObj('hcreatepf').style.display ='none';
		
	}else if(inp1==2){
		fObj('hcreateph').style.display = 'none';		
		fObj('hcreatepf').style.display ='block';
	}
}
function pfcreateType(inp1){
	if(inp1==1){
		fObj('pfcreateph').style.display = 'block';	
		fObj('pfcreatepf').style.display ='none';
		
	}else if(inp1==2){
		fObj('pfcreateph').style.display = 'none';		
		fObj('pfcreatepf').style.display ='block';
	}
}
function EbtalHType(inp1){
	if(inp1==1){
		fObj('hEbtelph').style.display = 'block';	
		fObj('hEbtalpf').style.display ='none';
		fObj('hEbtalh').style.display ='none';
		
	}else if(inp1==2){
		fObj('hEbtelph').style.display = 'none';		
		fObj('hEbtalpf').style.display ='block';
		fObj('hEbtalh').style.display ='none';
	}else if(inp1==3){
		fObj('hEbtelph').style.display = 'none';		
	    fObj('hEbtalpf').style.display ='none';
	    fObj('hEbtalh').style.display ='block';
}
}

function mngSellType(inp){
	if(inp==1){
		fObj('tableProduct').style.display = 'block';
		fObj('Analyzetable').style.display = 'none';
	//	fObj('tableProduct1').style.display = 'block';
		
	}else if(inp==2){
		fObj('tableProduct').style.display = 'none';
		fObj('Analyzetable').style.display = 'block';
//		fObj('tableProduct1').style.display = 'none';
		
	}
}

var cBF = '';
var isValidAjRes = false;
function aHW(q){
	isValidAjRes = false;
	$.ajax({ url: "ajax.handler.php?"+q, context: document.body, success: function(data){ajaxCallback(data);}});
}

function ajaxCallback(response){
//	response = response.replace(/TAKQOT/g, "\\'" );
	var res = response.split('[*]');
	if(!res[1]){
		isValidAjRes = false;
		alert('Inv Aj Res');
		return;
	}
	
	if(res[1]=='ok'){
		isValidAjRes = true;
		if(res[2]=='no'){
			var fRes = res[3]; 
			
		}else if(res[2]=='b64'){
		
		}else if(res[2]=='json'){
			eval('var fRes = '+res[3]); 
		}
		
	}else if(res[1]=='err'){
		isValidAjRes = false;
		var fRes = res[3]; 
	}else{
		isValidAjRes = false;
		alert('Inv Aj Res');
		return;
	}
	var cbfN = eval(cBF);
	cbfN(fRes);
	
//	(function(fRes){eval(cBF+"('"+fRes+"')");
//	eval(cBF+"('"+fRes+"')");
}
function DisableRelCombo(response,val){
	cBF = 'DisableRelCombo';
	if(response){
		var dtl = response.split(';');
		var value = dtl[0];
		if(value==2){	
		fObj('row').style.display = 'none';
		fObj('row1').style.display = 'none';
		fObj('rowh').style.display = '';
		}
		else if(value==1){
			fObj('row').style.display = '';
			fObj('row1').style.display = '';
			fObj('rowh').style.display = 'none';

		}
	}else{
		Q = 'pg=havaleMgmtPg&cmd=DisableRelCombo&value='+val;
		aHW(Q);
	}
}
function DisablePerCombo(response,val){
	cBF = 'DisablePerCombo';
	if(response){
		//alert(response);
		var dtl = response.split(';');
		var value = dtl[0];
		if(value==2){	
		fObj('rr').style.display = 'none';
		fObj('r').style.display = '';
		
		}
		if(value==3){	
			fObj('rr').style.display = 'none';
			fObj('r').style.display = '';
			
			}
		else if(value==1){
			fObj('rr').style.display = '';
			fObj('r').style.display = 'none';
			

		}
	}else{
		Q = 'pg=havaleMgmtPg&cmd=DisablePerCombo&value='+val;
		aHW(Q);
	}
}
function DisableezafidCombo(response,val){
	cBF = 'DisableezafidCombo';
	if(response){
		
		var dtl = response.split(';');
		var value = dtl[0];
		if(value==2){	
		fObj('d').style.display = 'none';
		fObj('d1').style.display = 'none';
		fObj('d2').style.display = 'none';
		fObj('d3').style.display = '';
		
		}
		else if(value==1){
			fObj('d').style.display = '';
			fObj('d1').style.display = '';
			fObj('d2').style.display = '';
			fObj('d3').style.display = 'none';
			
		

		}
		else if(value==3){
			fObj('d').style.display = 'none';
			fObj('d1').style.display = 'none';
			fObj('d2').style.display = '';
			fObj('d3').style.display = 'none';
			
		}
		else if(value==4){
			fObj('d').style.display = 'none';
			fObj('d1').style.display = 'none';
			fObj('d2').style.display = '';
			fObj('d3').style.display = 'none';
			
		}
	}else{
		Q = 'pg=havaleMgmtPg&cmd=DisableezafidCombo&value='+val;
		aHW(Q);
	}
}
function hndlCustComboChng(response, val){
	cBF = 'hndlCustComboChng';
	if(response){
//		alert(response);
		var dtl = response.split(';');// $rest = explode(';', $response);
		fObj('name_customer').innerHTML = dtl[0];
		fObj('code_customer').innerHTML = dtl[1];
		fObj('code_economic_customer').innerHTML = dtl[2];
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=getCustInfo&cId='+val;
		aHW(Q);
	}
}

//function hndlCategoryCustComboChng(response, val){
//	cBF = 'hndlCustComboChng';
//	if(response){
////		alert(response);
//		var dtl = response.split(';');// $rest = explode(';', $response);
//		fObj('category_name').innerHTML = dtl[0];
//		fObj('category_code').innerHTML = dtl[1];
////		fObj('code_economic_customer').innerHTML = dtl[2];
////		fObj('player_mask').style.display = 'block';
////		fObj('player_mask').innerHTML = beamContacts.tFunc;
//		
//	}else{
//		Q = 'pg=havaleMgmtPg&cmd=getCategoryCustInfo&cId='+val;
//		aHW(Q);
//	}
//}

function dspPrdType(type){
	var e=0;
	while(e<10){
		if(e==type){
			fObj('prodsCntnr_'+e).style.display = 'block';
		}else{
			fObj('prodsCntnr_'+e).style.display = 'none';
		}
		e++;
	}
}
function hndlProdComboChng1(response,val){
	cBF = 'hndlProdComboChng';
	if(response){
		
		var dtl = response.split(';');// $rest = explode(';', $response);
		fObj('p_name').innerHTML = dtl[0];
		fObj('p_code').innerHTML = dtl[1];
		fObj('p_price_combo').innerHTML = dtl[3];
 //       alert(dtl[3]);		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=getProdInfo&cId='+val;
		aHW(Q);
	}
}
function hndlProdComboChng(response,val){
	cBF = 'hndlProdComboChng';
	if(response){
		
		var dtl = response.split(';');// $rest = explode(';', $response);
		fObj('p_name').innerHTML = dtl[0];
		fObj('p_code').innerHTML = dtl[1];
		fObj('p_price_combo').innerHTML = dtl[3];
 //       alert(dtl[3]);		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=getProdInfo&cId='+fObj('inputString').value;
		aHW(Q);
	}
}
function GetCityCombo(response,val){
	cBF = 'GetCityCombo';
	if(response){
		
		var dtl = response.split(';');// $rest = explode(';', $response);
		
		fObj('getCityCombo').innerHTML = dtl[0];
        	
	}else{
		Q = 'pg=havaleMgmtPg&cmd=getProvinceInfo&cId='+val;
		aHW(Q);
	}
}

function hndlDocComboChng(response, val){
	cBF = 'hndlDocComboChng';
	if(response){
	//	alert(response);
		var dtl = response.split(';');// $rest = explode(';', $response);
    	fObj('d_documenttype').innerHTML = dtl[0];
    	fObj('d_accounttnum').innerHTML = dtl[1];
		fObj('d_bank').innerHTML = dtl[2];
		fObj('d_branch').innerHTML = dtl[3];
		fObj('d_fluentAccount').innerHTML = dtl[4];
	
	   	
	}else{
		Q = 'pg=havaleMgmtPg&cmd=getDocInfo&dId='+val;
		aHW(Q);
	}
}

function hndlLocationComboChng(response, val,val1){
	cBF = 'hndlLocationComboChng';
	if(response){
//		alert(response);
		var dtl = response.split(';');// $rest = explode(';', $response);
		fObj('l_name').innerHTML = dtl[0];
		fObj('l_type').innerHTML = dtl[1];
		if(l_type==3){
			fObj('row4').style.display = 'block';
			
		}else{
			
			fObj('row4').style.display = 'none';
		}
		
//		fObj('player_mask').style.display = 'block';
//		fObj('player_mask').innerHTML = beamContacts.tFunc;
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=getLocationInfo&locId='+val+'&l_type='+val1;
		aHW(Q);
	}
}
function hndlproductComboChng(response, val){
	cBF = 'hndlproductComboChng';
	if(response){
//		alert(response);
		var dtl = response.split(';');// $rest = explode(';', $response);
		fObj('p_name').innerHTML = dtl[0];
		
//		fObj('player_mask').style.display = 'block';
//		fObj('player_mask').innerHTML = beamContacts.tFunc;
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=getproductInfo&p_id='+val;
		aHW(Q);
	}
}
function addPfactor(response,val1,val2,val3){
	
	cBF = 'addPfactor';
	if(response){
	//alert(response);
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=addPfactor&ph_code='+val1+'&totalprice='+val2+'&pf_code='+val3;
       
		aHW(Q);
	}
}

function addhavale1(response,val1,val2){	
	cBF = 'addhavale1';
	if(response){
//		alert(response);
//		fObj('addedProdsCntnr').innerHTML = fObj('addedProdsCntnr').innerHTML+response;
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=addhavale1&ph_id='+val1+'&totalprice='+val2;
       
		aHW(Q);
	}
}
function addMoarefinameh(response,val1,val2,val3){
	
	cBF = 'addMoarefinameh';
	if(response){
		
		alert(response);
//		fObj('addedDocCntnr').innerHTML = fObj('addedDocCntnr').innerHTML+response;
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=addMoarefinameh&ph_code='+val1+'&totalprice='+val2+'&pf_code='+val3;
       
		aHW(Q);
	}
}

function addNewFactor(response,val1){	
	cBF = 'addNewFactor';
	if(response){
	//alert(response);
		var dtl = response.split(';');
		var f_id = dtl[0];
		var pf_code = dtl[1];
		var ph_code = dtl[2];
		var status = dtl[3];
//		alert(ph_code);	
			 
		if(status==3){
			alert('براي همه كالاهاي اين پيش فاكتور فاكتور صادر شده است');
		}else{
		window.open('?pg=PfactorMgmtPg&cmd=sucessRegF&f_id='+f_id+'&pf_code='+pf_code+'&ph_code='+ph_code,'_self');
		}
	}		   
		else{
		
		Q = 'pg=havaleMgmtPg&cmd=addNewFactor&ph_code='+val1;
       
		aHW(Q);
	}
}

function addhavale1(response,val1){	
	cBF = 'addhavale1';
	if(response){
//
		
		
alert(response);
//		fObj('addedProdsCntnr').innerHTML = fObj('addedProdsCntnr').innerHTML+response;
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=addhavale1&ph_code='+val1;
       
		aHW(Q);
	}
}
function ReportProd(response){
	
 //   cBF = 'ReportProd';
	if(response){
	//	alert(response);
	//	fObj('ShowReport').innerHTML = fObj('ShowReport').innerHTML+response;
		
	}else{
			
		Q = 'pg=havaleMgmtPg&cmd=ReportProd&firstDate='+fObj('firstDate').value+'&EndDate='+fObj('EndDate').value+'&firstNumber='+fObj('firstNumber').value+'&EndNumber='+fObj('EndNumber').value;
		aHW(Q);
	}
}

function insertHavale(response,val1,val2){
	
	cBF = 'insertHavale';
	if(response){
//		alert(response);
		fObj('addedhavale').innerHTML = fObj('addedhavale').innerHTML+response;
		

	}else{			
		Q = 'pg=havaleMgmtPg&cmd=insertHavale&pf_id='+val1+'&ph_id='+val2;
		
		aHW(Q);
	}
}

function insertFactor(response,val1,val2){
	
	cBF = 'insertFactor';
	if(response){
	//	alert(response);
		fObj('addedFactor').innerHTML = fObj('addedFactor').innerHTML+response;
		

	}else{
		
		
		Q = 'pg=havaleMgmtPg&cmd=insertFactor&ph_id='+val1+'&totalprice='+val2;
		
		aHW(Q);
	}
}

function insertFactor1(response,val1,val2,val3,val4,val5){
	
	cBF = 'insertFactor1';
	if(response){
		alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var f_id = dtl[1];
		var h_code = dtl[2];
		var f_code = dtl[3];
		var ph_code = dtl[4];
		var province_id = dtl[5];		
		var name_customer = dtl[6];
		var province_name = dtl[7];
		
		alert(message);
		window.open('PrintFactor.php?f_code='+f_code+'&f_id='+f_id+'&h_code='+h_code+'&ph_code='+ph_code+'&province_id='+province_id+'&province_name='+province_name+'&name_customer='+name_customer,'_self');

	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=insertFactor1&pf_code='+val1+'&h_code='+val2+'&f_code='+val3+'&ph_code='+val4+'&cusName='+val5;
		
		aHW(Q);
	}
}

function addInfPardakht(response){
	//cBF = 'addInfPardakht';
	if(response){
	//	alert(response);
	//	fObj('addedProdsCntnr').innerHTML = fObj('addedProdsCntnr').innerHTML+response;
		
	}else{
		
		
		Q = 'pg=havaleMgmtPg&cmd=addInfPardakht&d_code='+fObj('d_code').value+'&pf_num_doc='+fObj('pf_num_doc').value+'&pf_account_cus='+fObj('pf_account_cus').value+'&pf_sarresid_num='+fObj('pf_sarresid_num').value;
		
		aHW(Q);
	}
}

function addedProd(){
	cBF = 'addedProd';
	Q = 'pg=havaleMgmtPg&cmd=addedProd';
	
	aHW(Q);
	
}

function delAProdFromBill(response, val1,val2){
	cBF = 'delAProdFromBill';
		if(response){
			
			var dtl = response.split(';');
			var phd_id = dtl[0];
			var ph_id = dtl[1];
			
		fObj('bPrdC_'+phd_id).style.display='none';
	}else{
		Q = 'pg=havaleMgmtPg&cmd=delAProdFromBill&phd_id='+val1+'&ph_code='+val2;
		aHW(Q);
	}
}
//jadid

function addPdetFromBill(response, val1,val2){
	cBF = 'addPdetFromBill';
		if(response){
			
			var dtl = response.split(';');
			var phd_id = dtl[0];
			var ph_code = dtl[1];
			
			window.open('adddetprod.php?phd_id='+phd_id+'&ph_code='+ph_code,'_blank');

	}else{
		Q = 'pg=havaleMgmtPg&cmd=addPdetFromBill&phd_id='+val1+'&ph_code='+val2;
		aHW(Q);
	}
}


function delADocFromBill(response, val){
	cBF = 'delADocFromBill';
	if(response){
		fObj('Dcntr_'+response).style.display='none';
	}else{
		Q = 'pg=havaleMgmtPg&cmd=delADocFromBill&dpf_id='+val;
		aHW(Q);
	}
}


function DeletePHavale(response,val){
	cBF = 'DeletePHavale';	
	if(response){
		//alert(response);
		var dtl = response.split(';');
		var ph_id = dtl[0];
		var status = dtl[1];
		var message = dtl[2];
		
	if(status==0){
		alert(message);
		fObj('phavale_'+ph_id).style.display='none';
	        }else if(status==1){
	        	alert(message);	
	        }
	}else{
		Q = 'pg=havaleMgmtPg&cmd=DeletePHavale&ph_id='+val;
		aHW(Q);
	}
}
function refreshParent(){
	
	window.opener.location.href = window.opener.location.href;
	  if (window.opener.progressWindow)
	    window.opener.progressWindow.close();
	  window.close();
		
}
function passparent(response,val){
	cBF = 'passparent';
	
	if(response){
	//	alert(response);
		window.opener.document.form1.p_price_code1.value = response;
		
		window.close();
			
		}else{
			Q = 'pg=havaleMgmtPg&cmd=passparent&code='+val;
			aHW(Q);
		}
	
}
function passparentcus(response,val1){
	
	cBF = 'passparentcus';
	
	if(response){
     window.opener.document.form2.code_customer.value = response;
		
		window.close();
	
		}else{
			Q = 'pg=havaleMgmtPg&cmd=passparentcus&codecus='+val1;
			aHW(Q);
		}
	
}
function passparentprod(response,val1,val2){
	
	cBF = 'passparentprod';
	
	if(response){
	
		var dtl = response.split(';');
		var p_code = dtl[0];
		var price_code = dtl[1];

		window.opener.document.formprod.p_code.value = p_code;
		window.opener.document.formprod.p_price_combo.value = price_code;
		window.close();

//		refreshParent();
		
	
		}else{
			Q = 'pg=havaleMgmtPg&cmd=passparentprod&codeprod='+val1+'&pricecode='+val2;
			aHW(Q);
		}
	
}

function Deletefactor(response,val){
	cBF = 'Deletefactor';
	if(response){
		
		fObj('factor_'+response).style.display='none';
	
	}else{
		Q = 'pg=havaleMgmtPg&cmd=Deletefactor&f_id='+val;
		aHW(Q);
	}
}
function DeleteHavale(response,val){
	cBF = 'DeletePHavale';
	if(response){
		
		fObj('Havale_'+response).style.display='none';
	
	}else{
		Q = 'pg=havaleMgmtPg&cmd=DeleteHavale&h_id='+val;
		aHW(Q);
	}
}

function DeletePfactor(response,val){
	cBF = 'DeletePfactor';
	if(response){
	
		var dtl = response.split(';');
		var pf_id = dtl[0];
		var status = dtl[1];
		var message = dtl[2];
		if(status==1)
		{
			alert(message);
		fObj('Pfactor_'+pf_id).style.display='none';
		}else
		{
			alert(message);	
		}	
	
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=DeletePfactor&pf_id='+val;
		
		aHW(Q);
	}
}
function addAPrice2Bill(response,val1,val2){
	
	cBF = 'addAPrice2Bill';
	if(response){
	//alert(response);\
		var dtl = response.split(';');
		fObj('pf_unit_price').innerHTML = dtl[0];
		fObj('phd_amount').innerHTML = dtl[1];
		fObj('phd_id').innerHTML = dtl[2];
		fObj('pf_price').innerHTML = dtl[3];
		fObj('totalprice').innerHTML = dtl[4];
		eachprice=dtl[0]*dtl[1];
		fObj('priceProd'+dtl[2]).innerHTML = fObj('priceProd'+dtl[2]).innerHTML+eachprice;
		fObj('totalprice').innerHTML = fObj('totalprice').innerHTML+dt1[4];
	
	}else{

		Q = 'pg=havaleMgmtPg&cmd=addAPrice2Bill&pf_unit_price='+fObj('pf_unit_price'+val2).value+'&phd_amount='+val1+'&phd_id='+val2;
		aHW(Q);
	}
}

function Button1_onclick() {
	
    if (document.getElementById("customer_code").value == "") 
        alert("کد مشتري را وارد کنيد");
        return false;
        
//    else if{ (document.getElementById("customer_name").value == "") 
 //           alert("نام مشتري را وارد کنيد");
 //           return false;
 //   }   
}
function addDocument2Pf(response,val){	
	cBF = 'addDocument2Pf';
	if(response){
	alert(fObj('ph_code').value);
		if(response==1){
			
			addDocument2PfSave();
			
		}else if(response==2){
			alert('ابتدا پيش فاكتور را ثبت كنيد');
		}
	
 //   	fObj('addedDocCntnr').innerHTML = fObj('addedDocCntnr').innerHTML+response;
//		
	}else{

		Q = 'pg=havaleMgmtPg&cmd=addDocument2Pf&ph_code='+fObj('ph_code').value+'&dpf_d_id='+fObj('DocCombo').value+'&dpf_num='+fObj('dpf_num').value+'&dpf_sarresid='+fObj('dpf_sarresid').value+'&DocType='+fObj('d_documentType').innerHTML;
		Q += '&dpf_account='+fObj('dpf_account').value+'&dpf_price='+fObj('dpf_price').value+'&total_price='+fObj('total_price').value+'&dpf_type='+fObj('dpf_type').value+'&dpf_bank='+fObj('dpf_bank').value+'&dpf_branch='+fObj('dpf_branch').value+'&dpf_prov_sanad='+fObj('dpf_prov_sanad').value;
		aHW(Q);
	}
}
function addDocument2PfSave(response){
	
	cBF = 'addDocument2PfSave';
	if(response){	
		alert(response);
	
		   	fObj('addedDocCntnr').innerHTML = fObj('addedDocCntnr').innerHTML+response;
			
	}else{

		Q = 'pg=havaleMgmtPg&cmd=addDocument2PfSave&ph_code='+fObj('ph_code').value+'&dpf_d_id='+fObj('DocCombo').value+'&dpf_num='+fObj('dpf_num').value+'&dpf_sarresid='+fObj('dpf_sarresid').value+'&DocType='+fObj('d_documentType').innerHTML;
		Q += '&dpf_account='+fObj('dpf_account').value+'&dpf_price='+fObj('dpf_price').value+'&total_price='+fObj('total_price').value+'&dpf_type='+fObj('dpf_type').value+'&dpf_bank='+fObj('dpf_bank').value+'&dpf_branch='+fObj('dpf_branch').value+'&dpf_prov_sanad='+fObj('dpf_prov_sanad').value;
		aHW(Q);
	}
	
}
function addNewHavale(response,val1,val2,val3,val4,val5){
	
	cBF = 'addNewHavale';
	if(response){
	
		var dtl = response.split(';');
		var message = dtl[0];
		var h_ph_code = dtl[1];
		var h_code = dtl[2];
		var h_id = dtl[3];
		var status = dtl[4];
//		alert(h_ph_code);
		if (status==0){
		   alert(message);
		   }
		else if(status==2){
		  alert(message);
		}
		else if(status==3){
		  alert(message);
		}
		else if (status==1){
		alert(message);
//		res=confirm(response);
//		if(res){
//			alert('salam');
//		}
		window.open('?pg=PfactorMgmtPg&cmd=sucessRegH&h_ph_code='+h_ph_code+'&h_code='+h_code+'&h_id='+h_id,'_self');
            }	
	}else{
	
		Q = 'pg=havaleMgmtPg&cmd=addNewHavale&h_ph_code='+val1+'&pf_code='+val2+'&phd_price='+val3+'&phd_id='+val4+'&customer_code='+val5;
		aHW(Q);
	}
}
function addednewhavalekoli(response,val1,val2,val3,val4,val5,val6,val7,val8,val9){
	
	cBF = 'addednewhavalekoli';
	if(response){
		
		var dtl = response.split(';');
		var message = dtl[0];
		var h_ph_code = dtl[1];
		var h_code = dtl[2];
		var h_id = dtl[3];
		var status = dtl[4];
		var bestankari = dtl[6];
		var pf_code = dtl[7];
		var statusanbar = dtl[8];
		
		
		if (status==0){
		   alert(message);
		   }else if(status==5){
				  alert(message);
			}
		   else if(status==6){
				  alert(message);
			}
		else if(status==2){
		  alert(message);
		}
		else if(status==3){
		  alert(message);
		}else if(status==8){
		  alert(message);
		}else if(status==13){
			alert(message);
		}
		else if(status==4){
			res=confirm(message);
		if(res){
		
			window.betankari = bestankari;
			window.pf_code = pf_code;
	//	alert(window.pf_code);
		   addbestankari();
			}
		
		}
		
		else if(statusanbar==1){
			
			 alert(message);
			
		}
		else if (status==1){
		alert(message);
		window.open('?pg=havaleMgmtPg&cmd=dspHavaleList','_self');
	//	fObj('havale').style.display='none';
		
		
            }	
	}else{
	
		Q = 'pg=havaleMgmtPg&cmd=addednewhavalekoli&h_ph_code='+val1+'&pf_code='+val2+'&phd_price='+val3+'&phd_id='+val4+'&customer_code='+val5;
		aHW(Q);
	}
}
function addbestankari(response){
	
	cBF = 'addbestankari';
	
	if(response){
	//	 alert(window.myValue);
		 
		   
	}else{
		
	   	Q = 'pg=havaleMgmtPg&cmd=addbestankari&pf_code='+window.pf_code+'&bestankari='+window.betankari;
         
		aHW(Q);
		
		
	}
}

function addAProd2Bill(response){
	
	cBF = 'addAProd2Bill';		
	if(response){
	//	alert(response);
		//alert(fObj('selltype').innerHTML.value);
		var dtl = response.split(';');
		var status= dtl[0];
		var status1 = dtl[1];
		var mojodi = dtl[2];
		var l_type = dtl[3];
		var p_code = dtl[4];
		var phd_robari = dtl[5];
		var statusrobari = dtl[6];
		var h_id = dtl[7];
	
	//alert(statusrobari);
		
		alert('موجودی کالا '+mojodi+'میباشد');
		
		if(statusrobari==1){
			checkProdCode1();
			
		}else{
		
		if((phd_robari='')&& (l_type==3)){
			alert('لطفا محل روباری را مشخص کنید');
			
		
			
		}else if(status==1)	{
		//	alert(mojodi);
			if (mojodi==0){
				if(l_type==0){
	
					checkProdCode();
				}
				
				
				else if(p_code==2){
					
					checkProdCode();
				}else if(p_code==1){
					
					checkProdCode();
				}else if(p_code==21){
					
					checkProdCode();
				}else if(p_code==11){
					
					checkProdCode();
				}
				
				else{
					alert('چنین کالایی در این انبار موجودی ندارد');
				}
				
			}else{
			checkProdCode();
			}
			
		}else if(status==2){
			alert('چنين كالايي با اين كد كالا وكد قيمت وجود ندارد.');
		
		}
		else if(status==5){
			alert('مقدار انتخابی بیشتر از مقدار قابل برداشت از انبار است');
		
		}else if(status==7){
			alert('در نوع کالا خطا وجود دارد');
		
		}else if(status==8){
			alert('مقدار انتخابی بیشتر از حد مجاز است');
		
		}else if(status==10){
			alert('مقدار انتخابی باید ضریبی از 12 باشد');
		
		}if(status==12){
			alert('نوع کالای نهاده باید وارد شود');
		
		}
		
		else if(status1==3){
			alert('براي اين كالا بايد هزينه افزودني و كاستني وارد كنيد');
		
	}
		}	
		//else if(status1==4){
		//	alert('لطقا نوع تمام کالاهای خود را  بررسی نمایید و در صورت نیاز تغییر دهید');
		
		//}
    	
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=addAProd2Bill&h_id='+fObj('h_id').value+'&statusrobari='+fObj('statusrobari').value+'&ph_customer_code='+fObj('cId').value+'&ph_customer_type='+fObj('cType').value+'&phd_price_code='+fObj('p_price_combo').value;
		Q += '&phd_amount='+fObj('phd_amount').value+'&phd_deli_name='+fObj('phd_deli_name').value+'&phd_amount_remined='+fObj('phd_amount_remined').value+'&phd_name='+fObj('p_name').innerHTML+'&phd_l_id='+fObj('LocationCombo').value+'&phd_robari='+fObj('LocationCombo1').value;
        Q += '&cm_req_num='+fObj('cm_req_num').value+'&cm_req_date='+fObj( 'cm_req_date').value+'&phd_code='+fObj('p_code').value+'&phd_id_unit='+fObj('phd_id_unit').value+'&phd_operation_id='+fObj('ph_operation_id').value+'&ph_mojavez='+fObj('ph_mojavez').value+'&phm_id='+fObj('phm_id').value;
       
        Q += '&ph_types='+fObj('dts_id').value+'&ph_modat='+fObj('ph_modat').value+'&ph_zemanat='+fObj('selltype').value;
        Q += '&phd_tahator='+fObj('phd_tahator').value;
		aHW(Q);
	}
}

function EditAndEbtalCheck(response){
	
	cBF = 'EditAndEbtalCheck';	
	if(response){
	//	alert(response);
		var dtl = response.split(';');
		var status= dtl[0];
		var status1 = dtl[1];
		//alert(status);
		if(status==1)	{
			EditAndEbtal();
			
		}else if(status==2){
			alert('چنين كالايي با اين كد كالا وكد قيمت وجود ندارد.');
		
		}else if(status1==3){
			alert('براي اين كالا بايد هزينه افزودني و كاستني وارد كنيد');
		
		}		  	
	}else{
		var x=window.confirm( 'مقدار'+fObj('phd_amount').value+'كيلوگرم از حواله شما ابطال مي شود،آيا مي خواهيد ادامه دهيد؟');
		if (x){
		
		Q = 'pg=havaleMgmtPg&cmd=addAProd2Bill&statusrobari='+fObj('statusrobari').value+'&ph_customer_code='+fObj('cId').value+'&p_code='+fObj('p_code').value+'&ph_customer_type='+fObj('cType').value+'&phd_price_code='+fObj('p_price_combo').value;
		Q += '&phd_amount='+fObj('phd_amount').value+'&phd_deli_name='+fObj('phd_deli_name').value+'&phd_amount_remined='+fObj('phd_amount_remined').value+'&phd_name='+fObj('p_name').innerHTML+'&phd_l_id='+fObj('LocationCombo').value;
        Q += '&cm_req_num='+fObj('cm_req_num').value+'&cm_req_date='+fObj( 'cm_req_date').value+'&phd_code='+fObj('p_code').value+'&phd_id_unit='+fObj('phd_id_unit').value+'&ebh_reb_id='+fObj('ebh_reb_id').value;
        		
		
		}else{
			
			
		}
		aHW(Q);
	}	
}
function EditAndEbtalCheckk(response){
	
	cBF = 'EditAndEbtalCheckk';	
	if(response){
		window.open('?pg=havaleMgmtPg&cmd=done', '_self');
		
			  	
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=EditAndEbtalCheckk&phd_id='+fObj('phd_id').value+'&phd_amount='+fObj('phd_amount').value+'&phd_jari='+fObj('phd_jari').value;
		Q += '&h_id='+fObj('h_id').value+'&his_id='+fObj('his_id').value;

		aHW(Q);
	}	
}
function EbtalM(response){
	
	cBF = 'EbtalM';	
	if(response){
		//alert(response);
		var dtl = response.split(';');
		var pf_id= dtl[0];
		var ebm_id = dtl[1];
		window.open('?pg=havaleMgmtPg&cmd=ebtalMPage&ebm_id='+ebm_id+'&pf_id='+pf_id, '_self');
		
		}else{
			
			Q = 'pg=havaleMgmtPg&cmd=EbtalM&pf_id='+fObj('pf_id').value;					    		
			aHW(Q);
		}	
	
}
function EditAndEbtal(response){

	cBF = 'EditAndEbtal';
	//alert('sss');
	if(response){
		
		var dtl = response.split(';');
		var ebh_id= dtl[0];
		var status = dtl[1];
		//alert(response);
	
		if(status==2){
			alert('مقدار وارده نا درست است');
		}else if(status==3){
			alert('مقدار وارده بیشتر از موجودی انبار است');
		}else if(status==4){
			alert('سیستم در حال حاضر قادر به پاسخگویی نیست لطفا دوباره تلاش کنید');
		}else if(status==6){
			alert('شما نمیتوانید بیشتر از کسرارسالی ابطال داشته باشید');
		}
		
		else{
			//alert(ebh_id);
			window.open('?pg=havaleMgmtPg&cmd=ebtalPage&ebh_id='+ebh_id, '_self');
			
		}
	//	window.open('?pg=havaleMgmtPg&cmd=ebtalPage&ebh_id='+ebh_id, '_self');
	
	}else{
		Q   = 'pg=havaleMgmtPg&cmd=EditAndEbtal&phd_price_code='+fObj('p_price_combo').value;
		Q += '&phd_amount='+fObj('phd_amount').value+'&phd_deli_name='+fObj('phd_deli_name').value+'&phd_amount_remined='+fObj('phd_amount_remined').value+'&phd_name='+fObj('p_name').innerHTML+'&phd_l_id='+fObj('LocationCombo').value;
        Q += '&phd_code='+fObj('p_code').value+'&phd_id_unit='+fObj('phd_id_unit').value+'&p_code_pre='+fObj('p_code_pre').value+'&p_price_code_pre='+fObj('p_price_code_pre').value+'&l_code_pre='+fObj('l_code_pre').value+'&l_code_pre='+fObj('l_code_pre').value+'&phd_amount_pre='+fObj('phd_amount_pre').value;
	    Q += '&phd_id='+fObj('phd_id').value+'&phd_price_pre='+fObj('phd_price_pre').value+'&phd_id_unit_pre='+fObj('phd_id_unit_pre').value+'&h_code='+fObj('h_code').value+'&h_id='+fObj('h_id').value+'&ebh_reb_id='+fObj('ebh_reb_id').value;

		aHW(Q);
		
	}
}
function checkProdCode(response){

	cBF = 'checkProdCode';
	
	if(response){
//alert(fObj('selltype').value);
	
		
		fObj('addedProdsCntnr').innerHTML = fObj('addedProdsCntnr').innerHTML+response;

	}else{
		Q = 'pg=havaleMgmtPg&cmd=checkCodeP&h_id='+fObj('h_id').value+'&ph_customer_code='+fObj('cId').value+'&ph_customer_type='+fObj('cType').value+'&phd_price_code='+fObj('p_price_combo').value;
		Q += '&phd_amount='+fObj('phd_amount').value+'&phd_deli_name='+fObj('phd_deli_name').value+'&phd_amount_remined='+fObj('phd_amount_remined').value+'&phd_name='+fObj('p_name').innerHTML+'&phd_l_id='+fObj('LocationCombo').value+'&phd_robari='+fObj('LocationCombo1').value;;
        Q += '&cm_req_num='+fObj('cm_req_num').value+'&cm_req_date='+fObj( 'cm_req_date').value+'&phd_code='+fObj('p_code').value+'&phd_id_unit='+fObj('phd_id_unit').value+'&ph_operation_id='+fObj('ph_operation_id').value+'&ph_mojavez='+fObj('ph_mojavez').value+'&phm_id='+fObj('phm_id').value;
        Q += '&ph_types='+fObj('dts_id').value+'&ph_modat='+fObj('ph_modat').value+'&ph_zemanat='+fObj('ph_zemanat').value+'&phd_tahator='+fObj('phd_tahator').value;
    
		aHW(Q);
		
	}
	
}
function checkProdCode1(response){

	cBF = 'checkProdCode1';
	
	if(response){

	
		
		fObj('addedProdsCntnr').innerHTML = fObj('addedProdsCntnr').innerHTML+response;

	}else{
		Q = 'pg=havaleMgmtPg&cmd=checkCodeP1&h_id='+fObj('h_id').value+'&ph_customer_code='+fObj('cId').value+'&ph_customer_type='+fObj('cType').value+'&phd_price_code='+fObj('p_price_combo').value;
		Q += '&phd_amount='+fObj('phd_amount').value+'&phd_deli_name='+fObj('phd_deli_name').value+'&phd_amount_remined='+fObj('phd_amount_remined').value+'&phd_name='+fObj('p_name').innerHTML+'&phd_l_id='+fObj('LocationCombo').value+'&phd_robari='+fObj('LocationCombo1').value;;
        Q += '&cm_req_num='+fObj('cm_req_num').value+'&cm_req_date='+fObj( 'cm_req_date').value+'&phd_code='+fObj('p_code').value+'&phd_id_unit='+fObj('phd_id_unit').value+'&ph_operation_id='+fObj('ph_operation_id').value+'&ph_mojavez='+fObj('ph_mojavez').value+'&phm_id='+fObj('phm_id').value;
        Q += '&ph_types='+fObj('dts_id').value+'&ph_modat='+fObj('ph_modat').value+'&ph_zemanat='+fObj('ph_zemanat').value+'&phd_tahator='+fObj('phd_tahator').value;
    
		aHW(Q);
		
	}
	
}
function checkvalidData(response){
	cBF = 'checkvalidData';	
	if(response){
	//	alert(response);
		var dtl = response.split(';');
		var status = dtl[0];
		var message = dtl[1];
		var status3 = dtl[2];
		//alert(status);
		if(status3==1){
			alert('اين مشتري بدهكار مي باشد ، ابتدا  بدهي را در سيستم مالي تسويه كنيد سپس ادامه دهيد! ');
		}
		if(status==1){
			alert(message);
		}else if(status==2){
			alert(message);
		}
		else if(status==6){
			alert(message);
		}
		else if(status==0){
		window.open('?pg=havaleMgmtPg&cmd=dspPreHavaleFrm2&cType=norm&cId='+fObj('code_customer').value+'&cm_req_date='+fObj('cus_req_date').value+'&cus_req_num='+fObj('cus_req_num').value+'&cus_code='+fObj('code_customer').innerHTML+'&phm_id='+fObj('phm_id').value+'&ph_mojavez='+fObj('ph_mojavez').value, '_self');
	
		}
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=checkvalidData&code_customer='+fObj('code_customer').value+'&cm_req_date='+fObj('cm_req_date').value;
		Q += '&cus_req_num='+fObj('cus_req_num').value+'&phm_id='+fObj('phm_id').value+'&ph_mojavez='+fObj('ph_mojavez').value;
      
       
		aHW(Q);
	}
	
}
function validusername(response){
	cBF = 'validusername';	
	if(response){
		var dtl = response.split(';');
		var status = dtl[0];
		var message = dtl[1];
		if(status==1){
			alert(message);
		}else{
			window.open('?pg=prodMgmtPg&cmd=regNewUser&u_name='+fObj('u_name').value+'&u_family='+fObj('u_family').value+'&u_user_name='+fObj('u_user_name').value
				+'&u_email='+fObj('u_email').value+'&u_pass_word='+fObj('u_pass_word').value+
				'&u_phone='+fObj('u_phone').value+'&u_city_id='+fObj('u_city_id').value+'&u_group_menu_id='+fObj('NameGroupCombo').value+'&year_id='+fObj('NameYearCombo').value+'&u_province_id='+fObj('NameProvinceCombo1').value,'_self');
		}
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=validusername&u_user_name='+fObj('u_user_name').value;
		
           
		aHW(Q);
	}
	
}
function checkvalidcusData(response){
	
	cBF = 'checkvalidcusData';	
	if(response){
		
		var dtl = response.split(';');
		var status = dtl[0];
		var message = dtl[1];
		var ph_code = dtl[2];
		
		if(status==1){
			alert(message);
		}else{
			window.open('?pg=havaleMgmtPg&cmd=EditPishHavale&ph_code='+ph_code, '_self');

		}
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=checkvalidcus&code_customer='+fObj('ph_customer_code').value+'&cm_req_date1='+fObj('cm_req_date1').value;
		Q += '&cm_req_num='+fObj('cm_req_num').value+'&ph_code='+fObj('ph_code').value+'&ph_mojavez='+fObj('ph_mojavez').value;
      
       
		aHW(Q);
	}
	
}
function addAProd2Bill_H(response){
	
	cBF = 'addAProd2Bill';	
	if(response){
	//	alert(response);
		fObj('addedProdsCntnr').innerHTML = fObj('addedProdsCntnr').innerHTML+response;
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=addAProd2Bill_H&ph__code='+fObj('ph_code').value+'&phd_price_code='+fObj('priceCombo').value;
		Q += '&phd_amount='+fObj('phd_amount').value+'&phd_deli_name='+fObj('phd_deli_name').value+'&phd_amount_remined='+fObj('phd_amount_remined').value+'&phd_name='+fObj('p_name').innerHTML+'&phd_l_id='+fObj('LocationCombo').value;
        Q += '&phd_code='+fObj('inputString').value;
	    Q += '&ph_mojavez='+fObj('ph_mojavez').value;
       
		aHW(Q);
	}
}
function checkExistCode(response){
	cBF = 'checkExistCode';
	
	if(response){
		alert(response);
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=checkExistCode&p_code='+fObj('inputString').value;

		aHW(Q);
	}
}
function addAProd2Bill1(response,val1){	
	cBF = 'addAProd2Bill1';
	
	if(response){
		alert(response);
		fObj('addedProdsCntnr').innerHTML = fObj('addedProdsCntnr').innerHTML+response;
		
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=addAProd2Bill1&ph_customer_code='+fObj('cId').value+'&ph_customer_type='+fObj('cType').value+'&phd_pid='+fObj('ProdCombo').value+'&phd_price_code='+fObj('priceCombo').value;
		Q += '&phd_amount='+fObj('phd_amount').value+'&phd_deli_name='+fObj('phd_deli_name').value+'&phd_amount_remined='+fObj('phd_amount_remined').value+'&phd_name='+fObj('p_name').innerHTML+'&phd_l_name='+fObj('l_name').innerHTML;
        Q += '&cm_req_num='+fObj('cm_req_num').value+'&cm_req_date='+fObj('cm_req_date').value+'&ph_operation_id='+fObj('ph_operation_id').value+'&ph_mojavez='+fObj('ph_mojavez').value;
       
		aHW(Q);
	}
}
function AddAMenuToList(response,val,val1){	
	cBF = 'AddAMenuToList';
	
	if(response){
//		alert(response);
		
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var menu_id= dtl[2];
		fObj('ezaf_'+menu_id).style.display='none';
		fObj('kam_'+menu_id).style.display='block';
		
		if(status==2){
			alert(message);
		}
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=AddAMenuToList&rel_menu_id='+val+'&rel_ug_id='+val1;

//		Q = 'pg=havaleMgmtPg&cmd=AddAMenuToList&rel_menu_id='+val+'&ug_id='+fObj('ug_id').innerHTML+'&ug_category='+fObj('ug_category').innerHTML;
       
		aHW(Q);
	}
}
function AddAllMenuToList(response,val,val1){	
	cBF = 'AddAllMenuToList';	
	if(response){
	//	alert(response);
		var dtl = response.split(';');
		var ug_id = dtl[0];
		var u_id = dtl[1];
		window.open('?pg=prodMgmtPg&cmd=ShowAccess&ug_id='+ug_id+'&u_id='+u_id,'_self');
				
	}else{
		Q = 'pg=havaleMgmtPg&cmd=AddAllMenuToList&rel_ug_id='+val+'&u_id='+val1;

       
		aHW(Q);
	}
}

function addloc(response,val,val1){	
	cBF = 'addloc';
	
	if(response){
	
		var dtl = response.split(';');
		var chl_ch_id = dtl[0];
		var chl_l_id = dtl[1];
		
		fObj('ezaf_'+chl_l_id).style.display='none';
		fObj('kam_'+chl_l_id).style.display='block';
		
		if(status==2){
			alert(message);
		}
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=addloc&chl_ch_id='+val+'&chl_l_id='+val1;

       
		aHW(Q);
	}
}
function addoper(response,val,val1){	
	cBF = 'addoper';
	
	if(response){
	
		var dtl = response.split(';');
		var oph_ch_id = dtl[0];
		var oph_op_id = dtl[1];
		
		fObj('ezaf_'+oph_op_id).style.display='none';
		fObj('kam_'+oph_op_id).style.display='block';
		
		if(status==2){
			alert(message);
		}
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=addoper&oph_ch_id='+val+'&oph_op_id='+val1;

       
		aHW(Q);
	}
}

function AddAdetanbar(response,val,val1,val2,val3){	
	cBF = 'AddAdetanbar';

	if(response){
//	alert(response);
	
		
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var dad_anbar_id= dtl[2];
		var vaznkarton= dtl[3];
		
		if(status==0){
			
		fObj('ezaf_'+dad_anbar_id).style.display='none';
		fObj('kam_'+dad_anbar_id).style.display='block';
		}else
		{
			alert(message);
		}
		
	}else{
		
		
		Q = 'pg=havaleMgmtPg&cmd=AddAdetanbar&dad_phd_id='+val+'&dad_anbar_id='+val1+'&dad_vazn_karton='+val2+'&tedad_karton='+val3+'&dad_tedad='+fObj('dad_tedad_'+val1).value+'&dad_vazn_n='+fObj('dad_vazn_n_'+val1).value+'&dad_vazn_kh='+fObj('dad_vazn_kh_'+val1).value;

       
		aHW(Q);
	}
}


function ebtalAdetanbar(response,val,val1,val2,val3 ,val4){	
	cBF = 'ebtalAdetanbar';

	if(response){
//alert(response);
	
		
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var phd_id= dtl[2];
		var dad_anbar_id=dtl[3];
		
		
		
		if(status==7){
			alert(message);
		
		
		}
		else if(status==0){
			alert(message);
			fObj('ezaf_'+dad_anbar_id).style.display='none';
		
		}else if(status==1)
		{
			alert(message);
			fObj('ezaf_'+dad_anbar_id).style.display='none';
		
			window.open('?pg=havaleMgmtPg&cmd=done', '_self');
		}
		
	}else{
		
		
		Q = 'pg=havaleMgmtPg&cmd=ebtalAdetanbar&dad_phd_id='+val+'&dad_anbar_id='+val1+'&ebh_id='+val2+'&his_id='+val3+'&dad_tedad='+fObj('dad_tedad_'+val1).value+'&dad_vazn_n='+fObj('dad_vazn_n_'+val1).value+'&dad_vazn_kh='+fObj('dad_vazn_kh_'+val1).value+'p_pakage_type='+val4;

       
		aHW(Q);
	}
}


function delAdetanbar(response,val,val1,val2){	
	cBF = 'delAdetanbar';
	
	if(response){
//	alert(response);

		
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var dad_anbar_id= dtl[2];
		if(status==0){
		fObj('ezaf_'+dad_anbar_id).style.display='block';
		fObj('kam_'+dad_anbar_id).style.display='none';
		}else
		{
			alert(message);
		}
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=delAdetanbar&dad_phd_id='+val+'&dad_anbar_id='+val1+'&dad_tedad='+fObj('dad_tedad_'+val1).value+'&dad_vazn_n='+fObj('dad_vazn_n_'+val1).value+'&dad_vazn_kh='+fObj('dad_vazn_kh_'+val1).value+'&p_pakage_type='+val2;

       
		aHW(Q);
	}
}
function AddAMenuToList1(response,val,val1,val2){	
	cBF = 'AddAMenuToList1';
	
	if(response){
//	alert(response);

		
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var menu_id= dtl[2];
		fObj('ezaf_'+menu_id).style.display='none';
		fObj('kam_'+menu_id).style.display='block';
		
		if(status==2){
			alert(message);
		}
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=AddAMenuToList1&rel_menu_id='+val+'&rel_ug_id='+val1+'&u_id='+val2;

       
		aHW(Q);
	}
}
function Addprodv(response,val){	
	cBF = 'Addprodv';
	
	if(response){
		var dtl = response.split(';');
		var p_id = dtl[0];
	
		
		fObj('ezaf_'+p_id).style.display='none';
		fObj('kam_'+p_id).style.display='block';
		
		
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=Addprodv&p_id='+val;

       
		aHW(Q);
	}
}
function delprodv(response,val){	
	cBF = 'delprodv';
	
	if(response){
	//alert(response);
	var dtl = response.split(';');
	var p_id = dtl[0];
	
		
		fObj('ezaf_'+p_id).style.display='block';
		fObj('kam_'+p_id).style.display='none';
		
		
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=delprodv&p_id='+val;

       
		aHW(Q);
	}
}


function AddAccessEdit(response,val,val1,val2){	
	cBF = 'AddAccessEdit';
	
	if(response){
	//	alert(response);
		var dtl = response.split(';');	
		var menu_id= dtl[0];
		fObj('Edit_'+menu_id).style.display='none';
		fObj('NoEd_'+menu_id).style.display='block';
		
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=AddAccessEdit&rel_menu_id='+val+'&rel_ug_id='+val1+'&u_id='+val2;

       
		aHW(Q);
	}
}
function NoAccessEdit(response,val,val1,val2){	
	cBF = 'NoAccessEdit';
	
	if(response){
		
		var dtl = response.split(';');	
		var menu_id= dtl[0];
		fObj('Edit_'+menu_id).style.display='block';
		fObj('NoEd_'+menu_id).style.display='none';
		
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=NoAccessEdit&rel_menu_id='+val+'&rel_ug_id='+val1+'&u_id='+val2;

       
		aHW(Q);
	}
}

function AddAccessDelete(response,val,val1,val2){	
	cBF = 'AddAccessDelete';
	
	if(response){
		
		var dtl = response.split(';');	
		var menu_id= dtl[0];
		fObj('Del_'+menu_id).style.display='none';
		fObj('NoDel_'+menu_id).style.display='block';
		
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=AddAccessDelete&rel_menu_id='+val+'&rel_ug_id='+val1+'&u_id='+val2;

       
		aHW(Q);
	}
}
function NoAccessDelete(response,val,val1,val2){	
	cBF = 'NoAccessDelete';
	
	if(response){
		
		var dtl = response.split(';');	
		var menu_id= dtl[0];
		fObj('Del_'+menu_id).style.display='block';
		fObj('NoDel_'+menu_id).style.display='none';
		
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=NoAccessDelete&rel_menu_id='+val+'&rel_ug_id='+val1+'&u_id='+val2;

       
		aHW(Q);
	}
}
function DelAMenuToList(response,val,val1){	
	cBF = 'DelAMenuToList';
	
	if(response){
//	alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var menu_id = dtl[2];
		fObj('kam_'+menu_id).style.display='none';
		fObj('ezaf_'+menu_id).style.display='block';
		
//			alert(message);
	
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=DelAMenuToList&rel_menu_id='+val+'&rel_ug_id='+val1;

//		Q = 'pg=havaleMgmtPg&cmd=AddAMenuToList&rel_menu_id='+val+'&ug_id='+fObj('ug_id').innerHTML+'&ug_category='+fObj('ug_category').innerHTML;
       
		aHW(Q);
	}
}
function delloc(response,val,val1){
	
	cBF = 'delloc';
	
	if(response){
//	alert(response);
		var dtl = response.split(';');
		var chl_id = dtl[0];
		var l_id = dtl[1];
		
		fObj('kam_'+l_id).style.display='none';
		fObj('ezaf_'+l_id).style.display='block';
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=delloc&chl_id='+val+'&l_id='+val1;

       
		aHW(Q);
	}
}
function delopr(response,val,val1){
	
	cBF = 'delopr';
	
	if(response){
//	alert(response);
		var dtl = response.split(';');
		var oph_id = dtl[0];
		var g_id = dtl[1];
		
		fObj('kam_'+g_id).style.display='none';
		fObj('ezaf_'+g_id).style.display='block';
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=delopr&oph_id='+val+'&g_id='+val1;

//		Q = 'pg=havaleMgmtPg&cmd=AddAMenuToList&rel_menu_id='+val+'&ug_id='+fObj('ug_id').innerHTML+'&ug_category='+fObj('ug_category').innerHTML;
       
		aHW(Q);
	}
}
function DelAMenuToList1(response,val,val1,val2){	
	cBF = 'DelAMenuToList1';
	
	if(response){
//	alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var menu_id = dtl[2];
		fObj('kam_'+menu_id).style.display='none';
		fObj('ezaf_'+menu_id).style.display='block';
		
//			alert(message);
	
		
	}else{
		Q = 'pg=havaleMgmtPg&cmd=DelAMenuToList1&rel_menu_id='+val+'&rel_ug_id='+val1+'&u_id='+val2;

//		Q = 'pg=havaleMgmtPg&cmd=AddAMenuToList&rel_menu_id='+val+'&ug_id='+fObj('ug_id').innerHTML+'&ug_category='+fObj('ug_category').innerHTML;
       
		aHW(Q);
	}
}
function Ebtal_createNewh(response,val1,val2,val3){	
	cBF = 'Ebtal_createNewh';
	if(response){
		
	var dtl = response.split(';');
	var h_id = dtl[0];
	var pf_code = dtl[1];
	var message = dtl[2];
	var h_code = dtl[3];
//	alert(response);
	
		window.open('?pg=havaleMgmtPg&cmd=createNewH&h_id='+h_id+'&pf_code='+pf_code+'&h_code='+h_code,'_self');
//		fObj('addedProdsCntnr').innerHTML = fObj('addedProdsCntnr').innerHTML+response;
	}else{
		
		
		Q = 'pg=havaleMgmtPg&cmd=Ebtal_createNewh&h_code='+val1+'&pf_code='+val2+'&ph_code='+val3;
       
		aHW(Q);
	
	
	}
}

function EbtalHavaleNotNew(response,val1,val2,val3,val4){	
	cBF = 'EbtalHavaleNotNew';
	if(response){
	//	alert(response);
	var dtl = response.split(';');
	var h_id = dtl[0];
	var pf_id = dtl[1];
	var message = dtl[3];
	var ebh_id = dtl[5];
	alert(message);

		window.open('?pg=havaleMgmtPg&cmd=EbtalMessage&h_id='+h_id+'&pf_id='+pf_id+'&ebh_id='+ebh_id,'_self');

	}else{
		var x=window.confirm("كل حواله شما ابطال مي شود، آيا مي خواهيد ادامه دهيد؟")
		if (x){
		
		Q = 'pg=havaleMgmtPg&cmd=EbtalHavaleNotNew&h_id='+val1+'&pf_code='+val2+'&ph_code='+val3+'&ebh_reb_id='+val3;
       
		aHW(Q);
	}
          	}
} 
function check(response){
	//alert('salam');
	
	cBF = 'check';
	if(response){
		//alert(response);
		
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		if(status==1){
		alert(message);
		return false;
		}else{
			return true;
		}
		
	}else{	
	Q = 'pg=havaleMgmtPg&cmd=check&p_iran_code='+fObj('p_iran_code').value;
	aHW(Q);
	}
	
}

function hndlMenuComboChng(response, val){
	cBF = 'hndlMenuComboChng';
	if(response){
//		alert(response);
		var dtl = response.split(';');// $rest = explode(';', $response);
		fObj('ug_id').innerHTML = dtl[0];
		fObj('ug_category').innerHTML = dtl[1];
    	
			
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=getMenuInfo&menu_id='+val;
		aHW(Q);
	}
}
function checkAndValidProdName(response){
	
	cBF = 'checkAndValidProdName';
	if(response){
	//	alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
	//	alert(status);
		if(status==1){
			alert(message);
		}
		else if(status==0){	
		
			 window.open('?pg=prodMgmtPg&cmd=regProd1&p_number='+fObj('p_number').value+'&p_code='+fObj('p_code').value+'&p_name='+fObj('p_name').value+'&p_pakage_type='+fObj('p_pakage_type').value+
			 		 '&p_unit='+fObj('p_unit').value+'&p_sellprice='+fObj('p_sellprice').value+'&p_subsidies='+fObj('p_subsidies').value+'&p_category='+fObj('p_category').value+'&p_type='+fObj('p_type').value+'&p_iran_code='+fObj('p_iran_code').value+'&p_charge='+fObj('p_charge').value+'&p_price_code='+fObj('p_price_code1').value
			 		 +'&p_group_id='+fObj('p_group_id').value+'&p_valueadd='+fObj('p_valueadd').value+'&p_id='+fObj('p_id').value+'&p_kilo='+fObj('p_kilo').value,'_self');

		}else if(status==2){
			alert(message);
		}else if(status==3){
			alert(message);

		}
				
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=checkAndValidProdName&p_id='+fObj('p_id').value+'&p_code='+fObj('p_code').value+'&p_name='+fObj('p_name').value+'&p_price_code='+fObj('p_price_code1').value;
		aHW(Q);
	}
}
function checkAndValidProdNameEdit(response){
	
	cBF = 'checkAndValidProdNameEdit';
	if(response){
	
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var p_id = dtl[2];
		var status1 = dtl[3];
	//alert(status1);
		if(status==1){
			alert(message);
		}else if(status==3){
			alert(message);
		}
		if(status==0){
			 window.open('?pg=prodMgmtPg&cmd=updPrdInf&p_code='+fObj('p_code').value+'&p_name='+fObj('p_name').value+'&p_pakage_type='+fObj('p_pakage_type').value+
			 		 '&p_unit='+fObj('p_unit').value+'&p_sellprice='+fObj('p_sellprice').value+'&p_price_code='+fObj('p_price_code').value+'&p_price_mabadi='+fObj('p_price_mabadi').value+'&p_code_pmabadi='+fObj('p_code_pmabadi').value+
			     '&p_totalprice='+fObj('p_totalprice').value+'&p_Subsidies='+fObj('p_Subsidies').value+'&p_category='+fObj('p_category').value+'&p_type='+fObj('p_type').value+'&p_redundancy='+fObj('p_redundancy').value+'&p_number='+fObj('p_number').value+'&p_id1='+fObj('p_id1').value+'&price_id='+fObj('price_id').value+
			     '&p_charge='+fObj('p_charge').value+'&p_kilo='+fObj('p_kilo').value+'&status1='+status1+'&p_id='+p_id , '_self');
		}
				
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=checkAndValidProdNameEdit&p_code='+fObj('p_code').value+'&p_name='+fObj('p_name').value+'&p_id='+fObj('p_id').value+'&p_price_code='+fObj('p_price_code').value+'&price_id='+fObj('price_id').value;
		aHW(Q);
	}
}
function checkprod_morgh(response){
	
	cBF = 'checkprod_morgh';
	if(response){
	//alert(response);
		var dtl = response.split(';');
		var pm_id = dtl[0];
		var status = dtl[1];
		
	
		
		if(status==0){
			 window.open('?pg=prodMgmtPg&cmd=updPrd_morgh&pm_pcode='+fObj('pm_pcode').value+'&pm_price_code='+fObj('pm_price_code').value+'&pm_price='+fObj('pm_price').value+'&pm_id='+fObj('pm_id').value+'&pm_id='+pm_id, '_self');
		}
				
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=checkprod_morgh&pm_pcode='+fObj('pm_pcode').value+'&pm_price_code='+fObj('pm_price_code').value+'&pm_price='+fObj('pm_price').value+'&pm_id='+fObj('pm_id').value;
		aHW(Q);
	}
}

function checkAndValidProdNameEditM(response){
	
	cBF = 'checkAndValidProdNameEditM';
	if(response){
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
//		alert(response);
		if(status==1){
			alert(message);
			
		}else{
	
	window.open('?pg=prodMgmtPg&cmd=updPrdInfM& p_id='+fObj('p_id').value+'&p_sellprice='+fObj('p_sellprice').value+'&p_price_code='+fObj('p_price_code').value , '_self');
		}
	}else{
		Q = 'pg=havaleMgmtPg&cmd=checkAndValidProdNameEditM&p_code='+fObj('p_code').value+'&p_price_code='+fObj('p_price_code').value+'&p_name='+fObj('p_name').value;

		 		
		     
		aHW(Q);
	}
}
//
function checkAndValiPriceCode(response){
	
	cBF = 'checkAndValiPriceCode';
	if(response){
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		if(status==1){
			alert(message);
		}
				
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=checkAndValiPriceCode&p_code='+fObj('p_code').value+'&p_price_code='+fObj('p_price_code').value;
		aHW(Q);
	}
}

function CheckCodeL(response){
	
	cBF = 'CheckCodeL';
	if(response){
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		if(status==1){
			alert(message);
		}else if(status==0){
			
			  window.open('?pg=prodMgmtPg&cmd=regLocationGoods&l_code='+fObj('l_code').value+'&l_name='+fObj('l_name').value+'&l_distance='+fObj('l_distance').value+'&l_type='+fObj('l_type').value,'_self');

		}
				
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=CheckCodeL&l_code='+fObj('l_code').value;
		aHW(Q);
	}
}
function CheckCodeLEdit(response){
	
	cBF = 'CheckCodeLEdit';
	if(response){
//	alert(fObj('l_type').value);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var l_id = dtl[2];
		
		if(status==1){
			alert(message);
		}else if(status==0){
		  window.open('?pg=prodMgmtPg&cmd=upLocationGoodsInf&l_code='+fObj('l_code').value+'&l_name='+fObj('l_name').value+'&l_distance='+fObj('l_distance').value+'&l_id='+fObj('l_id').value+'&l_type='+fObj('l_type').value,'_self');	
		}
				
	}else{
		
		Q = 'pg=havaleMgmtPg&cmd=CheckCodeLEdit&l_code='+fObj('l_code').value+'&l_id='+fObj('l_id').value;
		aHW(Q);
	}
}
function checkGroupName(response){
	
	cBF = 'checkGroupName';
	if(response){
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		if(status==1){
			alert(message);
		}else if(status==0){
		
		     window.open('?pg=prodMgmtPg&cmd=RegNewGroup&ug_category='+fObj('ug_category').value , '_self');
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=checkGroupName&ug_category='+fObj('ug_category').value;
		    aHW(Q);
	}
}
function validCodech(response){
	
	cBF = 'validCodech';
	if(response){
		
		 var counter = 0, // counter for checked checkboxes
	        i = 0,       // loop variable
	        url = '',    // final url string
	        // get a collection of objects with the specified 'input' TAGNAME
	        input_obj = document.getElementsByName('opr_list');
	    // loop through all collected objects
		 oprlist = new Array();
		 
         url = url + '&c[]=mj' ;

	    for (i = 0; i < input_obj.length; i++) {
	    	
	        // if input object is checkbox and checkbox is checked then ...
	        if (input_obj[i].type === 'checkbox' && input_obj[i].checked === true) {
	            // ... increase counter and concatenate checkbox value to the url string
	        	
	            counter++;
	           
	            
	            url = url + '&c[]=' + input_obj[i].value;
 
	        }
	       
	    }
	    oprlist = new Array(counter);
   
	    // display url string or message if there is no checked checkboxes
	    if (counter > 0) {
	        // remove first "&" from the generated url string
	        url = url.substr(1);
	        // display final url string
	      //  alert(url);
	        // or you can send checkbox values
	        // window.location.href = 'my_page.php?' + url; 
	        status1=0;
	    }
	    else {
	    	status1=5;
	        alert('حداقل یک عمليات را انتخاب کنيد');
	      
	    }
			
	    //baraye location
	    
		  var counter1 = 0, 
		        j1 = 0,       
		        url1 = '',    
		        input_obj1 = document.getElementsByName('l_list');
			 llist = new Array();
			 
	       url1 = url1 + '&f[]=mj' ;

		    for (j1 = 0; j1 < input_obj1.length; j1++) {
		    	
		        if (input_obj1[j1].type === 'checkbox' && input_obj1[j1].checked === true) {
		        	
		            counter1++;
		           
		            
		            url1= url1 + '&f[]=' + input_obj1[j1].value;

		        }
		       
		    }
		 

		    if (counter1 > 0) {
		        url1 = url1.substr(1);
		      //  alert (url1);
		        status2=0;
		       
		    }
		    else {
		    	status2=5;
		        alert('حداقل يک محل را انتخاب کنيد');
		      
		      
		    }
	    
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		//alert(status);
		if(status==1){
			alert(message);
		}
		if(status==2){
			alert(message);
		}else if(status==3){
			
			alert(message);
		}
		else if(status==0 && status1==0 && status2==0){
		
	     window.open('?pg=prodMgmtPg&cmd=regchargeFactors&ch_dependancy='+fObj('ch_dependancy').value+'&ch_code='+fObj('ch_code').value+'&ch_topic='+fObj('ch_topic').value+'&ch_accountNum='+fObj('ch_accountNum').value+
		 		      '&ch_ratio='+fObj('ch_ratio').value+'&ch_code_location='+fObj('LocationCombo').value+'&ch_name_location='+fObj('ch_name_location').value+'&ch_code_good='+fObj('p_code').value+'&ch_name_good='+fObj('ch_name_good').value+
				      '&ch_charge='+fObj('ch_charge').value+'&ch_lisenceNo='+fObj('ch_lisenceNo').value+'&ch_lisenceDate='+fObj('datepicker6').value+'&ch_pricecode_good='+fObj('p_price_combo').value+'&ch_type_redundancy='+fObj('ch_type_redundancy').value
				      +'&opr_list='+url+'&l_list='+url1+'&i='+counter+'&fdate='+fObj('fdate').value+'&ldate='+fObj('ldate').value, '_self');
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=validCodech&ch_code='+fObj('ch_code').value+'&p_code='+fObj('p_code').value+'&p_price_combo='+fObj('p_price_combo').value+'&ch_type_redundancy='+fObj('ch_type_redundancy').value
		          +'&fdate='+fObj('fdate').value+'&ldate='+fObj('ldate').value;
		    aHW(Q);
	}
}
function checklocation_ch(){
	
	   //baraye location
    
	  var counter1 = 0, 
	        j1 = 0,       
	        url1 = '',    
	        input_obj1 = document.getElementsByName('l_list');
		 llist = new Array();
		 
       url1 = url1 + '&f[]=mj' ;

	    for (j1 = 0; j1 < input_obj1.length; j1++) {
	    	
	        if (input_obj1[j].type === 'checkbox' && input_obj1[j].checked === true) {
	        	
	            counter1++;
	           
	            
	            url1= url1 + '&f[]=' + input_obj1[j1].value;

	        }
	       
	    }
	 

	    if (counter1 > 0) {
	        url1 = url1.substr(1);
	        alert (url1);
	        status2=0;
	       
	    }
	    else {
	    	status2=5;
	        alert('حداقل يک محل را انتخاب کنيد');
	      
	      
	    }
  

	
	
}
function validCodechedit(response){
	
	cBF = 'validCodechedit';
	if(response){

		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var statusedit = dtl[2];
	//	alert(status);
		if(status==1){
			alert(message);
		}
		if(status==2){
			alert(message);
		}else if(status==3){
			
			alert(message);
		}
         else if(status==4){
			
			alert(message);
		}
		else if(status==0){
		//	alert(statusedit);
						if(statusedit==1){
					
				     window.open('?pg=prodMgmtPg&cmd=updChargeFactorsInf&ch_dependancy='+fObj('ch_dependancy').value+'&ch_code='+fObj('ch_code').value+'&ch_topic='+fObj('ch_topic').value+'&ch_accountNum='+fObj('ch_accountNum').value+
					 		      '&ch_ratio='+fObj('ch_ratio').value+'&ch_code_location='+fObj('LocationCombo').value+'&ch_name_location='+fObj('ch_name_location').value+'&p_code='+fObj('p_code').value+'&ch_name_good='+fObj('ch_name_good').value+
							      '&ch_charge='+fObj('ch_charge').value+'&ch_lisenceNo='+fObj('ch_lisenceNo').value+'&ch_lisenceDate='+fObj('datepicker6').value+'&p_price_code='+fObj('p_price_code').value+'&ch_type_redundancy='+fObj('ch_type_redundancy').value
							      +'&ch_id='+fObj('ch_id').value+'&ch_fdate='+fObj('fdate').value+'&ch_ldate='+fObj('ldate').value, '_self');
					}
					else if (statusedit==2){
						
						window.open('?pg=prodMgmtPg&cmd=updChargeFactorsInf1&ch_dependancy='+fObj('ch_dependancy').value+'&ch_code='+fObj('ch_code').value+'&ch_topic='+fObj('ch_topic').value+'&ch_accountNum='+fObj('ch_accountNum').value+
					 		      '&ch_ratio='+fObj('ch_ratio').value+'&ch_code_location='+fObj('LocationCombo').value+'&ch_name_location='+fObj('ch_name_location').value+'&p_code='+fObj('p_code').value+'&ch_name_good='+fObj('ch_name_good').value+
							      '&ch_charge='+fObj('ch_charge').value+'&ch_lisenceNo='+fObj('ch_lisenceNo').value+'&ch_lisenceDate='+fObj('datepicker6').value+'&p_price_code='+fObj('p_price_code').value+'&ch_type_redundancy='+fObj('ch_type_redundancy').value
							      +'&ch_id='+fObj('ch_id').value+'&ch_fdate='+fObj('fdate').value+'&ch_ldate='+fObj('ldate').value, '_self');
					}
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=validCodechedit&ch_code='+fObj('ch_code').value+'&p_code='+fObj('p_code').value+'&p_price_combo='+fObj('p_price_code').value+'&ch_type_redundancy='+fObj('ch_type_redundancy').value+'&ch_id='+fObj('ch_id').value
		          +'&ch_ldate='+fObj('ch_ldate').value+'&statusedit='+fObj('statusedit').value;
		    aHW(Q);
	}
}
function validCustomercode(response){
	
	cBF = 'validCustomercode';
	if(response){
//		alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		
		if(status==1){
			alert(message);
		}
		else if(status==0){
			 window.open('?pg=prodMgmtPg&cmd=regListInformationCustomer&code_customer='+fObj('code_customer').value+'&name_customer='+fObj('name_customer').value+'&code_economic_customer='+fObj('code_economic_customer').value+
			 		 '&code_postal_costumer='+fObj('code_postal_costumer').value+'&code_identificate_customer='+fObj('code_identificate_customer').value+'&cart_asnaf_customer='+fObj('cart_asnaf_customer').value+'&customer_tel='+fObj('customer_tel').value+'&customer_date='+fObj('customer_date').value+
					     '&address_location_delivery_c='+fObj('address_location_delivery_c').value+'&customer_address_office='+fObj('customer_address_office').value+'&personality_customer='+fObj('personality_customer').value
	+'&type_customer='+fObj('type_customer').value+'&condition_activity_customer='+fObj('condition_activity_customer').value +'&condition_pay_customer='+fObj('condition_pay_customer').value+'&condition_share_customer='+fObj('condition_share_customer').value
	+'&type_activity_customer='+fObj('type_activity_customer').value+'&customer_category='+fObj('customer_category').value, '_self');
		
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=validCustomercode&code_customer='+fObj('code_customer').value;
		    aHW(Q);
	}
}
function validCustomercodeEdit(response){
	
	cBF = 'validCustomercodeEdit';
	if(response){
		
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		var customer_id = dtl[2];
		
		if(status==1){
		//	alert(message);customer_date='+fObj('customer_date').value
		}
		else if(status==0){
			//alert(fObj('city_id').value);
			 window.open('?pg=prodMgmtPg&cmd=upListInformationCustomer&code_customer='+fObj('code_customer').value+'&name_customer='+fObj('name_customer').value+
			 		     '&code_postal_costumer='+fObj('code_postal_costumer').value+'&cart_asnaf_customer='+fObj('cart_asnaf_customer').value+'&customer_tel='+fObj('customer_tel').value+
					     '&address_location_delivery_c='+fObj('address_location_delivery_c').value+'&customer_address_office='+fObj('customer_address_office').value+'&customer_id='+fObj('customer_id').value+'&customer_cusid_province='+fObj('customer_cusid_province').value 
					     +'&condition_share_customer='+fObj('condition_share_customer').value+'&condition_pay_customer='+fObj('condition_pay_customer').value+'&type_customer='+fObj('type_customer').value+'&personality_customer='+fObj('personality_customer').value+'&customer_category='+fObj('customer_category').value
					     +'&type_activity_customer='+fObj('type_activity_customer').value+'&condition_activity_customer='+fObj('condition_activity_customer').value+'&customer_id='+customer_id+'&city_id='+fObj('city_id').value, '_self');		
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=validCustomercodeEdit&code_customer='+fObj('code_customer').value+'&customer_id='+fObj('customer_id').value;
		    aHW(Q);
	}
}
function insertop_mojavez(response,os){
	
	cBF = 'insertop_mojavez';
	if(response){
		//alert(response);
		var dtl = response.split(';');
		var status = dtl[0];
		var os = dtl[1];
					if(status==1){
					alert('در استانهای '+os+'این شماره مجوز قبلا ایجاد شده است');
					}
					else{
						
						 window.open('?pg=prodMgmtPg&cmd=ejadshod', '_self');	
						
					}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=insertop_mojavez&phm_mojavez='+fObj('phm_mojavez').value+'&phm_op_id='+fObj('phm_op_id').value+'&phm_date_l='+fObj('phm_date_l').value+'&phm_date_f='+fObj('phm_date_f').value+'&phm_type_id='+fObj('phm_type_id').value+'&phm_ptype='+fObj('p_type').value+'&phm_amount='+fObj('phm_amount').value;
		    aHW(Q);
	}
	
	
}
function insertop_mojavez_yeki(response){
	
	cBF = 'insertop_mojavez_yeki';
	
	if(response){
		
		

					if(response==1){
					alert('این شماره مجوز قبلا ایجاد شده ');
					}
					else{
						
						 window.open('?pg=prodMgmtPg&cmd=mojavezList', '_self');	
						
					}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=insertop_mojavez_yeki&phm_mojavez='+fObj('phm_mojavez').value+'&phm_op_id='+fObj('phm_op_id').value+'&phm_date_l='+fObj('phm_date_l').value+'&phm_date_f='+fObj('phm_date_f').value+'&phm_type_id='+fObj('phm_type_id').value+'&phm_ptype='+fObj('p_type').value+'&phm_amount='+fObj('phm_amount').value;
		    aHW(Q);
	}
	
	
}
function edit_mojavezk(response){
	
	cBF = 'edit_mojavezk';
	if(response){
		var dtl = response.split(';');	
		var status = dtl[0];
		var province = dtl[1];
		
		if(status==1){
		alert('این مجوز در استان با کد'+province+'ایجاد شده است');
		}else{
			
			
			window.open('?pg=prodMgmtPg&cmd=upmojavezk&phm_mojavez='+fObj('phm_mojavez').value+'&phm_mojavezj='+fObj('phm_mojavezj').value+'&phm_op_id='+fObj('phm_op_id').value+'&phm_op_idj='+fObj('phm_op_idj').value+'&phm_id='+fObj('phm_id').value+'&phm_date_l='+fObj('phm_date_l').value+'&phm_date_f='+fObj('phm_date_f').value+'&phm_type_id='+fObj('phm_type_id').value+'&phm_ptype='+fObj('p_type').value+'&phm_amount='+fObj('phm_amount').value, '_self');						
			
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=edit_mojavezk&phm_mojavezj='+fObj('phm_mojavezj').value+'&phm_op_idj='+fObj('phm_op_idj').value+'&phm_id='+fObj('phm_id').value+'&phm_date_l='+fObj('phm_date_l').value+'&phm_date_f='+fObj('phm_date_f').value+'&phm_type_id='+fObj('phm_type_id').value;
		    aHW(Q);
	}
	
	
}

function edit_mojavez(response){
	
	cBF = 'edit_mojavez';
	if(response){
		
		//alert(response);
		//alert(fObj('phm_amount').value);
		if(response==1){
		alert('اين شماره مجوز قبلا ايجاد شده است');
		}else{
			
			window.open('?pg=prodMgmtPg&cmd=upmojavez&phm_mojavez='+fObj('phm_mojavez').value+'&phm_op_id='+fObj('phm_op_id').value+'&phm_id='+fObj('phm_id').value+'&phm_date_l='+fObj('phm_date_l').value+'&phm_date_f='+fObj('phm_date_f').value+'&phm_type_id='+fObj('phm_type_id').value+'&phm_ptype='+fObj('p_type').value+'&phm_amount='+fObj('phm_amount').value, '_self');
					

			
			
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=edit_mojavez&phm_mojavez='+fObj('phm_mojavez').value+'&phm_op_id='+fObj('phm_op_id').value+'&phm_id='+fObj('phm_id').value+'&phm_date_l='+fObj('phm_date_l').value+'&phm_date_f='+fObj('phm_date_f').value+'&phm_type_id='+fObj('phm_type_id').value+'&phm_amount='+fObj('phm_amount').value;
		    aHW(Q);
	}
	
	
}
function validDocCode(response){
	
	cBF = 'validDocCode';
	if(response){
//		alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		
		if(status==1){
			alert(message);
		}
		else if(status==0){
			  window.open('?pg=prodMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountnum='+fObj('d_accountnum').value+'&d_branch='
					   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value+'&d_documentType='+fObj('d_documentType').value+'&d_bank='+fObj('d_bank').value+'&d_ac_bed='+fObj('d_ac_bed').value+'&d_ac_bes='+fObj('d_ac_bes').value+'&d_ac_bes_dis='+fObj('d_ac_bes_dis').value+'&d_ac_bed_dis='+fObj('d_ac_bed_dis').value+'&d_pardakht_t='+fObj('d_pardakht_t').value , '_self');
		
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=validDocCode&d_code='+fObj('d_code').value;
		    aHW(Q);
	}
}
function validDocCodek(response){
	
	cBF = 'validDocCodek';
	if(response){
//		alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		
		if(status==1){
			alert(message);
		}
		else if(status==0){
			  window.open('?pg=prodMgmtPg&cmd=regDocumentk&d_code='+fObj('d_code').value+'&d_accountnum='+fObj('d_accountnum').value+'&d_branch='
					   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value+'&d_documentType='+fObj('d_documentType').value+'&d_bank='+fObj('d_bank').value+'&d_ac_bed='+fObj('d_ac_bed').value+'&d_ac_bes='+fObj('d_ac_bes').value+'&d_ac_bes_dis='+fObj('d_ac_bes_dis').value+'&d_ac_bed_dis='+fObj('d_ac_bed_dis').value+'&d_pardakht_t='+fObj('d_pardakht_t').value , '_self');
		
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=validDocCodek&d_code='+fObj('d_code').value;
		    aHW(Q);
	}
}
function validDocCodeEdit(response){
	
	cBF = 'validDocCodeEdit';
	if(response){
//		alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		
		if(status==1){
			alert(message);
		}else if(status==1){
			alert(message);
		}
		else if(status==0){
			  window.open('?pg=prodMgmtPg&cmd=updocumenInf&d_code='+fObj('d_code').value+'&d_accountnum='+fObj('d_accountnum').value+'&d_branch='
					   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value+'&d_id='+fObj('d_id').value
					   +'&d_ac_bed='+fObj('d_ac_bed').value+'&d_ac_bes='+fObj('d_ac_bes').value+'&d_ac_bed_dis='+fObj('d_ac_bed_dis').value
					   +'&d_ac_bes_dis='+fObj('d_ac_bes_dis').value+'&d_documentType='+fObj('d_documentType').value
					   +'&d_bank='+fObj('d_bank').value, '_self');
		
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=validDocCodeEdit&d_code='+fObj('d_code').value+'&d_id='+fObj('d_id').value;
		    aHW(Q);
	}
}



function validDocCodeEditk(response){
	
	cBF = 'validDocCodeEditk';
	if(response){
//		alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];
		
		if(status==1){
			alert(message);
		}else if(status==1){
			alert(message);
		}
		else if(status==0){
			  window.open('?pg=prodMgmtPg&cmd=updocumenInfk&d_code='+fObj('d_code').value+'&d_accountnum='+fObj('d_accountnum').value+'&d_branch='
					   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value+'&d_id='+fObj('d_id').value
					   +'&d_ac_bed='+fObj('d_ac_bed').value+'&d_ac_bes='+fObj('d_ac_bes').value+'&d_ac_bed_dis='+fObj('d_ac_bed_dis').value
					   +'&d_ac_bes_dis='+fObj('d_ac_bes_dis').value+'&d_documentType='+fObj('d_documentType').value
					   +'&d_bank='+fObj('d_bank').value, '_self');
		
		}
				
	}else{
		
		    Q = 'pg=havaleMgmtPg&cmd=validDocCodeEditk&d_code='+fObj('d_code').value+'&d_id='+fObj('d_id').value;
		    aHW(Q);
	}
}
function validProvincecode(response){
	
	cBF = 'validProvincecode';
	if(response){
//		alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];		
		if(status==1){
			alert(message);
		}
		else if(status==0){
			  window.open('?pg=prodMgmtPg&cmd=regInformationProvince&province_code='+fObj('province_code').value+'&province_name='+fObj('province_name').value+'&province_ecode='+fObj('province_ecode').value+'&province_address='+fObj('province_address').value
					  +'&province_sabt='+fObj('province_sabt').value+'&province_postal='+fObj('province_postal').value+'&province_tel='+fObj('province_tel').value , '_self');		
					  
					 
		}
				
	}else{
		    Q = 'pg=havaleMgmtPg&cmd=validProvincecode&province_code='+fObj('province_code').value+'&province_ecode='+fObj('province_ecode').value+'&province_sabt='+fObj('province_sabt').value+'&province_postal='+fObj('province_postal').value+'&province_tel='+fObj('province_tel').value;
		    aHW(Q);
	}
}
function validProvincecodeEdit(response){
		
		cBF = 'validProvincecodeEdit';
		if(response){
		//	alert(response);
			var dtl = response.split(';');
			var message = dtl[0];
			var status = dtl[1];		
			if(status==1){
				alert(message);
			}
			else if(status==0){
				  window.open('?pg=prodMgmtPg&cmd=upProvinceName&province_code='+fObj('province_code').value+'&province_name='+fObj('province_name').value+'&province_id='+fObj('province_id').value+'&province_ecode='+fObj('province_ecode').value+'&province_address='+fObj('province_address').value
						  +'&province_sabt='+fObj('province_sabt').value+'&province_postal='+fObj('province_postal').value+'&province_tel='+fObj('province_tel').value, '_self');		
			}
		
		}else{
			    Q = 'pg=havaleMgmtPg&cmd=validProvincecodeEdit&province_code='+fObj('province_code').value+'&province_id='+fObj('province_id').value;
			    aHW(Q);
		}
}
function validCitycode(response){
	
	cBF = 'validCitycode';
	if(response){
	//	alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];		
		if(status==1){
			alert(message);
		}
		else if(status==0){
			  window.open('?pg=prodMgmtPg&cmd=regCityInf&city_code='+fObj('city_code').value+'&city_name='+fObj('city_name').value+'&city_province='+fObj('city_province').value , '_self');		
		}
				
	}else{
		    Q = 'pg=havaleMgmtPg&cmd=validCitycode&city_code='+fObj('city_code').value;
		    aHW(Q);
	}
}
function validCitycodeEdit(response){
	
	cBF = 'validCitycodeEdit';
	if(response){
	//	alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];		
		if(status==1){
			alert(message);
		}
		else if(status==0){
			  window.open('?pg=prodMgmtPg&cmd=upCityInf&city_code='+fObj('city_code').value+'&city_name='+fObj('city_name').value+'&city_province='+fObj('city_province').value , '_self');		
		}
				
	}else{
		    Q = 'pg=havaleMgmtPg&cmd=validCitycodeEdit&city_code='+fObj('city_code').value+'&city_id='+fObj('city_id').value;
		    aHW(Q);
	}
}
function validCitycodeEdit(response){
	
	cBF = 'validCitycodeEdit';
	if(response){
	//	alert(response);
		var dtl = response.split(';');
		var message = dtl[0];
		var status = dtl[1];		
		if(status==1){
			alert(message);
		}
		else if(status==0){
			  window.open('?pg=prodMgmtPg&cmd=upCityInf&city_code='+fObj('city_code').value+'&city_name='+fObj('city_name').value+'&city_province='+fObj('city_province').value+'&city_id='+fObj('city_id').value , '_self');		
		}
				
	}else{
		    Q = 'pg=havaleMgmtPg&cmd=validCitycodeEdit&city_code='+fObj('city_code').value+'&city_id='+fObj('city_id').value;
		    aHW(Q);
	}
}
function hndlProvinceCombo(response,val){
	cBF = 'hndlProvinceCombo';
	if(response){
		var dtl = response.split(';');
		var pg = dtl[0];
		var cmd = dtl[1];
		window.open('?pg='+pg+'&cmd='+cmd,'_self');


	}else{
	    Q = 'pg=havaleMgmtPg&cmd=changeProvince&province_id='+val;
	    aHW(Q);
}	
}

function hndlmodat(response,val){
	cBF = 'hndlmodat';
	if(response){
	//	alert(response);
		fObj('phd_modat').innerHTML = response;
		
		

	}else{
	    Q = 'pg=havaleMgmtPg&cmd=createmodat';
	    aHW(Q);
}	
}
function hndltypesell(response,val){
	cBF = 'hndltypesell';
	if(response){		
		 if(response==2){
			fObj('row1').style.display = 'none';
			fObj('row2').style.display = '';
			

		}else if(response==3){
			
			fObj('row1').style.display = '';
			fObj('row2').style.display = 'none';
			
		}else if(response==1){
			
			fObj('row1').style.display = 'none';
			fObj('row2').style.display = 'none';
			
		}
else if(response==4){
			
			fObj('row1').style.display = 'none';
			fObj('row2').style.display = 'none';
			
		}
		

	}else{
	    Q = 'pg=havaleMgmtPg&cmd=createselltype&dts_id='+val;
	    aHW(Q);
}	
}



function hndlProvince_cityCombo(response,val,val2){
	cBF = 'hndlProvince_cityCombo';
	if(response){
	//	alert(response);
		fObj('cityCntnr').innerHTML = response;
		

	}else{
	    Q = 'pg=havaleMgmtPg&cmd=createCityCombo&province_id='+val+'&customer_id='+val2;
	    aHW(Q);
}	
}
function hndlProvince_cityCombooo(response,val){
	cBF = 'hndlProvince_cityCombooo';
	if(response){
	//	alert(response);
		
		

	}else{
	    Q = 'pg=havaleMgmtPg&cmd=createCityCombooo&cityCntnr='+val;
	    aHW(Q);
}	
}
function hndlProvince_cityCombo1(response,val){
	cBF = 'hndlProvince_cityCombo1';
	if(response){
	//	alert(response);
		fObj('city_id').innerHTML = response;
		

	}else{
	    Q = 'pg=havaleMgmtPg&cmd=createCityCombo1&province_id='+val;
	    aHW(Q);
}	
}
function hndlNameYearCombo(response,val){
	cBF = 'hndlNameYearCombo';
	if(response){
//		alert(response);
		var dtl = response.split(';');
		var pg = dtl[0];
		var cmd = dtl[1];
		window.open('?pg='+pg+'&cmd='+cmd,'_self');


	}else{
	    Q = 'pg=havaleMgmtPg&cmd=changeYear&year_id='+val;
	    aHW(Q);
}	
}
function addNewHavaleDetail(response,val1,val2,val3){
	cBF = 'addNewHavaleDetail';
	if(response){
		var dtl = response.split(';');
		var phd_id = dtl[0];
		var ph_code = dtl[1];	
		var h_code = dtl[2];
		var province_name = dtl[3];
		var province_id = dtl[4];
		var name_customer = dtl[5];
		var price_code = dtl[6];
		var p_code = dtl[7];
		var l_id = dtl[8];
		//alert(response);
		window.open('printHavale.php?phd_id='+phd_id+'&ph_code='+ph_code+'&h_code='+h_code+'&province_name='+province_name+'&province_id='+province_id +'&name_customer='+name_customer+'&price_code='+price_code+'&p_code='+p_code+'&l_id='+l_id,'_blank');


	}else{
	    Q = 'pg=havaleMgmtPg&cmd=addNewHavaleDetail&ph_code='+val1+'&pf_code='+val2+'&phd_id='+val3;
	    aHW(Q);
}
}
function Deletephd(response,val){
	cBF = 'Deletephd';
	if(response){
		fObj('phd_'+response).style.display='none';
		alert(response);
	}else{
	
	
	 Q = 'pg=havaleMgmtPg&cmd=Deleteph_det&phd_id='+val;
	    aHW(Q);
	}	
}
function EditphprodCheck(response){
	cBF = 'EditphprodCheck';
	if(response){
//	alert('dfdsf');
		var dtl = response.split(';');
		var status = dtl[0];
		var message = dtl[1];	
		if(status==1){
			alert(message);
		}else if(status==2){
			alert(message);
			
		}
		
		else{
			window.open('?pg=havaleMgmtPg&cmd=EditPishHavale&ph_code='+fObj('ph_code').value,'_self');

		}
		
	}else{
	
		Q  = 'pg=havaleMgmtPg&cmd=EditphprodCheck&p_price_code='+fObj('p_price_code').value;
		Q += '&phd_amount='+fObj('phd_amount').value+'&phd_deli_name='+fObj('phd_deli_name').value+'&phd_amount_remined='+fObj('phd_amount_remined').value+'&phd_name='+fObj('p_name').innerHTML+'&phd_l_id='+fObj('LocationCombo').value;
        Q += '&p_code='+fObj('p_code').value+'&phd_id_unit='+fObj('phd_id_unit').value;
	    Q += '&phd_id='+fObj('phd_id').value+'&phd_operation_id='+fObj('phd_operation_id').value+'&phd_robari='+fObj('LocationCombo1').value;
	    Q += '&phd_tahator='+fObj('phd_tahator').value;
	    aHW(Q);
	}
	
}
