<html>
 <head>
  <title>ReShare: Login</title>
  <link rel="stylesheet" href="CSS/main.css" type="text/css">
 </head>
 <body>
 <?php 
 
	require 'header.php';
	require 'database.php';
	
	$uname = "";
	$pword = "";
	$errorMessage = "";


	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$uname = $_POST['username'];
		$pword = $_POST['password'];
		
		$db = new ReShareDB();

		//===================================================
		//	Check to see if the username and password match
		//===================================================
		if ($db->login($uname, $pword)) {
			session_start();
			$_SESSION['login'] = "1";
			$_SESSION['user'] = $uname;
			header ("Location: index.php");
		}
		else {
			$errorMessage = "Provided Info does not match our records.";
		}	
	}


?>

<FORM NAME ="form1" METHOD ="POST" ACTION ="register.php">

	<div>Email: </div><INPUT TYPE = 'text' Name ='username'  value="<?PHP print $uname;?>" maxlength="20"><br />
	<div>Password: </div><INPUT TYPE = 'password' Name ='password'  value="<?PHP print $pword;?>" maxlength="16"><br />
	<div><INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login"></div><br />
	<div id="error_message"><?PHP print $errorMessage;?></div><br />

</FORM>

</body>
</html>