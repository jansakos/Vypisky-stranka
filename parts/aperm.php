<?php
include ('config.php');
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if(($_SESSION['permission']) != "o"){
	header("location: set.php");
	exit;
}
$sql = 'SELECT * 
		FROM login';
		
$query = mysqli_query($link, $sql);

if (!$query) {
	die ('SQL chyba: ' . mysqli_error($link));
}
?>
<?php
$username = $password = $permission = "";
$username_err = $password_err = $permission_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Nezadáno už. jméno.";
    }elseif(strlen(trim($_POST['username'])) != 6){
        $username_err = "Špatně zadané už. jméno (šest písmen).";
    }else{
        // Prepare a select statement
        $sql = "SELECT id FROM login WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Použité už. jméno.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Něco se pokazilo.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Nezadáno heslo.";     
    }else{
        $password = trim($_POST['password']);
    }
    
    //Permission
	if(empty(trim($_POST['permission']))){
        $permission_err = "Nezadána oprávnění.";     
    }elseif(strlen(trim($_POST['permission'])) > 1){
        $permission_err = "Špatně zadaná oprávnění (jen jedno písmeno).";
    }else{
        $permission = trim($_POST['permission']);
    }
	
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($permission_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO login (username, password, permission) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_permission);
            
            // Set parameters
            $param_username = $username;
            $param_password = $password;
			$param_permission = $permission;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Nečekaná chyba.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>