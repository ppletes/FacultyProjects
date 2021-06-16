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
<br><br><br>
<form method="post" action="" enctype="multipart/form-data">
<p style="text-align: center; align: center; float: center; font-family: Arial; font-size: 13px;"><b>MOLIMO ODABERITE ŠTO ŽELITE AŽURIRATI...</b></p>
<br><br>
<div style="text-align: center; float: cenetr; align: center;">
<button type="submit" style="display: inline-block; height: 100px; width: 200px;" name="korisnik" class="gumb">KORISNIK</button>
<button type="submit" style="display: inline-block; height: 100px; width: 200px; margin-left: 5%;" name="tvrtka" class="gumb">TVRTKA</button>
</div>

<?php
if(isset($_POST['korisnik'])){
	echo "<script>window.location= 'azur_korisnik.php';</script>";
}
if(isset($_POST['tvrtka'])){
	echo "<script>window.location= 'azur_tvrtka.php';</script>";	
}
?>
</form>
<br><br><br>
</body>
<footer>
<?php include ('podnozje.php'); ?>
</footer>
</html>