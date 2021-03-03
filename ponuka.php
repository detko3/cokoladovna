<?php
$titulok = 'Ponuka';
include('funkcie.php');
include('hlavicka.php');
include('navigacia.php');
include('akcia.php');
?>
<section>


<!-- Nasledujúcu časť treba vygenerovať z databázy -->
<?php 
echo '<p>';
echo '<form method="post">';
echo '<label>';
echo "zobraz len";
echo '<select name="zoradit">';
echo "<option value='0'>Vsetko</option>";
    if (!$mysqli->connect_errno) {
        $sql = "SELECT * FROM coko_kategorie"; // definuj dopyt
    
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_kat']}'>{$row['nazov']}</option>";
            }
            $result->free();
        } elseif ($mysqli->errno) {
            echo '<p class="chyba">NEpodarilo sa vykonať dopyt! (' . $mysqli->error . ')</p>';
        }
    } 
echo '</select>';
echo '</lable>';
echo '<input type="submit" value="filtruj" name="submit"  />';
echo '</form>';
echo '</p>';

if (isset($_POST['submit'])) {
    $zoradenie = $_POST['zoradit'];
} else {
    $zoradenie = -1;
}

if (!$mysqli->connect_errno) {
    if ($zoradenie == -1 || $zoradenie == 0) {
        $sql = "SELECT * FROM coko_produkty ORDER BY nazov ASC"; // definuj dopyt
    } else {
        $sql = "SELECT * FROM coko_produkty WHERE id_kat='$zoradenie' ORDER BY nazov ASC"; // definuj dopyt
    }

	if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
		while ($row = $result->fetch_assoc()) {
            echo "<figure>";
            echo "<figcaption>". $row['nazov']. "</figcaption>";
            if (file_exists("foto/" . $row['foto'] . "")) {
				echo "<img src='foto/{$row['foto']}' alt='{$row['nazov']}' width='130' height='130'>";
			}
            echo "<p>cena: {$row['cena']} &euro;</p>";
            echo "<p>[ <a href='detail.php?pid={$row['pid']}' >detail</a> ]</p>";
            echo "</figure>";
		}
		$result->free();
	} elseif ($mysqli->errno) {
		echo '<p class="chyba">NEpodarilo sa vykonať dopyt! (' . $mysqli->error . ')</p>';
	}
} 
?>



<!--<figure>
<figcaption>Amaretto Truffle</figcaption>
<img src='foto/amaretto_truffle.jpg' alt='Amaretto Truffle' width='130' height='130'>
<p>cena: 2.62 &euro;</p>
</figure>

<figure>
<figcaption>Banán</figcaption>
<img src='foto/banan.jpg' alt='Banán' width='130' height='130'>
<p>cena: 2.62 &euro;</p>
</figure>
-->
...
<div id="posledny"></div>
</section>
<?php include('paticka.php'); ?>
