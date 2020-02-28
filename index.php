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
	case "t":
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
require_once 'config.php';

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
    if(isset($_POST['date']) && isset($_POST['subj']) && isset($_POST['type']) && isset($_POST['name'])){
        $name = htmlspecialchars($_POST['name']);
        $subj = htmlspecialchars($_POST['subj']);
        $type = $_POST['type'];
        $date = $_POST['date'];
        $namet = substr($name, 0, 30);
        if(is_numeric($type)){
            $typet = substr($type, 0, 1);
            if(strlen($date) == 10 && date("N", strtotime($date)) < 6){
                if(date("N", strtotime($date)) < 6){
                    if(strlen($subj) <= 6){
                        if(!empty($_POST['othtype'])){
                            $othtypet = substr(htmlspecialchars($_POST['othtype']), 0, 20);
                            if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diar` WHERE date='".$date."' AND subj='".$subj."' AND type='".$typet."' AND name='".$namet."' AND othtype='".$othtypet."'")) != 0){
                                $diarmsg = "Událost již existuje";
                                $diarmsgc = "lightcoral";
                            }else{
                                mysqli_query($link, "INSERT into diar (date, subj, type, name, othtype) VALUES ('".$date."', '".$subj."', '".$typet."', '".$namet."', '".$othtypet."')");
                                $diarmsg = "Událost přidána";
                                $diarmsgc = "lightgreen";
								//add to RSS
								$sql = "INSERT INTO rss (title, description) VALUES (?, ?)";
								if($stmt = mysqli_prepare($link, $sql)){
											
									// Bind variables to the prepared statement as parameters
									mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_description);
														
									// Set parameters
									$param_title = 'Nová událost!';
									$param_description = 'Na den '.date('d. m. Y', strtotime ($date)).' byla přidána událost '.$namet.' typu '.$othtypet.'.';
														
									// Attempt to execute the prepared statement
									if(mysqli_stmt_execute($stmt)){
										$diarmsg = "Událost přidána";
										$diarmsgc = "lightgreen";
									}else{
										echo "Neočekávaná chyba.";
									}
								}
                            }
                        }else{
                            if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diar` WHERE date='".$date."' AND subj='".$subj."' AND type='".$typet."' AND name='".$namet."'")) != 0){
                                $diarmsg = "Událost již existuje";
                                $diarmsgc = "lightcoral";
                            }else{
                                mysqli_query($link, "INSERT into diar (date, subj, type, name) VALUES ('".$date."', '".$subj."', '".$typet."', '".$namet."')");
                                $diarmsg = "Událost přidána";
                                $diarmsgc = "lightgreen";
								//add to RSS
								$sql = "INSERT INTO rss (title, description) VALUES (?, ?)";
								if($stmt = mysqli_prepare($link, $sql)){
											
									// Bind variables to the prepared statement as parameters
									mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_description);
														
									// Set parameters
									$param_title = 'Nová událost!';
									$param_description = 'Na den '.date('d. m. Y', strtotime ($date)).' byla přidána událost '.$namet.' typu '.$typet.'.';
														
									// Attempt to execute the prepared statement
									if(mysqli_stmt_execute($stmt)){
										$diarmsg = "Událost přidána";
										$diarmsgc = "lightgreen";
									}else{
										echo "Neočekávaná chyba.";
									}
								}
                            }
                        }
                    }else{
                        $diarmsg = "Nelze zpracovat předmět";
                        $diarmsgc = "lightcoral";
                    }
                }else{
                    $diarmsg = "Víkendy nejsou podporovány";
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

//predmety na realname
$subjectsjson = json_decode(file_get_contents('parts/subjects.json'));

function subjname($subjdbname){
	global $subjectsjson;
	if($response = $subjectsjson->{$subjdbname}){
		return $response;
	}else{
		return "?(".$subjdbname.")";
	}
}

//typy na realname
$typesjson = json_decode(file_get_contents('parts/events.json'));

function typename($typedbnum){
    global $typesjson;
	if($response = $typesjson->{intval($typedbnum)}){
		return $response;
	}else{
		return "?(".$typedbnum.")";
	}
}

//compute week, page listing
$weekmul = $page * 7;
switch(date("N")){
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
$mondate = $dateseek->format('Y-m-d');
$dateseek->modify('+1 day');
$tuedate = $dateseek->format('Y-m-d');
$dateseek->modify('+1 day');
$weddate = $dateseek->format('Y-m-d');
$dateseek->modify('+1 day');
$thudate = $dateseek->format('Y-m-d');
$dateseek->modify('+1 day');
$fridate = $dateseek->format('Y-m-d');


//select all days
$monevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$mondate."'");
$tueevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$tuedate."'");
$wedevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$weddate."'");
$thuevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$thudate."'");
$frievents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$fridate."'");

//date format
$mondatef = intval(substr($mondate, 8, 2)).". ".intval(substr($mondate, 5, 2)).". ".intval(substr($mondate, 0, 4));
$tuedatef = intval(substr($tuedate, 8, 2)).". ".intval(substr($tuedate, 5, 2)).". ".intval(substr($tuedate, 0, 4));
$weddatef = intval(substr($weddate, 8, 2)).". ".intval(substr($weddate, 5, 2)).". ".intval(substr($weddate, 0, 4));
$thudatef = intval(substr($thudate, 8, 2)).". ".intval(substr($thudate, 5, 2)).". ".intval(substr($thudate, 0, 4));
$fridatef = intval(substr($fridate, 8, 2)).". ".intval(substr($fridate, 5, 2)).". ".intval(substr($fridate, 0, 4));

