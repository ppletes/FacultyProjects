<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8"/>
	<title>KORISNIČKA PODRŠKA</title>
	<link 
		href="style.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>	
</head>

<body>
<?php include('zaglavlje.php'); ?>
<br>
<form id="pocetna_tablica" method="post" action="" enctype="multipart/form-data">
<div style="float: center; text-align: center; align: center; display: block;">
<?php
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

$id=$_SESSION['korisnik_id'];
$sql = mysqli_query($conn,"SELECT pitanje_id, pitanje.tvrtka_id, zaposlenik.tvrtka_id, naslov, datum_vrijeme_pitanja, tekst, slika, video FROM pitanje INNER JOIN zaposlenik ON zaposlenik.tvrtka_id = pitanje.tvrtka_id WHERE zaposlenik.korisnik_id='$id'");
if (!$sql) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

if(isset($_POST['pitanje'])){
	$checkbox = $_POST['checkbox'];
		for($i=1;$i>count($_POST['checkbox']);$i++){
			header("Location: pocetak.php");
		}
		for($i=0;$i<count($_POST['checkbox']);$i++){
			$id=$_POST['checkbox'][$i];
			$_SESSION['pitanje_id']=$id;
			header("Location: pitodg.php");
		}
}


echo "<table id=\"tvmod\" style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
<tr>
<th style=\"color: rgb(210,36,36);\">Označi</th>
<th style=\"height: 50px;\">NASLOV PITANJA</th>
</tr>";
	while($row = mysqli_fetch_array($sql)){ 
		echo "<tr>";
			echo "<td>" ?> <input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $row['pitanje_id']; ?>"/> <?php "</td>";
			echo "<td style=\"height: 30px;\">" . $row['naslov'] . "</td>";
		echo "</tr>";
	}
echo "</table>"; ?>
<br><br><br>
<p style="text-align: center; align: center; float: center; font-family: Arial; font-size: 15px;">Za moderatora tvrtke:</p>
<?php
$mod=mysqli_query($conn, "SELECT *, pitanje.tvrtka_id, pitanje.naslov, pitanje.pitanje_id FROM tvrtka 
							INNER JOIN pitanje ON pitanje.tvrtka_id=tvrtka.tvrtka_id WHERE moderator_id='$id'");
echo "<table id=\"tvmod\" style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
<tr>
<th style=\"color: rgb(210,36,36);\">Označi</th>
<th style=\"height: 50px;\">NASLOV PITANJA</th>
</tr>";
	while($roww = mysqli_fetch_array($mod)){ 
		echo "<tr>";
			echo "<td>" ?> <input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $roww['pitanje_id']; ?>"/> <?php "</td>";
			echo "<td style=\"height: 30px;\">" . $roww['naslov'] . "</td>";
		echo "</tr>";
	}
echo "</table>";
?>
<br>
<input style="float: left; margin-left: 5%;" type="submit" class="gumb" name="pitanje" value="Otvori" onclick="window.location.replace('pitodg.php')"/>
<br><br><br>
</div>
</form>
</body>
<footer>
<?php include('podnozje.php'); ?>
</footer>
</html>