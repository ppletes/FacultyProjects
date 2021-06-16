<br>
<hr>
	<div id="vrijeme" name="vrijeme" class="vrijeme">
	<script type="text/javascript">
	document.write ('<p><span id="date-time">', new Date().toLocaleString(), '<\span>.<\p>')
	if (document.getElementById) onload = function () {
	setInterval ("document.getElementById ('date-time').firstChild.data = new Date().toLocaleString()", 50)
	}
	</script>
	</div>
	<p class="c">
		© Sva prava pridržana
	</p>