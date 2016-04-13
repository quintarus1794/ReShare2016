<?php


$APIkey = "f8bgy6bj5fq6762x8qkqyx7k";

class Book {
    public $id;
	public $isbn;
	public $title;
	public $edition;
	public $author;
	public $seller;
	public $price;
	public $postedDate;
	public $buyBorrow;
	
	
	public function __construct($id,$isbn,$title,$edition,$author,$seller,$price,$postedDate,$buyBorrow) {
	$this->id = $id;
	$this->isbn = $isbn;
	$this->title = $title;
	$this->edition = $edition;
	$this->author = $author;
	$this->seller = $seller;
	$this->price = $price;
	$this->postedDate = $postedDate;
	$this->buyBorrow = $buyBorrow;
	
	}
	
}
	
class ReShareDB {
	
	const USERNAME = "root";		//username for database
	const PASSWORD = "";			//password for database
	const NAME = "test";			//name of database
	const SERVER = "127.0.0.1";		//database address
	const USERTABLE = "login";		//table containing user info
	const STORAGETABLE = "books";	//table containing book info
	const APIKEY = "AIzaSyDIWd3XchLhz1b18OZZGD0pCQoiyNwtdp0";

	

	/*	REGISTRATION FUNCTION
	This function recieves a username and password and
	attempts to register them a new user.
	
	It will open the database, and check if the username 
	already exists. If it does not exist, it will enter 
	the user and an md5 hashed password into the table.
	Bound parameters are used when querrying the database 
	to prevent sql injection attacks.
	
	If the user previously existed, it returns false.
	If not, it registers the user and returns true.
	*/
	public function register($uname, $pword) {
		
		//===================
		//Open the Database:
		//===================
		$db_handle = mysqli_connect(self::SERVER, self::USERNAME, self::PASSWORD);
		$db_found = mysqli_select_db( $db_handle, self::NAME);
		
		//=====================
		//Remove any HTML code:
		//=====================
		$uname = htmlspecialchars($uname);
		$pword = htmlspecialchars($pword);
		
		//===============================
		//Query to check if user exists:
		//===============================
		$stmnt = mysqli_prepare($db_handle, "SELECT * FROM ".self::USERTABLE." WHERE username = ?");	//Prepares the query as a mysqli_stmt.
		mysqli_stmt_bind_param($stmnt, "s", $uname);		//Binds the $uname variable (as a string) in place of the ? above.
		mysqli_stmt_execute($stmnt);						//Executes the query.
		mysqli_stmt_store_result($stmnt);					//Stores the result of the query.
		$num_rows = mysqli_stmt_num_rows($stmnt);			//Stores the number of rows in the result.
		
		if($num_rows > 0) {
			
			//=====================
			//User already exists:
			//=====================
			mysqli_close($db_handle);
			return false;
			
		} else {
		
			//================================================
			//User does not exist; register user in database.
			//================================================
			$stmnt = mysqli_prepare($db_handle, "INSERT INTO login (username, password) VALUES (?, md5(?));");	//Prepares the query as a mysqli_stmt.
			mysqli_stmt_bind_param($stmnt, 'ss', $uname, $pword);		//Binds the $uname and $pword variable (as strings) in place of the ?'s above.
			mysqli_stmt_execute($stmnt);								//Executes the query.
			
			mysqli_close($db_handle);
			return true;
		}
		
	}
	
