<?php
chdir('../');
require_once 'core/config.php';
session_start();

if ( !in_array($_SERVER['REMOTE_ADDR'], $AUTH_USERS) ) {
  session_destroy();
  include 'includes/no_access.php';
  exit;
}

if ( isset($_SESSION['user_groups']) && !in_array($AUTH_GROUP, $_SESSION['user_groups']) ) {
  session_destroy();
  include 'includes/no_access.php';
  exit;
}


//log them out
$logout = $_GET['logout'];
if ($logout == "yes") { //destroy the session
	session_start();
	$_SESSION = array();
	session_destroy();
}

$username = strtoupper($_POST["username"]); //remove case sensitivity on the username
$password = $_POST["password"];
$formage = $_POST["formage"];

if ($_POST["oldform"]) { //prevent LDAP null bind

	if ($username != NULL && $password != NULL){
		//include the class and create a connection
		include "adLDAP/src/adLDAP.php";
        try {
		    $adldap = new adLDAP();
        }
        catch (adLDAPException $e) {
            echo $e; 
            exit();   
        }
		
		//authenticate the user
		if ($adldap->authenticate($username, $password)){
			//establish your session and redirect
			session_start();
			$_SESSION["username"] = $username;
      $_SESSION["user_info"] = $adldap->user()->info($username);
      $_SESSION["user_groups"] = $adldap->user()->groups($username);

			$redir = "Location: /";
			header($redir);
			exit;
		}
	}
	$failed = 1;
}

?>

<head>
<style>
body {
  width: 80%;
  height: 80%;
  margin: 0 auto;
}
div {
  display: block;
  width: 30%;
  margin: 10em auto;
}
</style>
</head>

<body>

<div>
This area is restricted.<br>
Please login to continue.<br><br>
<form method='post' action='<?php echo $_SERVER["PHP_SELF"]; ?>'>
<input type='hidden' name='oldform' value='1'>

Username: <input type='text' name='username' value='<?php echo ($username); ?>'><br>
Password: <input type='password' name='password'><br>
<br>

<input type='submit' name='submit' value='Submit'><br>
<?php if ($failed){ echo ("<br>Login Failed!<br><br>\n"); } ?>
</form>

<?php if ($logout=="yes") { echo ("<br>You have successfully logged out."); } ?>
</div>

</body>