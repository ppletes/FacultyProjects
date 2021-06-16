<?php  
header('Content-type: text/html; charset=utf-8');
?>
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


$kor_id=$_SESSION['korisnik_id'];
$id=$_SESSION['pitanje_id'];

$naziv = mysqli_query($conn,"SELECT * FROM pitanje WHERE pitanje_id = '$id'");
$sql = mysqli_query($conn,"SELECT tekst, datum_vrijeme_pitanja, slika, video FROM pitanje WHERE pitanje_id='$id'");

if (!$sql) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
?>
<br>
<form method="post" action="" enctype="multipart/form-data">
<div style="float: center; text-align: center; align: center; display: inline;">
<?php
echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
<tr>
<th>PITANJE</th>
<th>DATUM I VRIJEME POSTAVLJANJA</th>
<th>SLIKA <span style=\"color: rgb(210,36,36);\">(pritisnite)</span></th>
<th>VIDEO</th>
</tr>";
	while($row = mysqli_fetch_array($sql)){ 
		echo "<tr>";
		echo "<td>" . $row['tekst'] . "</td>";
		$da=$row['datum_vrijeme_pitanja']; $datt=date("d.m.Y H:i:s", strtotime($da)); echo "<td>".$datt."</td>"; ?>
		<td style="width: 10%;">
		<?php echo "<img src=".$row['slika']." width=\"50%\" onclick=\"window.open(this.src, '_blank', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0');\">"; ?>
		</td>
		<?php
		if ($row['video']==false){ echo "<td>" . "<b>Video nije priložen</b>" . "</td>";}else{ ?> <td><iframe width="200" height="200" src="<?php echo $row['video'] ?>"></iframe></td> <?php } 
	}
echo "</table>";
?>
<br>
<?php while($n = mysqli_fetch_array($naziv)){?>

<div style="font-family: Arial; text-align: center; float: center; align: center;">
	<label style="font-weight: bold;">ZA</label>
	<input name="naziv" style="text-align: center; align: center; float: center; font-weight: bold; color: rgb(210,36,36);" type="text" value="<?php echo $n['naslov']; ?>">
</div>
<br><br>

<div id="form1" style="float: left; margin-left: 5%; font-family: Arial;">
<div style="float: center; align: center; text-align: center; font-family: Arial;">
	<label style="font-size: 15px;">ODGOVOR <span style="color: rgb(210,36,36);">*</span></label><br>
	<textarea name="odgovor" type="text" placeholder="Unesite odgovor" style="resize: none; height: 200px; font-size: 15px; text-align: left; width: 500px;"></textarea>
</div>
<br><br>
<?php } ?>

<div style="float: center; text-align: center; align: center;">
<button type="submit" style="display: inline-block; margin-right: 2%;" name="unesi" class="gumb">UNESI</button>
<button type="submit" name="odustani" class="gumb">Odustani</button>
</div>

<br><br>

<?php
if(isset($_POST['odustani'])){ 
	header ("Location: pocetak.php");
} 

