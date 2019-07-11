<?php
// User logged in
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}

// Redirect to help
if (isset($_SESSION['first'])){
	if ($_SESSION['first'] == '1') {
	header("location: first.php");
	}
}

// Permission to Diarperm
switch ($_SESSION['permission']) {
    case "o":
        $diarpermlevel = 2;
        break;
    case "w":
        $diarpermlevel = 1;
        break;
	case "u":
		$diarpermlevel = 1;
		break;
    default:
        $diarpermlevel = 0;
        break;
}
//pg select
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}
$page = round($page);

//db config
include('config.php');

//rm event
if($diarpermlevel >= 2){
    if(isset($_GET['rmid'])){
        mysqli_query($link, "DELETE from diar WHERE id=".$_GET['rmid']);
        if(mysqli_affected_rows($link) == 1){
            $diarmsg = "Událost úspěšně odebrána";
            $diarmsgc = "lightgreen";
        }else{
            $diarmsg = "Událost nelze odebrat";
            $diarmsgc = "lightcoral";
        }
    }
}

//add event
if(isset($_POST['addevent'])){
    if(isset($_POST['addevent']) && isset($_POST['date']) && isset($_POST['subj']) && isset($_POST['type']) && isset($_POST['name'])){
        $name = $_POST['name'];
        $subj = $_POST['subj'];
        $type = $_POST['type'];
        $date = $_POST['date'];
        $namet = htmlspecialchars(substr($name, 0, 30));
        if(is_numeric($type)){
            $typet = substr($type, 0, 1);
            if(strlen($date) == 10){
                //$dateyear = substr($date, 0, 4);
                $datemon = substr($date, 5, 2);
                $dateday = substr($date, 8, 2);
                $datepar = intval($dateday).". ".intval($datemon).".";
                if($subj == "Č" || $subj == "M" || $subj == "A/Ju" || $subj == "A/Bžk" || $subj == "D" || $subj == "Hv" || $subj == "Vv" || $subj == "F" || $subj == "In/Bla" || $subj == "In/Kre" || $subj == "In/Hk" || $subj == "N/Cla" || $subj == "N/Smě" || $subj == "Š" || $subj == "Fr" || $subj == "Tv" || $subj == "Bi" || $subj == "Z" || $subj == "Ch" || $subj == "Sv" || $subj == "X"){
                    if(!empty($_POST['othtype'])){
                        $othtypet = htmlspecialchars(substr($_POST['othtype'], 0, 20));
                        if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diar` WHERE date='".$datepar."' AND subj='".$subj."' AND type='".$typet."' AND name='".$namet."' AND othtype='".$othtypet."'")) != 0){
                            $diarmsg = "Událost již existuje";
                            $diarmsgc = "lightcoral";
                        }else{
                            mysqli_query($link, "INSERT into diar (date, subj, type, name, othtype) VALUES ('".$datepar."', '".$subj."', '".$typet."', '".$namet."', '".$othtypet."')");
                            $diarmsg = "Událost přidána";
                            $diarmsgc = "lightgreen";
                        }
                    }else{
                        if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diar` WHERE date='".$datepar."' AND subj='".$subj."' AND type='".$typet."' AND name='".$namet."'")) != 0){
                            $diarmsg = "Událost již existuje";
                            $diarmsgc = "lightcoral";
                        }else{
                            mysqli_query($link, "INSERT into diar (date, subj, type, name) VALUES ('".$datepar."', '".$subj."', '".$typet."', '".$namet."')");
                            $diarmsg = "Událost přidána";
                            $diarmsgc = "lightgreen";
                        }
                    }
                }else{
                    $diarmsg = "Nelze zpracovat předmět";
                    $diarmsgc = "lightcoral";
                }
            }else{
                $diarmsg = "Nelze zpracovat datum";
                $diarmsgc = "lightcoral";
            }
        }else{
            $diarmsg = "Nelze zpracovat typ";
            $diarmsgc = "lightcoral";
        }
    }else{
        $diarmsg = "Nebyly přijaty požadované informace";
        $diarmsgc = "lightcoral";
    }
}

//predmety na realname v2
$subjrealjson = json_decode(file_get_contents('parts/subjects.json'));

function subjname($subjdbname){
    global $subjrealjson;
    return $subjrealjson->{$subjdbname};
}

//typy na realname
function typename($typedbnum){
    switch($typedbnum){
        case 0:
            return "Písemka";
            break;
        case 1:
            return "Dopisování";
            break;
        case 2:
            return "Dozkušování";
            break;
        case 3:
            return "Jiné";
            break;
        case 4:
            return "Státní svátek";
            break;
        case 5:
            return "Prázdniny";
            break;
        case 6:
            return "Olympiáda";
            break;
        case 7:
            return "Exkurze";
            break;
        case 8:
            return "Úkol";
            break;
        default:
            return "?(".$typedbnum.")";
            break;
    }
}

//compute week, page listing
$today = date("j. n.");
$weekday = date("N");

