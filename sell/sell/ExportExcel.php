<?php
ini_set('memory_limit', '1024M');
echo export('select * from sell.dm_customer1','dm_customer1');

function export($query_exp,$name)
{
	$conn = new PDO('mysql:host=192.168.254.16;dbname=sell;','root','xlsdj@#@aHdF');
	$conn->exec('set names utf8');

	$filename = $name.' - '.date('Y.m.d').'.xls'; /*set desired output file name here*/

	function cleanData(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
		if ($str=='') {$str='-';}
	}

	header('Content-Encoding: UTF-8');
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");	
	
	$Temp = '';
	$flag = false;
	$sqlExc = $conn->prepare($query_exp);
	$sqlExc->execute();
	$Records = $sqlExc->fetchAll(PDO::FETCH_ASSOC);
	foreach ($Records as $Row)
	{
		if(!$flag)
		{
			foreach ($Row as $Key => $Value)
			$Temp .= $Key."\t";
			$Temp .=  "\r\n";
			$flag = true;	
		}
		foreach ($Row as $Key => $Value)
			$Temp .= $Value."\t";
		$Temp .= "\r\n";
	}
	return $Temp;
}