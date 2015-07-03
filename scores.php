<?php
	//collecting data from local JSON file and decode them into an associative array
	$json = file_get_contents('names.json');
	$names = json_decode($json, true);
	//implementing DOMXPath
	$html = file_get_contents('https://location.services.mozilla.com/leaders');
	$pokemon_doc = new DOMDocument();
	libxml_use_internal_errors(TRUE);
	if(!empty($html)){
		$pokemon_doc->loadHTML($html);
		libxml_clear_errors();
		$pokemon_xpath = new DOMXPath($pokemon_doc);
		for($i = 0; $i < count($names); $i++){
			$pokemon_row = $pokemon_xpath->query('//tr[td/a[@id="' . $names[$i] . '"]]');
			if($pokemon_row->length > 0){
				// Get each tr
				foreach($pokemon_row as $row){
					// Get each td in the tr group
					$tds = $row->childNodes;
					$j = 0;
					foreach($tds as $td){
						// Filter out empty nodes
						if(trim($td->nodeValue, " \n\r\t\0\xC2\xA0") !== "") {
							$contributors[$i][$j] = $td->nodeValue;
							$j++;
						}
					}
				}
			}
		}
	}
	//sorting based on the points
	usort($contributors, function($a, $b) {
		return $a[0] - $b[0];
	});
	//storing contributors data on a json file which will be done once in a day by a cron
	file_put_contents('scores.json', json_encode($contributors, JSON_FORCE_OBJECT));
?>
