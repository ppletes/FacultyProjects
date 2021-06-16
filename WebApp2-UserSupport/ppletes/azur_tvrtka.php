<?php  
header('Content-type: text/html; charset=UTF-8');
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
<form method="post" action="" enctype="multipart/form-data">
<?php 
if(isset($_POST['unesi'])){
	echo "<script>window.location= 'nova_tvrtka.php';</script>";
}

if(isset($_POST['uredi'])){
			$checkbox = $_POST['checkbox'];
			for($i=1;$i>count($_POST['checkbox']);$i++){
				header("Location: azur_tvrtka.php");
			}
			for($i=0;$i<count($_POST['checkbox']);$i++){
				$id=$_POST['checkbox'][$i];
				$_SESSION['tvrtka_id']=$id;
				header("Location: uredi_tvrtka.php");
			}
}

if(isset($_POST['postavi'])){
			$checkbox = $_POST['checkbox'];
			for($i=1;$i>count($_POST['checkbox']);$i++){
				header("Location: azur_tvrtka.php");
			}
			for($i=0;$i<count($_POST['checkbox']);$i++){
				$id=$_POST['checkbox'][$i];
				$_SESSION['tvrtka_id']=$id;
				header("Location: postavi_tvrtka.php");
			}
}
?>

<?php
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

if (!isset($_GET['broj']) or !is_numeric($_GET['broj'])) {
  $broj = 0;
} else {
  $broj = (int)$_GET['broj'];
}

$sql=mysqli_query($conn, "SELECT *, korisnik.korisnik_id, korisnik.ime, korisnik.prezime FROM tvrtka INNER JOIN korisnik ON korisnik.korisnik_id=tvrtka.moderator_id LIMIT $broj, 5");


$ukupno=mysqli_num_rows($sql);

	if($ukupno>0){

	echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
		<tr>
			<th style=\"color: rgb(210,36,36);\">Označi</th>
			<th style=\"height: 50px;\">ID MODERATOR</th>
			<th>NAZIV</th>
			<th>OPIS</th>
			<th>BROJ ZAPOSLENIKA</th>
			<th>PREOSTALI ODGOVORI</th>
			<th>ZAHTJEV ZA +ODGOVOR</th>
		</tr>";
		
	for($i=0; $i<$ukupno; $i++){
		$row=mysqli_fetch_array($sql);

		echo "<tr>";
			echo "<td>" ?> <input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $row['tvrtka_id']; ?>"/> <?php "</td>";
			echo "<td>" . $row['ime'] ." ".$row['prezime']. "</td>";
			echo "<td>" . $row['naziv'] . "</td>";
			echo "<td>" . $row['opis'] . "</td>";
			echo "<td>" . $row['broj_zaposlenika'] . "</td>";
			echo "<td>" . $row['preostaliOdgovori'] . "</td>";
			echo "<td>" . $row['zahtjev'] . "</td>";
	}
	echo "</table>";
	}
?>
<div class="slipre" style="float: center; text-align: center; align: center; color: rgb(210,36,36);">
<?php
if($ukupno=='5'){
	echo '<a class="slipre" name="slijedece" style="float: center;" href="'.$_SERVER['PHP_SELF'].'?broj='.($broj+5).'">Slijedeće</a>';
}elseif($ukupno<'5'){
	echo '<a class="slipre" name="slijedece" style="display: none;" href="'.$_SERVER['PHP_SELF'].'?broj='.($broj+5).'">Slijedeće</a>';
}
$prethodno = $broj-5;
if($prethodno >= 0){
    echo '<a class="slipre" style="float: center;" href="'.$_SERVER['PHP_SELF'].'?broj='.$prethodno.'">Predhodno</a>';
}
?>
</div>
<br><br>
<div style="float: center; text-align: center; align: center;">
<button type="submit" style="width: 30%; display: inline-block; margin-right: 2%;" name="unesi" class="gumb">UNESI NOVU TVRTKU</button>
<button type="submit" style="width: 30%; margin-right: 2%;" name="uredi" class="gumb">UREDI POSTOJEĆU TVRTKU</button>
<button type="submit" style="width: 30%;" name="postavi" class="gumb">POSTAVI ZAHTJEV NA 0</button>
</div>

<br><br><br><br><br><br>
<p style="text-align: center; align: center; float: center; font-family: Arial; font-size: 15px;"><b>Statistika broja pitanja i odgovora po tvrtkama</b></p>
<br>

