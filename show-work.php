<?php
function showWork() {
	$conn = new PDO('sqlite:zotero.sqlite');
	// get all the works
	$query = "SELECT DISTINCT itemID FROM collectionItems WHERE collectionID = 4";
	$result = $conn->query($query);
	$works = [];
	// add works into array
	foreach ($result as $row) {
		array_push($works, $row['itemID']);
	}
	// pick a random Work
	$rand_key = array_rand($works, 1);
	$rand_work = $works[$rand_key];
	// get URL ID of the random work 
	$query = 'SELECT valueID FROM itemData WHERE (fieldID = 1 AND itemID = '. $rand_work .')';
	$result = $conn->query($query);
	foreach ($result as $row) {
		$url_id = $row['valueID'];
	}
	// if urlID is empty redo the procedure
	if (empty($url_id)) {
		showWork();
	} else {
		// get the URL value from the ID
		$query = 'SELECT value FROM itemDataValues WHERE valueID = '. $url_id;
		$result = $conn->query($query);
		foreach ($result as $row) {
			$url = $row['value'];
		}
		return $url;
	}
}
?>