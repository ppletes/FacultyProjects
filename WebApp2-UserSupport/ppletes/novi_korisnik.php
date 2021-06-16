<?php  
header('Content-type: text/html; charset=UTF-8');
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
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
<br><br>
<form style="text-align: center; float: center; align: center;" method="post" action="" enctype="multipart/form-data">

<p style="font-family: Arial; font-size: 12px;">Molimo polja označena s <span style="color: rgb(210,36,36); font-weight: bold;">*</span> ne ostavljajte prazna.</p>

<br><br>

<div style="font-family: Arial;">
<label>ID TIP <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<select name="tip_id" style="height: 30px; text-align: center;" type="text">
	<option value="1">1 | KORISNIK MODERATOR</option>
	<option value="2">2 | OBIČNI KORISNIK</option>
</select>
</div>

<br><br>

<div style="font-family: Arial;">

<div style="float: left; margin-left: 20%;">
<label>Ime</label><br>
<input name="ime" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
<label>Prezime</label><br>
<input name="prezime" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
<label>Email</label><br>
<input name="email" style="height: 30px; text-align: center; width: 300px;" type="email"><br><br>
</div>

<div style="float: right; margin-right: 20%;">
<label>Korisničko ime <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="korisnicko_ime" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
<label>Lozinka <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="lozinka" style="height: 30px; text-align: center; width: 300px;" type="password"><br><br>
<label>Slika</label><br>
<input name="slika" style="height: 30px; text-align: center; width: 300px;" type="file"><br><br>
</div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div style="">
<button type="submit" style="display: inline-block; width: 10%;" name="unesi" class="gumb">UNESI</button>
<button type="submit" style="display: inline-block; margin-left: 3%; width: 10%;" name="odustani" class="gumb">Odustani</button>
</div>

<?php
if(isset($_POST['unesi'])){
	$tip_id=$_POST['tip_id'];
	$korisnicko_ime=$_POST['korisnicko_ime'];
	$lozinka=$_POST['lozinka'];
	$ime=$_POST['ime'];
	$prezime=$_POST['prezime'];
	$email=$_POST['email'];
	$slika=$_FILES['slika'];
	
	$servername = "localhost";
	$username = "iwa_2018";
	$password = "foi2018";
	$dbname = "iwa_2018_zb_projekt";
	
	$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	
	if ($tip_id=="" or $korisnicko_ime=="" or $lozinka==""){
		echo "<script>alert('Niste unijeli sve potrebne podatke.'); window.location='novi_korisnik.php'</script>";
	}else{
		move_uploaded_file($_FILES["slika"],"uploads/" . $_FILES["slika"]);			

		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika) VALUES ('$tip_id','$korisnicko_ime', '$lozinka', '$ime', '$prezime', '$email', '$slika')";
 
		$con->exec($sql);
		echo "<script>alert('Uspiješno ste unijeli novog korisnika!'); window.location='azur_korisnik.php'</script>";

	}
}

if(isset($_POST['odustani'])){
	echo "<script> window.location='azur_korisnik.php'</script>";
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