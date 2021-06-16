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
<?php include('zaglavlje.php'); 
$id=$_SESSION['tvrtka_id'];

$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

$sql=mysqli_query($conn, "SELECT *, korisnik.korisnik_id, korisnik.ime, korisnik.prezime FROM tvrtka INNER JOIN korisnik ON korisnik.korisnik_id=tvrtka.moderator_id WHERE tvrtka_id='$id'");
$sqll=mysqli_query($conn, "SELECT * FROM korisnik WHERE tip_id='1' AND korisnik_id NOT IN (SELECT moderator_id FROM tvrtka)");
while($row=mysqli_fetch_array($sql)){  
?>
<br><br>
<form style="text-align: center; float: center; align: center;" method="post" action="" enctype="multipart/form-data">

<p style="font-family: Arial; font-size: 12px;">Molimo polja označena s <span style="color: rgb(210,36,36); font-weight: bold;">*</span> ne ostavljajte prazna.</p>

<br><br>

<div style="font-family: Arial;">
<label>ID MODERATOR <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<select name="moderator_id" style="height: 30px; text-align: center;" type="text">
	<option value="<?php echo $row['moderator_id']; ?>"><?php echo $row['ime']." ".$row['prezime']; ?></option>
<?php while($roww=mysqli_fetch_array($sqll)){ ?>
	<option value="<?php echo $roww['korisnik_id']; ?>"><?php echo $roww['ime']." ".$roww['prezime']; ?></option>
<?php } ?>
</select>
</div>

<br><br>

<div style="font-family: Arial;">

<div style="float: left; margin-left: 20%;">
<label>Naziv <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="naziv" value="<?php echo $row['naziv']; ?>" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
<label>Opis</label><br>
<input name="opis" value="<?php echo $row['opis']; ?>" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
</div>

<div style="float: right; margin-right: 20%;">
<label>Broj zaposlenika <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="broj_zaposlenika" value="<?php echo $row['broj_zaposlenika']; ?>" style="height: 30px; text-align: center; width: 300px;" type="number"><br><br>
<label>Preostali odgovori <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="preostaliOdgovori" disabled="disabled" value="<?php echo $row['preostaliOdgovori']; ?>" style="height: 30px; text-align: center; width: 300px;" type="number"><br><br>
<label>Zahtjev za +odgovor <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="zahtjev" disabled="disabled" value="<?php echo $row['zahtjev']; ?>" style="height: 30px; text-align: center; width: 300px;" type="number"><br><br>
</div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div style="float: center;">
<button type="submit" style="display: inline-block; width: 10%;" name="uredi" class="gumb">UREDI</button>
<button type="submit" style="display: inline-block; margin-left: 3%; width: 10%;" name="odustani" class="gumb">Odustani</button>
</div>

<?php
}

if(isset($_POST['uredi'])){
	$moderator_id=$_POST['moderator_id'];
	$naziv=$_POST['naziv'];
	$opis=$_POST['opis'];
	$broj_zaposlenika=$_POST['broj_zaposlenika'];
	$preostaliOdgovori=$_POST['preostaliOdgovori'];
	$zahtjev=$_POST['zahtjev'];
	
	$servername = "localhost";
	$username = "iwa_2018";
	$password = "foi2018";
	$dbname = "iwa_2018_zb_projekt";

	$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	
	if ($moderator_id=="" or $naziv=="" or $broj_zaposlenika==""){
		echo "<script>alert('Niste unijeli sve potrebne podatke.'); window.location='uredi_tvrtka.php'</script>";
	}else{

		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE tvrtka SET moderator_id='$moderator_id', naziv='$naziv', opis='$opis', broj_zaposlenika='$broj_zaposlenika', preostaliOdgovori='$preostaliOdgovori', zahtjev='$zahtjev' WHERE tvrtka_id='$id'";
 
		$con->exec($sql);
		echo "<script>alert('Uspiješno ste uredili postojećeg korisnika!'); window.location='azur_tvrtka.php'</script>";

	}
}


if(isset($_POST['odustani'])){
	echo "<script> window.location='azur_tvrtka.php'</script>";
}
?>

<br>
</form>
<br>
</body>
<footer>
<?php include ('podnozje.php'); ?>
</footer>
</html>