<?php
	// initialize Google Sheet URL
	$key = '***************************';
	$url = 'http://spreadsheets.google.com/feeds/cells/' . $key . '/1/public/values';
	// initialize curl
	$curl = curl_init();
	// set curl options
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	// get the spreadsheet using curl
	$google_sheet = curl_exec($curl);
	// close the curl connection
	curl_close($curl);
	// import the xml file into a SimpleXML object
	$feed = new SimpleXMLElement($google_sheet);
	// get every entry (cell) from the xml object
	// extract the column and row from the cell's title
	// e.g. A1 becomes [1][A]
	$array = array();
	foreach ($feed->entry as $entry) {
		$location = (string) $entry->title;
		preg_match('/(?P<column>[A-Z]+)(?P<row>[0-9]+)/', $location, $matches);
		$array[$matches['row']][$matches['column']] = (string) $entry->content;
	}
	for($i = 2, $j = 0; $i < count($array) + 1; $i++){
			//avoiding null inputs
			if(trim($array[$i]['U']) != null){
				//creating the nick list
				$names[$j] = trim($array[$i]['U']);
				$j++;
			}
	}
	//storing contributors' nicks on a json file which will be done once in a day by a cron
	file_put_contents('names.json', json_encode($names, JSON_FORCE_OBJECT));
?>