<div class="statistika_admin" style="text-align: center;">
<?php
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");

	$statistika1=mysqli_query($conn, "SELECT pitanje.pitanje_id, pitanje.tvrtka_id, tvrtka.tvrtka_id, tvrtka.naziv,
									COUNT(pitanje.pitanje_id) AS pit
									FROM pitanje 
									INNER JOIN tvrtka ON pitanje.tvrtka_id=tvrtka.tvrtka_id
									GROUP BY pitanje.tvrtka_id");

		echo "<table style=\"background: #f1f1f1; font-family: Arial; width: 100%; text-align: center;\" align=center border=2>
			<tr>
				<th style=\"height: 50px; width: 30%;\">TVRTKA</th>
				<th>BROJ PITANJA</th>
			</tr>";
			while($row_stat = mysqli_fetch_array($statistika1)){ 
				echo "<tr>";
					echo "<td>" . $row_stat['naziv'] . "</td>";
					echo "<td>" .$row_stat['pit'] . "</td>";					
				echo "</tr>";
			}
		echo "</table>";
?><br>
<?php	
	$statistika2=mysqli_query($conn, "SELECT odgovor.odgovor_id, odgovor.zaposlenik_id, 
											zaposlenik.zaposlenik_id, zaposlenik.tvrtka_id, 
											tvrtka.tvrtka_id, tvrtka.naziv,
									COUNT(odgovor.odgovor_id) AS odg
									FROM odgovor 
									INNER JOIN zaposlenik ON odgovor.zaposlenik_id=zaposlenik.zaposlenik_id
									LEFT JOIN tvrtka ON tvrtka.tvrtka_id=zaposlenik.tvrtka_id
									GROUP BY zaposlenik.tvrtka_id");

		echo "<table style=\"background: #f1f1f1; font-family: Arial; width: 100%; text-align: center;\" align=center border=2>
			<tr>
				<th style=\"height: 50px; width: 30%;\">TVRTKA</th>
				<th>BROJ ODGOVORA</th>
			</tr>";
			while($row_statt = mysqli_fetch_array($statistika2)){ 
				echo "<tr>";
					echo "<td>" . $row_statt['naziv'] . "</td>";
					echo "<td>" .$row_statt['odg'] . "</td>";					
				echo "</tr>";
			}
		echo "</table>";
		
?>
<br><br>
</div>

<p style="text-align: center; align: center; float: center; font-family: Arial; font-size: 15px;"><b>Rang lista zaposlenika</b></p>
<br>

<div class="statistika_admin" style="text-align: center;">
<?php
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");

	$statistika3=mysqli_query($conn, "SELECT odgovor.odgovor_id, odgovor.zaposlenik_id, 
											zaposlenik.zaposlenik_id, zaposlenik.tvrtka_id, 
											korisnik.korisnik_id,korisnik.ime, korisnik.prezime,
											tvrtka.tvrtka_id, tvrtka.naziv,
									COUNT(odgovor.odgovor_id) AS odg
									FROM odgovor 
									INNER JOIN zaposlenik ON odgovor.zaposlenik_id=zaposlenik.zaposlenik_id
									LEFT JOIN tvrtka ON tvrtka.tvrtka_id=zaposlenik.tvrtka_id
									RIGHT JOIN korisnik ON korisnik.korisnik_id=zaposlenik.korisnik_id
									GROUP BY zaposlenik.zaposlenik_id");

		echo "<table style=\"background: #f1f1f1; font-family: Arial; width: 100%; text-align: center;\" align=center border=2>
			<tr>
				<th style=\"height: 50px; width: 30%;\">TVRTKA</th>
				<th>ZAPOSLENIK</th>
				<th>BROJ ODGOVORA</th>
			</tr>";
			while($row_stattt = mysqli_fetch_array($statistika3)){ 
				echo "<tr>";
					echo "<td>" . $row_stattt['naziv'] . "</td>";
					echo "<td>" . $row_stattt['ime'] ." ". $row_stattt['prezime']. "</td>";
					echo "<td>" .$row_stattt['odg'] . "</td>";					
				echo "</tr>";
			}
		echo "</table>";
		
?>
<br><br>
</div>


</form>
<br>
</body>
<footer>
<?php include ('podnozje.php'); ?>
</footer>
</html>