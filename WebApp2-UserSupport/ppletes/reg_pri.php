<?php  
header('Content-type: text/html; charset=UTF-8');
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
	<link 
		href="styleregpri.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>	
</head>

<body>
<?php include('zaglavlje.php'); ?>
<br>

<?php 
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

$sql = mysqli_query($conn,"SELECT * FROM korisnik");
if (!$sql) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
?>


	<form method="post" action="" enctype="multipart/form-data">
	<div style="margin-left: 30%;">
<div class="forma" id="forma1" style="width: 43%; font-family: Arial;">
	<fieldset>
		<legend style="color: rgb(210,36,36); font-weight: bold;">PRIJAVA</legend>
			<div style="text-align: center; float: center; align: center;">
			<br>
				<p style="font-size: 12px;">Polja označena s <span style="color: rgb(210,36,36);">*</span> morate ispuniti</p>
			<br><br>
			<div>
				<label style="font-size: 15px;"><span style="color: rgb(210,36,36);">*</span> Korisničko ime:</label><br>
				<input type="text" name="korisnicko_ime" size="50%" style="font-size: 15px; text-align: center; height: 30px;">
			</div>
			<br><br>
			<div>
				<label style="font-size: 15px;"><span style="color: rgb(210,36,36);">*</span> Lozinka:</label><br>
				<input type="password" name="lozinka" size="50%" style="font-size: 15px; text-align: center; height: 30px;">
			</div>
			<br>
			</div>
	</fieldset>
	
	<div style="text-align: center; margin-left: -40%; margin-top: 5%;">	
		<button class="gumb" name="prijava" style="width: 40%;">PRIJAVI</button>
	</div>
</div>
</div>

<?php
if (isset($_POST['registracija'])){

	$tip_id="2";
	$korisnickoime=$_POST['korisnickoime'];
	$korisnickalozinka=$_POST['korisnickalozinka'];
	$ime=$_POST['ime'];
	$prezime=$_POST['prezime'];
	$email=$_POST['email'];
	
	$slika = "korisnici/";
	$slika = $slika . basename( $_FILES['slika']);



	if($korisnickoime=="" or $korisnickalozinka==""){
		echo "<script>alert('Niste unjeli sve podatke. Nesmijete ostaviti prazno * označena polja');window.location='reg_pri.php';</script>";
	}else{
		$servername = "localhost";
		$username = "iwa_2018";
		$password = "foi2018";
		$dbname = "iwa_2018_zb_projekt";


try {
	$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	
    $korisnik_baza = "INSERT INTO korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika)
    VALUES ('$tip_id', '$korisnickoime', '$korisnickalozinka', '$ime', '$prezime', '$email', '$slika')";
    $con->exec($korisnik_baza);
    echo "<script>alert('Uspiješno ste se registrirali, sada se možete prijaviti.'); window.location= 'reg_pri.php';</script>";
    }
catch(PDOException $e)
    {
    echo $korisnik_baza . "<br>" . $e->getMessage();
    }

$con = null;
} 
} 

?>

	</form>
	
<?php mysqli_close($conn); ?>
<br><br><br>
</body>
<footer>
<?php include('podnozje.php'); ?>
</footer>
</html>