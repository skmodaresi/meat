<?php
//For ElectronicSellServices
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
header('Content-Type: text/html; charset=UTF-8');
$wsdl_url = "https://pub-cix.ntsw.ir/services/InternalTradeServices?wsdl";
$client = new SoapClient($wsdl_url, array('login'=>"internalservice" ,'password'=>"ESBesb12?" ));
//var_dump ($atservices_client->__getTypes());
// مهم 
$client->__setLocation($wsdl_url);


$seller_UserRoleExtraFields=array(
	   	 'PostalCode'=>'7156615446',
	   	 'LicenseNumber'=>'',
	   	 'ActivityType'=>10
	   );
	   $buyer_UserRoleExtraFields=array(
	   	 'PostalCode'=>'2392077673',
	   	 'LicenseNumber'=>'',
	   	 'ActivityType'=>10
	   );
	   $ownershipTransfer=array(
	   	 'buyerNationalID'=>'0054777631',
		 'buyerUserRoleIDStr'=>NULL,
		 'buyerName'=>'مسعود',
		 'buyerMobile'=>'09173227136'
	   );
	   $PlaceTransfer=array(
	   	 'ToPostalCode'=>'2392077673',
		 'wayBillHas'=>2,
		 'wayBillNumber'=>'453',
		 'wayBillSerial'=>NULL,
		 'wayBillDate'=>'9089'
	   );
	   $Stuff_Code_Count_Pair=array(
	       'Code'=>'2004464168139',
	       'Count'=>'1653',
	       'Price'=>''
	       );
	   $params=array(
          'username'=>'internalservice',
          'srvPass'=>'ESBesb12?',
          'PersonNationalCode'=>'',
		  'password_otpCode'=>'',
          'UserRoleIDstr'=>'',
		  'userSellType'=>3,
          'documentDate'=>'2020-03-20',
		  'fromPostalCode'=>'7156615446',
		  'ownershipTransfer'=>null,
		  'placeTransfer'=>null,
		  'seller_UserRoleExtraFields'=>null,
          'buyer_UserRoleExtraFields'=>null,
          'stuffs_In'=>null,
          'documentDescription'=>NULL,
          'statusAppointment'=>0,
          'DocNumber'=>null
		); 
		
	
	   
	  $result=$client->TransferOwnershipPlace_SI($params); 
	  // مهم 
	  $response=$result->TransferOwnershipPlace_SIResult;
	  
	  //$webservice_ResultCode =$response->ResultCode;
	  $webservice_ResultMessage =$response->ResultMessage;
	  
	  echo '<br>';
	  echo 'ResultCode: ';print_r($response->ResultCode);echo'<br>';
      echo 'ResultMessage: ';print_r($response->ResultMessage);echo'<br>';

print_r($response); // review the returned object converted from SOAP response.
?>