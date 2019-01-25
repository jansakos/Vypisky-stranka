<h4>VAROVÁNÍ</h4>
	<p>Vzhedem k současným implementacím jazyka a dalším bezpečnostním opatřením nesmí velikost souboru přesáhnout 
	<?php if(($_SESSION['permission'])=="o") {
			echo"10 MB.";
			}
		if(($_SESSION['permission'])=="w") {
			echo"1 MB.";
			}
		if(($_SESSION['permission'])=="u") {
			echo"200 kB.";
			}?>
		 Po nahrání bude odstraněna diakritika. Pokud máte problém s nahráním souboru, stačí mi ho poslat a já ho nahraji.</p>