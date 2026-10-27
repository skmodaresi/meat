<?php
 header('Content-Type: text/html; charset=UTF-8');
include_once 'includer.php';
$GLOBALS['pg'] = isset($_REQUEST['pg']) ? $_REQUEST['pg'] : '';
$GLOBALS['cmd'] = isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$GLOBALS['ajaxRes'] = '';

switch ($pg){
	case 'havaleMgmtPg':
		switch($cmd){
			
			case 'getCustInfo':
				$cId = isset($_REQUEST['cId']) ? $_REQUEST['cId'] : 0;
				$res = getCustInfo($cId);
				print_r($res);
				$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$res['name_customer'].';'.$res['code_customer'].';'.$res['code_economic_customer'].';';
				break;
				
//			case 'getCategoryCustInfo':
//				$cId = isset($_REQUEST['cId']) ? $_REQUEST['cId'] : 0;
//				$res = getCustInfo($cId);
//				print_r($res);
//				$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$res['category_name'].';'.$res['category_code'].';';
//				break;
								
			case 'getProdInfo':	
				$_SESSION['check']=1;			
				
				$cId = isset($_REQUEST['cId']) ? $_REQUEST['cId'] : 0;  
				$res = getProdInfo($cId);
		     	print_r($res);
			    $pricComboHtml = getPriceCombo($_REQUEST['cId']);
				$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$res['p_name'].';'.$res['p_code'].';'.$res['p_id'].';'.$pricComboHtml.';';
				break;
			case 'edit_mojavez':
				echo edit_mojavez();
				break;
			case 'edit_mojavezk':
				echo edit_mojavezk();
				break;
			case 'getProvinceInfo':
				$cId = isset($_REQUEST['cId']) ? $_REQUEST['cId'] : 0;  
				
			    $CityHtml = getCityCombo($_REQUEST['cId']);
				$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$CityHtml.';';
				break;		
			case 'DisableComboDep':
				$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : 0;
				$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]';
				
			break;
				
			case 'getDocInfo':

	       getDocInfo();

				break;
			case 'getChargeInfo':
				$chId = isset($_REQUEST['chId']) ? $_REQUEST['chId'] : 0;
				$res = getChargeInfo($chId);
			//print_r($res);               
				$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$res['ch_code'].';'.$res['ch_topic'].';'.$res['ch_type'].';'.$res['ch_dependancy'].';'.$res['ch_dependancy_to'].';'.$res['ch_ratio'].';';
				break;
			
				case 'getproductInfo':
				$p_id = isset($_REQUEST['p_id']) ? $_REQUEST['p_id'] : 0;
				$res = getproductInfo($p_id);
				//print_r($res);
				$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$res['p_name'].';'.$res['p_code'].';';
				break;	
				
			case 'getLocationInfo':
				$locId = isset($_REQUEST['locId']) ? $_REQUEST['locId'] : 0;
				$l_type = isset($_REQUEST['l_type']) ? $_REQUEST['l_type'] : 0;
				$res = getLocationInfo($locId,$l_type);
				//print_r($res);
				$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$res['l_name'].';'.$res['l_code'].';'.$res['l_code'].';';
				break;	 
				
			case 'addAProd2Bill':
				addAProd2Bill();
				break;	
			case 'addAProd2Billk':
				addAProd2Billk();
				break;
			case 'EditAndEbtalCheckk':
				EditAndEbtalCheckk();
				break;
			case 'EditAndEbtal':
				EditAndEbtal();
				break;
			case 'addAProd2Bill_H':
			    addAProd2Bill_H();
				break;
			case 'addAProd2Bill1':
				addAProd2Bill1();
				break;
			case 'EbtalM':
				EbtalM();
				break;
			case 'checkCodeP':
				checkCodeP();
				break;
				case 'checkCodeP1':
				checkCodeP1();
				break;
			case 'checkvalidData':
				checkvalidData();
				break;
			case 'createselltype':
				createselltype();
				break;
			case 'createmodat':
				createmodat();
				break;
			case 'createCityCombo':
				createCityCombo();
				break;
				case 'createCityCombooo':
				createCityCombooo();
				break;
			case 'createCityCombo1':
				createCityCombo1();
				break;
			case 'validusername':
				validusername();
				break;				
			case 'delAProdFromBill':
				delAProdFromBill();
				break;
			case 'addPdetFromBill':
				addPdetFromBill();
				break;	
			case 'DeletePHavale':
				DeletePHavale();
				break;
			case 'passparent':
				 passparent();
				 break;
			case 'passparentcus':
				passparentcus();
				break;
			case 'passparentprod':
				passparentprod();
				break;
				
			case 'addAPrice2Bill':
				 addAPrice2Bill();
				break;
			case'addInfPardakht':
				addInfPardakht();
				break;
			case'insertHavale':
				insertHavale();
				break;
			case 'DeletePfactor':
				  DeletePfactor();
				break;
			case 'DeleteHavale':
				DeleteHavale();
				break;
			case 'Deletefactor':
				Deletefactor();
				break;
			case 'ReportProd':
				ReportProd();
				break;
			case 'insertFactor':
				insertFactor();
				break;
			case 'insertFactor1':
				insertFactor1();
				break;
			case 'addPfactor':
				addPfactor();
				
				break;
			case 'addMoarefinameh':
				addMoarefinameh();
				break;
			case 'addhavale1':
			    addhavale1();
			   break;
			case 'addDocument2Pf':
			     addDocument2Pf();
				break;
			case 'addDocument2PfSave':
				addDocument2PfSave();
				break;
			case'delADocFromBill':
				delADocFromBill();
				break;
			case 'addNewHavale':
				 addNewHavale();
				break;
			
			case 'addbestankari':
				addbestankari();
				break;
			case 'Ebtal_createNewh':
				Ebtal_createNewh();
				break;
			case 'EbtalHavaleNotNew':
				EbtalHavaleNotNew();
				break;
			case 'check':
				 check();
				break;
			case 'addNewFactor':
				addNewFactor();
				break;
			case 'AddAMenuToList':
				AddAMenuToList();
				break;
			case 'AddAllMenuToList':
				AddAllMenuToList();
				break;
			case 'AddAMenuToList1':
				AddAMenuToList1();
				break;
				
				case 'AddAdetanbar':
				AddAdetanbar();
				break;
			case 'ebtalAdetanbar':
			ebtalAdetanbar();
			break;
				case 'delAdetanbar':
				delAdetanbar();
				break;
			case 'Addprodv':
				Addprodv();
				break;
			case 'delprodv':
				delprodv();
				break;
			case 'addoper':
				  addoper();
				  break;
			
			case 'DelAMenuToList':
				DelAMenuToList();
				break;
			case 'DelAMenuToList1':
				DelAMenuToList1();
				break;
			case 'addloc':
				addloc();
				break;
			case 'delloc':
				delloc();
				break;
			case 'delopr':
				delopr();
				break;
			case 'AddAccessEdit':
				AddAccessEdit();
				break;
			case 'NoAccessEdit':
				NoAccessEdit();
				break;
			case 'NoAccessDelete':
				NoAccessDelete();
				break;
			case 'AddAccessDelete':
				AddAccessDelete();
			break;
			case 'addednewhavalekoli':
				 addednewhavalekoli();
				break;
			case 'getMenuInfo':				
				$menu_id = isset($_REQUEST['menu_id']) ? $_REQUEST['menu_id'] : 0;
				$res = getListMenuInfo($menu_id);
				print_r($res);
			   $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$res['ug_id'].';'.$res['ug_category'].';';
				break;
				
			case 'checkAndValidProdName':
				checkAndValidProdName();
				break;
			case 'checkAndValiPriceCode':
					checkAndValiPriceCode();
				break;
			case 'CheckCodeL':
			     	CheckCodeL();
			    break;
			case 'checkGroupName':
				  checkGroupName();
			    break;
			case 'RegNewGroup':
				RegNewGroup();
				break;
			case 'DisableRelCombo':
				DisableRelCombo();
				break;
				case 'DisablePerCombo':
				DisablePerCombo();
				break;
			case 'DisableezafidCombo':
				DisableezafidCombo();
				break;
			case 'validCodech':
				validCodech();
				break;	
			case 'validCodechedit':
				validCodechedit();
				break;
			
			case 'validCustomercode':
				validCustomercode();
				break;	
			case 'validCustomercodeEdit':
				validCustomercodeEdit();
				break;
			case 'insertop_mojavez':
				insertop_mojavez();
				break;
			case 'insertop_mojavez_yeki':
				insertop_mojavez_yeki();
				break;
			case 'phm_mojavez':
				phm_mojavez();
				break;
			case 'validDocCode':
				validDocCode();
				break;
			
			case 'validDocCodek':
				validDocCodek();
				break;
			case 'CheckCodeLEdit':
				CheckCodeLEdit();
				break;
			case 'checkAndValidProdNameEdit':
				checkAndValidProdNameEdit();
				break;
			case 'checkAndValidProdNameEdit_m':
				checkAndValidProdNameEdit_m();
				break;
				
			case 'checkprod_morgh':
				checkprod_morgh();
				break;
			case 'validDocCodeEdit':
				validDocCodeEdit();
				break;
				case 'validDocCodeEditk':
				validDocCodeEditk();
				break;
			case 'validProvincecode':
				validProvincecode();
				break;
			case 'validProvincecodeEdit':
				validProvincecodeEdit();
				break;
			case 'validCitycode':
				validCitycode();
				break;
			case 'validCitycodeEdit':
				validCitycodeEdit();
				break;
			case 'checkExistCode':
				checkExistCode();
				break;
			case 'changeProvince':
				changeProvince();
				break;
			case 'changeYear':
				changeYear();
				break;
			case 'addNewHavaleDetail':
				addNewHavaleDetail();
				break;
			case 'checkvalidcus':
				checkvalidcus();
				break;
			
			case 'Deleteph_det':
				Deleteph_det();
				break;
			case 'EditphprodCheck':
				EditphprodCheck();
				break;
			case 'checkAndValidProdNameEditM':
				checkAndValidProdNameEditM();
				break;
	}
}

echo $GLOBALS['ajaxRes'];


