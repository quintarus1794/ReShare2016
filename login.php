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

<FORM NAME ="form1" METHOD ="POST" ACTION ="login.php">

	Username: <INPUT TYPE = 'text' Name ='username'  value="<?PHP echo $uname;?>" maxlength="20">
	Password: <INPUT TYPE = 'password' Name ='password'  value="<?PHP echo $pword;?>" maxlength="16">
	<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login">

</FORM>

<?PHP print $errorMessage;?>

</body>
</html>