if (isset($_POST['unesi'])){
	
	$pitanje_id=$_SESSION['pitanje_id'];
	$tekst=$_POST['odgovor'];
	$datum_vrijeme_odgovora=date("Y-m-d H:i:s");	
		
	if($tekst==""){
		echo "<script>alert('Niste unjeli sve podatke. Nesmijete ostaviti prazno * označena polja');window.location='pitodg.php';</script>";
	}else{
		
		$tvrtka=mysqli_query($conn, "SELECT tvrtka.tvrtka_id, preostaliOdgovori, pitanje.tvrtka_id, pitanje.pitanje_id FROM tvrtka
									INNER JOIN pitanje ON pitanje.tvrtka_id=tvrtka.tvrtka_id WHERE pitanje.pitanje_id='$id'");
		while($row_tvrtka=mysqli_fetch_array($tvrtka)){
			
			$odg=$row_tvrtka['preostaliOdgovori'];	

			if($odg!=0){

				$servername = "localhost";
				$username = "iwa_2018";
				$password = "foi2018";
				$dbname = "iwa_2018_zb_projekt";

				$queryy=mysqli_query($conn,"SELECT * FROM zaposlenik WHERE korisnik_id='$kor_id'");
					while($roww=mysqli_fetch_assoc($queryy)){
						$zap=$roww['zaposlenik_id'];
						$tv=$roww['tvrtka_id'];
						
						$sql_provjera=mysqli_query($conn, "SELECT * FROM odgovor WHERE pitanje_id='$id' AND zaposlenik_id='$zap'");
						if(mysqli_num_rows($sql_provjera) > 0){
							echo "<script>alert('Ne možete unijeti novi odgovor. Na navedeno pitanje ste već dali svoj odgovor. ');window.location='pocetak.php';</script>";								
						}else{
							try{
								$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
								$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

								$odgovor_baza = "INSERT INTO odgovor (pitanje_id, zaposlenik_id, tekst, datum_vrijeme_odgovora)
												VALUES ('$pitanje_id', '$zap', '$tekst', '$datum_vrijeme_odgovora')";

								$con->exec($odgovor_baza);
								echo "<script>alert('Uspiješno ste unijeli novi odgovor.'); window.location= 'pocetak.php';</script>";
							}
							catch(PDOException $e){
								echo $odgovor_baza . "<br>" . $e->getMessage();
							}
							$con = null;

							try{
								$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
								$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

								$tvrtka_baza = "UPDATE tvrtka SET preostaliOdgovori=preostaliOdgovori-1 WHERE tvrtka_id='$tv'";

								$con->exec($tvrtka_baza);
								echo "<script>alert('Uspiješno ste unijeli novi odgovor.'); window.location= 'pocetak.php';</script>";
							}
							catch(PDOException $e){
								echo $tvrtka_baza . "<br>" . $e->getMessage();
							}
							$con = null;
						}
					}
			}else{
				echo "<script>alert('Ne možete unijeti novi odgovor. Broj preostalih odgovora možete vidjeti u desnom uglu zaglavlja. Nažalost iznosi 0.'); window.location= 'pocetak.php';</script>";
			}
		}
	
	}
}
?>

</div>

<div id="form1" style="margin-top: 1.5%; margin-right: 5%; font-family: Arial; display: inline;">
<?php
$sql_odg = mysqli_query($conn,"SELECT odgovor.tekst, odgovor.zaposlenik_id, odgovor.datum_vrijeme_odgovora, 
									zaposlenik.zaposlenik_id, zaposlenik.korisnik_id, 
									korisnik.korisnik_id, korisnik.ime, korisnik.prezime 
									FROM zaposlenik 
									INNER JOIN odgovor ON zaposlenik.zaposlenik_id=odgovor.zaposlenik_id
									INNER JOIN korisnik ON korisnik.korisnik_id=zaposlenik.korisnik_id
									WHERE pitanje_id = '$id'");

echo "<table style=\"background: #f1f1f1; font-family: Arial; width: 40%;\" align=center border=2>
<tr>
<th>ZAPOSLENIK</th>
<th>ODGOVOR</th>
<th>DATUM I VRIJEME ODGOVORA</th>
</tr>";
	while($row_odg = mysqli_fetch_array($sql_odg)){ 
		echo "<tr>";
		echo "<td>" . $row_odg['ime'] . " " . $row_odg['prezime'] . "</td>";
		echo "<td>" . $row_odg['tekst'] . "</td>";
		$daa=$row_odg['datum_vrijeme_odgovora']; $dattt=date("d.m.Y H:i:s", strtotime($daa)); echo "<td>".$dattt."</td>";
		echo "</tr>";
	}
echo "</table>";
?>
</div>
<br>
</div>
<br><br><br>
<p style="text-align: center; align: center; float: center; font-family: Arial; font-size: 15px;"><b>Pitanja i odgovori ostalih tvrtki:</b></p>

<div id="form1" style="overflow-y: scroll; height: 300px; margin-top: 1.5%; margin-right: 5%; font-family: Arial;">
<?php
$drtv=mysqli_query($conn,"SELECT pitanje.naslov, pitanje.pitanje_id, pitanje.tvrtka_id, odgovor.pitanje_id, odgovor.tekst, tvrtka.tvrtka_id, tvrtka.naziv 
							FROM pitanje 
							INNER JOIN odgovor ON pitanje.pitanje_id=odgovor.pitanje_id 
							INNER JOIN tvrtka ON tvrtka.tvrtka_id=pitanje.tvrtka_id");
echo "<table style=\"background: #f1f1f1; font-family: Arial; width: 80%;\" align=center border=2>
<tr>
<th>TVRTKA</th>
<th>PITANJE</th>
<th>ODGOVOR</th>
</tr>";
	while($rowic = mysqli_fetch_array($drtv)){
		echo "<tr>";
		echo "<td>" . $rowic['naziv'] . "</td>";
		echo "<td>" . $rowic['naslov'] . "</td>";
		echo "<td>" . $rowic['tekst'] . "</td>";
		echo "</tr>";
	}
echo "</table>";
?>
</div>
<br><br>
</form>
<?php mysqli_close($conn); ?>
</body>
<footer>
<?php include('podnozje.php'); ?>
</footer>
</html>