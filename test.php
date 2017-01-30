<?php
//*************************************************************************************************
$today = date("d-m-Y");
//если файла не существ.(перв. раз) или дата послед. изм-я - вчера и ранее:
if (!file_exists("files/valutes.xml") || date("d-m-Y", filemtime("files/valutes.xml")) != $today) {
	try {
		$client = new SoapClient("http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?wsdl");
		$param["On_date"] = time();
		$response = $client->GetCursOnDateXML($param);
		$result = $response->GetCursOnDateXMLResult->any;
		getSelectedValute($result, ["USD", 'EUR']);//если есть соед-е с сервисом
	} catch (SoapFault $e) {
		// echo "Не получены данные курса валют. ".$e->getMessage();
		if (!file_exists("files/valutes.xml"))
			echo "Извините, данных для показа нет";//если нет соед-я с сервисом и файла
		else
			getValuteFromFile("files/valutes.xml");//если соед-я с сервисом нет
	}
} else {
	getValuteFromFile("files/valutes.xml");
}

//ф-я запус-ся, если данных от сервиса нет или они устарели
function getSelectedValute1($xml, $valutes) {
	$xml_str = "<valutes>";
	$sxml = simplexml_load_string($xml);
	foreach ($sxml->ValuteCursOnDate as $item) {
		for ($i=0, $cnt=count($valutes); $i<$cnt; $i++) {
			if ($item->VchCode == $valutes[$i]) {
				$curs = round((float)$item->Vcurs, 2);
				//вывод на экран:
				// echo "<li> $item->Vnom $item->Vname ($item->VchCode) : $curs рублей </li>";
				//сохр-е в xml-строку для кешир-я:
				$xml_str .= $item->asXML();
			}
		}
	}
	$xml_str .= "</valutes>";
	if (!file_put_contents("files/valutes.xml", $xml_str))
		return false;
	return true;
}

//ф-я запус-ся при наличии свежих данных в локаль. xml-файле
function getValuteFromFile($xml) {
	$sxml = simplexml_load_file($xml);
	foreach ($sxml->ValuteCursOnDate as $item) {
		$curs = round((float)$item->Vcurs, 2);//округ-е до 2 зн. после запят.
		echo "<li> $item->Vnom $item->Vname ($item->VchCode : $item->Vcode) : $curs рублей </li>";
	}
	return true;
}


$valutes = ["USD", "EUR"];
try {
	$client = new SoapClient("http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?wsdl");
	$param["Seld"] = false;
	$response = $client->EnumValutesXML($param);
	$result = $response->EnumValutesXMLResult->any;
	$codes = getCodeValute($result, $valutes);
	// print_r($codes);
} catch (SoapFault $e) {
	echo $e->getMessage();
}
$codes = ["R01235", "R01239"];
$today = time();
$offset = 60*60*24;
// $valutes = $arr;
try {
	$client = new SoapClient("http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?wsdl");
	for ($i=0, $cnt=count($codes); $i<$cnt; $i++) {
		$param["FromDate"] = $today - $offset;
		$param["ToDate"] = $today;
		$param["ValutaCode"] = $codes[$i];
		$response = $client->GetCursDynamicXML($param);
		$result = $response->GetCursDynamicXMLResult->any;
		print_r($result);
		// getSelectedValute($result, ["USD", 'EUR']);
	}
} catch (SoapFault $e) {
	echo $e->getMessage();
}

function getCodeValute($xml, $arr) {
	$res_arr = [];
	$sxml = simplexml_load_string($xml);
	foreach ($sxml->EnumValutes as $item) {
		for ($i=0, $cnt=count($arr); $i<$cnt; $i++) {
			if ($arr[$i] == $item->VcharCode) {
				// echo "<li>$arr[$i] : $item->Vcode</li>";
				$res_arr[] = trim((string)$item->Vcode);
			}
		}
	}
	return $res_arr;
}

function getSelectedValute2($xml) {
	$xml_str = "<valutes>";
	$sxml = simplexml_load_string($xml);
	foreach ($sxml->ValuteCursDynamic as $item) {
		for ($i=0, $cnt=count($valutes); $i<$cnt; $i++) {
			if ($item->VchCode == $valutes[$i]) {
				$curs = round((float)$item->Vcurs, 2);
				//вывод на экран:
				echo "<li> $item->Vnom $item->Vname ($item->VchCode) : $curs рублей </li>";
				//сохр-е в xml-строку для кешир-я:
				$xml_str .= $item->asXML();
			}
		}
	}
	$xml_str .= "</valutes>";
	if (!file_put_contents("files/valutes.xml", $xml_str))
		return false;
	return true;
}