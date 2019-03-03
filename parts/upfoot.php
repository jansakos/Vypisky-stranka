<h4>VAROVÁNÍ</h4>
	<p>Vzhedem k současným implementacím jazyka a dalším bezpečnostním opatřením nesmí velikost souboru přesáhnout 
	<?php if(($_SESSION['permission'])=="o") {
			echo "10 MB.";
			}
		if(($_SESSION['permission'])=="w") {
			echo "2 MB.";
			}
		if(($_SESSION['permission'])=="u") {
			echo "250 kB.";
			}?>
		 Po nahrání bude názvu souboru odstraněna diakritika. Pokud máte problém s nahráním souboru, můžete požádat provozovatele o nahrání.</p>