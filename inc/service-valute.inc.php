<?php
$today = date("d-m-Y");
//если файла не существ.(перв. раз) или дата послед. изм-я - вчера и ранее:
if (!file_exists("files/valutes.xml") || date("d-m-Y", filemtime("files/valutes.xml")) != $today) {
	try {
		$client = new SoapClient("http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?wsdl");
		$param["On_date"] = time();
		$response = $client->GetCursOnDateXml($param);
		$result = $response->GetCursOnDateXMLResult->any;
		getSelectedValute($result, ["USD", 'EUR']);
	} catch (SoapFault $e) {
		echo "Не получены данные курса валют. ".$e->getMessage();
	}
} else {
	getValuteFromFile("files/valutes.xml");
}

//ф-я запус-ся, если данных нет или они устарели
function getSelectedValute($xml, $valutes) {
	$xml_str = "<valutes>";
	$sxml = simplexml_load_string($xml);
	foreach ($sxml->ValuteCursOnDate as $item) {
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
	file_put_contents("files/valutes.xml", $xml_str);
}

//ф-я запус-ся при наличии свежих данных в локаль. xml-файле
function getValuteFromFile($xml) {
	$sxml = simplexml_load_file($xml);
	foreach ($sxml->ValuteCursOnDate as $item) {
		$curs = round((float)$item->Vcurs, 2);//округ-е до 2 зн. после ,
		echo "<li> $item->Vnom $item->Vname ($item->VchCode) : $curs рублей </li>";
	}
}