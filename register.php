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
	$rePword = "";
	$errorMessage = "";
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$uname = $_POST['username'];
		$pword = $_POST['password'];
		$rePword = $_POST['re-password'];
		
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
			
			if(preg_match("/^[a-zA-Z0-9._%+-]+@letu.edu$/",$uname) != 1) {
				
				$errorMessage = "Please enter a valid LETU email address";
				
			}
			elseif($pword !== $rePword) {
				
				$errorMessage = "Entered passwords do not match";
				
			}
			elseif(!($db->register($uname, $pword))) {
				
				$errorMessage = "Username already taken";
			}
			else {
				//=================================================================================
				//	START THE SESSION AND PUT SOMETHING INTO THE SESSION VARIABLE CALLED login
				//	SEND USER TO A DIFFERENT PAGE AFTER SIGN UP
				//=================================================================================

				session_start();
				$_SESSION['login'] = "1";
				$_SESSION['user'] = $uname;
				header ("Location: index.php");

			} 
		}
	}
?> 
<FORM NAME ="register_form" METHOD ="POST" ACTION ="register.php">

	<div>Email: </div><INPUT TYPE = 'text' Name ='username'  value="<?PHP print $uname;?>" maxlength="50"><br />
	<div>Password: </div><INPUT TYPE = 'password' Name ='password'  value="<?PHP print $pword;?>" maxlength="16"><br />
	<div>Re-Enter Password: </div><INPUT TYPE = 'password' Name ='re-password'  value="<?PHP print $rePword;?>" maxlength="16"><br />
	<div><INPUT TYPE = "Submit" Name = "register_submit"  VALUE = "Register"></div><br />
	<div id="error_message"><?PHP print $errorMessage;?></div><br />

</FORM>

</body>
</html>