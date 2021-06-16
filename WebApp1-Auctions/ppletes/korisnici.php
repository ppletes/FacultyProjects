<?php
$conn = new PDO('mysql:host=localhost; dbname=iwa_2017_zb_projekt','iwa_2017', 'foi2017'); 

mysql_connect('localhost','iwa_2017','foi2017');
mysql_select_db('iwa_2017_zb_projekt');
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8"/>
	<title>AUKCIJE</title>
	<link 
		href="stil.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>	
</head>

<body>
<?php
include ('zaglavlje.php');
?>
<center>
<br>
<div style="text-align: center; height: 550px; width: 1200px; font-size: 20px; margin-top: 20px;" method="post" action="korisnici.php">

<form style="text-align: center;" method="post" action="" style="text-align: center;">

<input type="submit" target="_blank" style="width: 30px; height: 23px; margin-left: 850px; margin-bottom: 10px;" name="upitnik" id="upitnik" value="?"  target="_blank" onclick="window.open('korisnici_opis.html')" />

<?php
if(isset($_POST['uredi'])){
	$checkbox = $_POST['checkbox'];
	for($i=1;$i>count($_POST['checkbox']);$i++){
	header("Location: korisnici.php");
	}
	for($i=0;$i<count($_POST['checkbox']);$i++){
		$id=$_POST['checkbox'][$i];
		$_SESSION['korisnik_id']=$id;
		header("Location: uredikorisnik.php");
	}
}
if (isset($_POST['obrisi'])){
	$checkbox = $_POST['checkbox'];
	for($i=1;$i>count($_POST['checkbox']);$i++){
	header("Location: korisnici.php");
	}
	for($i=0;$i<count($checkbox);$i++){
		$id=$_POST['checkbox'][$i];	
		mysql_query("DELETE FROM korisnik WHERE korisnik_id='$id'");
		echo "<script>alert ('Korisnik je uspiješno obrisan');</script>";
		}
	header("Refresh:0; url=korisnici.php");
}	



if (!isset($_GET['koliko']) or !is_numeric($_GET['koliko'])) {
  $koliko = 0;
} else {
  $koliko = (int)$_GET['koliko'];
}

$podaci = mysql_query("SELECT korisnik_id,tip_id,korisnicko_ime,lozinka,ime,prezime,email FROM korisnik LIMIT $koliko, 5")or
die(mysql_error());
$slika = mysql_query("SELECT slika FROM korisnik LIMIT $koliko, 5")or
die(mysql_error());

   $num=Mysql_num_rows($podaci);
        if($num>0)
        {
        echo "<table style=\"background: #f1f1f1;\" align=center border=2>";
        echo "<tr><td>Označi</td><td>ID Korisnik</td><td>ID Tip</td><td><b>Korisničko ime</b></td><td><b>Lozinka</b></td><td><b>Ime</b></td><td><b>Prezime</b></td><td><b>E-mail</b></td><td><b>Slika</b></td></tr>";
        for($i=0;$i<$num;$i++)
        {
        $row=mysql_fetch_array($podaci);
		$slikica=mysql_fetch_array($slika);
        echo "<tr>";
		echo"<td>" ?> <input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $row['korisnik_id']; ?>"/><?php "</td>"  ; 
        echo"<td>$row[0]</td>";
        echo"<td>$row[1]</td>";
        echo"<td>$row[2]</td>";
		echo"<td>$row[3]</td>";
        echo"<td>$row[4]</td>";
        echo"<td>$row[5]</td>";
        echo"<td>$row[6]</td>";
		echo "<td><img src=".$slikica['slika']." width=\"50\"height=\"50\" onclick=\"window.open(this.src, '_blank', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0');\"></td>";        
		echo"</tr>";
		
        }		
        echo"</table>";
		}
		
?><br>
<?php
if ($num>1){
		echo '<a name="slijedece" style="margin-left: -400px, auto;" href="'.$_SERVER['PHP_SELF'].'?koliko='.($koliko+5).'">Slijedeće</a>';
}else{
		echo '<a name="slijedece" style="margin-left: -400px, auto; display: none;" href="'.$_SERVER['PHP_SELF'].'?koliko='.($koliko+5).'">Slijedeće</a>';

}

$prev = $koliko - 5;


if ($prev >= 0)
    echo '<a style="margin-left: -700px;" href="'.$_SERVER['PHP_SELF'].'?koliko='.$prev.'">Predhodno</a>';
?>

</div>
</center>
<div style="margin-top: -100px; margin-right: 50px;" class="ggg">
<input style="margin-left: -300px;" id="uredi" type="submit" class="uredi" name="uredi" value="Uredi" onclick="window.location.replace('uredikorisnik.php')"/>
<input id="obrisi" name="obrisi" type="submit" class="obrisi" value="Obriši" />
</div>

</form>
<div style="margin-top: -100px; margin-right:170px;" class="ggg">
<button style="margin-right: -140px;" class="unesi" name="upload" id="upload" type="submit" onclick="window.location.replace('novikorisnik.php')">Dodaj novog korisnika</button>
</div>
</body>

<footer style="margin-top: -30px;">
<?php
include ('podnozje.php');
?>
</footer>
</html>