$weekmul = $page * 7;
switch($weekday){
    case 1:
        $daynum = 0 + $weekmul;
        break;
    case 2:
        $daynum = -1 + $weekmul;
        break;
    case 3:
        $daynum = -2 + $weekmul;
        break;
    case 4:
        $daynum = -3 + $weekmul;
        break;
    case 5:
        $daynum = -4 + $weekmul;
        break;
    case 6:
        $daynum = 2 + $weekmul;
        break;
    case 7:
        $daynum = 1 + $weekmul;
        break;
}

if($daynum < 0){
    $daynum_s = $daynum." day";
}else{
    $daynum_s = "+".$daynum." day";
}

$dateseek = new DateTime('today');
$dateseek->modify($daynum_s);

//compute weekdays with $dateseek
$mondate = $dateseek->format('j. n.');
$dateseek->modify('+1 day');
$tuedate = $dateseek->format('j. n.');
$dateseek->modify('+1 day');
$weddate = $dateseek->format('j. n.');
$dateseek->modify('+1 day');
$thudate = $dateseek->format('j. n.');
$dateseek->modify('+1 day');
$fridate = $dateseek->format('j. n.');


//select all days
$monevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$mondate."'");
$tueevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$tuedate."'");
$wedevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$weddate."'");
$thuevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$thudate."'");
$frievents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$fridate."'");
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
		if (isset($_SESSION['design'])){
			echo "<link href='assets/css/bootstrap-". $_SESSION['design']. ".css' rel='stylesheet'>";
		}else{
			echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>";
		}
	?>
    <title>Úvod | Výpisky</title>
	
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">
	<link href="assets/css/main.css" rel="stylesheet">
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/notif.js"></script>
  </head>

	  <body class="x-body">
		<?php
			include("header.php");
		?>	
		
		<div class="content">
		
		<?php 
			// Notifications
			include("config.php");
			
			// Delete old notifications
			$query = "DELETE FROM notif WHERE exp < CURDATE()";
			$stmt= $pdo->prepare($query);
			$run = $stmt->execute();
			
			// Get notifications
			$query = "SELECT * FROM notif ORDER BY id";
			$stmt= $pdo->prepare($query);
			$run = $stmt->execute();
				
			$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
				
			$notifall="";
			
			// Types of notifications
			foreach( $rs as $notif ){
				
				if(($_SESSION['username']) == $notif->tothe || $notif->tothe == ""){
					if (($notif->type)== "1"){
						$notifall .= '<div class="alert alert-info">'.$notif->text.'</div>';
					}
					if (($notif->type)== "2"){
						$notifall .= '<div class="alert alert-warning">'.$notif->text.'</div>';
					}
					if (($notif->type)== "3"){
						$notifall .= '<div class="alert alert-danger">'.$notif->text.'</div>';
					}
					if (($notif->type)== "4"){
						$expdate = strtotime($notif->exp);
						$formdate = date( 'd. m. Y', $expdate );
						$notifall .= '<div class="alert alert-danger"><strong>Plánovaný výpadek:</strong> Dne '.$formdate.' z důvodu: '.$notif->text.' </div>';
					}
					if (($notif->type)== "5"){
						$notifall .= '<div class="alert alert-success">'.$notif->text.'</div>';
					}
					if (($notif->type)== "6"){
						$bandate = strtotime($notif->exp);
						$formban = date( 'd. m. Y', $bandate );
						$notifall .= '<div class="alert alert-danger"><strong>Ban:</strong> do dne '.$formban.' z důvodu: '.$notif->text.' </div>';
					}
				}
			}
			
			// Echo notifications
			echo $notifall;
			
			// Close connection - closed on end because of diary
			// mysqli_close($link);
		?>
		
		<div class="container">
		<fieldset style="margin: 0 auto;width: fit-content;width: -moz-fit-content;">
            <legend>Diář</legend>
            <?php if($diarpermlevel >= 0){ ?>
            <div class="diar">
                <div class="dbody">
                    <div class="dframe">
                        <a class="leftarrow" href="?page=<?php echo $page-1; ?>"><i class="fa fa-chevron-left"></i></a>
                        <a class="rightarrow" href="?page=<?php echo $page+1; ?>"><i class="fa fa-chevron-right"></i></a>
                        <?php if(isset($diarmsg)){ echo "<p id=\"diarmsg\" class=\"diarmsg\" style=\"background-color: ".$diarmsgc.";\">".$diarmsg."</p><script>var diarmsg = document.getElementById(\"diarmsg\"); setTimeout(function(){ diarmsg.parentNode.removeChild(diarmsg); }, 10000);</script>"; } ?>
                        <noscript><p class="diarmsg" style="background-color: lightblue;">Pro všechny funkce je požadován JavaScript</p></noscript>
                        <div class="dtable">
                            <div class="day">
                                <div class="head">
                                    <p><?php echo $mondate; ?></p><p>Po</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($monrow = mysqli_fetch_array($monevents)){ ?>
                                        <div class="event event<?php echo $monrow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $monrow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($monrow['subj']); ?></p><p><?php if($monrow['type'] == 3){ if(empty($monrow['othtype'])){ echo "Nespecifikováno"; }else{ echo $monrow['othtype']; } }else{ echo typename($monrow['type']); } ?></p><p><?php echo $monrow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="day">
                                <div class="head">
                                    <p><?php echo $tuedate; ?></p><p>Út</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($tuerow = mysqli_fetch_array($tueevents)){ ?>
                                        <div class="event event<?php echo $tuerow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $tuerow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($tuerow['subj']); ?></p><p><?php if($tuerow['type'] == 3){ if(empty($tuerow['othtype'])){ echo "Nespecifikováno"; }else{ echo $tuerow['othtype']; } }else{ echo typename($tuerow['type']); } ?></p><p><?php echo $tuerow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="day">
                                <div class="head">
                                    <p><?php echo $weddate; ?></p><p>St</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($wedrow = mysqli_fetch_array($wedevents)){ ?>
                                        <div class="event event<?php echo $wedrow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $wedrow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($wedrow['subj']); ?></p><p><?php if($wedrow['type'] == 3){ if(empty($wedrow['othtype'])){ echo "Nespecifikováno"; }else{ echo $wedrow['othtype']; } }else{ echo typename($wedrow['type']); } ?></p><p><?php echo $wedrow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="day">
                                <div class="head">
                                    <p><?php echo $thudate; ?></p><p>Čt</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($thurow = mysqli_fetch_array($thuevents)){ ?>
                                        <div class="event event<?php echo $thurow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $thurow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($thurow['subj']); ?></p><p><?php if($thurow['type'] == 3){ if(empty($thurow['othtype'])){ echo "Nespecifikováno"; }else{ echo $thurow['othtype']; } }else{ echo typename($thurow['type']); } ?></p><p><?php echo $thurow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="day">
                                <div class="head">
                                    <p><?php echo $fridate; ?></p><p>Pá</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($frirow = mysqli_fetch_array($frievents)){ ?>
                                        <div class="event event<?php echo $frirow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $frirow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($frirow['subj']); ?></p><p><?php if($frirow['type'] == 3){ if(empty($frirow['othtype'])){ echo "Nespecifikováno"; }else{ echo $frirow['othtype']; } }else{ echo typename($frirow['type']); } ?></p><p><?php echo $frirow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                        </div>
                    </div>
                    <fieldset class="legend">
                        <legend>Legenda</legend>
                        <div class="event0"><p>Písemka</p></div>
                        <div class="event8"><p>Úkol</p></div>
                        <div class="event1"><p>Dopisování</p></div>
                        <div class="event2"><p>Dozkušování</p></div>
                        <!--div class="event4"><p>Státní svátek</p></div>
                        <div class="event5"><p>Prázdniny</p></div-->
                        <div class="event6"><p>Olympiáda</p></div>
                        <div class="event7"><p>Exkurze</p></div>
                        <div class="event3"><p>Jiné</p></div>
                    </fieldset>
                </div>
                <?php if($diarpermlevel >= 1){ ?>
                <fieldset class="addevent">
                    <legend>Přidat událost</legend>
                    <form method="post" action="#">
                        <p><label for="date">Datum</label> <input class="form-control" type="date" name="date" id="date" required /></p>
                        <p><label for="subj">Předmět</label> 
                            <select class="form-control" name="subj" id="subj" required>
                                <?php include 'parts/upsubj.php'; ?>
                            </select></p>
                        <p><label for="type">Typ</label> 
                            <select class="form-control" name="type" id="type" required>
                                <option value="0">Písemka</option>
                                <option value="8">Úkol</option>
                                <option value="1">Dopisování</option>
                                <option value="2">Dozkušování</option>
                                <!--option value="4">Státní svátek</option>
                                <option value="5">Prázdniny</option-->
                                <option value="6">Olympiáda</option>
                                <option value="7">Exkurze</option>
                                <option value="3">Jiné</option>
                            </select> 
							<script>
								// Showing of othertype
								document.getElementById('type').onchange = function() {tothtype()};
								function tothtype(){
									if(document.getElementById('type')[document.getElementById('type').selectedIndex].value == 3){
										document.getElementById('othtype').style.display = "block";
									}else{
										document.getElementById('othtype').style.display = "none";
									}
								}
							</script>
							<input class="form-control" style="margin-top: 5px;display: none;" type="text" name="othtype" id="othtype" maxlength="20" /></p>
                        <p><label for="name">Téma</label> <input class="form-control" type="text" name="name" id="name" required maxlength="30" autocomplete="off" /></p>
                        <p><input class="btn btn-primary" type="submit" name="addevent" value="Přidat událost" /></p>
                    </form>
                </fieldset>
                <?php } ?>
            </div>
            <?php }else{ ?>
            <p>Na zobrazení diáře nemáte dostatečná práva</p>
            <?php } ?>
        </fieldset>
		</div>
	</div>
	<?php
		include("footer.php");
	?>

  </body>
</html>
<?php mysqli_close($link); ?>