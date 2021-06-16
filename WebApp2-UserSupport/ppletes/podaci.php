<?php  
header('Content-type: text/html; charset=UTF-8');  
$conn=mysqli_connect("localhost", "iwa_2018", "foi2018", "iwa_2018_zb_projekt");
?>
<!DOCTYPE html>
<html lang="hr">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
<br><br>
<?php
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

$id=$_SESSION['pitanje_id'];
$sql=mysqli_query($conn, "SELECT *, tvrtka.tvrtka_id, tvrtka.naziv FROM pitanje 
							INNER JOIN tvrtka ON pitanje.tvrtka_id=tvrtka.tvrtka_id WHERE pitanje.pitanje_id='$id'");
$sqll=mysqli_query($conn, "SELECT *, zaposlenik.zaposlenik_id, zaposlenik.korisnik_id, korisnik.korisnik_id, korisnik.ime, korisnik.prezime
							FROM odgovor 
							INNER JOIN zaposlenik ON zaposlenik.zaposlenik_id=odgovor.zaposlenik_id
							LEFT JOIN korisnik ON korisnik.korisnik_id=zaposlenik.korisnik_id
							WHERE pitanje_id='$id'");

echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
<tr>
<th style=\"height: 50px;\">TVRTKA</th>
<th style=\"height: 50px;\">NAZIV</th>
<th style=\"height: 50px;\">DATUM I VRIJEME PITANJA</th>
<th style=\"height: 50px;\">TEKST</th>
<th style=\"height: 50px;\">SLIKA</th>
<th style=\"height: 50px;\">VIDEO</th>
</tr>";
	while($pitanje=mysqli_fetch_array($sql)){ 

	echo "<tr>";
	echo "<td style=\"height: 30px;\">" . $pitanje['naziv'] . "</td>";
	echo "<td>" . $pitanje['naslov'] . "</td>";
	$da=$pitanje['datum_vrijeme_pitanja']; $datt=date("d.m.Y H:i:s", strtotime($da)); echo "<td>".$datt."</td>";
	echo "<td>" . $pitanje['tekst'] . "</td>"; ?>
	<td style="width: 10%;">
		<?php echo "<img src=".$pitanje['slika']." width=\"50%\" onclick=\"window.open(this.src, '_blank', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0');\">"; ?>
	</td>
		<?php
		if ($pitanje['video']==false){ echo "<td>" . "<b>Video nije priložen</b>" . "</td>";}else{ ?> <td><iframe width="200" height="200" src="<?php echo $pitanje['video'] ?>"></iframe></td> <?php } 
	echo "</tr>";

	}
echo "</table>";

?><br><br><br><?php

echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
<tr>
<th style=\"height: 50px;\">ZAPOSLENIK</th>
<th style=\"height: 50px;\">ODGOVOR</th>
<th style=\"height: 50px;\">DATUM I VRIJEME ODGOVORA</th>
</tr>";
	while($odgovor=mysqli_fetch_array($sqll)){ $datumic=$odgovor['datum_vrijeme_odgovora'];

	echo "<tr>";
	echo "<td style=\"height: 30px;\">" . $odgovor['ime'] ." ". $odgovor['prezime'] ."</td>";
	echo "<td>" . $odgovor['tekst'] . "</td>";
	$datumek = strtotime($datumic);
	echo "<td>" . date('d.m.y H:i:s', $datumek). "</td>";
	echo "</tr>";

	}
echo "</table>";
?>
<br><br><br>
</body>
<footer>
<?php include ('podnozje.php'); ?>
</footer>
</html>