	/*	LOGIN FUNCTION
	This function recieves a username and password and
	compares them to users registered in the database.
	
	It will open the database, and look for entries that
	contain both the username and md5 hashed password.
	Bound parameters are used when querrying the database 
	to prevent sql injection attacks.
	
	If such an entry does exist, the function returns true.
	If not, it will return false.
	*/
	public function login($uname, $pword) {
		
		//===================
		//Open the Database:
		//===================
		$db_handle = mysqli_connect(self::SERVER, self::USERNAME, self::PASSWORD);
		$db_found = mysqli_select_db( $db_handle, self::NAME);
		
		//=====================
		//Remove any HTML code:
		//=====================
		$uname = htmlspecialchars($uname);
		$pword = htmlspecialchars($pword);
		
		//==================================================
		//Query for entry containing username and password.
		//==================================================
		$stmnt = mysqli_prepare($db_handle, "SELECT * FROM login WHERE username = ? AND password = md5(?);");	//Prepares the query as a mysqli_stmt.
		mysqli_stmt_bind_param($stmnt, "ss", $uname, $pword);	//Binds the $uname and $pword variable (as strings) in place of the ?'s above.
		mysqli_stmt_execute($stmnt);							//Executes the query.
		mysqli_stmt_store_result($stmnt);						//Stores the result of the query.			
		$num_rows = mysqli_stmt_num_rows($stmnt);				//Stores number of rows in the result.
		
		mysqli_close($db_handle);
		
		if($num_rows > 0) {
			
			return true;
			
		} else {
			
			return false;
			
		}
		
	}
	
	public function findBooksByISBN($search) {
		
		$db_handle = mysqli_connect(self::SERVER, self::USERNAME, self::PASSWORD);
		$db_found = mysqli_select_db( $db_handle, self::NAME);
		
		$search = htmlspecialchars($search);
		$sql = "SELECT * FROM `books` WHERE `ISBN` = \"".$search."\" ORDER BY `PostedDate` DESC";
		$result = $db_handle->query($sql);
		
		/*
		mysqli_stmt_bind_param($stmnt, "s", $search);		//Binds the $search variable (as a string) in place of the ? above.
		mysqli_stmt_execute($stmnt);						//Executes the query.
		mysqli_stmt_store_result($stmnt);					//Stores the result of the query.
		$result = mysqli_stmt_get_result($stmnt);			//Stores the query result.
		*/
		$books = array();
		if (mysqli_num_rows($result) > 0) {
			$key_range = mysqli_num_rows($result);
			$key = 0;
			
			while($row = mysqli_fetch_assoc($result)) {
				$books[$key] = new Book($row["ID"],$row["ISBN"],$row["Title"],$row["Edition"],$row["Author"],$row["Seller"],$row["Price"],$row["PostedDate"],$row["LendBuy"]);
				$key = $key + 1;
			}
			
			mysqli_close($db_handle);
			var_dump($books);
			return $books;
		
		} else {
			
			mysqli_close($db_handle);
			return false;	
		}
	}
			
			
			
