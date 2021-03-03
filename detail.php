<?php
session_start();
$titulok = 'detail produktu';

include('funkcie.php');
include('hlavicka.php');
include('navigacia.php');
include('akcia.php');
?>
<section>

<?php
	$pocet = 0;
	if (!$mysqli->connect_errno) {
		$sql = "SELECT count(pid) as pp FROM coko_produkty";
		if (($result = $mysqli->query($sql)) && ($result->num_rows > 0)) {
			$row = $result->fetch_assoc();
			$pocet = $row['pp'];
			$result->free();
		}
	}

	if (isset($_GET['pid']) && ((int)$_GET['pid'] > 0) && (int)$_GET['pid']<= $pocet) {   //osteri neziaduci vstup

		$pid = $_GET['pid'];
		if (!$mysqli->connect_errno) {
			$sql = "SELECT * FROM coko_produkty WHERE pid = '$pid'"; // definuj dopyt
		
			if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
				while ($row = $result->fetch_assoc()) {
					
					echo "<h1>". $row['nazov']. "</h1>";
					if (file_exists("foto/" . $row['foto'] . "")) {
						echo "<img src='foto/{$row['foto']}' alt='{$row['nazov']}' width='130' height='130'>";
					}
					echo "<p>" . $row['popis'] . "</p>";
					echo "<p>cena: {$row['cena']} &euro;</p>";
					//echo "<h2>Komentáre</h2>";
				}
				$result->free();
			} elseif ($mysqli->errno) {
				echo '<p class="chyba">NEpodarilo sa vykonať dopyt! (' . $mysqli->error . ')</p>';
			}


			$sql = "SELECT * FROM coko_komentare WHERE pid = '$pid' ORDER BY cas DESC";
			if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
				echo "<h2>Komentáre</h2>";
				//$i = 1;
				echo "<ol>";
				while ($row = $result->fetch_assoc()) {
					echo "<li> {$row['komentar']} ({$row['cas']})</li>";
				//$i += 1;
				}
				echo "</ol>";
				$result->free();

			} elseif ($mysqli->errno) {
				echo '<p class="chyba">NEpodarilo sa vykonať dopyt! (' . $mysqli->error . ')</p>';
			}

		}
	
		
		
		
		
	} else {
		echo "<p>Chyba</p>";
	}
	if (isset($_SESSION['user'])) {

		if (isset($_POST['submit'])) {
			if (!$mysqli->connect_errno) {
				$komentar = $mysqli->real_escape_string($_POST['komentar']);
				$sql = "INSERT INTO coko_komentare SET komentar='$komentar', cas=NOW(), pid='$pid', uid='{$_SESSION['uid']}'"; 
				if ($result = $mysqli->query($sql)) { 
				} else {
					echo 'chyba';
				} 

			}
		}

	
?>

	<!--<h1>nazov</h1>
	<img src='foto/foto' alt='nazov' width='130' height='130'>
	<p>popis</p>
	<p>cena: cena &euro;</p>
	<h2>Komentáre</h2>
	<ol>
		<li>komentar 1</li>
		<li>komentar 2</li>
	</ol> -->
	<form method="post">
		<p><label for="komentar">Pridaj komentár:</label>
     <textarea name="komentar" cols="60" rows="4" id="komentar"></textarea>
		</p>
		<p>
			<input name="submit" type="submit" id="submit" value="Pridaj komentár">
		</p>
	</form>
	<?php } ?>
</section>
<?php include('paticka.php'); ?>
