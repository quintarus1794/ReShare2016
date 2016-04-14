<?php require "checkLogin.php" ?>

<html>
 <head>
  <title>ReShare: Buy/Borrow</title>
  <link rel="stylesheet" href="CSS/main.css" type="text/css">
 </head>
 <body>
 
 <?php 
		require 'header.php';
		$book_isbn = "";
		

		
?> 
 
	<div id="body_wrapper">
		<h2>Search for a Book</h2>
		
		<FORM NAME ="search_book_form" METHOD ="POST" ACTION ="buy-borrow.php">
			<div>ISBN: </div><INPUT TYPE = 'text' Name ='book_isbn'  value="<?PHP print $book_isbn;?>" maxlength="15">
			<div><INPUT TYPE = "Submit" Name = "add_book_submit"  VALUE = "Submit"></div><br />
		</FORM>
		
		<?php
			require 'database.php';
			
			$db = new ReShareDB();
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$books = $db->findBooksByISBN($_POST['book_isbn']);
			
			
				echo "<table id=\"MainContent_AvailableListings\">";
				echo "<tr>";
				echo "<th>Cover</th><th>Title</th><th>ISBN</th><th>Buy/Borrow</th><th>Price</th><th>Seller</th>";
				echo "</tr>";
					
				foreach($books as $book) {
					$img = $db->getImage($book->isbn);
					
					echo "<tr>";
					print "<td><img src=\"$img\" /></td><td>".$book->title."</td><td>".$book->isbn."</td><td>".$book->buyBorrow."</td><td>".$book->price."</td><td>".$book->seller."</td>";
					echo "</tr>";
				}
					
				echo "</table>";
			}
		?>
		
		
	</div>
	
 </body>
</html>