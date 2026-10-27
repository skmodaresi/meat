<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
IF((isset($_POST['codeMeli']))AND(isset($_POST['tarikhTavalod'])))//آمدن اطلاعات شخص از وب سرویس 
{
  //وب سرویس کد ملی
  $wsdl_meli_url="http://10.7.1.40/getPersonInfo/GetingPersonByNationalIdAndBirthDate.asmx?wsdl";
  header('Content-Type: text/html; charset=utf-8');
  try
  {
   $client=new SoapClient($wsdl_meli_url);
   $params=array('userName'=>'agriDam','passWord'=>'3rt67HM','NationalId'=>$codeMeli,'BirthDate'=>$tarikhTavalod);
   $result=$client->GetPersonInfo($params);
   $response=$result->GetPersonInfoResult;
   $firstName=$response->firstName;
   $lastName=$response->lastName;
   $fatherName=$response->fatherName;
   $gender=$response->gender;
   $identityCertificateID=$response->identityCertificateID;
   $identityCertificateSerial=$response->identityCertificateSerial;
   $identityCertificateSeries=$response->identityCertificateSeries;
   $lifeStatus=$response->lifeStatus;
   $deathDate=$response->deathDate;
   $Err=$response->Err;
   $status=$response->status;
   /*********/	
   $identityInformationExceptionMessage=$response->identityInformationExceptionMessage;
   $volumeNumber=$response->volumeNumber;
   $volumeSeries=$response->volumeSeries;
   $civilRegistrationOfficeCode=$response->civilRegistrationOfficeCode;
   /**فارسی درست**/
   $firstName=str_replace("ي","ی",$firstName);$firstName=str_replace("ك","ک",$firstName);
   $lastName=str_replace("ي","ی",$lastName);$lastName=str_replace("ك","ک",$lastName);
   $fatherName=str_replace("ي","ی",$fatherName);$fatherName=str_replace("ك","ک",$fatherName);
   if ($gender==1) $jensiat = 'مرد' ;
   if ($gender==0) $jensiat = 'زن' ;
   echo $firstName.'^'.$lastName.'^'.$fatherName.'^'.$gender.'^'.$identityCertificateID.'^'.$identityCertificateSerial.'^'.$identityCertificateSeries.'^'.$lifeStatus.'^'.$deathDate.'^'.$jensiat.'^'.$Err.'^'.$status;  
  }
  catch(SoapFault $client)
  {
	$response=0;
    echo "وب سرویس فعال نمی باشد";
  }
}
?>