	public function FindBooksByTitle($search) {	

	
		$db_handle = mysqli_connect(self::SERVER, self::USERNAME, self::PASSWORD);
		$db_found = mysqli_select_db( $db_handle, self::NAME);
		
		$sql =  "SELECT * FROM `books` WHERE `Title` LIKE \"".$search."\" ORDER BY `PostedDate` DESC";
		$result = $db_handle->query($sql);
		//$search = htmlspecialchars($search);
		
		
		/*$stmnt = mysqli_prepare($db_handle, "SELECT * FROM 'books' WHERE 'Title' LIKE 'Software Engineering' ORDER BY 'PostedDate' DESC");	//Prepares the query as a mysqli_stmt.
		//mysqli_stmt_bind_param($stmnt, "s", $search);		//Binds the $search variable (as a string) in place of the ? above.
		mysqli_stmt_execute($stmnt);						//Executes the query.
		mysqli_stmt_store_result($stmnt);					//Stores the result of the query.
		$result = mysqli_stmt_get_result($stmnt);			//Stores the query result.
		*/
		
		$books = array();
		
		
		if (mysqli_num_rows($result) > 0) {
			$key_range = mysqli_num_rows($result);
			$key = 0;
			
			while($row = mysqli_fetch_assoc($result)) {
				$books[$key] = new Book($row["ID"],$row["ISBN"],$row["Title"],$row["Edition"],$row["Author"],$row["Seller"],$row["Price"],$row["PostedDate"],$row["LendBuy"]);
				$key = $key + 1;
			}
			
			mysqli_close($db_handle);
			return $books;
			
		} else {
			mysqli_close($db_handle);
			return false;
		}	
	}	
	
	
	public function addBook($ISBN, $seller, $price, $lendBuy, $edition) {
		
		$stuff = $this->callAPI("GET", "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $ISBN . "&key=". self::APIKEY, false);
		$data = (array) json_decode($stuff);
		//echo "JSON:";
		//var_dump($data);
		$db_handle = mysqli_connect(self::SERVER, self::USERNAME, self::PASSWORD);
		$db_found = mysqli_select_db( $db_handle, self::NAME);
		
		if($data["totalItems"] != 0){
		$dataLVL0 = (array)$data["items"];
		$dataLVL1 = (array) $dataLVL0[0];
		$volumedata = (array) $dataLVL1["volumeInfo"];
		$authordata = (array) $volumedata;
		
		//var_dump($volumedata);
		$stmnt = mysqli_prepare($db_handle, "INSERT INTO `books`(`ISBN`, `Title`, `Edition`, `Author`, `Seller`, `Price`, `LendBuy`) VALUES ( ?, ?, ?, ?, ?, ?, ?)");	//Prepares the query as a mysqli_stmt.
		mysqli_stmt_bind_param($stmnt, "sssssss", $ISBN, $volumedata["title"], $edition, $volumedata["authors"][0], $seller, $price, $lendBuy );		//Binds the $search variable (as a string) in place of the ? above.
		//$stmnt = mysqli_prepare($db_handle, "INSERT INTO `books`(`ISBN`, `Title`, `Edition`, `Author`, `Seller`, `Price`, `LendBuy`) VALUES ( ?, ?, ?, ?, ?, ?, ?)");	//Prepares the query as a mysqli_stmt.
		//$testbook ="Test Book";
		//$testauthor = "TestAuth";
		//mysqli_stmt_bind_param($stmnt, "sssssss", $ISBN, $testbook, $edition, $testauthor, $seller, $price, $lendBuy );		//Binds the $search variable (as a string) in place of the ? above.
		
		mysqli_stmt_execute($stmnt);						//Executes the query.
		mysqli_stmt_store_result($stmnt);					//Stores the result of the query.
		$result = mysqli_stmt_get_result($stmnt);			//Stores the query result.
		return true;
		} else {
		return false;
		}

	}
	
	public function getImage($ISBN){
		$stuff = $this->callAPI("GET", "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $ISBN . "&key=". self::APIKEY, false);
		$data = (array) json_decode($stuff);
		//echo "JSON:";
		//var_dump($data);
		if($data["totalItems"] != 0){
		$dataLVL0 = (array)$data["items"];
		$dataLVL1 = (array) $dataLVL0[0];
		$volumedata = (array) $dataLVL1["volumeInfo"];
		$imgArray = (array) $volumedata["imageLinks"];
		return $imgArray["smallThumbnail"];
		//var_dump($imgArray);
		}
	}
	
	public function callAPI($method, $url, $data ) {
			$curl = curl_init();
				//	echo "URL:";
				//	var_dump($url);
			try {
				$ch = curl_init();

				if (FALSE === $ch)
					throw new Exception('failed to initialize');

				curl_setopt($ch, CURLOPT_URL, "$url");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				
				
				$content = curl_exec($ch);
		
				if (FALSE === $content)
					throw new Exception(curl_error($ch), curl_errno($ch));
					
			} catch(Exception $e) {

				trigger_error(sprintf(
					'Curl failed with error #%d: %s',
					$e->getCode(), $e->getMessage()),
					E_USER_ERROR);

			}
			//echo "Content:";
			//var_dump($content); 
			return $content;
		

	}

}
$db = new ReShareDB();

var_dump( $db -> findBooksByISBN("0133943038"));


?>