?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
		if (isset($_SESSION['design'])){
			echo "<link href='assets/css/bootstrap-".$_SESSION['design'].".css' rel='stylesheet'>
			<link href='assets/css/index-".$_SESSION['design'].".css' rel='stylesheet'>
			<link href='assets/css/main-".$_SESSION['design'].".css' rel='stylesheet'>";
		}else{
			echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>
			<link href='assets/css/index-default.css' rel='stylesheet'>
			<link href='assets/css/main-default.css' rel='stylesheet'>";
		}
	?>
    <title>Úvod | Výpisky</title>
	
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
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
		
		<fieldset class="diar">
            <legend>Diář</legend>
            <?php if($diarpermlevel >= 0){ ?>
                <div class="dbody">
                    <div class="dframe">
                        <a class="leftarrow" href="?page=<?php echo $page-1; ?>"><i class="fa fa-chevron-left"></i></a>
                        <a class="rightarrow" href="?page=<?php echo $page+1; ?>"><i class="fa fa-chevron-right"></i></a>
                        <?php if(isset($diarmsg)){ echo "<p id=\"diarmsg\" class=\"diarmsg\" style=\"background-color: ".$diarmsgc.";\">".$diarmsg."</p><script>var diarmsg = document.getElementById(\"diarmsg\"); setTimeout(function(){ diarmsg.parentNode.removeChild(diarmsg); }, 10000);</script>"; } ?>
                        <noscript><p class="diarmsg" style="background-color: lightblue;">Pro všechny funkce je požadován JavaScript</p></noscript>
                        <div class="dtable">
                            <div class="day">
                                <div class="dtheader">
                                    <p><?php echo $mondatef; ?></p><p>Po</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($monrow = mysqli_fetch_array($monevents)){ ?>
                                        <div class="event event<?php echo $monrow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $monrow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($monrow['subj']); ?></p><p><?php if($monrow['type'] == 3){ if(empty($monrow['othtype'])){ echo "Nespecifikováno"; }else{ echo $monrow['othtype']; } }else{ echo typename($monrow['type']); } ?></p><p class="name"><?php echo $monrow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="day">
                                <div class="dtheader">
                                    <p><?php echo $tuedatef; ?></p><p>Út</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($tuerow = mysqli_fetch_array($tueevents)){ ?>
                                        <div class="event event<?php echo $tuerow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $tuerow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($tuerow['subj']); ?></p><p><?php if($tuerow['type'] == 3){ if(empty($tuerow['othtype'])){ echo "Nespecifikováno"; }else{ echo $tuerow['othtype']; } }else{ echo typename($tuerow['type']); } ?></p><p class="name"><?php echo $tuerow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="day">
                                <div class="dtheader">
                                    <p><?php echo $weddatef; ?></p><p>St</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($wedrow = mysqli_fetch_array($wedevents)){ ?>
                                        <div class="event event<?php echo $wedrow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $wedrow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($wedrow['subj']); ?></p><p><?php if($wedrow['type'] == 3){ if(empty($wedrow['othtype'])){ echo "Nespecifikováno"; }else{ echo $wedrow['othtype']; } }else{ echo typename($wedrow['type']); } ?></p><p class="name"><?php echo $wedrow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="day">
                                <div class="dtheader">
                                    <p><?php echo $thudatef; ?></p><p>Čt</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($thurow = mysqli_fetch_array($thuevents)){ ?>
                                        <div class="event event<?php echo $thurow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $thurow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($thurow['subj']); ?></p><p><?php if($thurow['type'] == 3){ if(empty($thurow['othtype'])){ echo "Nespecifikováno"; }else{ echo $thurow['othtype']; } }else{ echo typename($thurow['type']); } ?></p><p class="name"><?php echo $thurow['name']; ?></p></div>
                                        </div>
                                <?php }} ?>
                            </div>
                            <div class="day">
                                <div class="dtheader">
                                    <p><?php echo $fridatef; ?></p><p>Pá</p>
                                </div>
                                <?php for($i = 1;$i <= 5;$i++){ 
                                        while($frirow = mysqli_fetch_array($frievents)){ ?>
                                        <div class="event event<?php echo $frirow['type']; ?>">
                                            <?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $frirow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
                                            <div><p><?php echo subjname($frirow['subj']); ?></p><p><?php if($frirow['type'] == 3){ if(empty($frirow['othtype'])){ echo "Nespecifikováno"; }else{ echo $frirow['othtype']; } }else{ echo typename($frirow['type']); } ?></p><p class="name"><?php echo $frirow['name']; ?></p></div>
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
                            </select> <input class="form-control" style="margin-top: 5px;display: none;" type="text" name="othtype" id="othtype" maxlength="20" placeholder="Max. 20 znaků" /></p>
                        <p><label for="name">Téma</label> <input class="form-control" type="text" name="name" id="name" required maxlength="30" autocomplete="off" placeholder="Max. 30 znaků" /></p>
                        <p><input class="btn btn-primary" type="submit" name="addevent" value="Přidat událost" /></p>
                    </form>
                </fieldset>
            <?php } }else{ ?>
            <p>Na zobrazení diáře nemáte dostatečná práva</p>
            <?php } ?>
        </fieldset>
		<script>
								// Showing of othertype
								document.getElementById('type').onchange = function() {
									if(document.getElementById('type')[document.getElementById('type').selectedIndex].value == 3){
										document.getElementById('othtype').style.display = "block";
									}else{
										document.getElementById('othtype').style.display = "none";
									}
								};
							</script>
	</div>
	<?php
		include("footer.php");
	?>

  </body>
</html>
<?php mysqli_close($link); ?>