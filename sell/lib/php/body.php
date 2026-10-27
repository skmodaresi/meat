<?php
require_once __DIR__ . '/../../../mysql_compat.php';
 
function getBody(){
		
	global $pg, $cmd;
	$_SESSION['pg']=$pg;
	$_SESSION['cmd']=$cmd;
$query="select * from  dm_message  message 
			left join dm_user_profile profile
			on profile.u_id=message.mes_to_id
				where
			u_id=".$_SESSION['dm_user_profile']['u_id']."
			and
			mes_read_status=". 0 ."";

	$lnk = mysql_query($query);
	if($num=mysql_num_rows($lnk)>0){
		
		   echo ' <span><a href="?pg=prodMgmtPg&cmd=listunreadmes" ><img src="images/mail.PNG" title="پيغام" width="50" height="50" align="left" "></img></a></span>';
		
	}
	switch ($pg){
		
		case 'login_pg':
			switch($cmd){
				case 'dspFrm':
					dspLoginForm();
					break;
			}
			break;
			
		case 'logout_pg':
			dspLoginForm();
			break;
		case 'home':
			include_once 'wellcome_home.php';
			break;
	    case 'prodMgmtPg_det':
		
		   include_once 'prodMgmtPg_det.php';
		break;
		
		case 'havaleMgmtPg':
			include_once 'havale_mgmt.php';
//    	    include_once 'Pfactor_mgmt.php';
			break;
		
	case 'PfactorMgmtPg':
			include_once 'Pfactor_mgmt.php';
		   break;
	
		case 'reportMgmtPg':
			include_once 'report_mgmt.php';
						
		case 'prodMgmtPg':
			include_once 'prod_mgmt.php';
			switch ($cmd){
			case 'Backup':
				Backup();
				break;
			case 'newmessage':
				newmessage();
				break;
			case 'writemessage':
				writemessage();
				break;
			case 'BackupFrm':
				BackupFrm();
				break;
				case 'PrivatePanel':
					PrivatePanel();
					break;
				case 'Privatemessage':
					echo Privatemessage();
					break;
				case 'setting':
					echo setting();
					break;
				case 'listunreadmes':
					echo listunreadmes();
					break;
				case 'listsendmes':
					echo listsendmes();
					break;
				case 'ShowAmessage':
					ShowAmessage();
					break;
				case 'replymessage':
					replymessage();
					break;
				case 'ShowAmessage1':
					echo ShowAmessage1();
					break;
				case 'EditPrivatePanel':
					EditPrivatePanel();
					break;
				case 'savesetting':
					savesetting();
					break;
				case 'upPrivatePanel':
					upPrivatePanel();
					PrivatePanel();
					break;
			    case 'createMenu‍':
			        createMenu‍();
				   break;
			     case 'regMenu':
				    regMenu();
				break;
			     case'dspcalender':
					dspcalender();
					break;				
				case 'dspProdRegFrm1':
					dspProdRegFrm1();
					break;
				case 'dspProdFrmEdit':
					dspProdFrmEdit();
					break;
					case 'dspProdFrmEdit_m':
					dspProdFrmEdit_m();
					break;
					
				case 'dspProdFrmEdit_morgh':
					echo dspProdFrmEdit_morgh();
					break;
				case 'dspProdFrmEditM':
					dspProdFrmEditM();
					break;
				case 'upmojavez':
					upmojavez();
					echo mojavezList();
					break;
				case 'upmojavezk':
					echo upmojavezk();
					break;
				case 'updPrdInf':
					updPrdInf();
					$_SESSION['srchStr'] = '';
					
					echo getProdList();
					break;
					
					case 'updPrdInfbcode':
					 $_SESSION['srchStr'] = '';
					 updPrdInfbcode();
					 echo getProdList();
					break;
					
					case 'updPrdInf_m':
					updPrdInf_m();
					$_SESSION['srchStr'] = '';
					 echo listprod_m();
					
					break;
					
				case 'updPrd_morgh':
					updPrd_morgh();
					$_SESSION['srchStr'] = '';
					 echo prod_morgh();
					
					break;	
					
					
				case 'searchCodeProd_m':
				    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
				    echo listprod_m();
		     	    break;
				case 'taghir_cust':
					echo taghir_cust();
					break;
					case 'up_cust':
						
					echo up_cust();
						break;
					
		     	  case 'taghir_h':	   
				    echo taghir_h();
		     	    break;
		     	    case 'taghir_codeh':	   
				    echo taghir_codeh();
		     	    break;
		     	  case 'taghir_saveh':
		     	  	taghir_saveh();
		     	  	break;
		     	  case 'taghir_savecus':
		     	  	taghir_savecus();
		     	  	break;
		     	  case 'taghir_savecodeh':
		     	  	taghir_savecodeh();
		     	  	break;
		     	  case 'save_cust':
		     	  	save_cust();
		     	  	break;
		     	  case 'update_cust':
		     	  	update_cust();
		     	  	break;
				case 'updPrdInfM':
					updPrdInfM();
					$_SESSION['srchStr'] = '';
					echo getProdList();
					break;
				case 'regProd1':
					$p_id = regProd1();
//					echo getProdRegFrom2($p_id);
                   $_SESSION['srchStr'] = '';
					echo getProdList();
					break;					
				case 'deleteProd1':
					deleteProd1();
					$_SESSION['srchStr'] = '';
					echo getProdList();
					break;
				     
				case 'showprodList':
				
					echo getProdList();
					
					$_SESSION['srchStr'] = '';
          			break;
                     
				case 'searchCodeProd':
				    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
				    echo getProdList();
		     	    break;
//contact us	     	    
				case 'ContactUs':
					ContactUs();
					break;
//اسناد				     
				case 'dspRegDocumentFrm':
				   echo dspRegDocumentFrm($_SESSION['general']);
				     break;
				case 'dspRegDocumentFrmk':
				   echo dspRegDocumentFrmk($_SESSION['general']);
				     break;     
				case 'regDocument':
					
					$d_id=regDocument();
					$_SESSION['srchStr'] = '';
					echo getDocumentList();
					break;
				case 'regDocumentk':
					
					$d_id=regDocumentk();
					$_SESSION['srchStr'] = '';
					echo getDocumentListk();
					break;
				case 'updocumenInf':
					updocumentInf();
					 $_SESSION['srchStr'] = '';
				     echo getDocumentList();
					 break;
					 case 'updocumenInfk':
					updocumentInfk();
					 $_SESSION['srchStr'] = '';
				     echo getDocumentListk();
					 break;
				case 'deletedocument':
				        deletedocument();
					  echo getdocumentList();
					break;
					
					
				case 'dspdocFrmEdit':
					echo dspdocFrmEdit();
				    break;
				    case 'dspdocFrmEditk':
					echo dspdocFrmEditk();
				    break;
			    
				case 'showdocumentListk':
					$_SESSION['srchStr'] = '';
					echo getDocumentListk();
					 break;
					case 'showdocumentListk':
					$_SESSION['srchStr'] = '';
					echo getDocumentListk();
					 break; 
				 case 'searchCodedocument':
				    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
				    echo getdocumentListk();
					break;
//محل ها				 
				case 'dspRegLocationGoodsFrm':
					dspRegLocationGoodsFrm();
				    break;
				case 'searchCodelocation':
					echo $_SESSION['srchStr'];
				
		            echo getLocationGoodsList();
		     	    break;				
				case 'regLocationGoods':
				       $l_id= regLocationGoods();
				       $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';				       
				          getLocationGoodsList();
			    case 'showlocationList':
			    	$_SESSION['srchStr'] = '';
					  echo getLocationGoodsList();
					  break;
					
			    case'dspLocationFrmEdit':
			          dspLocationFrmEdit();			         
			          break;
			    case 'upLocationGoodsInf':
			    	upLocationGoodsInf();
			    	echo getLocationGoodsList();
			    	break;
			    case 'deleteLocationGoods':
			    	deleteLocationGoods();
			    	echo getLocationGoodsList();
			    	break;			    	
			           
//هزينه ها	

				case 'dspRegChargeFactorsFrm':
					  dspRegChargeFactorsFrm();
				break;
				
				case 'regchargeFactors':
					   $ch_id= regChargeFactors();
				       getChargeFactorsList();
			    case 'showChargeFactorsList':
			    	$_SESSION['srchStr'] = '';
					  echo getChargeFactorsList();
					  break;
					
			    case'dspChargeFactorFrmEdit':
			         dspChargeFactorFrmEdit();
			          break;
			    case 'FactorFrmEditop':
			    	echo FactorFrmEditop();
			    	 break; 
			    case 'FactorFrmEditloc':
			    	echo FactorFrmEditloc();
			    	 break;
			    case 'updChargeFactorsInf':
			    	  updChargeFactorsInf();
			    	echo getChargeFactorsList();
			    	break;
			    case 'updChargeFactorsInf1':
			    	  updChargeFactorsInf1();
			    	echo getChargeFactorsList();
			    	break;
			    case 'deleteChargeFactor':
			    	  deleteChargeFactors();
			    	echo getChargeFactorsList();
		    	break;
//?§?¨?·?§U„ ?­Uˆ?§U„U‡
			   	case 'dspRegCauseOfCanceledOrder':
					  dspRegCauseOfCanceledOrder();
				break;
				
				case 'regListCauseOfCanceledOrder':
				       $ch_id= regListCauseOfCanceledOrder();
				         getListCauseOfCanceledOrder();
			    case 'getListCauseOfCanceledOrder':
		
					  echo getListCauseOfCanceledOrder();
					  break;
					
			    case'dspListCauseOfCanceledOrderEdit':
			         dspListCauseOfCanceledOrderEdit();
			         
			          break;
			    case 'upListCauseOfCanceledOrder':
			    	     upListCauseOfCanceledOrder();
			    	echo getListCauseOfCanceledOrder();
			    	break;
			    case 'deleteCauseOfCanceledOrder':
			    	     deleteCauseOfCanceledOrder();
			    	echo getListCauseOfCanceledOrder();
		    	break;			    	
//اطلاعات مشتري	
 	            case 'dspRegInformationCustomer':
					  dspRegInformationCustomer();
				break;
 	            case 'searchCodecustomer':	
 	            	$_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';           	            	 
 	            	 echo  getListInformationCustomer();
 	            	break;
 	            	case 'getListInformationCustomer1':
					
				    //   $customer_id= regListInformationCustomer1();
				       $_SESSION['srchStr'] = '';
				        echo getListInformationCustomer1();
				         break;
			 	case 'regListInformationCustomer':
					 
				       $customer_id= regListInformationCustomer();
				       $_SESSION['srchStr'] = '';
				        echo getListInformationCustomer();
				         break;
			    case 'getListInformationCustomer':
			    	//$_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';  
					  echo getListInformationCustomer();
					  break;
					
			    case'dspListInformationCustomerEdit':
			         dspListInformationCustomerEdit();			         
			          break;
			    case 'upListInformationCustomer':
			    	     upListInformationCustomer();
			        echo getListInformationCustomer();			    	
			    	break;
			    case 'deleteListInformationCustomer':
			    	     deleteListInformationCustomer();
			    	     $_SESSION['srchStr'] = '';
			    	echo getListInformationCustomer();
		    	break;
			    case 'upcodeCustomer':
					    upcodeCustomer();
					    echo getListInformationCustomer();
					    break;
	//اطلاعات استان	

			    case 'dspregInformationProvince':
			    	  dspregInformationProvince();
			    break;
			         case 'regInformationProvince':
			    	 $province_id=regInformationProvince();
		    	      echo getProvinceNameList();
			    break; 
			    	 	
			    case 'getProvinceNameList':
			    	$_SESSION['srchStr'] = '';
			          echo getProvinceNameList();
			    
			     break;
		         case 'dspProvinceNameFrmEdit':
			    	   dspProvinceNameFrmEdit();
			    break;
			    case 'searchCityName':
				    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
				    echo getProvinceNameList();
					break;
			    case 'mojavezList':
			       echo mojavezList();
			    break;
			      case 'ejadshod':
			       echo ejadshod();
			    break;
			    case 'getcategoryNameList':
			    echo getcategoryNameList();
			    	break;
			    case 'searchCategoryName':
			    	  $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
			    	echo getcategoryNameList();
			    	break;
			    case 'searchmojavezName':
			    	  $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
			    echo	searchmojavezName();
			    	//echo mojavezList();
			    	break;
			    case'upProvinceName':
			    	upProvinceName();
			    	$_SESSION['srchStr'] = '';
			    echo getProvinceNameList();
			    	break;
//اطلاعات شهرها
                  case 'searchcityName':
				    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
				    echo getCityNameList();
					break;
			    case 'dspregInformationCity':
			    	  dspregInformationCity();
			    	break;
			    case 'regCityInf':
			    	  regCityInf();
			    	  $_SESSION['srchStr'] = '';
			    	  echo getCityNameList();
			    	break;
			    case 'getCityNameList':
			    	$_SESSION['srchStr'] = '';
			    	echo  getCityNameList();
			    	break;
			    case 'dspCityFrmEdit':
			    	dspCityFrmEdit();
			    	break;
			     case 'upCityInf':
			    	upCityInf();
			    	echo  getCityNameList();
			    	break;
			     case 'deleteCityInf':
			     	deleteCityInf();
			     	$_SESSION['srchStr'] = '';
			     	echo  getCityNameList();
			     	break;
			     case 'deletemojavez':
			       deletemojavez();
			      echo  mojavezList();
			     break;
//دسته بندي مشتريان
			    case 'dspRegcategoryCustomer':
			    	dspRegcategoryCustomer();
			    	break;
			
			    case 'searchCategoryName':
				    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';    
				    break;
			    case 'RegcategoryCustomer':
			    	$category_id= RegcategoryCustomer();
			    echo  getcategoryNameList();
			    	break;	

			    case 'getcategoryNameList':
			    	 $_SESSION['srchStr'] = '';
			    echo  getcategoryNameList();
			    	break;
			    case 'deleteCategoryName':
			    	deleteCategoryName();
			    	 $_SESSION['srchStr'] = '';
			     echo  getcategoryNameList();
			    	break;
			     case 'deleteCityName':
			    	deleteCityName();
			    	$_SESSION['srchStr'] = '';
			    echo getProvinceNameList();
			    
			     case'dspCategoryNameFrmEdit':
			     dspCategoryNameFrmEdit();
			     break;
			     
			     case'editmojavezfrm':
			     editmojavezfrm();
			     break;
			     case 'upCategoryName':
			     	upCategoryName();
			     	$_SESSION['srchStr'] = '';
			    echo getcategoryNameList();
			     	break;
//اطلاعات كاربر
		        case'dspInseNewUserFrm':
		        	dspInseNewUserFrm();
		        	break;		        	
		        case'regNewUser':
		        	regNewUser();
		          $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		        	
		        echo getUserList();
		        	break;
		        case 'searchUseName':
				    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		        			        	
		       	echo getUserList();
		        	break;
		        case 'dspUserNameFrmEdit':
			    	  dspUserNameFrmEdit();
			    	 break;
		        case'upUserName':
		        	 upUserName();
		        echo getUserList();
		        	break;
		        case'deleteUserName':
		             deleteUserName();
		        $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';		             
		             getUserList();
		           break;
		        case 'getUserList':
		         $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		        	
		        	 getUserList();
		        	break;
		        case 'dspInseNewGroupFrm':
		           echo dspInseNewGroupFrm();
		           break;
		            case 'listprod_m':
		           echo listprod_m();
		           break;

		         case 'prod_morgh':
		           echo prod_morgh();
		           break;
		        case  'RegNewGroup':
		        	 $ug_id=RegNewGroup();	
		         echo dspAccessGroupFrm($ug_id);
		           break;
		        case 'ListAccessMenu':
		         $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		        	
		            echo ListAccessMenu();
		            break;
		        case 'dspAccessGroupFrm':
		        	echo dspAccessGroupFrm();
		        	break;
		        case 'dspGUserFrmEdit':
		        	dspGUserFrmEdit();
		        	break;
		        case 'upGroupUser':
		        	upGroupUser();
		        $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		       	echo ListAccessMenu();
		        	break;
		        case 'DeleteGroup':
		        	DeleteGroup();
             $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		        	
		        	echo ListAccessMenu();
		        	break;
		        case 'searchGroup':
				    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
				    echo ListAccessMenu();
		     	    break;
		        case 'getGroupUserList':
		       $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		        	
		       	echo getGroupUserList();
		        	 break;
		        case 'RegAccessGroup':
		        	RegAccessGroup();
		        	break;
		        case'dspAccessUserToMenuFrm':
		        	dspAccessUserToMenuFrm();
		        	break;
		        case 'ShowAccess':
					 echo ShowAccess();
					 break;
				case 'ShowAccess1':
					 echo ShowAccess1();
					break;
		        case 'ListAllYears':
	       $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		        	
		        	ListAllYears();
		        	break;
			}
			
		        case 'changingSignatures':
		        	
		        	switch($cmd){
		        		
		        		case 'showchangingSignatures':
		        			echo showchangingSignatures();
		        			break;
		        		case 'showchangingSignatures_o':
		        			echo showchangingSignatures_o();
		        			break;
		        		case 'sigEdit':
		        			 sigEdit();
		        			break;
		        		case 'sigEdit_o':
		        			 sigEdit_o();
		        			break;
		        		case 'UpEdit':
		        			UpEdit();
		        			echo showchangingSignatures();
		            	
		        			break;
		        		case 'UpEdit_o':
		        			UpEdit_o();
		        			echo showchangingSignatures_o();
		            	
		        			break;	
		        	}
		        case 'yearManagement':
		        	switch($cmd){
		        		case 'CreateNewYearFrm':
		        			CreateNewYearFrm();
		        			
		        			break;
		        			
		        		case 'RegNewYear':
		        			RegNewYear();
		        			break;
		        		case 'RegNewYear':
		        			RegNewYear();
		        		echo ListAllYears();
		        			break;
		        		case 'ListAllYears':
		        			$_SESSION['srchStr'] = '';
		        			echo ListAllYears();
		        			break;
		        		case 'EditYearFrm':
		        			EditYearFrm();
		        			break;
		        		case 'updYearInf':
		        			updYearInf();
		        		echo ListAllYears();
		        			break;
		        		case 'DeleteYear':
		        			DeleteYear();
		        		echo ListAllYears();
		        			break;
	          		case 'searchYear':
						    $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
						 echo getProdList();
		     	       break;
		        	}
		        	
		        
		        	
			break;
		
	}

}
