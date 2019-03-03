<?php
	include("parts/iperm.php");
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
	?>
    <title>Jaroška | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="assets/css/index.css" rel="stylesheet">
	<link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/notif.js"></script>
	<script>
            function tothtype(){
                if(document.getElementById('type')[document.getElementById('type').selectedIndex].value == 3){
                    document.getElementById('othtype').removeAttribute('hidden');
                }else{
                    document.getElementById('othtype').setAttribute('hidden', '');
                }
            }
    </script>
  </head>

  <body>
  	<?php
     include("header.php");
	?>
	<br><br><br><br>
	
	
	<div class="container">
	<fieldset style="margin: 0 auto;">
            <legend>Diář</legend>
            <?php if($diarpermlevel != "p"){ ?>
            <div class="diar">
                <div class="dbody">
                    <?php if($page-1 >= -1){ ?><a class="leftarrow" href="?page=<?php echo $page-1; ?>"><i class="fa fa-arrow-left"></i></a><?php } ?>
                    <?php if($page+1 <= 1){ ?><a class="rightarrow" href="?page=<?php echo $page+1; ?>"><i class="fa fa-arrow-right"></i></a><?php } ?>
                     <?php if(isset($diarmsg)){ echo "<p class=\"diarmsg\" style=\"background-color:".$diarmsgc.";\">".$diarmsg."</p>"; } ?>
                    <div class="dtable">
                        <div class="day day1">
                            <div class="head">
                                <p><?php echo $mondate; ?></p>
                                <p>Po</p>
                            </div>
                            <?php for($i = 1;$i <= 5;$i++){ 
                                    while($monrow = mysqli_fetch_array($monevents)){ ?>
                                    <div class="event event<?php echo $monrow['type']; ?>">
                                        <?php if($diarpermlevel == "o"){ ?><a class="remove" href="?rmid=<?php echo $monrow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                        <div><p><?php echo subjname($monrow['subj']); ?></p><p><?php if($monrow['type'] == 3){ if(empty($monrow['othtype'])){ echo "Nespecifikováno"; }else{ echo $monrow['othtype']; } }else{ echo typename($monrow['type']); } ?></p><p><?php echo $monrow['name']; ?></p></div>
                                    </div>
                            <?php }} ?>
                        </div>
                        <div class="day day2">
                            <div class="head">
                                <p><?php echo $tuedate; ?></p>
                                <p>Út</p>
                            </div>
                            <?php for($i = 1;$i <= 5;$i++){ 
                                    while($tuerow = mysqli_fetch_array($tueevents)){ ?>
                                    <div class="event event<?php echo $tuerow['type']; ?>">
                                        <?php if($diarpermlevel == "o"){ ?><a class="remove" href="?rmid=<?php echo $tuerow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                        <div><p><?php echo subjname($tuerow['subj']); ?></p><p><?php if($tuerow['type'] == 3){ if(empty($tuerow['othtype'])){ echo "Nespecifikováno"; }else{ echo $tuerow['othtype']; } }else{ echo typename($tuerow['type']); } ?></p><p><?php echo $tuerow['name']; ?></p></div>
                                    </div>
                            <?php }} ?>
                        </div>
                        <div class="day day3">
                            <div class="head">
                                <p><?php echo $weddate; ?></p>
                                <p>St</p>
                            </div>
                            <?php for($i = 1;$i <= 5;$i++){ 
                                    while($wedrow = mysqli_fetch_array($wedevents)){ ?>
                                    <div class="event event<?php echo $wedrow['type']; ?>">
                                        <?php if($diarpermlevel == "o"){ ?><a class="remove" href="?rmid=<?php echo $wedrow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                        <div><p><?php echo subjname($wedrow['subj']); ?></p><p><?php if($wedrow['type'] == 3){ if(empty($wedrow['othtype'])){ echo "Nespecifikováno"; }else{ echo $wedrow['othtype']; } }else{ echo typename($wedrow['type']); } ?></p><p><?php echo $wedrow['name']; ?></p></div>
                                    </div>
                            <?php }} ?>
                        </div>
                        <div class="day day4">
                            <div class="head">
                                <p><?php echo $thudate; ?></p>
                                <p>Čt</p>
                            </div>
                            <?php for($i = 1;$i <= 5;$i++){ 
                                    while($thurow = mysqli_fetch_array($thuevents)){ ?>
                                    <div class="event event<?php echo $thurow['type']; ?>">
                                        <?php if($diarpermlevel == "o"){ ?><a class="remove" href="?rmid=<?php echo $thurow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                        <div><p><?php echo subjname($thurow['subj']); ?></p><p><?php if($thurow['type'] == 3){ if(empty($thurow['othtype'])){ echo "Nespecifikováno"; }else{ echo $thurow['othtype']; } }else{ echo typename($thurow['type']); } ?></p><p><?php echo $thurow['name']; ?></p></div>
                                    </div>
                            <?php }} ?>
                        </div>
                        <div class="day day5">
                            <div class="head">
                                <p><?php echo $fridate; ?></p>
                                <p>Pá</p>
                            </div>
                            <?php for($i = 1;$i <= 5;$i++){ 
                                    while($frirow = mysqli_fetch_array($frievents)){ ?>
                                    <div class="event event<?php echo $frirow['type']; ?>">
                                        <?php if($diarpermlevel == "o"){ ?><a class="remove" href="?rmid=<?php echo $frirow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                        <div><p><?php echo subjname($frirow['subj']); ?></p><p><?php if($frirow['type'] == 3){ if(empty($frirow['othtype'])){ echo "Nespecifikováno"; }else{ echo $frirow['othtype']; } }else{ echo typename($frirow['type']); } ?></p><p><?php echo $frirow['name']; ?></p></div>
                                    </div>
                            <?php }} ?>
                        </div>
                    </div>
                    <div class="legend">
                        <p><b>Legenda:</b></p>
                        <div class="event0"><p>Písemka</p></div>
                        <div class="event1"><p>Dopisování</p></div>
                        <div class="event2"><p>Dozkušování</p></div>
                        <div class="event3"><p>Jiné</p></div>
                    </div>
                </div>
                <?php if($diarpermlevel == "o" || $diarpermlevel == "w"){ ?>
                <fieldset class="addevent">
                    <legend>Přidat událost</legend>
                    <form method="post" action="#">
                        <p><label for="date">Datum</label> <input type="date" class="form-control" name="date" id="date" required /></p>
                        <p><label for="subj">Předmět</label> 
                            <select name="subj" id="subj" class="form-control" required>
                                <option value="c">Č / Čcv</option>
                                <option value="m">M / Mcv</option>
                                <option value="a">A</option>
                                <option value="d">D</option>
                                <option value="f">F</option>
                                <option value="hv">Hv</option>
                                <option value="vv">Vv</option>
                                <option value="in">In</option>
                                <option value="n">N</option>
                                <option value="s">Š</option>
                                <option value="fr">Fr</option>
                                <option value="tv">Tv</option>
                                <option value="bi">Bi / Bicv</option>
                                <option value="z">Z</option>
                                <option value="ch">Ch / Chcv</option>
                                <option value="sv">Sv</option>
                            </select></p>
                        <p><label for="type">Typ</label> 
                            <select name="type" id="type" class="form-control" onchange="tothtype()" required>
                                <option value="0">Písemka</option>
                                <option value="1">Dopisování</option>
                                <option value="2">Dozkušování</option>
                                <option value="3">Jiné</option>
                            </select> 
							<input type="text" name="othtype" id="othtype" hidden /></p>
                        <p><label for="name">Téma</label> 
						<input type="text" name="name" id="name" required maxlength="30" autocomplete="off" class="form-control" /></p>
                        <p><input type="submit" name="addevent" class="btn btn-primary" value="Přidat událost" /></p>
                    </form>
                </fieldset>
                <?php } ?>
            </div>
            <?php }else{ ?>
            <p>Na zobrazení diáře nemáte dostatečná práva</p>
            <?php } ?>
        </fieldset>
		</div>
		<?php
     include("footer.php");
	?>

  </body>
</html>
<?php mysqli_close($link); ?>