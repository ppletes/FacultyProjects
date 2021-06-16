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
<?php include('zaglavlje.php');
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

$id=$_SESSION['korisnik_id'];?>
<br>
<form method="post" action="" enctype="multipart/form-data">
<?php
$sql=mysqli_query($conn, "SELECT DISTINCT *, pitanje.tvrtka_id, tvrtka.tvrtka_id, tvrtka.moderator_id, tvrtka.naziv FROM pitanje
							INNER JOIN tvrtka ON tvrtka.tvrtka_id=pitanje.tvrtka_id 
							WHERE tvrtka.moderator_id='$id'");
$sqll=mysqli_query($conn, "SELECT DISTINCT * from tvrtka WHERE moderator_id='$id'");					
echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
<tr>
<th style=\"height: 50px;\">NASLOV PITANJA</th>
<th>DATUM I VRIJEME PITANJA</th>
<th>STATUS</th>
</tr>";
	while($roww=mysqli_fetch_array($sqll)){?>
	<div style="font-family: Arial; text-align: center; float: center; align: center;">
	<label style="font-weight: bold;">ZA</label>
	<input name="naziv" style="text-align: center; align: center; float: center; font-weight: bold; color: rgb(210,36,36);" type="text" value="<?php echo $roww['naziv']; ?>">
	</div><br>
<?php }
	while($row = mysqli_fetch_array($sql)){
		echo "<tr>";
		echo "<td style=\"height: 30px;\">" . $row['naslov'] . "</td>";
		$da=$row['datum_vrijeme_pitanja']; $datt=date("d.m.Y H:i:s", strtotime($da)); echo "<td>".$datt."</td>"; 
		if($id != NULL){
			echo "<td>Ima odgovor</td>";
		}else{
			echo "<td>Nema odgovor</td>";
		}
	}
echo "</table>";
?>
<br><br><br>

<div style="float: center; align: center; text-align: center; font-family: Arial;">
<button type="submit" style="display: inline-block;" name="zatrazi" class="gumb">Zatraži <b>dodatnih 10 odgovora</b> za svoju tvrtku</button>
<?php
if(isset($_POST['zatrazi'])){
	$sql_zahtjev=mysqli_query($conn, "SELECT * FROM tvrtka WHERE moderator_id='$id'");
	while($row_zahtjev=mysqli_fetch_array($sql_zahtjev)){ $stanje=$row_zahtjev['zahtjev'];
		if($stanje!=0){
			echo "<script>alert('Već ste zatražili povećanje broja odgovora.');window.location='moja_tvrtka.php';</script>";
		}else{
			
			$servername = "localhost";
			$username = "iwa_2018";
			$password = "foi2018";
			$dbname = "iwa_2018_zb_projekt";
			
			try{
				$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$zahtjev_baza = "UPDATE tvrtka SET zahtjev=zahtjev+1 WHERE moderator_id='$id'";

				$con->exec($zahtjev_baza);
				echo "<script>alert('Uspiješno ste zatražili povećanje broja odgovora.'); window.location= 'moja_tvrtka.php';</script>";
			}
			catch(PDOException $e){
				echo $zahtjev_baza . "<br>" . $e->getMessage();
			}
			$con = null;
		}
	}
}
?>
</div>
<br><br><br><br>
<p style="text-align: center; align: center; float: center; font-family: Arial; font-size: 15px;"><b>Statistika broja odgovora po zaposleniku</b></p>
<p style="font-family: Arial; font-size: 11px; float: center; text-align: center;">(MOLIMO POLJA POPUNJAVAJTE KAKO JE PRIKAZANO S <span style="color: rgb(210,36,36); font-weight: bold;">-</span>, <span style="color: rgb(210,36,36); font-weight: bold;">:</span> I <span style="color: rgb(210,36,36); font-weight: bold;">razmakom</span>)</p>
<br>

<div style="text-align: center;">
<div style="font-family: Arial; text-align: center; display: inline-block;">
<label>Unesite datum i vrijeme početka pretraživanja:</label><br>
<input name="pocetak" style="height: 30px; width: 95%; text-align: center;" type="text" placeholder="gggg-mm-dd hh:mm:ss">
</div>
<div style="font-family: Arial; text-align: center; display: inline-block; margin-left: 5%;">
<label>Unesite datum i vrijeme završetka pretraživanja:</label><br>
<input name="zavrsetak" style="height: 30px; width: 95%; text-align: center;" type="text" placeholder="gggg-mm-dd hh:mm:ss">
</div>
<br><br>
<button type="submit" style="display: inline-block; margin-right: 2%;" name="pretrazi" class="gumb">PRETRAŽI</button>
<br><br>
</div>

<?php 
if(isset($_POST['pretrazi'])){
	$tvrtkica=mysqli_query($conn, "SELECT * FROM tvrtka WHERE moderator_id='$id'");
	while($tvrtkicaId=mysqli_fetch_array($tvrtkica)){
	$idtvrtka=$tvrtkicaId['tvrtka_id'];

	
	$pocetak=date("Y-m-d H:i:s", strtotime($_POST['pocetak']));
	$zavrsetak=date("Y-m-d H:i:s", strtotime($_POST['zavrsetak']));

	$datum=mysqli_query($conn, "SELECT odgovor.datum_vrijeme_odgovora, odgovor.zaposlenik_id,
									zaposlenik.zaposlenik_id, zaposlenik.tvrtka_id, zaposlenik.korisnik_id, 
									korisnik.ime, korisnik.prezime, korisnik.korisnik_id,
									COUNT(odgovor.zaposlenik_id) AS broj
									FROM zaposlenik 
									LEFT JOIN odgovor ON zaposlenik.zaposlenik_id=odgovor.zaposlenik_id 
									INNER JOIN korisnik ON korisnik.korisnik_id=zaposlenik.korisnik_id
									WHERE zaposlenik.tvrtka_id='$idtvrtka' AND odgovor.datum_vrijeme_odgovora >= '$pocetak' AND odgovor.datum_vrijeme_odgovora <= '$zavrsetak'
									GROUP BY odgovor.zaposlenik_id");

	if(!isset($pocetak) || trim($pocetak) == ''){
		echo "<script>alert('Niste ispunili polja za pretraživanje.'); window.location= 'moja_tvrtka.php';</script>";	
	}elseif(!isset($zavrsetak) || trim($zavrsetak) == ''){
		echo "<script>alert('Niste ispunili polja za pretraživanje.'); window.location= 'moja_tvrtka.php';</script>";	
	}else{
		echo "<table style=\"background: #f1f1f1; font-family: Arial; width: 100%; text-align: center;\" align=center border=2>
			<tr>
				<th>ZAPOSLENIK</th>
				<th>BROJ ODGOVORA</th>
			</tr>";
			while($roww_odg = mysqli_fetch_array($datum)){ 
				echo "<tr>";
					echo "<td>" . $roww_odg['ime'] ." " . $roww_odg['prezime'] . "</td>";
					echo "<td>" .$roww_odg['broj'] . "</td>";					
				echo "</tr>";
			}
		echo "</table>";
	}
}
}
?>

<br>
</form>
<br>

</body>
<footer>
<?php include('podnozje.php'); ?>
</footer>
</html>