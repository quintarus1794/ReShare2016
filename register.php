<html>
 <head>
  <title>ReShare: Register</title>
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

		//====================================================================
		//	CHECK TO SEE IF U AND P ARE OF THE CORRECT LENGTH
		//	A MALICIOUS USER MIGHT TRY TO PASS A STRING THAT IS TOO LONG
		//	if no errors occur, then $errorMessage will be blank
		//====================================================================

		$uLength = strlen($uname);
		$pLength = strlen($pword);

		if ($uLength >= 3 && $uLength <= 20) {
			$errorMessage = "";
		}
		else {
			$errorMessage = $errorMessage . "Username must be between 10 and 20 characters" . "<BR>";
		}

		if ($pLength >= 8 && $pLength <= 16) {
			$errorMessage = "";
		}
		else {
			$errorMessage = $errorMessage . "Password must be between 8 and 16 characters" . "<BR>";
		}

		//=======================================================================
		//Test to see if $errorMessage is blank. If it is, then we can go ahead 
		//with the rest of the code. If it's not, we can display the error
		//=======================================================================

		if ($errorMessage == "") {

			

			//============================================================================
			//	Pass $uname and $pword to the register function and check to see if 
			//	the user already exists.
			//============================================================================
			
			if (!($db->register($uname, $pword))) {
				$errorMessage = "Username already taken";
			}
			else {
				//=================================================================================
				//	START THE SESSION AND PUT SOMETHING INTO THE SESSION VARIABLE CALLED login
				//	SEND USER TO A DIFFERENT PAGE AFTER SIGN UP
				//=================================================================================

				session_start();
				$_SESSION['login'] = "1";

				header ("Location: index.php");

			} 
		}
	}
?> 
<FORM NAME ="form1" METHOD ="POST" ACTION ="register.php">

	Username: <INPUT TYPE = 'text' Name ='username'  value="<?PHP print $uname;?>" maxlength="20">
	Password: <INPUT TYPE = 'password' Name ='password'  value="<?PHP print $pword;?>" maxlength="16">
	<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Register">

</FORM>

<?PHP print $errorMessage;?>

</body>
</html>