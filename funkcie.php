<?php
date_default_timezone_set('Europe/Bratislava');
include('db.php');

function vypis_select($min, $max, $oznac = -1) {
	for($i = $min; $i <= $max; $i++) {
		echo "<option value='$i'";
		if ($i == $oznac) echo ' selected';
		echo ">$i</option>\n";
	}
}

// vrati udaje pouzivatela ako asociativne pole, ak existuje pouzivatel $username s heslom $pass, inak vrati FALSE
function over_pouzivatela($mysqli, $username, $pass) {
	if (!$mysqli->connect_errno) {
		$sql = "SELECT * FROM coko_pouzivatelia WHERE username='$username' AND heslo=MD5('$pass')";  // definuj dopyt
//		echo "sql = $sql <br>";
		if (($result = $mysqli->query($sql)) && ($result->num_rows > 0)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
			$row = $result->fetch_assoc();
			$result->free();
			return $row;
		} else {
			// dopyt sa NEpodarilo vykonať, resp. používateľ neexistuje!
			return false;
		}
	} else {
		// NEpodarilo sa spojiť s databázovým serverom!
		return false;
	}
}

?>
