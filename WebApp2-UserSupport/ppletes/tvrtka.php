<?php  
header('Content-type: text/html; charset=UTF-8');  
$conn=mysqli_connect("localhost", "iwa_2018", "foi2018", "iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

 ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>KORISNIČKA PODRŠKA</title>
	<link 
		href="style.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>	
	<link 
		href="styletvrtka.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>
</head>

<body>
<?php include('zaglavlje.php'); ?>
<br>

<form method="post" action="">
<?php 
	if(isset($_POST['pitanje'])){
		$checkbox = $_POST['checkbox'];
			for($i=1;$i>count($_POST['checkbox']);$i++){
				header("Location: tvrtka.php");
			}
			for($i=0;$i<count($_POST['checkbox']);$i++){
				$id=$_POST['checkbox'][$i];
				$_SESSION['tvrtka_id']=$id;
				header("Location: obrazac_pitanje.php");
			}
	}
?>
<?php
$sql = mysqli_query($conn,"SELECT *, korisnik.korisnik_id, korisnik.ime, korisnik.prezime FROM tvrtka INNER JOIN korisnik ON korisnik.korisnik_id=tvrtka.moderator_id");

echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
<tr>
<th style=\"color: rgb(210,36,36);\">Označi</th>
<th id=\"tvrtka_anonim\" style=\"height: 50px;\">ID TVRTKA</th>
<th id=\"tvrtka_anonim\">ID MODERATOR</th>
<th>NAZIV</th>
<th>OPIS</th>
<th id=\"tvrtka_anonim\">BROJ ZAPOSLENIKA</th>
<th id=\"tvrtka_anonim\">PREOSTALI ODGOVORI</th>
<th id=\"tvrtka_anonim\">ZAHTJEV</th>
</tr>";

while($row = mysqli_fetch_array($sql)){
echo "<tr>";
echo "<td>" ?> <input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $row['tvrtka_id']; ?>"/> <?php "</td>";
echo "<td id=\"tvrtka_anonim\" style=\"height: 30px;\">" . $row['tvrtka_id'] . "</td>";
echo "<td id=\"tvrtka_anonim\">" . $row['ime'] ." ". $row['prezime'] . "</td>";
echo "<td>" . $row['naziv'] . "</td>";
echo "<td>" . $row['opis'] . "</td>";
echo "<td id=\"tvrtka_anonim\">" . $row['broj_zaposlenika'] . "</td>";
echo "<td id=\"tvrtka_anonim\">" . $row['preostaliOdgovori'] . "</td>";
echo "<td id=\"tvrtka_anonim\">" . $row['zahtjev'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($conn);
?>
<br>
<input style="margin-left: 5%;" type="submit" class="gumb" name="pitanje" value="Postavi pitanje" onclick="window.location.replace('obrazac_pitanje.php')"/>
</form>

<br>
</body>
<footer>
<?php include ('podnozje.php'); ?>
</footer>
</html>