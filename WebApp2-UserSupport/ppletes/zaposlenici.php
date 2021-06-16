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
$mod=$_SESSION['korisnik_id'];
?>
<br>
<form id="pocetna_tablica" method="post" action="" enctype="multipart/form-data">
<?php
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

if (!isset($_GET['broj']) or !is_numeric($_GET['broj'])) {
  $broj = 0;
} else {
  $broj = (int)$_GET['broj'];
}

$sql = mysqli_query($conn,"SELECT zaposlenik.zaposlenik_id, zaposlenik.korisnik_id, zaposlenik.tvrtka_id, 
								tvrtka.tvrtka_id, tvrtka.naziv, 
								korisnik.korisnik_id, korisnik.ime, korisnik.prezime FROM zaposlenik 
								INNER JOIN tvrtka ON zaposlenik.tvrtka_id = tvrtka.tvrtka_id
								INNER JOIN korisnik ON korisnik.korisnik_id=zaposlenik.korisnik_id
								LIMIT $broj, 5");

$ukupno=mysqli_num_rows($sql);
	if($ukupno>0){
		echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
		<tr>
			<th style=\"height: 50px;\">IME I PREZIME</th>
			<th style=\"height: 50px;\">NAZIV TVRTKE</th>
		</tr>";
		for($i=0; $i<$ukupno; $i++){
			$row=mysqli_fetch_array($sql);
				echo "<tr>";
					echo "<td style=\"height: 30px;\">" . $row['ime']." ".$row['prezime'] . "</td>";
					echo "<td style=\"height: 30px;\">" . $row['naziv']. "</td>";
				echo "</tr>";
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

<br><br><br>

<div style="font-family: Arial; float: center; text-align: center; align: center;">
<label><b>Novi zaposlenik</b></label>
<select name="odabir" style="margin-left: 1%; padding: 10px 32px; text-align: center; float: center; align: center;">
<?php
$sql_zaposlenik=mysqli_query($conn, "SELECT * FROM korisnik WHERE tip_id!=\"0\" AND tip_id!=\"1\" AND korisnik_id NOT IN (SELECT korisnik_id FROM zaposlenik)");
while($rowww=mysqli_fetch_array($sql_zaposlenik)){
	echo "<option value=".$rowww['korisnik_id']." style=\"text-align: center; float: center; align: center;\">" . $rowww['korisnik_id'] .' | '. $rowww['ime'] .' '. $rowww['prezime'] . "</option>";
}
?> 
</select>

<button type="submit" style="display: inline-block; margin-left: 2%;" name="unesi" class="gumb">UNESI</button>
<?php
if (isset($_POST['unesi'])){
	$odabir=$_POST['odabir'];
	
			$servername = "localhost";
			$username = "iwa_2018";
			$password = "foi2018";
			$dbname = "iwa_2018_zb_projekt";
	
			$sqll=mysqli_query($conn, "SELECT zaposlenik_id FROM zaposlenik ORDER BY zaposlenik_id DESC LIMIT 1");
			while($r_tv=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tvrtka WHERE moderator_id='$mod'")) and $row_sql=mysqli_fetch_array($sqll)){
				$id_zaposlenih=$r_tv['broj_zaposlenika'];
				$tv_id=$r_tv['tvrtka_id'];
				$id_sqll=$row_sql['zaposlenik_id'];
				$max=$id_sqll+1;
		
			if($id_zaposlenih!=0){
				
				try{
					$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
					$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$zaposlenik_baza = "INSERT INTO zaposlenik (zaposlenik_id, korisnik_id, tvrtka_id)
										VALUES ('$max', '$odabir', '$tv_id')";
			
					$con->exec($zaposlenik_baza);
					echo "<script>alert('Uspiješno ste unijeli novog zaposlenika.'); window.location= 'zaposlenici.php';</script>";
				}
				catch(PDOException $e){
					echo $zaposlenik_baza . "<br>" . $e->getMessage();
				}
				$con = null;
		
		
				try{
					$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
					$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$tvrtka_baza = "UPDATE tvrtka SET broj_zaposlenika=broj_zaposlenika-1 WHERE tvrtka_id='$tv_id'";

					$con->exec($tvrtka_baza);
					echo "<script>alert('Uspiješno ste unijeli novog zaposlenika.'); window.location= 'zaposlenici.php';</script>";
				}
				catch(PDOException $e){
					echo $tvrtka_baza . "<br>" . $e->getMessage();
				}
				$con = null;
		
		}else{
			echo "<script>alert('Ne možete unijeti novog zaposlenika. Tvrtka je popunjena.'); window.location= 'zaposlenici.php';</script>";			
		}
		
	}
}
?>

</div>
</form>
<br>
</body>
<footer>
<?php include('podnozje.php'); ?>
</footer>
</html>