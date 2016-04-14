<?php require "checkLogin.php" ?>

<html>
 <head>
  <title>ReShare: Sell/Lend</title>
  <link rel="stylesheet" href="CSS/main.css" type="text/css">
 </head>
 <body>
 
 
	<?php 
		require 'header.php';
		$add_book_isbn = "";
		$add_book_price = "";
		$remove_book_id = "";
		$sell_or_lend = 1;
	?> 
	 
	 
	 
	<div id="body_wrapper">
	
		<h2>Add a New Listing:</h2>
	
		<FORM NAME ="add_book_form" METHOD ="POST" ACTION ="sell-lend.php">
			<div>ISBN: </div><INPUT TYPE = 'text' Name ='add_book_isbn'  value="<?PHP print $add_book_isbn;?>" maxlength="15">
			<div>Sell or Lend?: </div>
			<select Name ='sell_or_lend'>
				<option value="1">Sell</option>
				<option value="0">Lend</option>
			</select><br />
			<div>Price: $</div><INPUT TYPE = 'text' Name ='add_book_price'  value="<?PHP print $add_book_price;?>" maxlength="6">
			<div><INPUT TYPE = "Submit" Name = "add_book_submit"  VALUE = "Submit"></div><br />
		</FORM>
	
		
		<h2>Your Existing Listings</h2>
		
		
		<?php
			require 'database.php';
			
			$db = new ReShareDB();
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				if(isset($_POST['add_book_submit'])){
			
					$add_book_isbn = $_POST['add_book_isbn'];
					$add_book_price = $_POST['add_book_price'];
					$sell_or_lend = $_POST['sell_or_lend'];
				
					$db->addBook($add_book_isbn, $_SESSION['user'], $add_book_price, $sell_or_lend, 0);
				}
				
				if(isset($_POST['remove_book_submit'])){
					$boxes = $_POST['delete_boxes'];
					foreach($boxes as $box){
						$db->removeBook($box);
					}
				}
			}
			
			if(isset($_GET['id'])) {
				$remove_book_id = $_GET['id'];
			}
		
			$books = $db->FindBooksByUser($_SESSION['user']);
			
			if(isset($books[0])){
			
				echo "<FORM NAME =\"remove_book_form\" METHOD =\"POST\" ACTION =\"sell-lend.php\">";
				
				echo "<INPUT TYPE = \"Submit\" Name = \"remove_book_submit\"  VALUE = \"Remove Selected Entries\">";
				
				echo "<table id=\"MainContent_AvailableListings\">";
				echo "<tr>";
				echo "<th>Cover</th><th>Title</th><th>ISBN</th><th>Buy/Borrow</th><th>Price</th><th>Delete</th>";
				echo "</tr>";
				
				
				foreach($books as $book) {
					if($book->buyBorrow == 1) {
						
						$buyBorrow = "Buy";
						$price = $book->price;
						
					}else {
						
						$buyBorrow = "Borrow";
						$price = "N/A";
						
					}
					
					$img = $db->getImage($book->isbn);
					
					echo "<tr>";
					echo "<td><img src=\"".$img."\" /></td><td>".$book->title."</td><td>".$book->isbn."</td><td>".$buyBorrow."</td>
					<td>$".$price."</td><td><input type=\"checkbox\" class=\"delete_box\" name=\"delete_boxes[]\" value=\"".$book->id."\"></td>";
					echo "</tr>";
				}
			}
				
			echo "</table>";
			echo "</form>";
		?>

		
	</div>
	
 </body>
</html>