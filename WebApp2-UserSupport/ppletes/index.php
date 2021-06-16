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
		href="styleindex.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>
</head>

<body>
<div class="crno"><br></div>
<center><div class="kocka"><div class="tijelo">

<center>
<div class="index">
<br>
<p id="tekst"><i>PRITISNITE ZA NASTAVAK</i></p><br>
<button class="gumb" onclick="location.href='pocetak.php'">NASTAVI</button>
</div>
</center>

<br><br><br>
</div></div></center>
</body>
<footer>
	<hr>
	<div class="footer-time">
	<script type="text/javascript">
	document.write ('<p><span id="date-time">', new Date().toLocaleString(), '<\span>.<\p>')
	if (document.getElementById) onload = function () {
	setInterval ("document.getElementById ('date-time').firstChild.data = new Date().toLocaleString()", 50)
	}
	</script>
	</div>
	<p class="footer-prava">
		© Sva prava pridržana - 2019
	</p>
</footer>
</html>