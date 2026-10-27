<?php
abstract class QueryType{
	const Insert = 0;
	const Update = 1;
	const Delete = 2;
	const Query = 3;
	const DeleteLog=4;
	const UpdateOneRow = 5;
	const DeleteLogReciever=6;
	const DeleteLogSender=7;
}
class BoMain {
	var $KeyName;
	var $KeyValue;
	var $Result;
	var $BoName;
	var $BoType;
	var $WhereStr;
	var $Query;
	var $TableName;
	var $ResultList;
	var $DbName;
	var $RecordCount;
}   
?>